<?php
namespace OCFram;
 
class Route
{
  protected $action;
  protected $module;
  protected $var;
 
  public function __construct($module, $action, $var)
  {
    $this->setModule($module);
    $this->setAction($action);
    $this->setVar($var);
  }
 
  public function hasVars()
  {
    return !empty($this->varsNames);
  }
 
  public function match($url)
  {
    if (preg_match('`^'.$this->url.'$`', $url, $matches))
    {
      return $matches;
    }
    else
    {
      return false;
    }
  }

  //SETTERS
  public function setAction($action)
  {
    if (is_string($action))
    {
      $this->action = $action;
    }
  }
 
  public function setModule($module)
  {
    if (is_string($module))
    {
      $this->module = $module;
    }
  }
 
  public function setVar($var)
  {
    $this->var = $var;
  }
 
  //GETTERS
  public function action()
  {
    return $this->action;
  }
 
  public function module()
  {
    return $this->module;
  }
 
  public function vars()
  {
    return $this->var;
  }
}