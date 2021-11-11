<?php
namespace App\Backend\Entity;

use OCFram\Entity;

class Admin extends Entity
{
	protected $id,
            $name,
            $pseudo,
            $pass,
            $email,
            $confirmed,
            $createdAt,
            $updatedAt;

  const NAME_NOT_VALIDE = 1;
	const PSEUDO_NOT_VALIDE = 2;
	const PASS_NOT_VALIDE = 3;
	const EMAIL_NOT_VALIDE = 4;

  // GETTERS //
  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
   return $this->name;
  }

  public function getPseudo()
  {
    return $this->pseudo;
  }

  public function getPmail()
  {
   return $this->email;
  }

  public function getPass()
  {
    return $this->pass;
  }

  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

 // SETTERS //
  public function setName($name)
  {
    if (!is_string($name) || empty($name))
    {
      $this->erreurs[] = self::NOM_NON_VALIDE;
    }
    $this->name = $name;
  }

  public function setPseudo($pseudo)
  {
    if (!is_string($pseudo) || empty($pseudo))
    {
      $this->erreurs[] = self::PSEUDO_NOT_VALIDE;
    }
    $this->firstName = $firstName;
  }

  public function setEmail($email)
  {
    if (!is_string($email) || empty($email))
    {
      if(!preg_match("/^([w-.]+)@((?:[w]+.)+)([a-zA-Z]{2,4})/i", $email)){
        $this->erreurs[] = self::EMAIL_NOT_VALIDE;
      }
    }
    $this->email = $email;
  }

  public function setPass($pass)
  {
    if (!is_string($pass) || empty($pass))
    {
      if(!preg_match("/^([w-.]+)@((?:[w]+.)+)([a-zA-Z]{2,4})/i", $pass)){
        $this->erreurs[] = self::PASS_NOT_VALIDE;
      }
    }
    $this->pass = $pass;
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