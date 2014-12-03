<?php
session_start();
include("db.php");
$now = date('Y-m-d H:i:s');
if(isset($_POST["login"]))
{
    $username = $_POST["l_username"];
    $password = $_POST["l_password"];
    
    $username = mysql_real_escape_string(stripslashes($username));
    $password = mysql_real_escape_string(stripslashes($password));
    
	$password = md5($password);
    $query = $db->prepare("SELECT * FROM quiz_member WHERE username = :username AND password = :password");
	
	$query->bindParam(":username",$username);
	$query->bindParam(":password",$password);
	
	$query->execute();
	
	$affectedRow = $query->rowCount();
	
	if($affectedRow == 1)
	{		
		$_SESSION["u_name"] = $username;
				
		$db->query("UPDATE quiz_member SET logged=1,lastlogin='$now' WHERE username='$username'");
						
		header("location: member.php");
	}
	
}

include("class/template.php");

$scripts = array("main.js","http://code.jquery.com/jquery-latest.min.js");
$styles = array("main.css","forms.css");

$template = new Template("QuizBuilder - Easier to Build Quiz", $scripts, $styles);

$template->outPutHeader();

$template->headerBlock();

$template->navigationBlock();
?>

<div id="login">
<p>Login Form: </p>
<form action="login.php" method="post" id="login">
	<label for="l_username">Username: </label><input name="l_username" type="text" id="l_username"><br>
    <label for="l_password">Password: </label><input name="l_password" type="password" id="l_password"><br>  	
 	<input type="submit" name="login" id="login" value="Login">
</form>
</div>

<?php $template->outputFooter(); ?>
