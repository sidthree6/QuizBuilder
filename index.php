<?php
session_start();
include("db.php");

if(isset($_SESSION['u_name']))
{
	$query = $db->prepare("SELECT * FROM quiz_member WHERE username = :username");
	$query->bindParam(":username",$_SESSION['u_name']);
	$query->execute();
	
	$query->setFetchMode(PDO::FETCH_OBJ);
	$result = $query->fetch();

	if($result->logged == 1)
            header("location: member.php");
}

include("class/template.php");

$scripts = array("main.js","http://code.jquery.com/jquery-latest.min.js","");
$styles = array("main.css");

$template = new Template("QuizBuilder - Easier to Build Quiz", $scripts, $styles);

$template->outPutHeader();

$template->headerBlock();

$template->navigationBlock();
?>

<div class="slider"> 
 
</div>

<div id="f_content">
    <h2>What is QuizBuilder?</h2>
    <p>QuizBuilder is an automated online test taking service that allows users to login and create quizzes of their very own. These quizzes can be about anything and relate directly to the subject matter that the creator needs to learn about. It is intended mainly for learning purposes and giving users a safe and dependable platform in which to test themselves. </p>
    <h2>Why build QuizBuilder?</h2>
    <p>Throughout our university careers we have found that multiple choice quizzes are something that happen quite often. We want to make the process of studying for these quizzes as easy as possible by giving students the ability to create their own quizzes. They will be able to create tailored quizzes to their specific subject matter, store these, and redo them at later times. From this it will also give students a good reference to their University learning materials since they will be saved within our database.</p>
    <p>But why stop there?</p>
    <p>It is essentially a test taking tool and we all know that test taking does not end at the university level. Employers can test new or existing employees within companies to gain feedback or a better understanding of what systems need to be improved upon. Leaders and Managers are always looking for ways in which to improve a company’s overall quality and structure. Our safe and dependable quizzes will give them the correct feedback. This is just a small example of what we believe QuizBuilder can be useful for. There are tons people who can make use of QuizBuilder and we feel this is just the tip of the Iceburg.</p> 
    
    <h2>Is Quizbuilder Secure?</h2>
    <p>Our quizzes are completely secure and private to you and can only be shared to other users who you give the link to. They also must be a current member of our services. </p>
    <p>Admins have full control over what happens on our website. If someone is harassing one of our other users we will delete them from the service.</p>
</div>

<?php $template->outputFooter(); ?>