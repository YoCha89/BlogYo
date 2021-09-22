<?php
namespace App\Frontend\Modules\Account;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Account;


class AccountController extends BackController {
	//access to connexion form 
	public function executeIndex (HTTPRequest $request){	

		if ($request->postExists('pseudo'))
    	{
	     	$passEntered = $request->postData('pass');
	    	$PseudoEntered = $request->postData('pseudo');

	    	$managerE = $this->managers->getManagerOf('Account');
	    	$account = $managerE->getAccountPerPseudo($userNameEntered);
	    	$registeredPass = $account['pass'];

	    	//confirming pass entered
	    	if(password_verify($passEntered, $registeredPass))
		    {
			    //setup connexion indicator and other session variable
			    $this->app->user()->setAuthenticated(true);

				$this->app->user()->setAttribute('id', $account['id']);
			    $this->app->user()->setAttribute('pseudo', $account['pseudo']);
			    $this->app->user()->setAttribute('firstName', $account['firstName']);

			    $this->app->user()->setFlash('Vous êtes connecté, nous sommes ravis de votre retour !');

			    $this->app->httpResponse()->redirect('bootstrap.php?action=blogList');
		    }

		    else
		    {
		    	$this->app->user()->setFlash('Votre nom d\'utilisateur ou votre mot de passe sont incorrect.');
		    }
	    }
	}

	public function executeDisconnect (HTTPRequest $request){

		$this->app->user()->setAuthenticated(false);
		$this->app->user()->destroy();

		$this->app->httpResponse()->redirect('bootstrap.php?action=index'); 
	}

	//Create an account
	public function executeCreateAccount (HTTPRequest $request){

	    $this->page->addVar('title', 'Créez votre compte');

	    $managerE = $this->managers->getManagerOf('Account');

		if ($request->postExists('name'))
		{
			//checking pseudo availability (must be unique for connexion mgmt)
			if (!empty ($managerE->checkPseudo($request->postData('pseudo')))){
				$this->app->user()->setFlash('Ce pseudo n\'est pas disponible.');					  		
			} else {
				$uppercase = preg_match('@[A-Z]@', $request->postData('pass'));
				$lowercase = preg_match('@[a-z]@', $request->postData('pass'));
				$number    = preg_match('@[0-9]@', $request->postData('pass'));

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

						$this->processForm($request, $pass, $secretQ, $managerE);
					}
				}
			}
		}	   
	}


	//Update the account
	public function executeModifyAccount (HTTPRequest $request){

		$this->page->addVar('title', 'Mise à jour de votre compte');

	    $managerE = $this->managers->getManagerOf('Account');

	    $employee = $managerE->getAccount($this->app->user()->getAttribute('id'));

		//checking is first field is empty. If yes, we send account data to put default value in the form
		if (empty ($request->postData('name'))){
	    	$this->page->addVar('account', $account);
		} else {
			//cheking pseudo availability
			if (!empty ($managerE->checkPseudo($request->postData('pseudo')))){

				//if a pseudo is found, we check its his pseudo
				if ($request->postData('pseudo') == $this->app->user()->getAttribute('pseudo')){

					$pass = $employee['pass'];
					$secretA = password_hash($request->postData('secretA'), PASSWORD_DEFAULT);

					$this->processForm($request, $pass, $secretA, $managerE);
				} else {
					$this->app->user()->setFlash('Ce nom d\'utilisateur n\'est pas disponible.');
				}	
			} else {//pseudo is new and unique
				$pass = $employee['pass']; 
				$secretA = password_hash($request->postData('secretA'), PASSWORD_DEFAULT);

				$this->processForm($request, $pass, $secretA, $managerE);
			}
		}

	}

	//See account informations
	public function executeSeeAccount (HTTPRequest $request) {

    	$this->page->addVar('title', 'Paramètre du compte');

	    $managerE = $this->managers->getManagerOf('Account');

	    $account = $managerE->getAccount($this->app->user()->getAttribute('id'));

	    $this->page->addVar('account', $account);	
	}

	//Ask for a new account password
	public function executeAskPass (HTTPRequest $request){
		$this->page->addVar('title', 'Mise à jour du mot de passe');

	    $managerE = $this->managers->getManagerOf('Account');
	    $account = $managerE->getAccountPerPseudo($request->postData('pseudo'));

	    if (!empty($account))  {
			if (!empty($request->postData('newPass'))){
				$uppercase = preg_match('@[A-Z]@', $request->postData('pass'));
				$lowercase = preg_match('@[a-z]@', $request->postData('pass'));
				$number    = preg_match('@[0-9]@', $request->postData('pass'));

				if(!$uppercase || !$lowercase || !$number || strlen($newPass) < 8) {
					$this->app->user()->setFlash('Votre mot de passe doit contenir au moins 8 caractères dont 1 majuscule, 1 minuscule, un nombre et un caractère spécial.');
				} else {
					//checking the 2 form pass matching
					if ( $request->postData('newpass') != $request->postData('confNewPass')){
						$this->app->user()->setFlash('Vous avez saisie 2 mots de passe différents.');
					} else {
						//security question validation
			        	$secretA = password_hash($request->postData('secretA'));

						if (!password_verify($secretA, $account['secretA']))
						{
			            	$this->app->user()->setFlash('Vous n\'avez pas entré la bonne réponse à votre question secrète.');
			        		$this->app->httpResponse()->redirect('bootstrap.php?action=index');
			            } else {
							$pass = password_hash($request->postData('newPass'), PASSWORD_DEFAULT);

			            	$managerE->updatePass($request->postData('pseudo'), $pass);

			            	$this->app->user()->setFlash('Votre mot de passe a bien été mis à jour !');

							//On redirigre sur la page "Paramètre du compte" ou l'utilisateur voit les infos à jour
							$this->app->httpResponse()->redirect('bootstrap.php?action=seeAccount');
				        }
			        }
				}
			} else {
		    	$this->page->addVar('account', $account);
		    }	 
		} else {
	    	$this->app->user()->setFlash('Entrez un nom d\'utilisateur valide pour modifier votre mot de passe.');
	    	$this->app->httpResponse()->redirect('bootstrap.php?action=index');
	    }
	}

	//Contact the site admin
	public function executeContactAdmin (HTTPRequest $request) {
	   	//getting back the mail data 
	   	$firstName = $request->postData('firstName');
	   	$name = $request->postData('name');
		$title = $request->postData('title');
		$content = $request->postData('content');
		$attachment = $request->postData('attachment');

		if($this->app->user()->getAuthenticated() == true){
			$managerE = $this->managers->getManagerOf('Account');
	    	$account = $managerE->getAccount($this->app->user()->getId()));
			$userMail = $account->email();
		} else {
			$userMail = $request->postData('userMail')
		}

		// creating 2 mail within the mailer
		$file = __DIR__.'/../../App/'.$this->name.'/config/param.json';

	    $data = file_get_contents($file);

	    $confirm = json_decode($data);

		$this->app->user()->setFlash('Votre message a été envoyé, vous allez recevoir un mail de confirmation');
		

	}

	protected function processForm(HTTPRequest $request, $pass, $secretA, $managerE) {

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
	      $formAccount->setId($idCheck);
	      //update indicator for flash message mgmt
	      $flashInd="id";
	    }

	    if ($formAccount->isValid()){

			$managerE->save($formAccount);

			$this->app->user()->setFlash(!empty($flashInd) ? 'Votre compte a été mis à jour !' : 'Votre compte a été créé, bienvenue sur le portail salarié de la GBAF !');

			//connexion if previous step successful
			    $this->app->user()->setAuthenticated(true);

				$this->app->user()->setAttribute('id', $account['id']);
			    $this->app->user()->setAttribute('pseudo', $account['pseudo']);
			    $this->app->user()->setAttribute('firstName', $account['firstName']);

			    $this->app->httpResponse()->redirect('bootstrap.php?action=blogList') 
		} else {
			$this->app->user()->setFlash('Entrez au moins un caractère autre q\'un espace pour valider chaque champ');
			//different redirection based on creration or update of account
			!empty($idCheck) ? $this->app->httpResponse()->redirect('bootstrap.php?action=seeAccount'): $this->app->httpResponse()->redirect('bootstrap.php?action=index'); 
		}
	}
}


