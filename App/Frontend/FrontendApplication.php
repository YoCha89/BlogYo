<?php
namespace App\Frontend;
 
use OCFram\Application;

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

/*    //Action to do disconnected
    if ($this->httpRequest->getData('action') == 'index' || $this->httpRequest->getData('action') == 'askPass' || $this->httpRequest->getData('action') == 'blogList' || $this->httpRequest->getData('action') == 'seeBlog'){
      $controller = $this->getController();
    }else if ($this->httpRequest->getData('action') == 'createAccount'){
      if ($this->user->getAttribute('auth') == true)
      {
        $this->user->setFlash('Vous devez être déconnecté pour créer un compte');
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