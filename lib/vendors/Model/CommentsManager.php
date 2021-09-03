<?php
namespace Model;
 
use \OCFram\Manager;
use \Entity\Comments;
 
abstract class CommentsManager extends Manager
{
  abstract protected function add(Comments $Comments);
 
  //add or modify 
  public function save(Comments $Comments)
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
  abstract public function getOne($id);

  //used to get the Comments list of a specific account
  abstract public function getAccountList($id);

  //counts the number of subscribers
  abstract public function count($id);
 
  abstract protected function modify(News $news);
}