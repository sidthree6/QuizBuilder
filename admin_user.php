<?php
session_start();
include("db.php");

$isAdmin = 0; // Is user Admin?
$output = "";
$mid = 0;
$now = date('Y-m-d H:i:s');
$username = "";
$error = "";

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

include("class/template.php");

$scripts = array("main.js");
$styles = array("main.css","forms.css");

$template = new Template("QuizBuilder - Easier to Build Quiz", $scripts, $styles);

$template->outPutHeader();

$template->headerBlock(1);

$template->navigationBlockLogged($isAdmin);

?>

<article id="content">

<div id="adminLog">

<?php

$log = $db->prepare("SELECT * FROM quiz_member");
$log->execute();
$log->setFetchMode(PDO::FETCH_OBJ);

$count = 1;
?>
<h2>Users List:</h2>
<table cellspacing="0">
	<tr><th style="width:10px">Index</th><th>Username</th><th style="width:100px">Last Login</th><th style="width:100px">Action</th></tr>
<?php
foreach($log as $r)
{
	if($r->type != 1)
	{
		echo "<tr class=\"".$r->mid."\"><td>$count</td><td>".$r->username."</td><td>".$r->lastlogin."</td><td><img src=\"images/delete.png\" class=\"deleteUser\" id=\"".$r->mid."\" /></td></tr>";
		$count++;
	}
}

?>

</div>

</article>

<?php $template->outputFooter(); ?>