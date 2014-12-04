<?php
/*
 * Made By: Siddharth Panchal & Dylan Burnham
 * 
 * File Name: ajax.php
 * 
 * Description: This file will handle all ajax request from php side.  
 */
session_start(); // Start session
include("db.php"); // Include database

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
	
        // If action and member id is defined
	if(isset($_GET['action']) && isset($_GET['mid']))
	{
		// Store values in a string
		$action = mysql_real_escape_string(stripslashes(trim($_GET['action'])));
        $memid     = mysql_real_escape_string(stripslashes(trim($_GET['mid'])));
		//Check if its an admin, because only admin can delete user
		if($isAdmin == 1)
		{
                    //Delete the user
			if($action == "deleteuser")
			{
				$del = $db->prepare("DELETE FROM quiz_member WHERE mid=".$memid);
				$del->execute();
				
				echo "deleted";
			}
		}
	}
	//User Create New Catagory
	if(isset($_GET['action']) && isset($_GET['id']))
	{
			// Get action and ID, and also value if its set
            $action = mysql_real_escape_string(stripslashes(trim($_GET['action'])));
            $id     = mysql_real_escape_string(stripslashes(trim($_GET['id'])));
            $value  = "";
            $cid = 0;
            if(isset($_GET['cid']))
            {
                    $cid = mysql_real_escape_string(stripslashes(trim($_GET['cid'])));
            }
            else
            {
                    $cid=0;
            }

            if(isset($_GET['value']))
                    $value = $_GET['value'];			

            $check = $db->prepare("SELECT mid FROM quiz_catagory WHERE cid=".$id);
            // Change SQL query based on which actions were specified to check if its the same user editing content who has created it
            if($action == "delete")
                $check = $db->prepare("SELECT mid FROM quiz_catagory WHERE cid=".$id);
            if($action == "deletequiz")
                $check = $db->prepare("SELECT mid FROM quiz_quizes WHERE qid=".$id);
            if($action == "addquiz")
                $check = $db->prepare("SELECT mid FROM quiz_catagory WHERE cid=".$id);
            if($action == "savemc" || $action == "savetf")
                $check = $db->prepare("SELECT mid FROM quiz_catagory WHERE cid=".$cid);
            // Execute
            $check->execute();
            $check->setFetchMode(PDO::FETCH_ASSOC);
            $checkResult = $check->fetch();
            
            // Only perform action if right user is performing action or user is an admin
            if($checkResult['mid'] == $mid || $isAdmin == 1)
            {
				// Delete Title
				if($action == "delete")
				{
					// Delete the Quiz Title
					$del = $db->prepare("DELETE FROM quiz_catagory WHERE cid=".$id);
					$del->execute();
					// Also delete all the quiz question under that title
					$del = $db->prepare("DELETE FROM quiz_quizes WHERE cid=".$id);
					$del->execute();
					
					echo "deleted";
				}
				//Delete Quiz
				if($action == "deletequiz")
				{
					// Delete specified quiz
					$del = $db->prepare("DELETE FROM quiz_quizes WHERE qid=".$id);
					$del->execute();						
					
					echo "deleted";
				}
				// Edit Title
				if($action == "edit" && !empty($value))
				{
					// Get value of edited title
					$value = mysql_real_escape_string(stripslashes(trim($value)));
					// Title cant be less than 1 or more than 100 word
					if(strlen($value) < 1 || strlen($value) > 100)
					{
						echo "wrongsize";
					}
					else
					{
						// Update the quiz title
						$edit = $db->query("UPDATE quiz_catagory SET title='".$value."' WHERE cid=".$id);
						echo "edited";
					}
				}
				
				if($action == "addquiz" && !empty($value))
				{
					// Add quiz to database
					if($value == "mc")
					{
						$question     = "Sample Question";
						$answerOne    = "Option One";
						$answerTwo    = "Option Two";
						$answerThree  = "Option Three";
						$answerFour   = "Option Four";
						$correctanswer= 1;
						$mcortf		  = 1;
						// Insert sample questions and option to database, so user can edit it later.
						$db->query("INSERT INTO quiz_quizes (mid,cid,question,answerOne,answerTwo,answerThree,answerFour,correctanswer,mcortf,datecreated) VALUES ($mid,$id,'$question','$answerOne','$answerTwo','$answerThree','$answerFour',$correctanswer,$mcortf,'$now')");
											
						echo "1";
					}
                    if($value == "tf")
					{
						$question     = "Sample True/False Question";
						$answerOne    = "True";
						$answerTwo    = "False";
						$correctanswer= 1;
						$mcortf	      = 2;
						
						$db->query("INSERT INTO quiz_quizes (mid,cid,question,answerOne,answerTwo,correctanswer,mcortf,datecreated) VALUES ($mid,$id,'$question','$answerOne','$answerTwo',$correctanswer,$mcortf,'$now')");
												
						echo "2";
					}
				} 
											
				if($action == "savetf")
				{
					// If some requires items are not found, redirect user to main page.
					if(!isset($_GET['correct']))
						header("location: c_quiz.php");
					if(!isset($_GET['question']))
						header("location: c_quiz.php");
					
					$correct = 	mysql_real_escape_string(stripslashes(trim($_GET['correct'])));
					$quesion = 	mysql_real_escape_string(stripslashes(trim($_GET['question'])));
						
					if($correct == "true")
						$answer=1;
					else
						$answer=2;
					
					// Update true and false question and store the answer.	
					$insertItem = $db->prepare("UPDATE quiz_quizes SET question=:question,correctanswer=$answer WHERE qid=:qid");
					$insertItem->bindParam(":question",$quesion); // Bind params
					$insertItem->bindParam(":qid",$id);
					$insertItem->execute();
					echo "inserted";
					
				}
				
				if($action == "savemc")
				{
					// Similar process but with multiple choise
					if(!isset($_GET['correct']))
						header("location: c_quiz.php");
					if(!isset($_GET['question']))
						header("location: c_quiz.php");
					if(!isset($_GET['one']))
						header("location: c_quiz.php");
					if(!isset($_GET['two']))
						header("location: c_quiz.php");
					if(!isset($_GET['three']))
						header("location: c_quiz.php");
					
					$correct = 	mysql_real_escape_string(stripslashes(trim($_GET['correct'])));
					$quesion = 	mysql_real_escape_string(stripslashes(trim($_GET['question'])));
					$one = mysql_real_escape_string(stripslashes(trim($_GET['one'])));
					$two = mysql_real_escape_string(stripslashes(trim($_GET['two'])));
					$three = mysql_real_escape_string(stripslashes(trim($_GET['three'])));
					
					$answer = 1;
					
					if($correct == "one")
						$answer=1;
					if($correct == "two")
						$answer=2;
					if($correct == "three")
						$answer=3;
					if($correct == "four")
						$answer=4;
					if($correct == "five")
						$answer=5;
					
					if(isset($_GET['four']))
					{
						$four = mysql_real_escape_string(stripslashes(trim($_GET['four'])));
					}
					if(isset($_GET['five']))
					{
						$five = mysql_real_escape_string(stripslashes(trim($_GET['five'])));
					}
					
					if(isset($_GET['four']) && isset($_GET['five']))
					{
						$insertItem = $db->prepare("UPDATE quiz_quizes SET question=:question,answerOne=:one,answerTwo=:two,answerThree=:three,answerFour=:four,answerFive=:five,correctanswer=$answer WHERE qid=:qid");
						$insertItem->bindParam(":question",$quesion);
						$insertItem->bindParam(":one",$one);
						$insertItem->bindParam(":two",$two);
						$insertItem->bindParam(":three",$three);
						$insertItem->bindParam(":four",$four);
						$insertItem->bindParam(":five",$five);
						$insertItem->bindParam(":qid",$id);
						$insertItem->execute();
					}
					else
					{
						if(isset($_GET['four']))
						{
							$insertItem = $db->prepare("UPDATE quiz_quizes SET question=:question,answerOne=:one,answerTwo=:two,answerThree=:three,answerFour=:four,answerFive='',correctanswer=$answer WHERE qid=:qid");
							$insertItem->bindParam(":question",$quesion);
							$insertItem->bindParam(":one",$one);
							$insertItem->bindParam(":two",$two);
							$insertItem->bindParam(":three",$three);
							$insertItem->bindParam(":four",$four);
							$insertItem->bindParam(":qid",$id);
							$insertItem->execute();
						}
						else
						{
							$insertItem = $db->prepare("UPDATE quiz_quizes SET question=:question,answerOne=:one,answerTwo=:two,answerThree=:three,answerFour='',answerFive='',correctanswer=$answer WHERE qid=:qid");
							$insertItem->bindParam(":question",$quesion);
							$insertItem->bindParam(":one",$one);
							$insertItem->bindParam(":two",$two);
							$insertItem->bindParam(":three",$three);
							$insertItem->bindParam(":qid",$id);
							$insertItem->execute();
						}
					}
					
					echo "inserted";
						
				}
				
				                               
            }
	}
}
else
{
	header("location: index.php");
}
 
?>