<?php
namespace App\Backend\Model;
 
use OCFram\Manager;
use Entity\Comments;
 
abstract class CommentsManager extends Manager
{
  abstract protected function add(Comments $comments);
 
  //add or modify 
  public function save(Comments $comments)
  {
    if ($Comments->isValid())
    {
      $Comments->isNew() ? $this->add($Comments) : $this->modify($Comments);
    }
    else
    {
      throw new \RuntimeException('Respectez la forme des données à saisir');
    }
  }

  abstract public function delete($id);

  //used for connexion and disconnexion
  abstract public function getUnique($id);

  //used to get the Comments list of a blogPost
  abstract public function getComments($id);

  //used to get the Comments list of a specific account
  abstract public function getCommentsList($accountId);

  //counts the number of comments for a blogPost or from a subscriber
  abstract public function countA($id);

  //used to get the Comments to moderate
  abstract public function getCommentsToModerate();
 
  abstract protected function modify(Comments $comments);

  //apply validation or rejection status to a comment
  abstract public function moderate($verdict, $id);
}