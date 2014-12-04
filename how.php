<?php
/*
 * Made By: Siddharth Panchal & Dylan Burnham
 * 
 * File Name: how.php
 * 
 * Description: How to Use page  
 */
session_start(); // Start the session to check loggedin user
include("db.php"); // Include database connection file
$isAdmin = 0; // Store admin priviliage
$logged = 0;
// Check if user is logged in
if(isset($_SESSION['u_name']))
{
	$query = $db->prepare("SELECT * FROM quiz_member WHERE username = :username");
	$query->bindParam(":username",$_SESSION['u_name']);
	$query->execute();
	
	$query->setFetchMode(PDO::FETCH_OBJ);
	$result = $query->fetch();
        $logged = $result->logged;
        if($result->type == 1)
		$isAdmin = 1;
}
// Include template
include("class/template.php");

$scripts = array("main.js","http://code.jquery.com/jquery-latest.min.js","");
$styles = array("main.css");

$template = new Template("QuizBuilder - Easier to Build Quiz", $scripts, $styles);

$template->outPutHeader();

$template->headerBlock($logged);

if($logged == 1)
    $template->navigationBlockLogged($isAdmin);
else
    $template->navigationBlock();
?>

<div id="f_content">
    <p style="font-weight: bold">How Do I Create a Quiz?</p>
    <p>Quizes can be created once you log in. After you login, navigate to "Quiz Management > Create / Edit Quiz Title" where you can see all your previously created quizes as well as option to create new one.</p>
    
    <p style="font-weight: bold">How Do I Add Question to Quiz?</p>
    <p>After the quiz title is created, you can navigate to "Quiz Management > Create / Edit Quiz Contents". It will ask you to choose quiz title first. After you choose appropriate quiz title you can create either multiple choice or true & false questions. You can add as many questions as you want. From the same page you can either edit questions content by clicking on edit button beside them or delete the question by clicking on delete button.</p>
    
    <p style="font-weight: bold">How Do I Share The Quiz I've Created?</p>
    <p>When you are adding questions to the quiz, you have an option to go to quiz link, just copy the link from browser address bar and give it to other people who wish to take a quiz.</p>
</div>

<?php $template->outputFooter(); ?>