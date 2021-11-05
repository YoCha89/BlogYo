<?php
namespace App\Frontend\Modules\Account;

use OCFram\BackController;
use OCFram\HTTPRequest;
use App\Backend\Entity\Account;
use App\Backend\Model\AccountManagerPDO;

class AccountController extends BackController {

	//access to connexion form 
	public function executeIndex (HTTPRequest $request){

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

					    $this->app->user()->setFlash('Vous êtes connecté, nous sommes ravis de votre retour !');

					    $this->app->httpResponse()->redirect('bootstrap.php?action=blogList');
				    }

				    else {
				    	$this->app->user()->setFlash('Votre nom d\'utilisateur ou votre mot de passe sont incorrect.');
				    }	    		
		    	}else{
		    		$passTransfert = str_replace('&', '\&', $passEntered);
		    		$this->app->httpResponse()->redirect('bootstrap.php?app=backend&action=backConnectAdmin&pseudo='.$PseudoEntered.'&pass='.urlencode($passEntered));
		    	}
		    }

		    $this->app->httpResponse()->redirect('bootstrap.php?action=index');
		    $this->app->user()->setFlash('saisissez votre pseudo et votre mot de passe pour vous connecter.'); 
		}
			

	}

	public function executeDisconnect (HTTPRequest $request){
		
		if( $this->app->user()->isAdmin() == true){
			$this->app->user()->setAdmin(false);
		}

		$this->app->user()->setAuthenticated(false);
		$this->app->user()->destroy();

		$this->app->httpResponse()->redirect('bootstrap.php?action=index'); 
	}

	//Create an account
	public function executeCreateAccount (HTTPRequest $request){

		if(!empty($this->app->user()->getAttribute('id'))){
			$this->app->user()->setFlash('Vous avez déja un compte.');
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
					$this->app->user()->setFlash('Ce pseudo n\'est pas disponible.');					  		
				} else {
					$uppercase = preg_match('@[A-Z]@', $request->postData('pass'));
					$lowercase = preg_match('@[a-z]@', $request->postData('pass'));
					$number    = preg_match('@[0-9]@', $request->postData('pass'));
					$password = $request->postData('pass');

					if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
						$this->app->user()->setFlash('Votre mot de passe doit contenir au moins 8 caractères dont 1 majuscule, 1 minuscule, un nombre et un caractère spécial.');
					} else {
						//checking the 2 form pass matching
						if ( $request->postData('pass') != $request->postData('confPass')){
							$this->app->user()->setFlash('Vous avez saisie 2 mots de passe différents.');
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

					$pass = $formAccount['pass'];
					$secretA = password_hash($request->postData('secretA'), PASSWORD_DEFAULT);

					$this->processForm($request, $pass, $secretA, $managerA);
				} else {
					$this->app->user()->setFlash('Ce nom d\'utilisateur n\'est pas disponible.');
				}	
			} else {//pseudo is new and unique
				$pass = $formAccount['pass']; 
				$secretA = password_hash($request->postData('secretA'), PASSWORD_DEFAULT);

				$this->processForm($request, $pass, $secretA, $managerA);
			}
		}

	}

	//See account informations
	public function executeSeeAccount (HTTPRequest $request) {

    	$this->page->addVar('title', 'Paramètre du compte');

    	if($this->app->user()->isAdmin() == true){
	    	
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
	    	$this->app->httpResponse()->redirect('bootstrap.php?app=backend&action=backFurnishPass');
	    	}
		}

		if(empty($account) && empty($admin)){
	    	$accountStep2 = $managerA->getAccountPerPseudo($request->postData('hiddenPseudo'));
		}

	    if (empty($account) && empty($request->postData('newPass')))  {
	    	$this->app->user()->setFlash('Entrez un nom d\'utilisateur valide pour modifier votre mot de passe.');
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
				$this->app->user()->setFlash('Votre mot de passe doit contenir au moins 8 caractères dont 1 majuscule, 1 minuscule, un nombre et un caractère spécial.');
			} else {

				//checking the 2 form pass matching
				if ( $request->postData('newPass') != $request->postData('confNewPass')){
					$this->app->user()->setFlash('Vous avez saisie 2 mots de passe différents.');
				} else {
					//security question validation
		        	$secretA = password_hash($request->postData('secretA'), PASSWORD_DEFAULT);

					if (!password_verify($secretA, $accountStep2['secret_a'])){
		            	$this->app->user()->setFlash('Vous n\'avez pas entré la bonne réponse à votre question secrète.');
		        		$this->app->httpResponse()->redirect('bootstrap.php?action=index');
		            } else {
						$pass = password_hash($request->postData('newPass'), PASSWORD_DEFAULT);

		            	$managerA->updatePass($request->postData('pseudo'), $pass);

		            	$this->app->user()->setFlash('Votre mot de passe a bien été mis à jour !');

					    $this->app->user()->setAuthenticated(true);

						$this->app->user()->setAttribute('id', $formAccount['id']);
					    $this->app->user()->setAttribute('pseudo', $formAccount['pseudo']);
					    $this->app->user()->setAttribute('firstName', $formAccount['firstName']);


						//On redirigre sur la page "Paramètre du compte" ou l'utilisateur voit les infos à jour
						$this->app->httpResponse()->redirect('bootstrap.php?action=blogList');
			        }
		        }
			}
	    }
	}

	//Contact the site admin
	public function executeContactAdmin (HTTPRequest $request) {
	   	//getting back the mail data 
	   	$firstName = $request->postData('firstName');
	   	$name = $request->postData('name');
		$title = $request->postData('title');
		$content = $request->postData('content');

		if($this->app->user()->getAuthenticated() == true){
			$managerA = $this->managers->getManagerOf('Account');
	    	$account = $managerA->getAccount($this->app->user()->getId());
			$userMail = $account->email();
		} else {
			$userMail = $request->postData('userMail');
		}

		// creating 2 mail within the mailer
		$file = dirname(__FILE__).'/../../App/'.$this->name.'/config/param.json';

	    $data = file_get_contents($file);

	    $confirm = json_decode($data);

		$this->app->user()->setFlash('Votre message a été envoyé, vous allez recevoir un mail de confirmation');
		

	}

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

			$this->app->user()->setFlash(!empty($flashInd) ? 'Votre compte a été mis à jour !' : 'Votre compte a été créé, bienvenue sur BlogYo !');

			//connexion if previous step successful
			    $this->app->user()->setAuthenticated(true);

				$this->app->user()->setAttribute('id', $formAccount['id']);
			    $this->app->user()->setAttribute('pseudo', $formAccount['pseudo']);
			    $this->app->user()->setAttribute('firstName', $formAccount['firstName']);

			    $this->app->httpResponse()->redirect('bootstrap.php?action=blogList'); 
		} else {
			$this->app->user()->setFlash('Entrez au moins un caractère autre q\'un espace pour valider chaque champ');
			//different redirection based on creration or update of account
			!empty($idCheck) ? $this->app->httpResponse()->redirect('bootstrap.php?action=blogList'): $this->app->httpResponse()->redirect('bootstrap.php?action=index'); 
		}
	}
}


