<?php
namespace App\Backend\Model;
 
use Entity\Account;
 
class AccountManagerPDO extends AccountManager
{
   //used for connexion (id still unknown)
  public function getAccountPerPseudo($peuso){

    $sql =$this->dao->prepare('SELECT id, name, pseudo, email, pass, secretQ, secretA FROM account WHERE pseudo = :pseudo');

    $sql->bindValue(':pseudo', $pseudo);

    $sql->execute();

    $sql->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');
    $account = $sql->fetch();

    $sql->closeCursor();

    return $account; 
  }

  public function getAccount($id)
  {
    $sql =$this->dao->prepare('SELECT id, name, pseudo, email, pass, secretQ, secretA FROM account WHERE id = :id');
    
    $sql->bindValue(':id', (int)$id, \PDO::PARAM_INT);
    $sql->execute();

    $sql->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');
    $account = $sql->fetch();

    $sql->closeCursor();

    return $account;
  }

  public function add(Account $account){
    $sql = $this->dao->prepare('INSERT INTO account SET name = :name, pseudo = :pseudo, email = :email, pass = :pass, secretQ = :secretQ, secretA = :secretA, createdAt = NOW(), updatedAt = null');
  
    $sql->bindValue(':name', $account->name());
    $sql->bindValue(':firstName', $account->firstName());
    $sql->bindValue(':userName', $account->userName());
    $sql->bindValue(':pass', $account->pass());
    $sql->bindValue(':secretQ', $account->secretQ());
    $sql->bindValue(':secretA', $account->secretA());

    $sql->execute();
  
    $account->setId($this->dao->lastInsertId());

    $sql->closeCursor();
  }

  public function modify(Account $account)
  { 

    $sql = $this->dao->prepare('UPDATE employees SET name = :name, pseudo = :pseudo, email = :email, pass = :pass, secretQ = :secretQ, secretA = :secretA, updatedAt = NOW() WHERE id= :id');
    
      $sql->bindValue(':id', $account->id(), \PDO::PARAM_INT);
      $sql->bindValue(':name', $account->name());
      $sql->bindValue(':pseudo', $account->pseudo());
      $sql->bindValue(':email', $account->email());
      $sql->bindValue(':pass', $account->pass());
      $sql->bindValue(':secretQ', $account->secretQ());
      $sql->bindValue(':secretA', $account->secretA());
 
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