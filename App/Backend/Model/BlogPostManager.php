<?php
namespace App\Backend\Model;
 
use OCFram\Manager;
use App\Backend\Entity\BlogPosts;

abstract class BlogPostManager extends Manager
{
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

  abstract public function delete($id);

  //used for connexion and disconnexion
  abstract public function getUnique($id);

  //used to get the BlogPosts list
  abstract public function getList($id);

  //counts the number of subscribers
  abstract public function count();
 
  abstract protected function modify(BlogPosts $blogPosts);
}