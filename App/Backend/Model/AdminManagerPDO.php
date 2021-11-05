<?php
namespace App\Backend\Model;
 
use App\Backend\Entity\Admin;
 
class AdminManagerPDO extends AdminManager
{
  public function getAdminPerPseudo($pseudo){

    $sql =$this->dao->prepare('SELECT id, name, pseudo, email, pass FROM admin WHERE pseudo = :pseudo');
    
    $sql->bindValue(':pseudo', $pseudo);

    $sql->execute();

    $sql->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Admin');
    $admin = $sql->fetch();

    $sql->closeCursor();

    return $admin;     
  }

  protected function add(Admin $admin)
  {
    $request = $this->dao->prepare('INSERT INTO admin SET name = :name, pseudo = :pseudo, pass = :pass, email = :email, created_at = NOW(), updated_at = NOW()');
 
    $request->bindValue(':pseudo', $Admin->getPseudo());
    $request->bindValue(':name', $Admin->getName());
    $request->bindValue(':pass', $Admin->getPass());
    $request->bindValue(':email', $Admin->getEmail());
 
    $request->execute();
  }
 
  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM Admin')->fetchColumn();
  }
 
  public function delete($id)
  {
    $this->dao->exec('DELETE FROM admin WHERE id = '.(int) $id);
  }
 
  public function getList($debut = -1, $limite = -1)
  {
    $sql = 'SELECT id, name, pseudo, pass, email, created_at, updated_at FROM Admin ORDER BY id DESC';
 
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
 
    $request = $this->dao->query($sql);
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Admin');
 
    $AdminList = $request->fetchAll();
 
   /* foreach ($listeAdmin as $Admin)
    {
      $Admin->setCreated_at(new \DateTime($Admin->created_at()));
      $Admin->setUpdated_at(new \DateTime($Admin->updated_at()));
    }*/
 
    $request->closeCursor();
 
    return $AdminList;
  }
 
  public function getUnique($id)
  {
    $request = $this->dao->prepare('SELECT id, name, pseudo, pass, email, created_at, updated_at FROM admin WHERE id = :id');
    $request->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $request->execute();
 
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Admin');

    $Admin = $request->fetch();

    return $Admin;
  }
 
  protected function modify(Admin $admin)
  {
    $request = $this->dao->prepare('UPDATE admin SET name = :name, pseudo = :pseudo, pass = :pass, email = :email, updated_at = NOW() WHERE id = :id');
 
    $request->bindValue(':pseudo', $Admin->getPseudo());
    $request->bindValue(':name', $Admin->getName());
    $request->bindValue(':pass', $Admin->getPass());
    $request->bindValue(':email', $Admin->getEmail());
    $request->bindValue(':id', $Admin->id(), \PDO::PARAM_INT);
 
    $request->execute();
  }  

  public function checkPseudo($pseudo)
  {
    $sql =$this->dao->prepare('SELECT pseudo FROM admin WHERE pseudo = :pseudo');
    $sql->bindValue(':pseudo', $pseudo);
    $sql->execute();

    $pseudo = $sql->fetch();

    $sql->closeCursor();

    return $pseudo;
  }
}