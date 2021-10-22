<?php
namespace App\Backend\Model;
 
use Entity\Account;
 
class AccountManagerPDO extends AccountManager
{
   //used for connexion (id still unknown)
  public function getAccountPerPseudo($peuso){

    $sql =$this->dao->prepare('SELECT id, name, pseudo, email, pass, secret_q, secret_a FROM account WHERE pseudo = :pseudo');

    $sql->bindValue(':pseudo', $pseudo);

    $sql->execute();

    $sql->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');
    $account = $sql->fetch();

    $sql->closeCursor();

    return $account; 
  }

  public function getAccount($id)
  {
    $sql =$this->dao->prepare('SELECT id, name, pseudo, email, pass, secret_q, secret_a FROM account WHERE id = :id');
    
    $sql->bindValue(':id', (int)$id, \PDO::PARAM_INT);
    $sql->execute();

    $sql->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');
    $account = $sql->fetch();

    $sql->closeCursor();

    return $account;
  }

  public function add(Account $account){
    $sql = $this->dao->prepare('INSERT INTO account SET name = :name, pseudo = :pseudo, email = :email, pass = :pass, secret_q = :secret_q, secret_a = :secret_a, createdAt = NOW(), updatedAt = null');
  
    $sql->bindValue(':name', $account->getName());
    $sql->bindValue(':firstName', $account->getFirstName());
    $sql->bindValue(':userName', $account->getUserName());
    $sql->bindValue(':pass', $account->getPass());
    $sql->bindValue(':secret_q', $account->getSecretQ());
    $sql->bindValue(':secret_a', $account->getSecretA());

    $sql->execute();
  
    $account->setId($this->dao->lastInsertId());

    $sql->closeCursor();
  }

  public function modify(Account $account)
  { 

    $sql = $this->dao->prepare('UPDATE account SET name = :name, pseudo = :pseudo, email = :email, pass = :pass, secret_q = :secret_q, secret_a = :secret_a, updatedAt = NOW() WHERE id= :id');
    
      $sql->bindValue(':id', $account->getId(), \PDO::PARAM_INT);
      $sql->bindValue(':name', $account->getName());
      $sql->bindValue(':pseudo', $account->getPseudo());
      $sql->bindValue(':email', $account->getEmail());
      $sql->bindValue(':pass', $account->getPass());
      $sql->bindValue(':secret_q', $account->getSecretQ());
      $sql->bindValue(':secret_a', $account->getSecretA());
 
      $sql->execute();

      $sql->closeCursor();
  } 

  public function checkPseudo($pseudo)
  {
    $sql =$this->dao->prepare('SELECT pseudo FROM account WHERE pseudo = :pseudo');
      $sql->bindValue(':pseudo', $pseudo);
    $sql->execute();

    $pseudo = $sql->fetch();

    $sql->closeCursor();

    return $pseudo;
  }

  public function updatePass($id){

  }

  public function delete($id){
    
  }
  public function getList($id){
    
  }
  public function count($id){
    
  }
}