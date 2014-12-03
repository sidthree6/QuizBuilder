<?php
session_start();
include("db.php");

$isAdmin = 0; // Is user Admin?
$output = "";
$mid = 0;
$now = date('Y-m-d H:i:s');
$username = "";

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

$scripts = array("main.js","member.js","quiz.js");
$styles = array("main.css","forms.css");

$template = new Template("QuizBuilder - Easier to Build Quiz", $scripts, $styles);

$template->outPutHeader();

$template->headerBlock(1);

$template->navigationBlockLogged($isAdmin);

//$template->sidebarBlock($isAdmin);
?>

<article id="content">
<?php
if(!isset($_GET['id']))
	header("location: index.php");

$id = mysql_real_escape_string(stripslashes(trim($_GET['id'])));

$catagory = $db->prepare("SELECT * FROM quiz_catagory WHERE cid=$id");
$catagory->execute();
$catagory->setFetchMode(PDO::FETCH_OBJ);
$getCat = $catagory->fetch();
?>
<input id="hiddenID" type="hidden" value="<?php echo $id; ?>">
<h2>Quiz Title: <?php echo $getCat->title; ?></h2>
	<div id="mainquiz">
    	
    </div>

</article>

<?php $template->outputFooter(); ?>