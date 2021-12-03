<?php
namespace App\Frontend\Modules\Account;

use OCFram\BackController;
use OCFram\HTTPRequest;
use App\Backend\Entity\Account;
use App\Backend\Model\AccountManagerPDO;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class AccountController extends BackController {

	//access to entry choices off the app : connexion, account creation, pass forgotten, contact admin
	public function executeIndex (HTTPRequest $request){
		if ($this->app->user()->isAuthenticated() == true){
			$this->app->user()->setFlashInfo('Vous êtes déja connecté.');
			$this->app->httpResponse()->redirect('bootstrap.php?action=blogList');
		}

		if ($request->postExists('pseudo')) {
			if ($request->postData('pseudo') !== null || $request->postData('pass') !== null){
		     	$passEntered = $request->postData('pass');
		    	$PseudoEntered = $request->postData('pseudo');
		    	
		    	$managerA = $this->managers->getManagerOf('Account');
		    	$account = $managerA->getAccountPerPseudo($PseudoEntered);

		    	if(!empty($account)){
			    	$registeredPass = $account['pass'];

			    	//confirming pass entered
			    	if(password_verify($passEntered, $registeredPass)) {
					    //setup connexion indicator and other session variable
					    $this->app->user()->setAuthenticated(true);

						$this->app->user()->setAttribute('id', $account['id']);
					    $this->app->user()->setAttribute('pseudo', $account['pseudo']);
					    $this->app->user()->setAttribute('email', $account['email']);

					    $this->app->user()->setFlashSuccess('Vous êtes connecté, nous sommes ravis de votre retour !');

					    $this->app->httpResponse()->redirect('bootstrap.php?action=blogList');
				    }

				    else {
				    	$this->app->user()->setFlashError('Votre nom d\'utilisateur ou votre mot de passe sont incorrect.');
				    }	    		
		    	}else{
		    		$passTransfert = str_replace('&', '\&', $passEntered);
		    		$this->app->httpResponse()->redirect('bootstrap.php?app=backend&action=backConnectAdmin&pseudo='.$PseudoEntered.'&pass='.urlencode($passEntered));
		    	}
		    }

		    $this->app->httpResponse()->redirect('bootstrap.php?action=index');
		    $this->app->user()->setFlashInfo('saisissez votre pseudo et votre mot de passe pour vous connecter.'); 
		}
	}

	// Disconnect user from session
	public function executeDisconnect (HTTPRequest $request){
		
		if( $this->app->user()->isAdmin() == 'isCo'){
			$this->app->user()->setAdmin('isDec');
		}

		$this->app->user()->setAuthenticated(false);
		$this->app->user()->destroy();

		$this->app->httpResponse()->redirect('bootstrap.php?action=index'); 
	}

	//Create an account
	public function executeCreateAccount (HTTPRequest $request){

		if(!empty($this->app->user()->getAttribute('id'))){
			$this->app->user()->setFlashInfo('Vous avez déja un compte.');
	    	$this->app->httpResponse()->redirect('bootstrap.php?action=index');
		}else{
		    $this->page->addVar('title', 'Créez votre compte');

		    $managerA = $this->managers->getManagerOf('Account');

			if ($request->postExists('name')){

				$managerAd = $this->managers->getManagerOf('Admin');

				$pseudo=$managerA->checkPseudo($request->postData('pseudo'));
				$pseudoAd=$managerAd->checkPseudo($request->postData('pseudo'));
				//checking pseudo availability (must be unique for connexion mgmt)
				if ($pseudo != null || $pseudoAd != null){
					$this->app->user()->setFlashError('Ce pseudo n\'est pas disponible.');					  		
				} else {
					$uppercase = preg_match('@[A-Z]@', $request->postData('pass'));
					$lowercase = preg_match('@[a-z]@', $request->postData('pass'));
					$number    = preg_match('@[0-9]@', $request->postData('pass'));
					$password = $request->postData('pass');

					if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
						$this->app->user()->setFlashError('Votre mot de passe doit contenir au moins 8 caractères dont 1 majuscule, 1 minuscule, un nombre et un caractère spécial.');
					} else {
						//checking the 2 form pass matching
						if ( $request->postData('pass') != $request->postData('confPass')){
							$this->app->user()->setFlashError('Vous avez saisie 2 mots de passe différents.');
						} else {
							//pass encryption
							$pass = password_hash($request->postData('pass'), PASSWORD_DEFAULT);
							$secretA = password_hash($request->postData('secretA'), PASSWORD_DEFAULT);

							$this->processForm($request, $pass, $secretA, $managerA);
						}
					}
				}
			}				
		}
	}

	//Update the account
	public function executeModifyAccount (HTTPRequest $request){

		if($this->app->user()->isAdmin() == 'isCo'){
			$this->app->httpResponse()->redirect('bootstrap.php?app=backend&action=backModifyAdminAccount');
		}

		$this->page->addVar('title', 'Mise à jour de votre compte');

	    $managerA = $this->managers->getManagerOf('Account');

	    $account = $managerA->getAccount($this->app->user()->getAttribute('id'));

		//checking is first field is empty. If yes, we send account data to put default value in the form
		if (empty($request->postData('name'))){
	    	$this->page->addVar('account', $account);
		} else {

			$managerAd = $this->managers->getManagerOf('Admin');

			$pseudoAcc=$managerA->checkPseudo($request->postData('pseudo'));
			$pseudo = $managerA->checkPseudo($request->postData('pseudo'));

			//cheking pseudo availability
			if ($pseudo != null || $pseudoAd != null){
				//if a pseudo is found, we check its his pseudo
				if ($request->postData('pseudo') == $this->app->user()->getAttribute('pseudo')){

					$pass = password_hash($request->postData('pass'), PASSWORD_DEFAULT);;
					$secretA = password_hash($request->postData('secretA'), PASSWORD_DEFAULT);

					$this->processForm($request, $pass, $secretA, $managerA);
				} else {
					$this->app->user()->setFlashError('Ce nom d\'utilisateur n\'est pas disponible.');
				}	
			} else {//pseudo is new and unique
				$pass = password_hash($request->postData('pass'), PASSWORD_DEFAULT);; 
				$secretA = password_hash($request->postData('secretA'), PASSWORD_DEFAULT);

				$this->processForm($request, $pass, $secretA, $managerA);
			}
		}

	}

	//See account informations
	public function executeSeeAccount (HTTPRequest $request) {

		if($this->app->user()->isAuthenticated() == false){
			$this->app->user()->setFlashError('Connectez-vous ou créez un compte pour accéder à cet interface.');
	    	$this->app->httpResponse()->redirect('bootstrap.php?action=index');
		}

    	$this->page->addVar('title', 'Paramètre du compte');

    	if($this->app->user()->isAdmin() == 'isCo' || $this->app->user()->isAdmin() == 'toConf'){
	    	
	    	$this->app->httpResponse()->redirect('bootstrap.php?app=backend&action=backSeeAdmin');

    	}else{
	    
		    $managerA = $this->managers->getManagerOf('Account');

		    $account = $managerA->getAccount($this->app->user()->getAttribute('id'));

		    $this->page->addVar('account', $account);

    	}	
	}

	//Ask for a new account password
	public function executeAskPass (HTTPRequest $request){
		$this->page->addVar('title', 'Mise à jour du mot de passe');

	    $managerA = $this->managers->getManagerOf('Account');
		$account = $managerA->getAccountPerPseudo($request->postData('pseudo'));

		if(empty($account)){
	    	$managerAd = $this->managers->getManagerOf('Admin');
	    	$admin = $managerAd->checkPseudo($request->postData('pseudo'));
	    	if(!empty($admin)){
	    		$this->askAdminPass($request);
	    	}
		}

		if(empty($account) && empty($admin)){
	    	$accountStep2 = $managerA->getAccountPerPseudo($request->postData('hiddenPseudo'));
		}

	    if (empty($account) && empty($request->postData('newPass')))  {
	    	$this->app->user()->setFlashError('Entrez un nom d\'utilisateur valide pour modifier votre mot de passe.');
	    	$this->app->httpResponse()->redirect('bootstrap.php?action=index');
	    }elseif(!empty($account)){
				$secretQ = $account['secret_q'];
		    	$this->page->addVar('secretQ', $secretQ);
		    	$this->page->addVar('pseudo', $request->postData('pseudo'));
	    }else{
			$newPass = $request->postData('newPass');
			$uppercase = preg_match('@[A-Z]@', $newPass);
			$lowercase = preg_match('@[a-z]@', $newPass);
			$number = preg_match('@[0-9]@', $newPass);

			if(!$uppercase || !$lowercase || !$number || strlen($newPass) < 8) {
				$this->app->user()->setFlashError('Votre mot de passe doit contenir au moins 8 caractères dont 1 majuscule, 1 minuscule, un nombre et un caractère spécial.');
			} else {

				//checking the 2 form pass matching
				if ( $request->postData('newPass') != $request->postData('confNewPass')){
					$this->app->user()->setFlashError('Vous avez saisie 2 mots de passe différents.');
				} else {
					//security question validation
		        	$secretA = $request->postData('secretA');

					if (!password_verify($secretA, $accountStep2['secret_a'])){
		            	$this->app->user()->setFlashError('Vous n\'avez pas entré la bonne réponse à votre question secrète.');
		        		$this->app->httpResponse()->redirect('bootstrap.php?action=index');
		            } else {
						$pass = password_hash($request->postData('newPass'), PASSWORD_DEFAULT);

		            	$managerA->updatePass($request->postData('hiddenPseudo'), $pass);

		            	$this->app->user()->setFlashSuccess('Votre mot de passe a bien été mis à jour !');

					    $this->app->user()->setAuthenticated(true);

						$this->app->user()->setAttribute('id', $formAccount['id']);
					    $this->app->user()->setAttribute('pseudo', $formAccount['pseudo']);
					    $this->app->user()->setAttribute('email', $formAccount['email']);

						$this->app->httpResponse()->redirect('bootstrap.php?action=blogList');
			        }
		        }
			}
	    }
	}

	//Deletes a user account
	public function executeDeleteAccount (HTTPRequest $request){
        $managerA = $this->managers->getManagerOf('account');
        $managerA->delete($this->app->user()->getAttribute('id'));

        $this->app->user()->destroy();

        $this->app->httpResponse()->redirect('bootstrap.php?action=index');
	}

	//Contact the site admin
	public function executeContactAdmin (HTTPRequest $request) {

		$managerA = $this->managers->getManagerOf('Account');
    	$account = $managerA->getAccount($this->app->user()->getAttribute('id'));

		if($request->postExists('body')){
			if($request->postExists('email')){
				$userMail = $request->postData('email');
			}else{
				$userMail = $account['email'];
			}
			
			$AdminMail = 'ychardel@gmail.com';
			$decoyMail = null;

			$title = $request->postData('title');
			$body = $request->postData('body');

			$titleConf = 'Confirmation d\'envoi de message :'. $title;
			$bodyConf = 'Votre message a bien été envoyé à l\'administrateur de BlogYo !<br/>
			<i>Ceci est un message automatique de confirmation. N\'essayez pas de répondre à ce mail.<\i>';

			//Message for Admin
			$this->sendMail($userMail, $AdminMail, $title, $body);

			//Confirmation email
			$this->sendMail($decoyMail, $userMail, $titleConf, $bodyConf);

		}else{

			if($this->app->user()->isAuthenticated() == true){
				$this->page->addVar('email', $userMail);
			}

    		$this->page->addVar('title', 'Contactez l\'administrateur');
		}
	}

	// A common private method for creation and uptate of an account
	protected function processForm(HTTPRequest $request, $pass, $secretA, $managerA) {

    	$formAccount = new Account ([
	    'name' => $request->postData('name'),
	    'pseudo' => $request->postData('pseudo'),
	    'email' => $request->postData('email'),
	    'pass' => $pass,
	    'secretQ' => $request->postData('secretQ'),
	    'secretA' => $secretA
		]);


	    // if id exist, its an update 
	    $idCheck = $this->app->user()->getAttribute('id');

	    if (!empty($idCheck)){
	      $pseudo = $this->app->user()->getAttribute('pseudo');
	      $account = $managerA->getAccountPerPseudo($pseudo);

	      $formAccount->setId($idCheck);
	      $formAccount->setSecretA($account['secret_a']);
	      $formAccount->setSecretQ($account['secret_q']);
	      $formAccount->setpass($account['pass']);


	      //update indicator for flash message mgmt
	      $flashInd="id";
	    }

	    if ($formAccount->isValid()){
			$managerA->save($formAccount);

			$this->app->user()->setFlashSuccess(!empty($flashInd) ? 'Votre compte a été mis à jour !' : 'Votre compte a été créé, bienvenue sur BlogYo !');

			$accountProcessed = $managerA->getAccountPerPseudo($request->postData('pseudo'));
			//connexion if previous step successful
			    $this->app->user()->setAuthenticated(true);

				$this->app->user()->setAttribute('id', $accountProcessed['id']);
			    $this->app->user()->setAttribute('pseudo', $accountProcessed['pseudo']);
			    $this->app->user()->setAttribute('email', $accountProcessed['email']);

			    $this->app->httpResponse()->redirect('bootstrap.php?action=blogList'); 
		} else {
			$this->app->user()->setFlashError('Entrez au moins un caractère autre qu\'un espace pour valider chaque champ');
			//different redirection based on creration or update of account
			!empty($idCheck) ? $this->app->httpResponse()->redirect('bootstrap.php?action=blogList'): $this->app->httpResponse()->redirect('bootstrap.php?action=index'); 
		}
	}

	// private function for sending mail through the app
	protected function sendMail($replyTo, $receiverMail, $title, $body){
		$mailAdmin = new PHPMailer();
		try {
			$mailAdmin->SMTPOptions = array(
			    'ssl' => array(
			    'verify_peer' => false,
			    'verify_peer_name' => false,
			    'allow_self_signed' => true
			    )
		    );
		    $mailAdmin->SMTPDebug = 2;                      //Enable verbose debug output
		    $mailAdmin->IsSMTP();                           //Send using SMTP
		    $mailAdmin->Mailer = "smtp";
		    $mailAdmin->Host  = 'smtp.gmail.com';           //Set the SMTP server to send through
		    $mailAdmin->SMTPSecure = "tls";
		    $mailAdmin->SMTPAuth   = true;                  //Enable SMTP authentication
		    $mailAdmin->Username   = 'yoaoc89@gmail.com';   //SMTP username
		    $mailAdmin->Password   = 'zpbPD&89';            //SMTP password
		    $mailAdmin->Port       = 587;                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		    //Recipients
		    $mailAdmin->setFrom('yoaoc89@gmail.com');
		    $mailAdmin->addAddress($receiverMail);

		    if($replyTo != null){
		    	$mailAdmin->addReplyTo($replyTo);
		    }
		    

		    //Content
		    $mailAdmin->isHTML(true);                 

		    $mailAdmin->Subject = $title;
		    $mailAdmin->Body    = $body;

		    $mailAdmin->send();		

		    $this->app->user()->setFlashSuccess('Votre message a été envoyé, vous allez recevoir un mail de confirmation');
		} catch (Exception $e) {
			$this->app->user()->setFlashError('Votre message n\'a pas pu être envoyé');
		}
	}

	//Ask for a new admin account password, going to backend through frontend when the user is registered as an admin
	protected function askAdminPass (HTTPRequest $request) {
		$managerA = $this->managers->getManagerOf('Admin');
		$pseudo = $request->postData('pseudo');

		$admin = $managerA->getAdminPerPseudo($pseudo);

		$emailAdmin = $admin['email'];
		$masterAdmin = 'ychardel@gmail.com';
		$decoyMail = null;

		$title = 'Demande de renouvellement de mot de passe';
		$body = "Une demande de renouvellement de mot de passe a été envoyé par ". $emailAdmin.".<br/> Cliquez sur le lien pour permettre le renouvellement : <a href=\"http://localhost/web/bootstrap.php?app=backend&action=backFurnishPass&pseudo=".$pseudo."\">Autoriser le changement de mot de passe</a>";

		$titleConf = 'Confirmation de demande de renouvellement de mot de passe';
		$bodyConf = 'Votre demande de renouvellement de mot de passe a été envoyé à l\'administrateur principal du site';

		$this->sendMail($decoyMail, $masterAdmin, $title, $body);
		$this->sendMail($decoyMail, $emailAdmin, $titleConf, $bodyConf);

	}
}


