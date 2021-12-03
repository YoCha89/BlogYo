<?php
namespace App\Backend\Model;
 
use OCFram\Manager;
use App\Backend\Entity\Account;
 
abstract class AccountManager extends Manager
{
  // add an account in DB
  abstract protected function add(Account $account);

  //modify an account in DB
  abstract protected function modify(Account $account);
 
  //Guides through add or modify  
  public function save(Account $account)
  {
    if ($account->isValid())
    {
      if($account->isNew() == false){
        $this->add($account);
      }else{
         $this->modify($account);
      }
    }
    else
    {
      throw new \RuntimeException('Respectez la forme des données à saisir');
    }
  }

  //updating user password
  abstract public function updatePass($id, $pass);

  abstract public function delete($id);

  //used for getting info about an account
  abstract public function getAccount($id);

  //checking pseudo availability
  abstract public function checkPseudo($pseudo);

  //used for connexion (id still unknown)
  abstract public function getAccountPerPseudo($peuso); 
 
}