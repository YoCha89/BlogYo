<?php
namespace Entity;

use \OCFram\Entity;

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
            $updatedAt;
            $lastConnexion;

  const NAME_NOT_VALIDE = 1;
	const PSEUDO_NOT_VALIDE = 2;
	const PASS_NOT_VALIDE = 3;
	const EMAIL_NOT_VALIDE = 4;
	const SECRET_QUESTION_NOT_VALIDE = 5;
	const SECRET_ANSWER_NOT_VALIDE = 6;

  protected function createAccount(){

  }

  protected function suppressAccount(){

  }

  protected function modifyAccount(){

  }

  //use for directing account data modification toward creation or update
  protected function isNew(){
    return isset($this->getId());
  }




  // GETTERS //
  public function id()
  {
    return $this->id;
  }

  public function name()
  {
   return $this->name;
  }

  public function pseudo()
  {
    return $this->pseudo;
  }

  public function email()
  {
   return $this->email;
  }

  public function pass()
  {
    return $this->pass;
  }

   public function secretQ()
  {
    return $this->secretQ;
  }

   public function secretA()
  {
    return $this->secretA;
  }

  public function createdAt()
  {
    return $this->createdAt;
  }

  public function updatedAt()
  {
    return $this->updatedAt;
  }

  public function lastConnexion()
  {
    return $this->lastConnexion;
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