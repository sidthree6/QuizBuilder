<?php
/*
 * Made By: Siddharth Panchal & Dylan Burnham
 * 
 * File Name: logout.php
 * 
 * Description: Logout user  
 */
session_start();
include("db.php");
if(isset($_SESSION['u_name']))
{
	// Update user logged value
	$db->query("UPDATE quiz_member SET logged=0 WHERE username='".$_SESSION['u_name']."'");
}
// Destroy session and redirect user to main page
session_destroy();

header("location: index.php");
?>