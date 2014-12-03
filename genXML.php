<?php
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
		
	//User Create New Catagory
	
}
else
{
	header("location: index.php");
}

if(!isset($_GET['id']))
	header("location: index.php");

$id = mysql_real_escape_string(stripslashes(trim($_GET['id'])));

$array = $db->query("SELECT * FROM quiz_quizes WHERE cid=$id")->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
?>