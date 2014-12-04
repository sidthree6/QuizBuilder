<?php
/*
 * Made By: Siddharth Panchal & Dylan Burnham
 * 
 * File Name: c_catagory.php
 * 
 * Description: This file contains data to view and edit quiz title.  
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
		
	//User Create New Catagory
	if(isset($_GET['create_cat']))
	{
		// User has submited form which contain data about quiz title
		$c_name = mysql_real_escape_string(stripslashes(trim($_GET['c_name'])));
		$catagory = $db->prepare("SELECT title FROM quiz_catagory WHERE title=:title");
		$catagory->bindParam(":title",$c_name);
		$catagory->execute();
		
		$affectedRow = $catagory->rowCount();
		if(empty($c_name))
		{
			$output = "<p class=\"error\">A catagory must have a name.</p>";
		}
		else
		{
			// If no error have been found, insert items
        	$db->query("INSERT INTO quiz_catagory (mid,title,datecreated) VALUES ($mid,'$c_name','$now')");
            $output = "<p class=\"success\">A catagory with the name \"$c_name\" has been created.</p>";
		}
	}
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

<div id="createCatagory">
    <h2>Create New Quiz</h2>
    <?php
    if($output != "")
    {
		// Output any form error here
        echo $output;
    }
    ?>
    <form action="c_catagory.php" method="get" id="catagory_create">
        <div class="tr"><label>Quiz Title: </label><input type="text" name="c_name" id="c_name"></div>
        <div class="tr"><label></label><input type="submit" name="create_cat" id="create_cat" value="Create Quiz"></div>
    </form>
</div>

<div id="listCatagory">
	<h2>List of Quizes</h2>
    <?php
	// This is where all user created quiz title exists
	$catagory = $db->prepare("SELECT * FROM quiz_catagory WHERE mid=$mid");
	$catagory->execute();
	
	$catagory->setFetchMode(PDO::FETCH_ASSOC);
	
        $numCatagory = $catagory->rowCount();
        
        if($numCatagory < 1)
        {
            echo "<p>You do not have any Quiz.</p>";
        }
        else
        {
            $count = 1;
            ?>    
            <table cellspacing="0">
                <tr><th style="width:10px">Index</th><th>Title</th><th style="width:20px">Creation Date</th><th style="width:50px">Action</th></tr>
            <?php
			// Loop through all values and output them with edit and delete option
                foreach($catagory as $result)
                {		
                        echo "\t<tr class=\"".$result['cid']."\"><td>$count</td><td class=\"content_".$result['cid']."\" id=\"".$result['cid']."\">".$result["title"]."</td><td>".$result["datecreated"]."</td><td id=\"buttons_".$result['cid']."\"><img src=\"images/edit.png\" class=\"edit\" id=\"".$result['cid']."\" /> <img src=\"images/delete.png\" class=\"delete\" id=\"".$result['cid']."\" /></td></tr>\n";
                        $count++;
                }
                ?>
            </table>
        <?php
        }
        ?>
</div>

</article>

<?php $template->outputFooter(); ?>