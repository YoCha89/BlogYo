<?php
namespace App\Backend\Entity;

use OCFram\Entity;

class Comments extends Entity
{
	protected $id,
            $blogPostId,
            $accountId,
            $author,
            $dateP,
            $content,
            $createdAt,
            $updatedAt,
            $validated;


  const CONTENU_INVALIDE = 1;

  public function isValid(){
    // var_dump($this->getBlogPostId(), $this->getContent(), $this->getAuthor());die;
    if (!empty($this->getBlogPostId()) && !empty($this->getContent()) && !empty($this->getAuthor())){
      return true;
    }else{
      return false;
    }
  }

  // GETTERS //
  public function getId()
  {
    return $this->id;
  }

  public function getAccountId()
  {
    return $this->accountId;
  }

  public function getBlogPostId()
  {
    return $this->blogPostId;
  }

  public function getAuthor()
  {
    return $this->author;
  }

  public function getDateP()
  {
   return $this->dateP;
  }

  public function getContent()
  {
   return $this->content;
  }

  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

  public function getValidated()
  {
   return $this->validated;
  }

  public function getAccount()
  {
   return $this->account;
  }

 // SETTERS //

  public function setAuthor($author)
  {
    if (!is_string($author) || empty($author))
    {
      $this->erreurs[] = self::CONTENU_INVALIDE;
    }

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

  public function setCreatedAt(\DateTime $creationDate)
  {
    $this->createdAt = $createdAt;
  }

  public function setUpdatedAt(\DateTime $creationDate)
  {
    $this->updatedAt = $updatedAt;
  }

  public function setValidated($validated)
  {
    $this->validated = $validated;
  }

  public function setAccountId($account)
  {
    $this->accountId = $accountId;
  }

  public function setBlogPostId($blogPost)
  {
    $this->accountId = $blogPostId;
  }
}