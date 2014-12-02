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
				// Delete
				if($action == "delete")
				{
					$del = $db->prepare("DELETE FROM quiz_catagory WHERE cid=".$id);
					$del->execute();
					
					echo "deleted";
				}
				// Edit
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
                                if($action == "getquiz")
                                {
                                    $getQuestion = $db->prepare("SELECT * FROM quiz_quizes WHERE qid=$id");
                                    $getQuestion->execute();
                                    
                                    $getQuestion->setFetchMode(PDO::FETCH_OBJ);
                                    $quizQ = $getQuestion->fetch();
                                    
                                    $output = "<h3>Editing Question:</h3>\n<textarea id=\"questionText\">".$quizQ->question."</textarea>\n<br/>";
                                    
                                    $countquestion = 0;
                                    $checked = "";
                                    
                                    if($quizQ->mcortf == 1)
                                    {
                                        if(!empty($quizQ->answerOne))
                                        {
                                            if($quizQ->correctanswer == 1)
                                                $checked = "checked=checked";                                       
                                            $output .= "<input type=\"radio\" name=\"answer\" value=\"one\" $checked> <textarea>".$quizQ->answerOne."</textarea>\n<br/>";

                                            $checked = "";
                                        }
                                        if(!empty($quizQ->answerTwo))
                                        {
                                            if($quizQ->correctanswer == 2)
                                                $checked = "checked=checked";
                                            $output .= "<input type=\"radio\" name=\"answer\" value=\"two\" $checked> <textarea>".$quizQ->answerTwo."</textarea>\n<br/>";

                                            $checked = "";
                                        }                                    
                                        if(!empty($quizQ->answerThree))
                                        {
                                            if($quizQ->correctanswer == 3)
                                                $checked = "checked=checked";
                                            $output .= "<input type=\"radio\" name=\"answer\" value=\"three\" $checked> <textarea>".$quizQ->answerThree."</textarea>\n<br/>";

                                            $checked = "";
                                        }                                    
                                        if(!empty($quizQ->answerFour))
                                        {
                                            if($quizQ->correctanswer == 4)
                                                $checked = "checked=checked";
                                            $output .= "<input type=\"radio\" name=\"answer\" value=\"four\" $checked> <textarea>".$quizQ->answerFour."</textarea>\n<br/>";

                                            $checked = "";
                                        }                                    
                                        if(!empty($quizQ->answerFive))
                                        {
                                            if($quizQ->correctanswer == 5)
                                                $checked = "checked=checked";
                                            $output .= "<input type=\"radio\" name=\"answer\" value=\"five\" $checked> <textarea>".$quizQ->answerFive."</textarea>\n<br/>";

                                            $checked = "";
                                        }
                                    }
                                    else
                                    {
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
                                            $output .= "<input type=\"radio\" name=\"answer\" value=\"false\" $checked> Flase\n<br/>";

                                            $checked = "";
                                        }
                                    }
                                    
                                    echo $output;
                                }
            }
	}
}
else
{
	header("location: index.php");
}
 
?>