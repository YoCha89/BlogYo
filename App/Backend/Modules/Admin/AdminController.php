<?php
namespace App\Frontend\Modules\Account;

use OCFram\BackController;
use OCFram\HTTPRequest;
use Entity\Admin;


class AccountController extends BackController
{
	//Admin connexion
	public function executeBackConnectAdmin (HTTPRequest $request){

		if ($request->postExists('pseudo')) {
			
	     	$passEntered = $request->postData('pass');
	    	$PseudoEntered = $request->postData('pseudo');

	    	$managerA = $this->managers->getManagerOf('Admin');
	    	$admin = $managerA->getAAdminPerPseudo($PseudoEntered);

	    	if(!empty($admin)){
		    	$registeredPass = $admin['pass'];

		    	//confirming pass entered
		    	if(password_verify($passEntered, $registeredPass)) {
				    //setup connexion indicator and other session variable
				    $this->app->user()->setAuthenticated(true);
				    $this->app->user()->setAdmin(true);

					$this->app->user()->setAttribute('id', $admin['id']);
				    $this->app->user()->setAttribute('pseudo', $admin['pseudo']);

				    $this->app->user()->setFlash('Vous êtes connecté, nous sommes ravis de votre retour !');

				    $this->app->httpResponse()->redirect('bootstrap.php?action=blogList');
			    }

			    else {
			    	$this->app->user()->setFlash('Votre nom d\'utilisateur ou votre mot de passe sont incorrect.');
			    }	    		
	    	}else{
	    		$this->app->httpResponse()->redirect('bootstrap.php?action=backConnectAdmin');
	    	}
	    }
	}
	//Create an admin account
	public function executeBackCreateAdminAccount (HTTPRequest $request) {
		 $this->page->addVar('title', 'Nouveau compte'); 

		if ($request->postExists('newMail')) {
			if ($this->user->isAuthenticated()){
				$managerA = $this->managers->getManagerOf('Admin');

				$clearTmpPass = TempoBlogYo21;

				$cryptedTmpPass = password_hash($clearTmpPass, PASSWORD_DEFAULT)

				$this->processForm($request, $clearTmpPass, $cryptedTmpPass, $managerA);
			}
		} elseif($request->postExists('pass')){

		}
	}

	public function executeBackModifyAdminAccount (HTTPRequest $request) {
		$id = $this->app->user()->getAttribute('id');
		$managerA = $this->managers->getManagerOf('Admin');

		$admin = $managerA->getUnique($id);
		$mail = $admin->getEmail();

		$this->page->addVar('title', 'Modifiez votre compte');
		$this->page->addVar('mail', $mail);

		if ($request->postExists('pseudo')) {
			//checking pseudo availability (must be unique for connexion mgmt)
			if (!empty ($managerA->checkPseudo($request->postData('pseudo')))){
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

						$this->processForm($request, $request->postData('pass'), $Pass, $managerA);
					}
				}
			}
		}
	}

	public function executeBackDisconnectAdmin (HTTPRequest $request)
	{
	
	}


	//Ask for a new account password
	public function executeBackAskAdminPass (HTTPRequest $request)
	{
		
	}

	//Ask for a new account password
	public function executeBackFurnishPass (HTTPRequest $request)
	{
		
	}

	protected function processForm(HTTPRequest $request, $clearpass, $pass, $managerA) {

		//if we are on the 'new mail' step, pseudo and name are null and hidden in the corresponding form
		$admin = new Admin([
			'email' => $request->postData('newMail'),
			'pseudo' => $request->postData('pseudo'),
			'name' => $request->postData('name'),
			'pass' => $request->postData('pass'),
		]);

	    // if id exist, its an update 
	    $idCheck = $this->app->user()->getAttribute('id');
	    if (!empty($idCheck)){
	      $admin->setId($idCheck);

	      //mailer sends confirmation to established admin and welcome mail to new admin with the clear pass to use at first connexion............................

	      //update indicator for flash message mgmt
	      $flashInd="id";
	    }

	    if ($admin->isValid()){

			$managerA->save($admin);

			$this->app->user()->setFlash(!empty($flashInd) ? 'Votre compte a été mis à jour !' : 'Le compte est créé ! Des mails de confirmations ont été envoyés aux nouvel admin et à votre adresse mail.');

			//connexion if previous step successful
			    $this->app->user()->setAuthenticated(true);
				$this->app->user()->setAdmin(true);

				$this->app->user()->setAttribute('id', $admin['id']);
			    $this->app->user()->setAttribute('pseudo', $admin['pseudo']);
			    $this->app->user()->setAttribute('firstName', $admin['firstName']);

			    $this->app->httpResponse()->redirect('bootstrap.php?action=blogList') 
		} else {
			$this->app->user()->setFlash('Entrez au moins un caractère autre q\'un espace pour valider chaque champ');

			$this->app->httpResponse()->redirect('bootstrap.php?action=index'); 
		}
	}
}


