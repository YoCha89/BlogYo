<?php
namespace App\Backend\Model;
 
use Entity\Comments;
 
class CommentsManagerPDO extends CommentsManager
{
  protected function add(Comments $Comments)
  {
    $request = $this->dao->prepare('INSERT INTO Comments SET account_id = :account_id, date_p = :date_p, author = :author, content = :content, last_connexion = :last_connexion, validated = :validated, created_at = NOW(), updated_at = NOW()');
    
    $request->bindValue(':account_id', $Comments->accountId());
    $request->bindValue(':date_p', $Comments->dateP());
    $request->bindValue(':author', $Comments->author());
    $request->bindValue(':content', $Comments->content());
    $request->bindValue(':last_connexion', $Comments->lastConnexion());
    $request->bindValue(':validated', $Comments->validated());
 
    $request->execute();
  }

  public function countA($id)
  {
    $request = $this->dao->query('SELECT COUNT(*) FROM comments WHERE account_id : account_id')->fetchColumn();

    $request->bindValue(':account_id', (int) $account_id, \PDO::PARAM_INT);
 
     return $this->dao->query($request);
  }
 
  public function delete($id)
  {
    $this->dao->exec('DELETE FROM Comments WHERE id = '.(int) $id);
  }

  public function getComments($id){
    $request = $this->dao->prepare('SELECT * FROM comments WHERE blog_post_id : blog_post_id ORDER BY created_at DESC');
    $request->bindValue(':blog_post_id', (int)$id, \PDO::PARAM_INT);

    $request->execute();
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comments');
 
    $CommentsList = $request->fetchAll();
 
    foreach ($listeComments as $Comments)
    {
      $Comments->setCreatedAt(new \DateTime($Comments->createdAt()));
      $Comments->setUpdatedAt(new \DateTime($Comments->updatedAt()));
    }
 
    $request->closeCursor();
 
    return $CommentsList; 
  }
 
  public function getAccountList($accountId)
  {
    $request = 'SELECT id, account_id, last_connexion, date_p, author, content, validated FROM comments WHERE account_id : account_id ORDER BY id DESC';
    $request->bindValue(':account_id', (int) $account_id, \PDO::PARAM_INT);
 
    $request = $this->dao->query($request);
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comments');
 
    $CommentsList = $request->fetchAll();
 
    foreach ($listeComments as $Comments)
    {
      $Comments->setCreatedAt(new \DateTime($Comments->createdAt()));
      $Comments->setUpdatedAt(new \DateTime($Comments->updatedAt()));
    }
 
    $request->closeCursor();
 
    return $CommentsList;
  }
 
  public function getUnique($id)
  {
    $request = $this->dao->prepare('SELECT id, account_id, last_connexion, date_p, author, content, validated FROM comments WHERE id = :id');
    $request->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $request->execute();
 
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comments');
 
    if ($Comments = $request->fetch())
    {
      $Comments->setCreatedAt(new \DateTime($Comments->createdAt()));
      $Comments->setUpdatedAt(new \DateTime($Comments->updatedAt()));
 
      return $Comments;
    }
 
    return null;
  }
 
  protected function modify(Comments $Comments)
  {
    $request = $this->dao->prepare('UPDATE comments SET account_id = :account_id, date_p = :date_p, author = :author, content = :content, last_connexion = :last_connexion, validated = :validated, updated_at = NOW() WHERE id = :id');
    
    $request->bindValue(':account_id', $Comments->accountId());
    $request->bindValue(':date_p', $Comments->dateP());
    $request->bindValue(':author', $Comments->author());
    $request->bindValue(':content', $Comments->content());
    $request->bindValue(':last_connexion', $Comments->lastConnexion());
    $request->bindValue(':validated', $Comments->validated());
    $request->bindValue(':id', $Comments->id(), \PDO::PARAM_INT);
 
    $request->execute();
  }
}