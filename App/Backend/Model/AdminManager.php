<?php
namespace Model;
 
use OCFram\Manager;
use Entity\Account;
 
abstract class AccountManager extends Manager
{
  abstract protected function add(Account $account);
 
  //add or modify 
  public function save(Account $account)
  {
    if ($account->isValid())
    {
      $account->isNew() ? $this->add($account) : $this->modify($account);
    }
    else
    {
      throw new \RuntimeException('Respectez la forme des données à saisir');
    }
  }

  abstract public function delete($id);

  //used for connexion and disconnexion
  abstract public function getOne($id);

  //used to get the account list
  abstract public function getList($id);

  //counts the number of subscribers
  abstract public function count($id);
 
  abstract protected function modify(News $news);
}