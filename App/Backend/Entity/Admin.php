<?php
namespace App\Backend\Entity;

use OCFram\Entity;

class Admin extends Entity
{
	protected $id,
            $pseudo,
            $pass,
            $email,
            $confirmed,
            $createdAt,
            $updatedAt;

	const PSEUDO_NOT_VALIDE = 2;
	const PASS_NOT_VALIDE = 3;
	const EMAIL_NOT_VALIDE = 4;

  public function isValid(){

    if (!empty($this->getEmail()) && !empty($this->getPseudo()) && !empty($this->getPass())){
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

  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

 // SETTERS //

  public function setPseudo($pseudo) {
    if (!is_string($pseudo) || empty($pseudo))
    {
      $this->erreurs[] = self::PSEUDO_NOT_VALIDE;
    }
    $this->pseudo = $pseudo;
  }

  public function setEmail($email) {
    if (is_string($email) || !empty($email)) {
      if(!preg_match("/^([w\-.]+)@((?:[w]+.)+)([a-zA-Z]{2,4})/i", $email)){
        $this->erreurs[] = self::EMAIL_NOT_VALIDE;
      }

      $this->email = $email;
    }
  }

  public function setPass($pass) {
    if (is_string($pass) || !empty($pass)) {
      if((strlen($pass) > 40) != true){
        if(!preg_match("/^([w\-.]+)@((?:[w]+.)+)([a-zA-Z]{2,4})/i", $pass)) {
          $this->erreurs[] = self::PASS_NOT_VALIDE;
        }        

        $this->pass = $pass;
      }

      $this->pass = $pass;
    }
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