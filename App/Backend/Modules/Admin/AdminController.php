<?php
namespace App\Backend\Modules\Admin;

use OCFram\BackController;
use OCFram\HTTPRequest;
use Entity\Admin;


class AdminController extends BackController
{
	//Admin connexion
	public function executeBackConnectAdmin (HTTPRequest $request){
		if ($request->getExists('pseudo')) {

	    	$managerA = $this->managers->getManagerOf('Admin');
	    	$PseudoEntered = $request->getData('pseudo');

	    	$admin = $managerA->getAdminPerPseudo($PseudoEntered);

	    	if(!empty($admin)){
	    		if(password_verify($admin['pass'], 'Temp&blog8')){
				    $this->app->user()->setAuthenticated(true);
				    $this->app->user()->setAdmin('toConf');
				    $this->app->user()->setAttribute('id', $admin['id']);
				    $this->app->user()->setAttribute('pseudo', $admin['pseudo']);

				    $this->app->user()->setFlash('Plus qu\'une étape pour confirmez la création de votre compte administrateur !');

				    $this->app->httpResponse()->redirect('bootstrap.php?app=backend&action=backCreateAdminAccount&key2=key2');
	    		}

	     		$passEntered = $request->getData('pass');
		    	$registeredPass = $admin['pass'];
		    	
		    	//confirming pass entered
		    	if(password_verify($passEntered, $registeredPass)) {
				    //setup connexion indicator and other session variable
				    $this->app->user()->setAuthenticated(true);
				    $this->app->user()->setAdmin('isCo');

					$this->app->user()->setAttribute('id', $admin['id']);
				    $this->app->user()->setAttribute('pseudo', $admin['pseudo']);

				    $this->app->user()->setFlash('Vous êtes connecté, nous sommes ravis de votre retour !');

				    $this->app->httpResponse()->redirect('bootstrap.php?action=blogList');
			    }else {
			    	$this->app->user()->setFlash('Votre nom d\'utilisateur ou votre mot de passe sont incorrect.');
		   			$this->app->httpResponse()->redirect('bootstrap.php?action=index');
			    }	    		
	    	}else{
				$this->app->user()->setFlash('Votre nom d\'utilisateur ou votre mot de passe sont incorrect.');
		    	$this->app->httpResponse()->redirect('bootstrap.php?action=index');
	    	}
	    }
	}

	//Create an admin account
	public function executeBackCreateAdminAccount (HTTPRequest $request) {

		if ($request->postData('step') == 'step1') { //form sent by established admin
			if ($this->app->user()->isAdmin() == 'isCo'){
				$managerA = $this->managers->getManagerOf('Admin');

				$clearTmpPass = 'Temp&blog8';
				$cryptedTmpPass = password_hash($clearTmpPass, PASSWORD_DEFAULT);

				$this->processForm($request->postData('email'), $request->postData('pseudo'), $cryptedTmpPass, $managerA);

				$newAdmin = $managerA->getAdminPerPseudo($request->postData('pseudo'));

				if($newAdmin != null){
					$message = "Bonjour". $request->postData('pseudo')."! Votre compte administrateur a été créé sur le site Blogyo ! Connectez vous dès à présent avec le lien ci-dessous pour personnaliser votre mot de passe et finaliser la création.<br/> 
						Identifiant :".$request->postData('email')."<br/>Mot de passe : Temp&blog8 <br/><a href=\"http://localhost/web/bootstrap.php?app=Backend&action=backConnectAdmin&pseudo=".$request->postData('pseudo')."\"> Finaliser la création de compte </a>";

/*					mail(
					    string $request->postData('email'),
					    string 'Création de votre compte administrateur BlogYo !',
					    string $message
					);

					$currentAdmin = $managerA->getUnique($this->app->user()->getAttribute('id'));
					$email = $currentAdmin->getEmail();
					$message2 = "Le compte de ".$request->postData('pseudo')."a été créé et est en attente de finalisation";

					mail(
					    string $email,
					    string 'Création de votre compte administrateur BlogYo !',
					    string $message2
					);*/

			   		$this->app->httpResponse()->redirect('bootstrap.php?app=backend&action=backSeeAdmin');				
				}
			}
		}elseif ($request->getData('key2') != null){ //creates confirmation form for new admin

			$this->page->addVar('title', 'Confirmation de votre compte'); 
			$this->page->addVar('key', 'key2'); 

			$managerA = $this->managers->getManagerOf('Admin');
			$newAdmin = $managerA->getAdminPerPseudo($request->getData('pseudo'));

			$this->app->user()->setAuthenticated(true);
		    $this->app->user()->setAdmin('toConf');

			$this->app->user()->setAttribute('id', $admin['id']);
		    $this->app->user()->setAttribute('pseudo', $admin['pseudo']);

		} elseif ($request->postData('key') == 'step2') { // form sent by new admin to finalize the account creation

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

					$managerA = $this->managers->getManagerOf('Admin');
					$pseudo = $this->app->user()->getAttribute('pseudo');
					$admin = $managerA->getAdminPerPseudo($pseudo);
					$email = $admin['email'];

					//pass encryption
					$pass = password_hash($request->postData('pass'), PASSWORD_DEFAULT);

					$this->processForm($email, $pseudo, $pass, $managerA);
				}
			}
		} else { // creates form to begin creation for established admin admin
			$this->page->addVar('title', 'Nouveau compte'); 
			$this->page->addVar('key1', 'key1'); 
		}
	}

	//See admin account informations
	public function executeBackSeeAdmin (HTTPRequest $request) {

    	$this->page->addVar('title', 'Paramètre du compte');

	    $managerA = $this->managers->getManagerOf('Admin');

	    $admin = $managerA->getUnique($this->app->user()->getAttribute('id'));

	    $this->page->addVar('admin', $admin);
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

	//Ask for a new account password
	public function executeBackAskAdminPass (HTTPRequest $request)
	{
		
	}

	//Ask for a new account password
	public function executeBackFurnishPass (HTTPRequest $request)
	{
		
	}

	protected function processForm($email, $pseudo, $pass, $managerA) {

		//if we are on the 'new mail' step, pseudo and name are null and hidden in the corresponding form
		$admin = new Admin([ 
			'email' => $request->postData('email'),
			'pseudo' => $request->postData('pseudo'),
			'pass' => $request->postData('pass'),
		]);

	    // if id exist, its an update 
	    $idCheck = $this->app->user()->getAttribute('id');
	    if (!empty($idCheck)){
	      $admin->setId($idCheck);
	      $adminCheck = $managerA->getAdminPerPseudo($pseudo);

	      if(password_verify($adminCheck['pass'], 'Temp&blog8')){
	      	$flashInd="conf";
	      }

	      $flashInd="id";
	    }

	    if ($admin->isValid()){

			$managerA->save($admin);

			if(isset($flashInd)){
				if($flashInd == 'id'){
					$this->app->user()->setFlash('Votre compte a été mis à jour !');
				}elseif($flashInd == 'conf'){
					$this->app->user()->setFlash('Votre compte est finalisé ! Bienvenu au nouvel administrateur :) !');
				}
			}else{
				$this->app->user()->setFlash('Le compte est créé ! Le nouvel administrateur doit confirmer la création en personalisant son mot de passe.');
			}

			$this->app->user()->setFlash(!empty($flashInd) ? 'Votre compte a été mis à jour !' : 'Le compte est créé ! Des mails de confirmations ont été envoyés aux nouvel admin et à votre adresse mail.');

			//connexion if previous step successful
			    $this->app->user()->setAuthenticated(true);
				$this->app->user()->setAdmin('isCo');

				$this->app->user()->setAttribute('id', $admin['id']);
			    $this->app->user()->setAttribute('pseudo', $admin['pseudo']);
			    $this->app->user()->setAttribute('firstName', $admin['firstName']);

			    $this->app->httpResponse()->redirect('bootstrap.php?action=blogList');
		} else {
			$this->app->user()->setFlash('Entrez au moins un caractère autre q\'un espace pour valider chaque champ');

			$this->app->httpResponse()->redirect('bootstrap.php?action=index'); 
		}
	}
}


