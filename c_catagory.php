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
	if(isset($_GET['create_cat']))
	{
		$c_name = mysql_real_escape_string(stripslashes($_GET['c_name']));
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
                    $db->query("INSERT INTO quiz_catagory (mid,title,datecreated) VALUES ($mid,'$c_name','$now')");
                    $output = "<p class=\"success\">A catagory with the name \"$c_name\" has been created.</p>";
			/*if($affectedRow == 0)
			{			
				
			}
			else
			{
				$output = "<p class=\"error\">A catagory with the name \"$c_name\" already exist. Please choose another name.</p>";
			}*/
		}
	}
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

$template->navigationBlock();

$template->sidebarBlock($isAdmin);
?>

<article id="content">

<div id="createCatagory">
    <h2>Create A New Catagory</h2>
    <?php
    if($output != "")
    {
        echo $output;
    }
    ?>
    <form action="c_catagory.php" method="get" id="catagory_create">
        <div class="tr"><label>Catagory Name: </label><input type="text" name="c_name" id="c_name"></div>
        <div class="tr"><label></label><input type="submit" name="create_cat" id="create_cat" value="Create Catagory"></div>
    </form>
</div>

<div id="listCatagory">
	<h2>List of Catagories</h2>
    <?php
	
	$catagory = $db->prepare("SELECT * FROM quiz_catagory WHERE mid=$mid");
	$catagory->execute();
	
	$catagory->setFetchMode(PDO::FETCH_ASSOC);
	
        $numCatagory = $catagory->rowCount();
        
        if($numCatagory == 0)
        {
            echo "<p>You do not have any Catagory.</p>";
        }
        else
        {
            $count = 1;
            ?>    
            <table cellspacing="0">
                <tr><th style="width:10px">Index</th><th>Title</th><th style="width:20px">Creation Date</th><th style="width:50px">Action</th></tr>
            <?php
                foreach($catagory as $result)
                {		
                        echo "\t<tr class=\"".$result['cid']."\"><td>$count</td><td id=\"".$result['cid']."\">".$result["title"]."</td><td>".$result["datecreated"]."</td><td id=\"buttons_".$result['cid']."\"><img src=\"images/edit.png\" class=\"edit\" id=\"".$result['cid']."\" /> <img src=\"images/delete.png\" class=\"delete\" id=\"".$result['cid']."\" /></td></tr>\n";
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