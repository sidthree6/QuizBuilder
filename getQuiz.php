<?php
/*
 * Made By: Siddharth Panchal & Dylan Burnham
 * 
 * File Name: genQuiz.php
 * 
 * Description: Get quiz to edit by id supplied.  
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
if(isset($_GET['id']) && isset($_GET['cid']))
{
	// Get quiz id and quiztitle id
	$qid = mysql_real_escape_string(stripslashes(trim($_GET['id'])));
	$cid = mysql_real_escape_string(stripslashes(trim($_GET['cid'])));
	
	// Get quiz by id, only if user who posted is editing
	$getQuestion = $db->prepare("SELECT * FROM quiz_quizes WHERE qid=$qid AND mid=$mid");
	$getQuestion->execute();
	
	$getQuestion->setFetchMode(PDO::FETCH_OBJ);
	$quizQ = $getQuestion->fetch();
	
	$affectedQuiz = $getQuestion->rowCount();
	
	if($affectedQuiz !== 1)
		header("location: c_quiz.php");
		
	$threechecked = "";
	$fourchecked = "";
	$fivechecked = "";
	
	if(!empty($quizQ->answerThree))
	{
		$threechecked = "selected=selected";
	}
	if(!empty($quizQ->answerFour))
	{
		$threechecked = "";
		$fourchecked  = "selected=selected";
	}
	if(!empty($quizQ->answerFive))
	{
		$threechecked = "";
		$fourchecked  = "";
		$fivechecked  = "selected=selected";
	}
	
	$output  = "<h3>Editing Question:</h3>\n";
	if($quizQ->mcortf == 1)
	{
		$output .= "Number of Options: <select id=\"howmanyoption\"><option value=\"3\" $threechecked>Three</option><option value=\"4\" $fourchecked>Four</option><option value=\"5\" $fivechecked>Five</option></select>\n<br/><br/>";
	}
	$output .= "<textarea id=\"questionText\" cols=\"125\" rows=\"3\">".$quizQ->question."</textarea>\n<br/>";
	
	$countquestion = 0;
	$checked = "";
	
	if($quizQ->mcortf == 1)
	{
		$output .= "<div id=\"MCEdit\">\n";
		$output .= "<div id=\"oneDiv\">";
		if(!empty($quizQ->answerOne))
		{
			if($quizQ->correctanswer == 1)
				$checked = "checked=checked";                                       
			$output .= "<input type=\"radio\" name=\"answer\" value=\"one\" $checked> <textarea id=\"oneT\" cols=\"121\">".$quizQ->answerOne."</textarea>\n<br/>";

			$checked = "";
		}
		$output .= "</div>"; 
		
		$output .= "<div id=\"twoDiv\">";
		if(!empty($quizQ->answerTwo))
		{
			if($quizQ->correctanswer == 2)
				$checked = "checked=checked";
			$output .= "<input type=\"radio\" name=\"answer\" value=\"two\" $checked> <textarea id=\"twoT\" cols=\"121\">".$quizQ->answerTwo."</textarea>\n<br/>";

			$checked = "";
		}  
		$output .= "</div>"; 
		
		$output .= "<div id=\"threeDiv\">";                                  
		if(!empty($quizQ->answerThree))
		{
			if($quizQ->correctanswer == 3)
				$checked = "checked=checked";
			$output .= "<input type=\"radio\" name=\"answer\" value=\"three\" $checked> <textarea id=\"threeT\" cols=\"121\">".$quizQ->answerThree."</textarea>\n<br/>";

			$checked = "";
		}             
		$output .= "</div>"; 
		
		$output .= "<div id=\"fourDiv\">";                       
		if(!empty($quizQ->answerFour))
		{
			if($quizQ->correctanswer == 4)
				$checked = "checked=checked";
			$output .= "<input type=\"radio\" name=\"answer\" value=\"four\" $checked> <textarea id=\"fourT\" cols=\"121\">".$quizQ->answerFour."</textarea>\n<br/>";

			$checked = "";
		}          
		$output .= "</div>"; 
		      
		$output .= "<div id=\"fiveDiv\">";                    
		if(!empty($quizQ->answerFive))
		{
			if($quizQ->correctanswer == 5)
				$checked = "checked=checked";
			$output .= "<input type=\"radio\" name=\"answer\" value=\"five\" $checked> <textarea id=\"fiveT\" cols=\"121\">".$quizQ->answerFive."</textarea>\n<br/>";

			$checked = "";
		}
		$output .= "</div>\n"; 
		$output .= "</div>"; 												
	}
	else
	{
		$output .= "<div id=\"MCEdit\">\n";
		if(!empty($quizQ->answerOne))
		{
			if($quizQ->correctanswer == 1)
				$checked = "checked=checked";                                       
			$output .= "<input type=\"radio\" name=\"answer\" value=\"true\" $checked> True\n<br/>";

			$checked = "";
		}
		if(!empty($quizQ->answerTwo))
		{
			if($quizQ->correctanswer == 2)
				$checked = "checked=checked";
			$output .= "<input type=\"radio\" name=\"answer\" value=\"false\" $checked> False\n<br/>";

			$checked = "";
		}
		$output .= "\n</div>";
	}
	
	$output .= "<input type=\"hidden\" value=\"".$cid."\" id=\"hiddenCid\">";	
	$output .= "<input type=\"hidden\" value=\"".$qid."\" id=\"hiddenQid\">";								
	$output .= "<input type=\"button\" value=\"Save Quiz\" name=\"saveQuiz\" id=\"saveQuiz_".$quizQ->mcortf."\"> <input type=\"button\" value=\"Close Without Saving\" name=\"closeQuiz\" id=\"closeQuiz\">";
	
	/*
	Above code snippet gets how many field is selected by quiz maker and only show specified field. It also input only selected amount of field in database with correct answer.
	*/
	
	echo $output;
	
}
else
{
	header("location: c_quiz.php");
}
?>

</article>

<?php $template->outputFooter(); ?>