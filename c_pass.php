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

if(isset($_POST['change']))
{
	$cpass = mysql_real_escape_string(stripslashes(trim($_POST['c_pass'])));
	$npass = mysql_real_escape_string(stripslashes(trim($_POST['n_pass'])));
	$nrpass = mysql_real_escape_string(stripslashes(trim($_POST['n_rpass'])));
	
	if(empty($cpass) || empty($npass) || empty($nrpass))
	{
		$error = "<div id=\"error\">Please Fill All Fields.</div>";
	}
	else
	{
		if(strlen($npass) > 20 || strlen($npass) < 5)
		{
			$error = "<div id=\"error\">Password must be between 5 to 20 character.</div>";
		}
		else
		{
			if($npass != $nrpass)
			{
				$error = "<div id=\"error\">New Password and Retype New Password does not match.</div>";
			}
			else
			{
				$cpass = md5($cpass);
				$checpass = $db->prepare("SELECT password FROM quiz_member WHERE password=:password AND mid=$mid");
				$checpass->bindParam(":password",$cpass);
				$checpass->execute();
				
				if($checpass->rowCount() != 1)
				{
					$error = "<div id=\"error\">Current Password does not match.</div>";
				}
				else
				{
					$error = "<div id=\"success\">Password has ben changed.</div>";
					$npass = md5($npass);
					$updatepass = $db->prepare("UPDATE quiz_member SET password=:pass WHERE mid=$mid");
					$updatepass->bindParam(":pass",$npass);
					$updatepass->execute();
				}
			}
		}
	}
}
?>

<article id="content">

<div id="changePassword">
<?php
echo $error;
?>
<p>Change Password: </p>
<form action="c_pass.php" method="post" id="changepass">
	<div><label for="c_pass">Current Password: </label><input name="c_pass" type="password" id="c_pass"></div>
    <div><label for="n_pass">New Password: </label><input name="n_pass" type="password" id="n_pass"></div>
    <div><label for="n_rpass">Retype New Password: </label><input name="n_rpass" type="password" id="n_rpass"></div>	  	
 	<div><label></label><input type="submit" name="change" id="change" value="Change Password"></div>
</form>

</div>

</article>

<?php $template->outputFooter(); ?>