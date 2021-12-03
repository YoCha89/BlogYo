<?php
namespace App\Backend\Modules\Admin;

use OCFram\BackController;
use OCFram\HTTPRequest;
use App\Backend\Entity\Admin;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class AdminController extends BackController{
	//Admin connexion
	public function executeBackConnectAdmin (HTTPRequest $request){
		if ($request->getExists('pseudo')) {

	    	$managerA = $this->managers->getManagerOf('Admin');
	    	$PseudoEntered = $request->getData('pseudo');

	    	$admin = $managerA->getAdminPerPseudo($PseudoEntered);

     		$passEntered = $request->getData('pass');
	    	$registeredPass = $admin['pass'];

	    	if(!empty($admin)){
	    		if($request->getData('pass') == 'TempEtBlog89'){
				    $this->app->user()->setAuthenticated(true);
				    $this->app->user()->setAdmin('toConf');

				    $this->app->user()->setAttribute('id', $admin['id']);
				    $this->app->user()->setAttribute('pseudo', $admin['pseudo']);
				    $this->app->user()->setAttribute('email', $admin['email']);

				    $this->app->user()->setFlashInfo('Plus qu\'une étape pour confirmez la création de votre compte administrateur !');

				    $this->app->httpResponse()->redirect('bootstrap.php?app=backend&action=backCreateAdminAccount');
	    		}else{
			    	//confirming pass entered
			    	if(password_verify($passEntered, $registeredPass)) {
					    //setup connexion indicator and other session variable
					    $this->app->user()->setAuthenticated(true);
					    $this->app->user()->setAdmin('isCo');

						$this->app->user()->setAttribute('id', $admin['id']);
					    $this->app->user()->setAttribute('pseudo', $admin['pseudo']);
					    $this->app->user()->setAttribute('email', $admin['email']);

					    $this->app->user()->setFlashSuccess('Vous êtes connecté, nous sommes ravis de votre retour !');
					    $this->app->httpResponse()->redirect('bootstrap.php?action=blogList');
				    }else {
				    	$this->app->user()->setFlashError('Votre nom d\'utilisateur ou votre mot de passe sont incorrect.');
			   			$this->app->httpResponse()->redirect('bootstrap.php?action=index');
				    }	
	    		}
	    	}else{
				$this->app->user()->setFlashError('Votre nom d\'utilisateur ou votre mot de passe sont incorrect.');
		    	$this->app->httpResponse()->redirect('bootstrap.php?action=index');
	    	}
	    }
	}

	//Create an admin account
	public function executeBackCreateAdminAccount (HTTPRequest $request) {
		if ($request->postData('step') == 'step1') { //form sent by established admin
			if ($this->app->user()->isAdmin() == 'isCo'){
				$managerA = $this->managers->getManagerOf('Admin');

				$clearTmpPass = 'TempEtBlog89';
				$cryptedTmpPass = password_hash($clearTmpPass, PASSWORD_DEFAULT);

				$this->processForm($request, $request->postData('email'), $request->postData('pseudo'), $cryptedTmpPass, $managerA);
			}
		} elseif ($request->postData('step') == 'step2') { // form sent by new admin to finalize the account creation
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
					$pseudo = $this->app->user()->getAttribute('pseudo');
					$email = $this->app->user()->getAttribute('email');
					$managerA = $this->managers->getManagerOf('Admin');
					//pass encryption
					$pass = password_hash($request->postData('pass'), PASSWORD_DEFAULT);

					$this->processForm($request, $email, $pseudo, $pass, $managerA);
				}
			}
		} else { // creates form to begin creation for established admin admin
			$this->page->addVar('title', 'Nouveau compte');
		}
	}

	//See admin account informations
	public function executeBackSeeAdmin (HTTPRequest $request) {

    	$this->page->addVar('title', 'Paramètre du compte');

	    $managerA = $this->managers->getManagerOf('Admin');

	    $admin = $managerA->getUnique($this->app->user()->getAttribute('id'));

	    $this->page->addVar('admin', $admin);
	}

	// Modifying a pseudo or an email
	public function executeBackModifyAdminAccount (HTTPRequest $request) {
		$managerA = $this->managers->getManagerOf('Admin');

		if ($request->postExists('pseudo')) {
			//checking pseudo availability (must be unique for connexion mgmt)
			if (!empty ($managerA->checkPseudo($request->postData('pseudo')))){
				$this->app->user()->setFlashError('Ce pseudo n\'est pas disponible.');					  		
			} else {
				$id = $this->app->user()->getAttribute('id');
				$admin = $managerA->getUnique($id);

				$pass = $admin['pass'];

				$this->processForm($request, $request->postData('email'), $request->postData('pseudo'), $pass, $managerA);
			}
		} else {
			$id = $this->app->user()->getAttribute('id');
			$admin = $managerA->getUnique($id);

			$this->page->addVar('title', 'Modifiez votre compte');
			$this->page->addVar('admin', $admin);
		}
	}

	//Ask for a new account password. Communicates with askAdlinPass in front account controller
	public function executeBackFurnishPass (HTTPRequest $request) {
		if($request->getExists('pseudo') && $request->getExists('renKey')){	// displays the form for updating the password

			$managerA = $this->managers->getManagerOf('Admin');
			$admin = $managerA->getAdminPerPseudo($request->getData('pseudo'));

			$this->app->user()->unsetFlash();

			$this->page->addVar('title', 'Renouvellement de mot de passe');	
			$id = $admin['id'];
			$this->page->addVar('id', $id);	
		}elseif($request->getExists('pseudo')){ //triggered throught the mail by the master admin, gives the admin the link to udpdate the password
			$managerA = $this->managers->getManagerOf('Admin');
			$admin = $managerA->getAdminPerPseudo($request->getData('pseudo'));

			$emailAdmin = $admin['email'];
			$masterAdmin = 'ychardel@gmail.com';
			$decoyMail = null;

			$title = 'Demande de renouvellement de mot de passe';
			$body = "Votre demande de renouvellement de mot de passe a été autorisé.<br/> Cliquez sur le lien pour renouveller votre mot de passe : <a href=\"http://localhost/web/bootstrap.php?app=backend&action=backFurnishPass&renKey=renkey&pseudo=" . $request->getData('pseudo')."\">Renouvellement du pass</a>";

			$titleConf = 'Confirmation de renouvellement autorisé pour :'.$request->getData('pseudo');
			$bodyConf = 'Votre demande de renouvellement de mot de passe a été envoyé à l\'administrateur principal du site">';

			$this->sendMail($decoyMail, $emailAdmin, $title, $body);
			$this->sendMail($decoyMail, $masterAdmin, $titleConf, $bodyConf);	

		}elseif($request->postExists('pass')){// form sending the new password to update 
			$id = $request->postData('id');

			$pass = $request->postData('pass');
			$confPass = $request->postData('confPass');

			$managerA = $this->managers->getManagerOf('Admin');
			$admin = $managerA->getUnique($id);

			if(!empty($admin)) {
				$uppercase = preg_match('@[A-Z]@', $pass);
				$lowercase = preg_match('@[a-z]@', $pass);
				$number    = preg_match('@[0-9]@', $pass);

				if(!$uppercase || !$lowercase || !$number || strlen($pass) < 8) {
					$this->app->user()->setFlashError('Votre mot de passe doit contenir au moins 8 caractères dont 1 majuscule, 1 minuscule, un nombre et un caractère spécial.');
				} else {
					//checking the 2 form pass matching
					if ( $request->postData('pass') != $request->postData('confPass')){
						$this->app->user()->setFlashError('Vous avez saisie 2 mots de passe différents.');
					} else {
						//pass encryption
						$pass = password_hash($pass, PASSWORD_DEFAULT);
						$email = $admin['email'];
						$pseudo = $admin['pseudo'];

						$this->processForm($request, $email, $pseudo, $pass, $managerA);
					}
				}
			}
		}
	}

	// A common private method for creation and uptate of an account
	protected function processForm(HTTPRequest $request, $email, $pseudo, $pass, $managerA) {

		$admin = new Admin([ 
			'email' => $email,
			'pseudo' => $pseudo,
			'pass' => $pass,
		]);

	    // if id exist, its an update 
	    $idCheck = $this->app->user()->getAttribute('id');
	    if (!empty($idCheck)){
	      $admin->setId($idCheck);
	      $flashInd="id";
	    }elseif($request->postData('id') != null){
	      $admin->setId($request->postData('id'));
	      $flashInd="id";
	    }

	    if ($admin->isValid()){

			$managerA->save($admin);

			if(isset($flashInd)){
				if($flashInd == 'id'){
					$this->app->user()->setFlashSuccess('Votre compte a été mis à jour !');
				}elseif($flashInd == 'conf'){
					$this->app->user()->setFlashSuccess('Votre compte est finalisé ! Bienvenu au nouvel administrateur :) !');
				}
			}else{
				$this->app->user()->setFlashSuccess('Le compte est créé ! Le nouvel administrateur doit confirmer la création en personalisant son mot de passe.');
			}

			//If we are on the first step of a Admin Account creation 
			if($request->postData('step') == 'step1'){
				$body = "Bonjour". $pseudo."! Votre compte administrateur a été créé sur le site Blogyo ! Connectez vous dès à présent avec le lien ci-dessous pour personnaliser votre mot de passe et finaliser la création.<br/> 
						Identifiant :".$pseudo."<br/>Mot de passe : TempEtBlog89 <br/><a href=\"http://localhost/web/bootstrap.php?action=index\"> Finaliser la création de compte </a>";
				$title = 'Création de votre compte administrateur BlogYo !';

				$currentAdminMail = $this->app->user()->getAttribute('email');
				$newAdminMail = $email;
				$decoyMail = null;

				$title2 = "le mail de confirmation de compte a été envoyé à ".$request->postData('pseudo');
				$body2 = "Le compte de ".$request->postData('pseudo')."a été créé et est en attente de finalisation";

				$this->sendMail($decoyMail, $newAdminMail, $title, $body);
				$this->sendMail($decoyMail, $currentAdminMail, $title2, $body2);

				$this->app->user()->setFlashInfo('Un mail de confirmation de création a du vous être envoyé.');
				$this->app->httpResponse()->redirect('bootstrap.php?app=backend&action=backSeeAdmin');
			}else{
			    $this->app->user()->setAuthenticated(true);
				$this->app->user()->setAdmin('isCo');

				$this->app->user()->setAttribute('id', $admin['id']);
			    $this->app->user()->setAttribute('pseudo', $admin['pseudo']);
			    $this->app->user()->setAttribute('email', $admin['email']);

			    $this->app->httpResponse()->redirect('bootstrap.php?action=blogList');				
			}

		} else {
			$this->app->user()->setFlashError('Entrez au moins un caractère autre qu\'un espace pour valider chaque champ');

			$this->app->httpResponse()->redirect('bootstrap.php?action=index'); 
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
		    $mailAdmin->Username   = '';   //SMTP username
		    $mailAdmin->Password   = '';            //SMTP password
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
}


