<?php
namespace App\Backend\Model;
 
use OCFram\Manager;
use App\Backend\Entity\Admin;
 
abstract class AdminManager extends Manager
{
  // add an account in DB
  abstract protected function add(Admin $admin);
 
  //add or modify 
  public function save(Admin $admin)
  {
    if ($admin->isValid())  {
      $admin->isNew() ? $this->add($admin) : $this->modify($admin);
    }
  }
  //Deletes an account
  abstract public function delete($id);

  //used for connexion and disconnexion
  abstract public function getUnique($id);

  //used to get the admin list
  abstract public function getList($id);

  // modify an account in DB
  abstract protected function modify(Admin $admin);

  // Checks if a pseudo is unique when creating an account
  abstract public function checkPseudo($pseudo);
}