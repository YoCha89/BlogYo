<?php
namespace App\Frontend;
 
use \OCFram\Application;

class FrontendApplication extends Application
{
  public function __construct()
  {
    parent::__construct();
 
    $this->name = 'Frontend';
  }
 
  public function run()
  {
      $controller = $this->getController();
      $controller->execute();
      $this->httpResponse->setPage($controller->page());
      $this->httpResponse->send();  

  /*  //Action to do disconnected
    if ($this->httpRequest->getData('action') == 'index' || $this->httpRequest->getData('action') == 'updatePass')
    {
      $controller = $this->getController();
    }else if ($this->httpRequest->getData('action') == 'createAccount')//CreateAccount -> not to do if connected  
    {
      if ($this->user->getAttribute('auth') == true)
      {
        $this->user->setFlash('Vous devez être déconnecté pour créer un compte');
        $controller = new Modules\Account\AccountController($this, 'Employees', 'seeAccount');
      } else if ($this->user->getAttribute('auth') == true)// Action to do once connected
      {
        $controller = $this->getController();
      }

      $controller->execute();

      $this->httpResponse->setPage($controller->page());
      $this->httpResponse->send();
    } else {  
        //Redirection if not connected
        $controller = new Modules\Account\AccountController($this, 'Account', 'index');
    }*/
  }
}