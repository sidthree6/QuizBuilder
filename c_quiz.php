<?php
/*
 * Made By: Siddharth Panchal & Dylan Burnham
 * 
 * File Name: c_quiz.php
 * 
 * Description: This file contains data where loggedin user can edit qestions in existing quiz title.  
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

$scripts = array("main.js");
$styles = array("main.css","forms.css");

$template = new Template("QuizBuilder - Easier to Build Quiz", $scripts, $styles);

$template->outPutHeader();

$template->headerBlock(1);

$template->navigationBlockLogged($isAdmin);

?>

<article id="content">

<?php
// Get all catagories which user can edit in
$getcatagory = $db->prepare("SELECT * FROM quiz_catagory WHERE mid=".$mid);
$getcatagory->execute();

$numCatagory = $getcatagory->rowCount();
?>

<?php
if(isset($_GET['quiz_title_chosen']) && isset($_GET['create_quiz']))
{
	// If catagory is chosen
	$cid = mysql_real_escape_string(stripslashes(trim($_GET['quiz_title_chosen'])));
	
	// Get all quizes questions from the catagory selected
	$getquiz = $db->prepare("SELECT * FROM quiz_quizes WHERE cid=".$cid." AND mid=".$mid);
	$getquiz->execute();
        $getquiz->setFetchMode(PDO::FETCH_ASSOC);

        $getquizname = $db->prepare("SELECT * FROM quiz_catagory WHERE cid=".$cid." AND mid=".$mid);
        $getquizname->execute();
        $getquizname->setFetchMode(PDO::FETCH_ASSOC);
        
        $title_Cat="";
        
        if($getquizname->rowCount() == 1)
        {
            foreach($getquizname as $r)
            {
                $title_Cat = $r['title'];
            }
        }
        else
        {
            header("location: c_quiz.php");
        }
        
	?>
    <a href="c_quiz.php" id="goBackQuiz"><< Go Back</a>
    <div id="questionBlock">
        <p>Catagory: <?php echo $title_Cat; ?></p>
        <p id="shareLink">Quiz Link (Share with others): <a href="quiz.php?id=<?php echo $cid; ?>">Link</a></p>
    <p id="questionP">Questions</p>    
    <input type="button" class="add_quiz_mc" id="<?php echo $cid; ?>" value="Add Multiple Choice"> <input type="button" class="add_quiz_tf" id="<?php echo $cid; ?>" value="Add True / False">
    <?php
	if($getquiz->rowCount() <1)
	{
            echo "<p>There are no question created for this quiz.</p>";
	}
        else
        {
            $count=1;
            ?>
            <table cellspacing="0">
                <tr><th style="width:10px">Index</th><th>Question</th><th style="width:100px">Question Type</th><th style="width:50px">Action</th></tr>
            <?php
            foreach($getquiz as $r)
            {
                $typeQ = "";
                if($r['mcortf'] == 1)
                    $typeQ = "Multiple Choice";
                else
                    $typeQ = "True / False";
                echo "\n<tr class=\"".$r['qid']."\" id=\"questionOut\"><td>".$count.")</td><td style=\"width:220px;overflow:hidden\">".$r['question']."</td><td>$typeQ</td><td><a href=\"getQuiz.php?id=".$r['qid']."&cid=".$r['cid']."\"><img src=\"images/edit.png\" class=\"editQuiz\" id=\"".$r['qid']."\" /></a> <img src=\"images/delete.png\" class=\"deleteQuiz\" id=\"".$r['qid']."\" /></td></tr>\n";
                $count++;
            }
            echo "</table>";
        }
	?>
    </div>
    
    <div id="quizBlock">
        
        
        
    </div>
    
    <?php	
}
else
{
?>
    <div id="quizBlock">
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