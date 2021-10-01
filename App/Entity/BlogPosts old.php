<?php
namespace Entity;

use \OCFram\Entity;

class BlogPosts extends Entity
{
	protected $author,
            $dateP,
            $content,
            $media,
            $slug,
            $createdAt,
            $updatedAt;


  const CONTENT_NOT_VALIDE = 1;

protected function createBlogPost(){

}

protected function suppressBlogPost(){

}

protected function modifyBlogPost(){

}

  // GETTERS //
  public function author()
  {
    return $this->author;
  }

  public function dateP()
  {
   return $this->dateP;
  }

  public function content()
  {
   return $this->content;
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

  public function setAuthor($author)
  {
    $this->author = $author;
  }

  public function setDateP($dateP)
  {
    $this->dateP = $dateP;
  }

  public function setContent($content)
  {
    if (!is_string($content) || empty($content))
    {
      $this->erreurs[] = self::CONTENU_INVALIDE;
    }

    $this->content = $content;
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