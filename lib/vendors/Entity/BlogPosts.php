<?php
namespace Entity;

use \OCFram\Entity;

class BlogPosts extends Entity
{
	protected $id,
            $adminId,
            $dateP,
            $title,
            $content,
            $media,
            $slug,
            $createdAt,
            $updatedAt;


  const CONTENT_NOT_VALIDE = 1;
  const TITLE_NOT_VALIDE = 2;

protected function createBlogPost(){

}

protected function suppressBlogPost(){

}

protected function modifyBlogPost(){

}

  // GETTERS //
  public function id()
  {
    return $this->id;
  }

  public function adminId()
  {
    return $this->adminId;
  }

  public function dateP()
  {
   return $this->dateP;
  }

  public function content()
  {
   return $this->content;
  }

  public function title()
  {
   return $this->title;
  }

  public function createdAt()
  {
    return $this->createdAt;
  }

  public function updatedAt()
  {
    return $this->updatedAt;
  }

  public function media()
  {
   return $this->media;
  }

  public function slug()
  {
   return $this->slug;
  }

 // SETTERS //

  public function setadminId($adminId)
  {
    $this->adminId = $adminId;
  }

  public function setDateP($dateP)
  {
    $this->dateP = $dateP;
  }

  public function setContent($content)
  {
    if (!is_string($content) || empty($content))
    {
      $this->erreurs[] = self::CONTENT_INVALIDE;
    }

    $this->content = $content;
  }

  public function setContent($title)
  {
    if (!is_string($title) || empty($title))
    {
      $this->erreurs[] = self::TITLE_INVALIDE;
    }

    $this->title = $title;
  }

  public function setMedia($media)
  {
    $this->media = $media;
  }
  
  public function setSlug($slug)
  {
    $this->slug = $slug;
  }

  public function setCreatedAt(\DateTime $creationDate)
  {
    $this->createdAt = $createdAt;
  }

  public function setUpdatedAt(\DateTime $creationDate)
  {
    $this->updatedAt = $updatedAt;
  }
}