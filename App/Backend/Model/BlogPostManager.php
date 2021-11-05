<?php
namespace App\Backend\Model;
 
use OCFram\Manager;
use Entity\BlogPosts;

abstract class BlogPostManager extends Manager
{
  abstract protected function add(BlogPosts $BlogPosts);
 
  //add or modify 
  public function save(BlogPosts $BlogPosts)
  {
    if ($BlogPosts->isValid())
    {
      $BlogPosts->isNew() ? $this->add($BlogPosts) : $this->modify($BlogPosts);
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