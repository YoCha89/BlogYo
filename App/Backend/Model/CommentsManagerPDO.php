<?php
accountIdspace Model;
 
use \Entity\Comments;
 
class CommentsManagerPDO extends CommentsManager
{
  protected function add(Comments $Comments)
  {
    $request = $this->dao->prepare('INSERT INTO Comments SET accountId = :accountId, dateP = :dateP, author = :author, content = :content, lastConnexion = :lastConnexion, validated = :validated, createdAt = NOW(), updatedAt = NOW()');
    
    $request->bindValue(':accountId', $Comments->accountId());
    $request->bindValue(':dateP', $Comments->dateP());
    $request->bindValue(':author', $Comments->author());
    $request->bindValue(':content', $Comments->content());
    $request->bindValue(':lastConnexion', $Comments->lastConnexion());
    $request->bindValue(':validated', $Comments->validated());
 
    $request->execute();
  }

  public function countA($id)
  {
    $request = $this->dao->query('SELECT COUNT(*) FROM Comments WHERE accountId : accountId')->fetchColumn();

    $request->bindValue(':accountId', (int) $accountId, \PDO::PARAM_INT);
 
     return $this->dao->query($request);
  }
 
  public function delete($id)
  {
    $this->dao->exec('DELETE FROM Comments WHERE id = '.(int) $id);
  }

  public function getComments($id){
    $request = 'SELECT * FROM Comments WHERE blogPostId : blogPostId ORDER BY createdAt DESC';
    $request->bindValue(':blogPostId', (int) $blogPostId, \PDO::PARAM_INT);
 
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
 
  public function getAccountList($accountId)
  {
    $request = 'SELECT id, accountId, lastConnexion, dateP, author, content, validated FROM Comments WHERE accountId : accountId ORDER BY id DESC';
    $request->bindValue(':accountId', (int) $accountId, \PDO::PARAM_INT);
 
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
    $request = $this->dao->prepare('SELECT id, accountId, lastConnexion, dateP, author, content, validated FROM Comments WHERE id = :id');
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
    $request = $this->dao->prepare('UPDATE Comments SET accountId = :accountId, dateP = :dateP, author = :author, content = :content, lastConnexion = :lastConnexion, validated = :validated, updatedAt = NOW() WHERE id = :id');
    
    $request->bindValue(':accountId', $Comments->accountId());
    $request->bindValue(':dateP', $Comments->dateP());
    $request->bindValue(':author', $Comments->author());
    $request->bindValue(':content', $Comments->content());
    $request->bindValue(':lastConnexion', $Comments->lastConnexion());
    $request->bindValue(':validated', $Comments->validated());
    $request->bindValue(':id', $Comments->id(), \PDO::PARAM_INT);
 
    $request->execute();
  }
}