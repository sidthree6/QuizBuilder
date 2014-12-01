<?php
session_start();
include("db.php");

$isAdmin = 0; // Is user Admin?
$output = "";
$mid = 0;
$now = date('Y-m-d H:i:s');

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
	
	if($result->type == 1)
		$isAdmin = 1;
		
	//User Create New Catagory
	if(isset($_POST['create_cat']))
	{
		$c_name = mysql_real_escape_string(stripslashes($_POST['c_name']));
		$catagory = $db->prepare("SELECT title FROM quiz_catagory WHERE title=:title");
		$catagory->bindParam(":title",$c_name);
		$catagory->execute();
		
		$affectedRow = $catagory->rowCount();
		if($affectedRow == 0)
		{			
			$db->query("INSERT INTO quiz_catagory (mid,title,datecreated) VALUES ($mid,'$c_name','$now')");
			$output = "<p class=\"success\">A catagory with the name \"$c_name\" has been created</p>";
		}
		else
		{
			$output = "<p class=\"error\">A catagory with the name \"$c_name\" already exist. Please choose another name</p>";
		}
	}
}
else
{
	header("location: index.php");
}

include("class/template.php");

$scripts = array("main.js","http://code.jquery.com/jquery-latest.min.js");
$styles = array("main.css","forms.css");

$template = new Template("QuizBuilder - Easier to Build Quiz", $scripts, $styles);

$template->outPutHeader();

$template->headerBlock(1);

$template->navigationBlock();

$template->sidebarBlock($isAdmin);
?>

<article id="content">

<h2>Create A New Catagory</h2>
<?php
if($output != "")
{
	echo $output;
}
?>
<form action="c_catagory.php" method="post" id="catagory_create">
	<div class="tr"><label>Catagory Name: </label><input type="text" name="c_name" id="c_name"></div>
    <div class="tr"><label></label><input type="submit" name="create_cat" id="create_cat" value="Create Catagory"></div>
</form>

</article>

<?php $template->outputFooter(); ?>