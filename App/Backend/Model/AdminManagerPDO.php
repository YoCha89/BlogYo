<?php
namespace Model;
 
use Entity\Admin;
 
class AdminManagerPDO extends AdminManager
{
  protected function add(Admin $Admin)
  {
    $request = $this->dao->prepare('INSERT INTO Admin SET name = :name, pseudo = :pseudo, pass = :pass, email = :email, createdAt = NOW(), updatedAt = NOW()');
 
    $request->bindValue(':pseudo', $Admin->pseudo());
    $request->bindValue(':name', $Admin->name());
    $request->bindValue(':pass', $Admin->pass());
    $request->bindValue(':email', $Admin->email());
 
    $request->execute();
  }
 
  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM Admin')->fetchColumn();
  }
 
  public function delete($id)
  {
    $this->dao->exec('DELETE FROM Admin WHERE id = '.(int) $id);
  }
 
  public function getList($debut = -1, $limite = -1)
  {
    $sql = 'SELECT id, name, pseudo, pass, email, createdAt, updatedAt FROM Admin ORDER BY id DESC';
 
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
 
    $request = $this->dao->query($sql);
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Admin');
 
    $AdminList = $request->fetchAll();
 
    foreach ($listeAdmin as $Admin)
    {
      $Admin->setCreatedAt(new \DateTime($Admin->createdAt()));
      $Admin->setUpdatedAt(new \DateTime($Admin->updatedAt()));
    }
 
    $request->closeCursor();
 
    return $AdminList;
  }
 
  public function getUnique($id)
  {
    $request = $this->dao->prepare('SELECT id, name, pseudo, pass, email, createdAt, updatedAt FROM Admin WHERE id = :id');
    $request->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $request->execute();
 
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Admin');
 
    if ($Admin = $request->fetch())
    {
      $Admin->setCreatedAt(new \DateTime($Admin->createdAt()));
      $Admin->setUpdatedAt(new \DateTime($Admin->updatedAt()));
 
      return $Admin;
    }
 
    return null;
  }
 
  protected function modify(Admin $Admin)
  {
    $request = $this->dao->prepare('UPDATE Admin SET name = :name, pseudo = :pseudo, pass = :pass, email = :email, updatedAt = NOW() WHERE id = :id');
 
    $request->bindValue(':pseudo', $Admin->pseudo());
    $request->bindValue(':name', $Admin->name());
    $request->bindValue(':pass', $Admin->pass());
    $request->bindValue(':email', $Admin->email());
    $request->bindValue(':id', $Admin->id(), \PDO::PARAM_INT);
 
    $request->execute();
  }
}