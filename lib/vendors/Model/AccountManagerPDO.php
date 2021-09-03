<?php
namespace Model;
 
use \Entity\Account;
 
class AccountManagerPDO extends AccountManager
{
  protected function add(Account $Account)
  {
    $request = $this->dao->prepare('INSERT INTO Account SET name = :name, pseudo = :pseudo, pass = :pass, email = :email, secretQ = :secretQ, secretA = :secretA, createdAt = NOW(), updatedAt = NOW()');
 
    $request->bindValue(':pseudo', $Account->pseudo());
    $request->bindValue(':name', $Account->name());
    $request->bindValue(':pass', $Account->pass());
    $request->bindValue(':secretQ', $Account->secretQ());
    $request->bindValue(':secretA', $Account->secretA());
    $request->bindValue(':email', $Account->email());
 
    $request->execute();
  }
 
  public function count()
  {
    return $this->dao->query('SELET COUNT(*) FROM Account')->fetchColumn();
  }
 
  public function delete($id)
  {
    $this->dao->exec('DELETE FROM Account WHERE id = '.(int) $id);
  }
 
  public function getList($debut = -1, $limite = -1)
  {
    $sql = 'SELECT id, name, pseudo, pass, email, secretQ, secretA, createdAt, updatedAt FROM Account ORDER BY id DESC';
 
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
 
    $request = $this->dao->query($sql);
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');
 
    $accountList = $request->fetchAll();
 
    foreach ($listeAccount as $Account)
    {
      $Account->setCreatedAt(new \DateTime($Account->createdAt()));
      $Account->setUpdatedAt(new \DateTime($Account->updatedAt()));
    }
 
    $request->closeCursor();
 
    return $accountList;
  }
 
  public function getUnique($id)
  {
    $request = $this->dao->prepare('SELECT id, name, pseudo, pass, email, secretQ, secretA, createdAt, updatedAt FROM Account WHERE id = :id');
    $request->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $request->execute();
 
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Account');
 
    if ($Account = $request->fetch())
    {
      $Account->setCreatedAt(new \DateTime($Account->createdAt()));
      $Account->setUpdatedAt(new \DateTime($Account->updatedAt()));
 
      return $Account;
    }
 
    return null;
  }
 
  protected function modify(Account $Account)
  {
    $request = $this->dao->prepare('UPDATE Account SET name = :name, pseudo = :pseudo, pass = :pass, email = :email, secretQ = :secretQ, secretA = :secretA, updatedAt = NOW() WHERE id = :id');
 
    $request->bindValue(':pseudo', $Account->pseudo());
    $request->bindValue(':name', $Account->name());
    $request->bindValue(':pass', $Account->pass());
    $request->bindValue(':secretQ', $Account->secretQ());
    $request->bindValue(':secretA', $Account->secretA());
    $request->bindValue(':email', $Account->email());
    $request->bindValue(':id', $Account->id(), \PDO::PARAM_INT);
 
    $request->execute();
  }
}