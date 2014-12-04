<?php
/*
 * Made By: Siddharth Panchal & Dylan Burnham
 * 
 * File Name: db.php
 * 
 * Description: Main database connection file PDO is connected through here and included in all files.  
 */
define("server","localhost");
define("dbname","quizbuilder");
define("dbuser","root");
define("dbpass","dbpass");

$db = new PDO("mysql:host=".server.";dbname=".dbname,dbuser, dbpass);


?>