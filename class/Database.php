<?php

class Database {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $db;
    
   function __construct($name="",$dbn="", $user="", $pass="") {
       $this->setServerName($name);
       $this->setDatabaseName($dbn);
       $this->setUserName($user);
       $this->setPassword($pass);
   }
   
   protected function setServerName($name) {
       $this->servername = $name;
   }
   
   protected function setDatabaseName($dbn) {
       $this->dbname = $dbn;
   }
   
   protected function setUserName($user) {
       $this->username = $user;
   }
   
   protected function setPassword($pass) {
       $this->password = $pass;
   }
   
   public function connect($released="released") {
       try
       {
           $this->db = new PDO("mysql:host=$this->servername;dbname=$this->dbname",$this->username, $this->password);
           if($released == "debug") {
               echo "Connected to $this->dbname successfully<br/>";
           }
       }
       catch(PDOException $e)
       {
           if($released == "debug") {
                echo $e->getMessage();
           }
       }
   }
   
   public function query($query="")
   {
       $this->db->query($query);
   }
   
   public function close() {
       $this->db = NULL;
   }
}

?>