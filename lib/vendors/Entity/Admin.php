<?php
namespace Entity;

use \OCFram\Entity;

class Admin extends Entity
{
	protected $id,
            $name,
            $pseudo,
            $pass,
            $email,
            $createdAt,
            $updatedAt;

  const NAME_NOT_VALIDE = 1;
	const PSEUDO_NOT_VALIDE = 2;
	const PASS_NOT_VALIDE = 3;
	const EMAIL_NOT_VALIDE = 4;

  protected function createAdmin(){

  }

  protected function suppressAdmin(){

  }

  protected function modifyAdmin(){

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

  public function createdAt()
  {
    return $this->createdAt;
  }

  public function updatedAt()
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