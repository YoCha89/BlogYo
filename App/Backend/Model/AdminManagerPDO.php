<?php
namespace App\Backend\Model;
 
use App\Backend\Entity\Admin;
 
class AdminManagerPDO extends AdminManager
{
  public function getAdminPerPseudo($pseudo) {

    $sql =$this->dao->prepare('SELECT id, pseudo, email, pass FROM admin WHERE pseudo = :pseudo');
    
    $sql->bindValue(':pseudo', $pseudo);

    $sql->execute();

    $sql->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Admin');
    $admin = $sql->fetch();

    $sql->closeCursor();

    return $admin;     
  }

  protected function add(Admin $admin) {
    $request = $this->dao->prepare('INSERT INTO admin SET pseudo = :pseudo, pass = :pass, email = :email, created_at = NOW(), updated_at = NOW()');
 
    $request->bindValue(':pseudo', $admin->getPseudo());
    $request->bindValue(':pass', $admin->getPass());
    $request->bindValue(':email', $admin->getEmail());
 
    $request->execute();
  }
 
  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM admin')->fetchColumn();
  }
 
  public function delete($id)
  {
    $this->dao->exec('DELETE FROM admin WHERE id = '.(int) $id);
  }
 
  public function getList($debut = -1, $limite = -1) {
    $sql = 'SELECT id, pseudo, pass, email, created_at, updated_at FROM admin ORDER BY id DESC';
 
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
 
    $request = $this->dao->query($sql);
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Admin');
 
    $adminList = $request->fetchAll();
 
    $request->closeCursor();
 
    return $adminList;
  }
 
  public function getUnique($id) {
    $request = $this->dao->prepare('SELECT id, pseudo, pass, email, created_at, updated_at FROM admin WHERE id = :id');
    $request->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $request->execute();
 
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Admin');

    $admin = $request->fetch();

    return $admin;
  }
 
  protected function modify(Admin $admin) {
    $request = $this->dao->prepare('UPDATE admin SET pseudo = :pseudo, pass = :pass, email = :email, updated_at = NOW() WHERE id = :id');
 
    $request->bindValue(':pseudo', $admin->getPseudo());
    $request->bindValue(':pass', $admin->getPass());
    $request->bindValue(':email', $admin->getEmail());
    $request->bindValue(':id', $admin->getId(), \PDO::PARAM_INT);
 
    $request->execute();
  }  

  public function checkPseudo($pseudo) {
    $sql =$this->dao->prepare('SELECT pseudo FROM admin WHERE pseudo = :pseudo');
    $sql->bindValue(':pseudo', $pseudo);
    $sql->execute();

    $pseudo = $sql->fetch();

    $sql->closeCursor();

    return $pseudo;
  }
}