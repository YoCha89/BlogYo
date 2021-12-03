<?php
namespace OCFram;

use App\Frontend\Modules\Account\AccountController;
use App\Backend\Modules\Blog\BlogController;

abstract class Application
{
  protected $httpRequest;
  protected $httpResponse;
  protected $name;
  protected $user;
 
  public function __construct() {
    $this->httpRequest = new HTTPRequest($this);
    $this->httpResponse = new HTTPResponse($this);  
    $this->name = '';
    $this->user = new User($this);
  }

  public function getController() {
    $action = $this->httpRequest->getData('action');
    
    if($action == null){

      return new AccountController($this, 'Account', 'index');

    } else {
      if(preg_match('/back/', $action) == 0) {
        $router = new Router;
        $file = dirname(__FILE__).'/../../App/Frontend/config/routes.json';

        $data = file_get_contents($file);

        $routes = json_decode($data, true);
      } else {
        $router = new Router;
        $file = dirname(__FILE__).'/../../App/Backend/config/routes.json';

        $data = file_get_contents($file);

        $routes = json_decode($data, true);
      }

      foreach ($routes as $route) {
        $vars = [];
        if (isset($route['params']) && $route['param'] != null)
        {
          $vars = explode(',', $route['params']); 
        }
        $router->addRoute(new Route($route['Module'], $route['Action'], $route['params']));
      }

      try {
        $matchedRoute = $router->getRoute($this->httpRequest->getData('action'));
      }

      catch (\RuntimeException $e) {
        if ($e->getCode() == Router::NO_ROUTE)
        {
          $this->httpResponse->redirect404();
        }
      }

      if ($this->httpRequest->getExists('var')) {
        $matchedRoute->setVar(getData('var'));
      }
      
      $controllerClass = 'App\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
      
      return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());     
    }
  }
 
  abstract public function run();
 
  public function httpRequest() {
    return $this->httpRequest;
  }
 
  public function httpResponse() {
    return $this->httpResponse;
  }
 
  public function name() {
    return $this->name;
  }
 
  public function user() {
    return $this->user;
  }
}