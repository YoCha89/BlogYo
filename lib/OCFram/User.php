<?php
namespace OCFram;
 
session_start();

//Les méthodes de la classe user permet la gestion des variables de session
class User extends ApplicationComponent
{
  public function getAttribute($attr)
  {
    return isset($_SESSION[$attr]) ? $_SESSION[$attr] : null;
  }
 
  public function getFlash()
  {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
 
    return $flash;
  }
 
  public function hasFlash()
  {
    return isset($_SESSION['flash']);
  }
 
  public function isAuthenticated()
  {
    return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
  }
 

  public function setAuthenticated($authenticated)
  {
    if (!is_bool($authenticated))
    {
      throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setAuthenticated() doit être un boolean');
    }

    $_SESSION['auth'] = $authenticated;
  }

  public function isAdmin()
  {
    return $_SESSION['admin'];
  }
 

  public function setAdmin($admin)
  {
    if ($admin != 'isCo' && $admin != 'toConf' && $admin != 'isDec')
    {
      throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setAuthenticated() doit être une des string définie');
    }

    $_SESSION['admin'] = $admin;
  }

  public function setAttribute($attr, $value)
  {
    $_SESSION[$attr] = $value;
  } 

  public function setFlash($value)
  {
    $_SESSION['flash'] = $value;
  }

  public function destroy()
  {
    $_SESSION=array();
    session_destroy();
  }
}