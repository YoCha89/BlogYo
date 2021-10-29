<?php
namespace App\Backend\Model;
 
use App\Backend\Entity\Account;
 
class AccountManagerPDO extends AccountManager
{
   //used for connexion (id still unknown)
  public function getAccountPerPseudo($pseudo){

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
    $sql = $this->dao->prepare('INSERT INTO account SET name = :name, pseudo = :pseudo, email = :email, pass = :pass, secret_q = :secret_q, secret_a = :secret_a, created_at = NOW(), updated_at = null');
  
    $sql->bindValue(':name', $account->getName());
    $sql->bindValue(':pseudo', $account->getPseudo());
    $sql->bindValue(':email', $account->getEmail());
    $sql->bindValue(':pass', $account->getPass());
    $sql->bindValue(':secret_q', $account->getSecretQ());
    $sql->bindValue(':secret_a', $account->getSecretA());

    $sql->execute();
  
    $account->setId($this->dao->lastInsertId());

    $sql->closeCursor();
  }

  public function modify(Account $account)
  { 

    $sql = $this->dao->prepare('UPDATE account SET name = :name, pseudo = :pseudo, email = :email, pass = :pass, secret_q = :secret_q, secret_a = :secret_a, updated_at = NOW() WHERE id= :id');
    
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

  public function updatePass($id, $pass){

    $sql->bindValue(':id', $account->getId(), \PDO::PARAM_INT);
    $sql = $this->dao->prepare('UPDATE account SET pass = :pass, updated_at = NOW() WHERE id= :id');

    $sql->bindValue(':id', $id, \PDO::PARAM_INT);
    $sql->bindValue(':pass', $pass->getPass());
    
    $sql->execute();

    $sql->closeCursor();
  }

  public function delete($id){
    
  }
  public function getList($id){
    
  }
  public function count($id){
    
  }
}