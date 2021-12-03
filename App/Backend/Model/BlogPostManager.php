<?php
namespace App\Backend\Model;
 
use OCFram\Manager;
use App\Backend\Entity\BlogPosts;

abstract class BlogPostManager extends Manager
{
  // add a blogpost in DB
  abstract protected function add(BlogPosts $BlogPosts);
 
  //add or modify 
  public function save(BlogPosts $BlogPosts)
  {
    if ($BlogPosts->isValid())
    {
      if ($BlogPosts->isNew() == true){
        $this->add($BlogPosts);
      }else{
        $this->modify($BlogPosts);
      }
    }
    else
    {
      throw new \RuntimeException('Respectez la forme des données à saisir');
    }
  }

  //delete a blogpost from DB
  abstract public function delete($id);

  //used for connexion and disconnexion
  abstract public function getUnique($id);

  //used to get the BlogPosts list
  abstract public function getList($id);

  //counts the number of subscribers
  abstract public function count();
 
  // modify a blogpost in DB
  abstract protected function modify(BlogPosts $blogPosts);
}