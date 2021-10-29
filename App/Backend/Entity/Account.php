<?php
namespace App\Backend\Entity;

use OCFram\Entity;

class Account extends Entity
{
	protected $id,
            $name,
            $pseudo,
            $pass,
            $email,
            $secretQ,
            $secretA,
            $createdAt,
            $updatedAt,
            $lastConnexion;

  const NAME_NOT_VALIDE = 1;
	const PSEUDO_NOT_VALIDE = 2;
	const PASS_NOT_VALIDE = 3;
	const EMAIL_NOT_VALIDE = 4;
	const SECRET_QUESTION_NOT_VALIDE = 5;
	const SECRET_ANSWER_NOT_VALIDE = 6;

  //use for directing account data modification toward creation or update
  public function isNew(){
    return null !== $this->getId();
  }

  public function isValid(){
    if (!empty($this->getName()) && !empty($this->getPseudo()) && !empty($this->getPass()) && !empty($this->getEmail()) && !empty($this->getSecretQ()) && !empty($this->getSecretA())){
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

  public function getName()
  {
   return $this->name;
  }

  public function getPseudo()
  {
    return $this->pseudo;
  }

  public function getEmail()
  {
   return $this->email;
  }

  public function getPass()
  {
    return $this->pass;
  }

   public function getSecretQ()
  {
    return $this->secretQ;
  }

   public function getSecretA()
  {
    return $this->secretA;
  }

  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

  public function getLastConnexion()
  {
    return $this->lastConnexion;
  }


 // SETTERS //
  public function setId($id)
  {
    $this->id = $id;
  }

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
    $this->pseudo = $pseudo;
  }

  public function setEmail($email)
  {
    if (!is_string($email) || empty($email))
    {
      if(!preg_match("/^([w\-.]+)@((?:[w]+.)+)([a-zA-Z]{2,4})/i", $email)){
        $this->erreurs[] = self::EMAIL_NOT_VALIDE;
      }
    }
    $this->email = $email;
  }

  public function setPass($pass)
  {
    if (!is_string($pass) || empty($pass))
    {
      if(!preg_match("/^([w\-.]+)@((?:[w]+.)+)([a-zA-Z]{2,4})/i", $pass)){
        $this->erreurs[] = self::PASS_NOT_VALIDE;
      }
    }
    $this->pass = $pass;
  }

   public function setSecretQ($secretQ)
  {
    if (!is_string($secretQ) || empty($secretQ))
    {
      $this->erreurs[] = self::SECRET_QUESTION_NOT_VALIDE;
    }
    $this->secretQ = $secretQ;
  }

   public function setSecretA($secretA)
  {
    if (!is_string($secretA) || empty($secretA))
    {
      $this->erreurs[] = self::SECRET_ANSWER_NOT_VALIDE;
    }
    $this->secretA = $secretA;
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
}