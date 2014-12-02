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

$scripts = array("main.js","member.js");
$styles = array("main.css","forms.css");

$template = new Template("QuizBuilder - Easier to Build Quiz", $scripts, $styles);

$template->outPutHeader();

$template->headerBlock(1);

$template->navigationBlockLogged($isAdmin);

//$template->sidebarBlock($isAdmin);
?>

<article id="content">

<?php
$getcatagory = $db->prepare("SELECT * FROM quiz_catagory WHERE mid=".$mid);
$getcatagory->execute();

$numCatagory = $getcatagory->rowCount();
?>

<?php
if(isset($_GET['quiz_title_chosen']) && isset($_GET['create_quiz']))
{
	$cid = mysql_real_escape_string(stripslashes(trim($_GET['quiz_title_chosen'])));
	
	$getquiz = $db->prepare("SELECT * FROM quiz_quizes WHERE cid=".$cid." AND mid=".$mid);
	$getquiz->execute();
	
	?>
    <div id="questionBlock">
    <p id="questionP">Questions</p>
    <input type="button" class="add_quiz_mc" id="<?php echo $cid; ?>" value="Add Multiple Choice"> <input type="button" class="add_quiz_tf" id="<?php echo $cid; ?>" value="Add True / False">
    <?php
	if($getquiz->rowCount() <1)
	{
		echo "<p>There are no question created for this quiz.</p>";
	}
	?>
    </div>
    
    <div id="quizBlock">
    
    <?php	
}
else
{
?>
	<h2>Choose Quiz Title</h2>
    
    <?php
	if($numCatagory < 1)
	{
		echo "<p>Please create <span style=\"font-weight:bold\">Quiz Title</span> first.</p>";
	}
	else
	{
	?>		
		<form action="c_quiz.php" method="get" id="quiz_create">
			<div class="tr"><label>Quiz: </label><select name="quiz_title_chosen">
			<?php 
			foreach($db->query("SELECT * FROM quiz_catagory WHERE mid=".$mid) as $r)
			{
				echo "<option value=\"".$r['cid']."\">".$r['title']."</option>";
			}
			?>
            </select></div>
			<div class="tr"><label></label><input type="submit" name="create_quiz" id="create_quiz" value="Choose Quiz Title"></div>
		</form>
    <?php
	}
}
	?>
</div>

</article>

<?php $template->outputFooter(); ?>