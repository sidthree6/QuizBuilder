<?php
session_start();
include("db.php");
if(isset($_SESSION['u_name']))
{
	$db->query("UPDATE quiz_member SET logged=0 WHERE username='".$_SESSION['u_name']."'");
}

session_destroy();

header("location: index.php");
?>