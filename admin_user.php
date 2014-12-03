<?php/*
 * Made By: Siddharth Panchal & Dylan Burnham
 * 
 * File Name: admin_user.php
 * 
 * Description: This file contains admin panel where admin can delete and view other users  
 */
session_start();
include("db.php");

$isAdmin = 0; // Is user Admin?
$output = "";
$mid = 0;
$now = date('Y-m-d H:i:s');
$username = "";
$error = "";

// Check if user is logged in
if(isset($_SESSION['u_name']))
{
	$query = $db->prepare("SELECT * FROM quiz_member WHERE username = :username");
	$query->bindParam(":username",$_SESSION['u_name']);
	$query->execute();
	
	$query->setFetchMode(PDO::FETCH_OBJ);
	$result = $query->fetch();
	
        // If user is not logged, redirect him to front page
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
// Get all users available
$log = $db->prepare("SELECT * FROM quiz_member");
$log->execute(); // Execute the query
$log->setFetchMode(PDO::FETCH_OBJ); // Get returned data in object form

$count = 1;
?>
<h2>Users List:</h2>
<table cellspacing="0">
	<tr><th style="width:10px">Index</th><th>Username</th><th style="width:100px">Last Login</th><th style="width:100px">Action</th></tr>
<?php
// Loop through all users and display them in table
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

</div>
</body>
</html>