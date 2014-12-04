<?php
/*
 * Made By: Siddharth Panchal & Dylan Burnham
 * 
 * File Name: genXML.php
 * 
 * Description: Json File which output quiz question in json format which is captured by ajax.  
 */
session_start();
header('Content-Type: application/json');
include("db.php");

$isAdmin = 0; // Is user Admin?
$output = "";
$mid = 0;
$now = date('Y-m-d H:i:s');
$username = "";

if(isset($_SESSION['u_name']))
{
	// Check is user is logged in.
	$query = $db->prepare("SELECT * FROM quiz_member WHERE username = :username");
	$query->bindParam(":username",$_SESSION['u_name']);
	$query->execute();
	
	$query->setFetchMode(PDO::FETCH_OBJ);
	$result = $query->fetch();
	
	if($result->logged == 0)
		header("location: index.php");
	
	$mid = $result->mid;
	$username = $result->username;
	
	if($result->type == 1)
		$isAdmin = 1;
	
}
else
{
	header("location: index.php");
}

if(!isset($_GET['id']))
	header("location: index.php");

$id = mysql_real_escape_string(stripslashes(trim($_GET['id'])));
// Get the quiz contents with id supplied
$array = $db->query("SELECT * FROM quiz_quizes WHERE cid=$id")->fetchAll(PDO::FETCH_ASSOC);
// Encode the data returned by query into json
echo json_encode($array);
?>