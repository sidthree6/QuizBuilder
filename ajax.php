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
	if(isset($_GET['action']) && isset($_GET['id']))
	{
            $action = mysql_real_escape_string(stripslashes(trim($_GET['action'])));
            $id     = mysql_real_escape_string(stripslashes(trim($_GET['id'])));
			$value  = "";
			
			if(isset($_GET['value']))
				$value = $_GET['value'];			
            
            $check = $db->prepare("SELECT mid FROM quiz_catagory WHERE cid=".$id);
            $check->execute();
            $check->setFetchMode(PDO::FETCH_ASSOC);
            $checkResult = $check->fetch();
            
			// Only perform action if right user is performing action or user is an admin
            if($checkResult['mid'] == $mid || $isAdmin == 1)
            {
				// Delete Title
				if($action == "delete")
				{
					$del = $db->prepare("DELETE FROM quiz_catagory WHERE cid=".$id);
					$del->execute();
					
					$del = $db->prepare("DELETE FROM quiz_quizes WHERE cid=".$id);
					$del->execute();
					
					echo "deleted";
				}
				//Delete Quiz
				if($action == "deletequiz")
				{
					$del = $db->prepare("DELETE FROM quiz_quizes WHERE qid=".$id);
					$del->execute();						
					
					echo "deleted";
				}
				// Edit Title
				if($action == "edit" && !empty($value))
				{
					$value = mysql_real_escape_string(stripslashes(trim($value)));
					if(strlen($value) < 0 || strlen($value) > 100)
					{
						echo "wrongsize";
					}
					else
					{
						$edit = $db->query("UPDATE quiz_catagory SET title='".$value."' WHERE cid=".$id);
						echo "edited";
					}
				}
				
				if($action == "addquiz" && !empty($value))
				{
					if($value == "mc")
					{
						$question     = "Sample Question";
						$answerOne    = "Option One";
						$answerTwo    = "Option Two";
						$answerThree  = "Option Three";
						$answerFour   = "Option Four";
						$correctanswer= 1;
						$mcortf		  = 1;
						
						$db->query("INSERT INTO quiz_quizes (mid,cid,question,answerOne,answerTwo,answerThree,answerFour,correctanswer,mcortf,datecreated) VALUES ($mid,$id,'$question','$answerOne','$answerTwo','$answerThree','$answerFour',$correctanswer,$mcortf,'$now')");
						
						/*$db->query("INSERT INTO quiz_quizes (mid,cid,question) VALUES ($mid,$id,'Sample Question')");*/
						
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
						
						/*$db->query("INSERT INTO quiz_quizes (mid,cid,question) VALUES ($mid,$id,'Sample Question')");*/
						
						echo "2";
					}
				} 
				
				if($action == "savetf")
				{
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
						
					$insertItem = $db->prepare("UPDATE quiz_quizes SET question=:question,correctanswer=$answer WHERE qid=:qid");
					$insertItem->bindParam(":question",$quesion);
					$insertItem->bindParam(":qid",$id);
					$insertItem->execute();
					echo "inserted";
					
				}
				
				if($action == "savemc")
				{
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