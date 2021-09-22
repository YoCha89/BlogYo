<?php
namespace OCFram;
 
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

  //Méthode pour instancier le controlleur gérant l'action de la requête
  public function getController()
  {
    $router = new Router;
    $file = __DIR__.'/../../App/'.$this->name.'/config/routes.json';

    $data = file_get_contents($file);

    $routes = json_decode($data, false);


    foreach ($routes as $route)
      {
        $vars = [];
        
        if (isset($route->param) && $route->param != null)
        {
          $vars = explode(',', $route->param); 
        }

        $router->addRoute(new Route($route->module, $route->action, $route->param));

      }

    if($this->httpRequest->getData('action') == null){
      include (dirname(__FILE__) . '..\..App\Frontend\Modules\Account\AccountController.php');
      return new AccountController($this, 'Account', 'index');
    }else{
     try
      {
        // On récupère la route correspondante à l'URL.
        $matchedRoute = $router->getRoute($this->httpRequest->getData('action'));
        var_dump($this->httpRequest->getData('action'));die;
      }
      catch (\RuntimeException $e)
      {
        if ($e->getCode() == Router::NO_ROUTE)
        {
          // Si aucune route ne correspond, c'est que la page demandée n'existe pas.
          $this->httpResponse->redirect404();
        }
      }

      // On ajoute la variable éventuelle à l'objet.
      if ($this->httpRequest->getExists('var'))
      {
        $matchedRoute->setVar(getData('var'));
      }

      // On instancie le contrôleur.
      $controllerClass = 'App/'.$this->name.'/Modules/'.$matchedRoute->module().'/'.$matchedRoute->module().'Controller'; 
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