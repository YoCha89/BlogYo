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
 
  public function getFlashInfo()
  {
    $flash = $_SESSION['flashInfo'];
    unset($_SESSION['flashInfo']);
 
    return $flash;
  }
 
  public function hasFlashInfo()
  {
    return isset($_SESSION['flashInfo']);
  }

  public function getFlashSuccess()
  {
    $flash = $_SESSION['flashSuccess'];
    unset($_SESSION['flashSuccess']);
 
    return $flash;
  }
 
  public function hasFlashSuccess()
  {
    return isset($_SESSION['flashSuccess']);
  }

  public function getFlashError()
  {
    $flash = $_SESSION['flashError'];
    unset($_SESSION['flashError']);
 
    return $flash;
  }
 
  public function hasFlashError()
  {
    return isset($_SESSION['flashError']);
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

  public function setFlashInfo($value)
  {
    $_SESSION['flashInfo'] = $value;
  }

  public function setFlashSuccess($value)
  {
    $_SESSION['flashSuccess'] = $value;
  }

  public function setFlashError($value)
  {
    $_SESSION['flashError'] = $value;
  }

    public function unsetFlash()
  {
    unset($_SESSION['flashError']);
    unset($_SESSION['flashInfo']);
    unset($_SESSION['flashSuccess']);
  }

  public function destroy()
  {
    $_SESSION=array();
    session_destroy();
  }
}