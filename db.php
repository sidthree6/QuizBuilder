<?php

define("server","localhost");
define("dbname","quizbuilder");
define("dbuser","root");
define("dbpass","dbpass");

$db = new PDO("mysql:host=".server.";dbname=".dbname,dbuser, dbpass);


?>