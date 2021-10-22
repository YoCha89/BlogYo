<?php
namespace OCFram;

use App\Frontend\Modules\Account\AccountController;

abstract class Application
{
  protected $httpRequest;
  protected $httpResponse;
  protected $name;
  protected $user;

 
  public function __construct()
  {
    $this->httpRequest = new HTTPRequest($this);
    $this->httpResponse = new HTTPResponse($this);  
    $this->name = '';
    $this->user = new User($this);
  }

  public function getController()
  {

    var_dump($this->httpRequest->getData('action'));
    if($this->httpRequest->getData('action') == null){

      return new AccountController($this, 'Account', 'index');

    } else {
      $router = new Router;
      $file = dirname(__FILE__).'/../../App/'.$this->name.'/config/routes.json';

      $data = file_get_contents($file);

      $routes = json_decode($data, true);


      foreach ($routes as $route)
        {
          $vars = [];
          if (isset($route['params']) && $route['param'] != null)
          {
            $vars = explode(',', $route['params']); 
          }
          $router->addRoute(new Route($route['Module'], $route['Action'], $route['params']));

        }

       try
        {   
         $matchedRoute = $router->getRoute($this->httpRequest->getData('action'));
        }
        catch (\RuntimeException $e)
        {
          if ($e->getCode() == Router::NO_ROUTE)
          {

            $this->httpResponse->redirect404();
          }
        }

        if ($this->httpRequest->getExists('var'))
        {
          $matchedRoute->setVar(getData('var'));
        }
        
        $controllerClass = 'App\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
        return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());     
      }
       
  }
 
  abstract public function run();
 
  public function httpRequest()
  {
    return $this->httpRequest;
  }
 
  public function httpResponse()
  {
    return $this->httpResponse;
  }
 
  public function name()
  {
    return $this->name;
  }
 
  public function user()
  {
    return $this->user;
  }
}