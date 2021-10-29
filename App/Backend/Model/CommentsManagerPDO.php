<?php
namespace App\Backend\Model;
 
use App\Backend\Entity\Comments;
 
class CommentsManagerPDO extends CommentsManager
{
  protected function add(Comments $comments)
  {
    $request = $this->dao->prepare('INSERT INTO comments SET account_id = :account_id, author = :author, content = :content, blog_post_id = :blog_post_id, created_at = NOW()');
    
    $request->bindValue(':account_id', $comments->getAccountId());
    $request->bindValue(':blog_post_id', $comments->getblogPostId());
    $request->bindValue(':author', $comments->getAuthor());
    $request->bindValue(':content', $comments->getContent());
 
    $request->execute();
  }

  public function countA($id)
  {
    $request = $this->dao->query('SELECT COUNT(*) FROM comments WHERE account_id :account_id')->fetchColumn();

    $request->bindValue(':account_id', (int) $account_id, \PDO::PARAM_INT);
 
     return $this->dao->query($request);
  }
 
  public function delete($id)
  {
    $this->dao->exec('DELETE FROM comments WHERE id = '.(int) $id);
  }

  public function getcomments($id){
    $request = $this->dao->prepare('SELECT * FROM comments WHERE blog_post_id = :blog_post_id ORDER BY created_at DESC');
    $request->bindValue('blog_post_id', (int)$id, \PDO::PARAM_INT);

    $request->execute();
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comments');
 
    $commentsList = $request->fetchAll();
 
    /*foreach ($commentsList as $comments)
    {
      $comments->setCreatedAt(new \DateTime($comments->getCreatedAt()));
      $comments->setUpdatedAt(new \DateTime($comments->getUpdatedAt()));
    }*/
 
    $request->closeCursor();
 
    return $commentsList; 
  }
 
  public function getCommentsList($accountId)
  {
    $request = 'SELECT id, account_id, last_connexion, date_p, author, content, validated FROM comments WHERE account_id = :account_id ORDER BY id DESC';
    $request->bindValue(':account_id', (int) $account_id, \PDO::PARAM_INT);
 
    $request = $this->dao->query($request);
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comments');
 
    $commentsList = $request->fetchAll();
 
   /* foreach ($listecomments as $comments)
    {
      $comments->setCreatedAt(new \DateTime($comments->createdAt()));
      $comments->setUpdatedAt(new \DateTime($comments->updatedAt()));
    }*/
 
    $request->closeCursor();
 
    return $commentsList;
  }
 
  public function getUnique($id)
  {
    $request = $this->dao->prepare('SELECT id, account_id, last_connexion, date_p, author, content, validated FROM comments WHERE id = :id');
    $request->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $request->execute();
 
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\comments');
 
    if ($comments = $request->fetch())
    {
      $comments->setCreatedAt(new \DateTime($comments->createdAt()));
      $comments->setUpdatedAt(new \DateTime($comments->updatedAt()));
 
      return $comments;
    }
 
    return null;
  }
 
  protected function modify(Comments $comments)
  {
    $request = $this->dao->prepare('UPDATE comments SET account_id = :account_id, date_p = :date_p, author = :author, content = :content, last_connexion = :last_connexion, validated = :validated, updated_at = NOW() WHERE id = :id');
    
    $request->bindValue(':account_id', $comments->getAccountId());
    $request->bindValue(':last_connexion', $comments->getLastConnexion());
    $request->bindValue(':date_p', $comments->getDateP());
    $request->bindValue(':author', $comments->getAuthor());
    $request->bindValue(':content', $comments->getContent());
    $request->bindValue(':validated', $comments->getValidated());
    $request->bindValue(':id', $comments->id(), \PDO::PARAM_INT);
 
    $request->execute();
  }
}