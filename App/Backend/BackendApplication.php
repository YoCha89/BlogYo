<?php

namespace App\Backend;

use OCFram\Application;


class BackendApplication extends Application
{
	public function __construct()
	{
		parent::__construct();

		$this->name = 'Backend';
	}

	public function run()
	{
		if ($this->user->isAuthenticated() && $this->user->isAdmin())
		{ 
			$controller=$this->getcontroller();
		}

		else
		{
			 $controller = new Modules\Connexion\UsersController($this, 'Connexion', 'index');
		}
		
		$controller->execute(); 

		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}