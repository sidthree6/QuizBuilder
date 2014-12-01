<?php
session_start();
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
	if(isset($_GET['action']))
	{
		/*$c_name = mysql_real_escape_string(stripslashes($_POST['c_name']));
		$catagory = $db->prepare("SELECT title FROM quiz_catagory WHERE title=:title");
		$catagory->bindParam(":title",$c_name);
		$catagory->execute();
		
		$affectedRow = $catagory->rowCount();
		if(empty($c_name))
		{
			$output = "<p class=\"error\">A catagory must have a name.</p>";
		}
		else
		{
			if($affectedRow == 0)
			{			
				$db->query("INSERT INTO quiz_catagory (mid,title,datecreated) VALUES ($mid,'$c_name','$now')");
				$output = "<p class=\"success\">A catagory with the name \"$c_name\" has been created.</p>";
			}
			else
			{
				$output = "<p class=\"error\">A catagory with the name \"$c_name\" already exist. Please choose another name.</p>";
			}
		}*/
		echo "Submited";
	}
}
else
{
	header("location: index.php");
}
 
?>