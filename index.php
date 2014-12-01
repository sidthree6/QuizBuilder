<?php
session_start();
include("db.php");

if(isset($_SESSION['u_name']))
{
	$query = $db->prepare("SELECT * FROM quiz_member WHERE username = :username");
	$query->bindParam(":username",$_SESSION['u_name']);
	$query->execute();
	
	$query->setFetchMode(PDO::FETCH_OBJ);
	$result = $query->fetch();

	if($result->logged == 1)
            header("location: member.php");
}

include("class/template.php");

$scripts = array("main.js","http://code.jquery.com/jquery-latest.min.js");
$styles = array("main.css");

$template = new Template("QuizBuilder - Easier to Build Quiz", $scripts, $styles);

$template->outPutHeader();

$template->headerBlock();

$template->navigationBlock();
?>

<div style="padding:20px;"><p>Registration Form: </p>
<form action="register.php" method="post" id="registration">
	<label for="r_fname">First Name: </label><input name="r_fname" type="text" id="r_fname"><br>
    <label for="r_lname">Last Name: </label><input name="r_lname" type="text" id="r_lname"><br>
	<label for="r_username">Username: </label><input name="r_username" type="text" id="r_username"><br>
    <label for="r_email">Email Address: </label><input name="r_email" type="text" id="r_email"><br>
    <label for="r_password">Password: </label><input name="r_password" type="password" id="r_password"><br>
    <label for="r_rpassword">Retype Password: </label><input name="r_rpassword" type="password" id="r_rpassword"><br>	  	
 	<input type="submit" name="register" id="register" value="Register">
</form>

</div>

<?php $template->outputFooter(); ?>