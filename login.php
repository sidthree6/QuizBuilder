<?php
session_start();
include("db.php");

if(isset($_POST["login"]))
{
    $username = $_POST["l_username"];
    $password = $_POST["l_password"];
    
    $username = mysql_real_escape_string(stripslashes($username));
    $password = mysql_real_escape_string(stripslashes($password));
    
    $sql = "SELECT * FROM quiz_members";
    
    foreach ($database->query($sql) as $row)
    {
        echo $row['fname']."<br/>";
    }
}
?>
