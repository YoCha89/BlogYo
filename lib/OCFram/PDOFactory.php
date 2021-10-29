<?php
namespace OCFram;

//classe gérant l'API PDO pour communiquer avec la base de données.  
class PDOFactory
{
  public static function getMysqlConnexion()
  {
    $db = new \PDO('mysql:host=localhost;dbname=blogyo', 'root', 'root');
    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
 
    return $db;
  }
}