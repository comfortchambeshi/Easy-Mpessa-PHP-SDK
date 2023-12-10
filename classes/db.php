<?php

class db{

private $dbname = "MPESSA";
private $dbhost = "localhost";
private $dbuser = "batcall";
private $dbpwd = "nnnnnnnn";

protected function connect(){

$dsn = 'mysql:host='.$this->dbhost.';dbname='.$this->dbname.'';
$pdo = new PDO($dsn, $this->dbuser, $this->dbpwd);

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
return $pdo;

}




}


?>