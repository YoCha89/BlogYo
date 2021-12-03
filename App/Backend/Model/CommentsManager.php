<?php
namespace App\Backend\Model;
 
use OCFram\Manager;
use App\Backend\Entity\Comments;
 
abstract class CommentsManager extends Manager
{
  //add comment in DB
  abstract protected function add(Comments $comments);
 
  //add or modify 
  public function save(Comments $comments)
  {
    if ($comments->isValid())
    {
      $comments->isNew() ? $this->add($comments) : $this->modify($comments);
    }
    else
    {
      throw new \RuntimeException('Respectez la forme des données à saisir');
    }
  }

  //delete comment in DB
  abstract public function delete($id);

  //Fetch a specific comment
  abstract public function getUnique($id);

  // fetch the comments of a blogpost
  abstract public function getComments($id);

  //fetch the comments of a user
  abstract public function getCommentsList($accountId);

  //used to get the Comments to moderate
  abstract public function getCommentsToModerate();
 
  // Modify a comment in DB
  abstract protected function modify(Comments $comments);

  // Setup the "validated" attribute of comment, deciding if its displayed
  abstract public function moderate($verdict, $id);
}