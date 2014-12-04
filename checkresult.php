<?php
/*
 * Made By: Siddharth Panchal & Dylan Burnham
 * 
 * File Name: checkresult.php
 * 
 * Description: This file contains data where person who completed quiz can view result.  
 */
session_start();
include("db.php");

$isAdmin = 0; // Is user Admin?
$output = "";
$mid = 0;
$now = date('Y-m-d H:i:s');
$username = "";

if(isset($_SESSION['u_name']))
{
	// Check is user is logged in.
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

}
else
{
	header("location: index.php");
}
// Include necessary html class
include("class/template.php");

$scripts = array("main.js","member.js","quiz.js");
$styles = array("main.css","forms.css");

$template = new Template("QuizBuilder - Easier to Build Quiz", $scripts, $styles);

$template->outPutHeader();

$template->headerBlock(1);

$template->navigationBlockLogged($isAdmin);

?>

<article id="content">
<?php
if(!isset($_GET['id']))
	header("location: index.php");

$id = mysql_real_escape_string(stripslashes(trim($_GET['id'])));

// Get quiz by id
$catagory = $db->prepare("SELECT * FROM quiz_catagory WHERE cid=$id");
$catagory->execute();
$catagory->setFetchMode(PDO::FETCH_OBJ);
$getCat = $catagory->fetch();
?>
<input id="hiddenID" type="hidden" value="<?php echo $id; ?>">
<a href="c_quiz.php" id="goback"><< Go Back</a>
<h2>Result For: <?php echo $getCat->title; ?></h2>
	<div id="quizresult">
    	<?php
		
		$totalQuestion = $db->prepare("SELECT * FROM quiz_quizes WHERE cid=$id");
		$totalQuestion->execute();
		
		$total = $totalQuestion->rowCount();
		
		$currentmark = 0;
		
		foreach ($_GET as $key => $value)
		{
			$answer = 1;
			if($value == "one")
				$answer = 1;
			if($value == "two")
				$answer = 2;
			if($value == "three")
				$answer = 3;
			if($value == "four")
				$answer = 4;
			if($value == "five")
				$answer = 5;
			// Check if the answer user entered matches in database
			$checkAns = $db->prepare("SELECT * FROM quiz_quizes WHERE qid=$key AND correctanswer=$answer");	
			$checkAns->execute();
			
			if($checkAns->rowCount() == 1)
			{
				$currentmark++;
			}
			
		}
		// Calculate average
		$avg = ($currentmark/$total)*100;
		$avg = number_format((float)$avg, 2, '.', '');
		
		// Output average
		?>
        <table cellspacing="0">
        	<tr><td>Total Questions: </td><td><?php echo $total; ?></td></tr>
            <tr><td>Correct Answers: </td><td><?php echo $currentmark; ?></td></tr>
            <tr><td>Your Average: </td><td><?php echo $avg; ?>%</td></tr>
        </table>
    </div>

</article>

<?php $template->outputFooter(); ?>