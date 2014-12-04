<?php
/*
 * Made By: Siddharth Panchal & Dylan Burnham
 * 
 * File Name: register.php
 * 
 * Description: Registration Page  
 */
session_start();
include("db.php");
$now = date('Y-m-d H:i:s');

$error = "";

if(isset($_POST['register']))
{
	// Get value of username and password when registration form is submited
	$username = mysql_real_escape_string(stripslashes(trim($_POST['r_username'])));
	$password = mysql_real_escape_string(stripslashes(trim($_POST['r_password'])));
	$repass = mysql_real_escape_string(stripslashes(trim($_POST['r_rpassword'])));
	
	if(empty($username) || empty($password) || empty($repass))
	{
		//Return error if any field is empty
		$error = "<div id=\"error\">Please Fill All Fields.</div>";
	}
	else
	{
		if(strlen($username) > 50 || strlen($username) < 2)
		{
			// IF wrong username size
			$error = "<div id=\"error\">Username must be between 2 to 50 character.</div>";
		}
		else
		{
			if(strlen($password) > 20 || strlen($password) < 5)
			{
				//IF wrong password size
				$error = "<div id=\"error\">Password must be between 5 to 20 character.</div>";
			}
			else
			{
				if($password != $repass)
				{
					// If password and retype password doesnt match
					$error = "<div id=\"error\">Password and Re-Password does not match.</div>";
				}
				else
				{
					// Check if user already exists
					$checkuser = $db->prepare("SELECT username FROM quiz_member WHERE username=:username");
					$checkuser->bindParam(":username",$username);
					$checkuser->execute();
					
					if($checkuser->rowCount() > 0)
					{
						$error = "<div id=\"error\">Username already exists.</div>";
					}
					else
					{
						// If no error, insert username and hashed password in database.
						$password = md5($password);
						$error = "<div id=\"success\">Account has been created. You may Login now.</div>";
						$insert = $db->prepare("INSERT INTO quiz_member (username,password,type,joindate,lastlogin) VALUES ('$username','$password',0,'$now','$now')");
						$insert->execute();
					}
				}
			}
		}
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

<div id="register">
<?php 
if(!empty($error))
{
	echo $error;
} 
?>
<p>Registration Form: </p>
<form action="register.php" method="post" id="registration">
	<div><label for="r_username">Username: </label><input name="r_username" type="text" id="r_username"></div>
    <div><label for="r_password">Password: </label><input name="r_password" type="password" id="r_password"></div>
    <div><label for="r_rpassword">Retype Password: </label><input name="r_rpassword" type="password" id="r_rpassword"></div>	  	
 	<div><label></label><input type="submit" name="register" id="register" value="Register"></div>
</form>

</div>

<?php $template->outputFooter(); ?>
