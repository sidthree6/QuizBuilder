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
            $action = mysql_real_escape_string(stripslashes($_GET['action']));
            $id     = mysql_real_escape_string(stripslashes($_GET['id']));
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
				}
            }
	}
}
else
{
	header("location: index.php");
}
 
?>