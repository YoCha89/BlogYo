<?php
namespace Entity;

use \OCFram\Entity;

class Comments extends Entity
{
	protected $id,
            $accountId,
            $author,
            $dateP,
            $content,
            $createdAt,
            $updatedAt,
            $validated,
            $lastConnexion;


  const CONTENU_INVALIDE = 1;

protected function createComment(){

}

protected function suppressComment(){

}

protected function modifyComment(){
  
}

  // GETTERS //
  public function id()
  {
    return $this->id;
  }

  public function accountId()
  {
    return $this->accountId;
  }

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

  public function validated()
  {
   return $this->validated;
  }

  public function account()
  {
   return $this->account;
  }

  public function lastConnexion()
  {
    return $this->lastConnexion;
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

  public function setLastConnexion(\DateTime $creationDate)
  {
    $this->lastConnexion = $lastConnexion;
  }

  public function setValidated($validated)
  {
    $this->validated = $validated;
  }

  public function setAccountId($account)
  {
    $this->accountId = $accountId;
  }
}