<?php
namespace App\Backend\Model;
 
use App\Backend\Entity\Comments;
 
class CommentsManagerPDO extends CommentsManager{

  protected function add(Comments $comments) {

    $request = $this->dao->prepare('INSERT INTO comments SET account_id = :account_id, author = :author, content = :content, blog_post_id = :blog_post_id, validated = :validated, created_at = NOW()');
    
    $request->bindValue(':account_id', $comments->getAccountId());
    $request->bindValue(':blog_post_id', $comments->getblogPostId());
    $request->bindValue(':author', $comments->getAuthor());
    $request->bindValue(':content', $comments->getContent());
    $request->bindValue(':validated', null);
 
    $request->execute();
  }

  //delete comment in DB
  public function delete($id) {
    $this->dao->exec('DELETE FROM comments WHERE id = '.(int) $id);
  }

  public function getcomments($id){
    $request = $this->dao->prepare('SELECT * FROM comments WHERE blog_post_id = :blog_post_id ORDER BY created_at DESC');
    $request->bindValue('blog_post_id', (int)$id, \PDO::PARAM_INT);

    $request->execute();
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comments');
 
    $commentsList = $request->fetchAll();
 
    $request->closeCursor();
 
    return $commentsList; 
  }

  public function getCommentsList($accountId) {
    $request = $this->dao->prepare('SELECT * FROM comments WHERE account_id = :account_id ORDER BY id DESC');
    $request->bindValue('account_id', (int)$accountId, \PDO::PARAM_INT);
 
    $request->execute();
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comments');
 
    $commentsList = $request->fetchAll();
 
    $request->closeCursor();
 
    return $commentsList;
  }
  
  public function getUnique($id) {
    $request = $this->dao->prepare('SELECT id, account_id, date_p, author, content, validated, blog_post_id FROM comments WHERE id = :id');
    $request->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $request->execute();
 
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\comments');
  
    $comment = $request->fetch();
 
    return $comment;
  }

  protected function modify(Comments $comments) {

    $request = $this->dao->prepare('UPDATE comments SET account_id = :account_id, date_p = :date_p, author = :author, content = :content, validated = :validated, updated_at = NOW() WHERE id = :id');
    
    $request->bindValue(':account_id', $comments->getAccountId());
    $request->bindValue(':date_p', $comments->getDateP());
    $request->bindValue(':author', $comments->getAuthor());
    $request->bindValue(':content', $comments->getContent());
    $request->bindValue(':validated', $comments->getValidated());
    $request->bindValue(':id', $comments->getId(), \PDO::PARAM_INT);
 
    $request->execute();
  }

  public function getCommentsToModerate(){
    $request = 'SELECT * FROM comments WHERE validated is NULL';
 
    $request = $this->dao->query($request);
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comments');
 
    $commentsList = $request->fetchAll();
 
    $request->closeCursor();
 
    return $commentsList;
  }

  public function moderate($verdict, $id){
    $request = $this->dao->prepare('UPDATE comments SET validated = :validated, date_p = NOW() WHERE id = :id');

    $request->bindValue(':validated', $verdict);
    $request->bindValue(':id', $id);

    $request->execute();
  }
}