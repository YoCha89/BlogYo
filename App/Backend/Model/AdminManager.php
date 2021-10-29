<?php
namespace App\Backend\Model;
 
use OCFram\Manager;
use App\Backend\Entity\Admin;
 
abstract class AdminManager extends Manager
{
  abstract protected function add(Admin $admin);
 
  //add or modify 
  public function save(Admin $admin)
  {
    if ($admin->isValid())
    {
      $admin->isNew() ? $this->add($admin) : $this->modify($admin);
    }
    else
    {
      throw new \RuntimeException('Respectez la forme des données à saisir');
    }
  }

  abstract public function delete($id);

  //used for connexion and disconnexion
  abstract public function getUnique($id);

  //used to get the admin list
  abstract public function getList($id);

  //counts the number of admin
  abstract public function count();
 
  abstract protected function modify(Admin $admin);

  abstract public function checkPseudo($pseudo);
}