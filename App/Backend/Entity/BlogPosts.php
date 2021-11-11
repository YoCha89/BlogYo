<?php
namespace App\Backend\Entity;

use OCFram\Entity;

class BlogPosts extends Entity
{
	protected $id,
            $adminId,
            $content,
            $title,
            $slug,
            $createdAt,
            $updatedAt;


  const CONTENT_NOT_VALIDE = 1;
  const TITLE_NOT_VALIDE = 2;

  public function isValid(){
    if (!empty($this->getAdminId()) && !empty($this->getContent()) && !empty($this->getTitle()) && !empty($this->getSlug())){
      return true;
    }else{
      return false;
    }
  }

  public function isNew(){
    if($this->getId() != null){
      return false;
    }
    return true;
  }

  // GETTERS //
  public function getId()
  {
    return $this->id;
  }

  public function getAdminId()
  {
    return $this->adminId;
  }

  public function getContent()
  {
   return $this->content;
  }

  public function getTitle()
  {
   return $this->title;
  }

  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

  public function getSlug()
  {
   return $this->slug;
  }

 // SETTERS //

  public function setAdminId($adminId)
  {
    $this->adminId = $adminId;
  }

  public function setContent($content)
  {
    if (!is_string($content) || empty($content))
    {
      $this->erreurs[] = self::CONTENT_INVALIDE;
    }

    $this->content = $content;
  }

  public function setTitle($title)
  {
    if (!is_string($title) || empty($title))
    {
      $this->erreurs[] = self::TITLE_NOT_VALIDE;
    }

    $this->title = $title;
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