<?php
/*
 * Made By: Siddharth Panchal & Dylan Burnham
 * 
 * File Name: about.php
 * 
 * Description: This file contains a company overview  
 */
session_start(); // Start the session to check loggedin user
include("db.php"); // Include database connection file
$isAdmin = 0; // Store admin priviliage
$logged = 0;
// Check if user is logged in
if(isset($_SESSION['u_name']))
{
	$query = $db->prepare("SELECT * FROM quiz_member WHERE username = :username");
	$query->bindParam(":username",$_SESSION['u_name']);
	$query->execute();
	
	$query->setFetchMode(PDO::FETCH_OBJ);
	$result = $query->fetch();
        $logged = $result->logged;
        if($result->type == 1)
		$isAdmin = 1;
}
// Include template
include("class/template.php");

$scripts = array("main.js","http://code.jquery.com/jquery-latest.min.js","");
$styles = array("main.css");

$template = new Template("QuizBuilder - Easier to Build Quiz", $scripts, $styles);

$template->outPutHeader();

$template->headerBlock($logged);

if($logged == 1)
    $template->navigationBlockLogged($isAdmin);
else
    $template->navigationBlock();
?>

<div id="f_content">
    <h2>About Us</h2>
    <p>QuizBuilder was created by Siddharth Panchal and Dylan Burnham, two game development and entrepreneurship from UOIT.  Throughout the past four years we have been working on the same gaming team, Kanata. Kanata games was created four years ago and was finalized with the creation of our first game Falling Into Darkness, a game in which you descend into madness into a world where absolutely nothing is going right. Since then we have also developed two more titles together being, Blue Screen, a science fiction FPS, and The Followers, an open world RPG. Some of these games have been more successful than others as we have progressed through our program and we hope to expand and finish some of the ideas.</p>
</div>

<?php $template->outputFooter(); ?>