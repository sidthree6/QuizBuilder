<?php

/*
 * Made By: Siddharth Panchal & Dylan Burnham
 * 
 * File Name: template.php
 * 
 * Description: this file contains a basic html code inside a class so html stays consistent on all pages  
 */
class Template
{
	private $title;
	private $script;
	private $style;
		
        // Constructor of the class
	function __construct($input="",$inputTwo=array(),$inputThree=array()) {
		$this->setTitle($input);
		$this->setScript($inputTwo);
		$this->setStyle($inputThree);
	}
	
        // Set the title for html document
	protected function setTitle($input)
	{
		$this->title = $input;
	}
	
        // Append all scripts required by html
	protected function setScript($input)
	{
		for($i=0;$i<count($input);$i++)
		{
			$this->script[$i] = $input[$i];
		}
	}
	
        // Append all styles required by html
	protected function setStyle($input)
	{
		for($i=0;$i<count($input);$i++)
		{
			$this->style[$i] = $input[$i];
		}
	}
	
        // Output basic html starting tags
	public function outPutHeader()
	{
		$output  = "<!doctype html>\n";
		$output .= "<html>\n";
		$output .= "<head>\n";
		$output .= "<title>".$this->title." ".count($this->script)."</title>\n";
		$output .= ("<script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-latest.min.js\"></script>\n");
		for($i = 0;$i<count($this->script);$i++)
		{
			 $output .= ("<script type=\"text/javascript\" src=\"scripts/".$this->script[$i]."\"></script>\n");
		}
		for($i = 0;$i<count($this->style);$i++)
		{
			 $output .= ("<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/".$this->style[$i]."\">\n");
		}
		$output .= "</head>\n";
		$output .= "<body>\n<div class=\"main\">\n";
		
		echo $output;
	}
	
        // Output basic html ending tags
	public function outputFooter()
	{
		$output  = "<footer>QuizBuilder &#169; 2014</footer></div>\n";
                $output .= "</body>\n";
		$output .= "</html>";
		
		echo $output;
	}
	
        // Output header block
	public function headerBlock($logged=0)
	{		
		$output  = "<div id=\"header\">\n<header>\n";
		$output .= "\t<img src=\"images/title.png\" class=\"titleimg\"/>\n";
		$output .= "\t\t<ul>\n";
		if($logged == 1)
		{
			$output .= "\t\t\t<li><a href=\"logout.php\"><img src=\"images/logout.png\" /> LogOut</a></li>\n";
		}
		else
		{
			$output .= "\t\t\t<li><a href=\"login.php\"><img src=\"images/login.png\" /> Login</a></li>\n";
			$output .= "\t\t\t<li><a href=\"register.php\"><img src=\"images/register.png\" /> Register</a></li>\n";
		}
		$output .= "\t\t</ul>\n";
		$output .= "</header>\n</div>\n";
		
		echo $output;
	}
	
        // Output navigation panel for loggedin user
	public function navigationBlockLogged($isadmin = 0)
	{
		$output  = "<nav id=\"navigation\">\n";
		$output .= "\t<ul>\n";
		$output .= "\t\t<li><a href=\"#\">Quiz Management</a>\n";
		$output .= "\t\t\t<ul>\n";
		$output .= "\t\t\t\t<li><a href=\"c_catagory.php\">Create / Edit Quiz Title</a></li>\n";
		$output .= "\t\t\t\t<li><a href=\"c_quiz.php\">Create / Edit Quiz Contents</a></li>\n";
		$output .= "\t\t\t</ul>\n";
		$output .= "\t\t</li>\n";
		if($isadmin == 1)
		{
			$output .= "\t\t<li><a href=\"#\">Admin Panel</a>\n";
			$output .= "\t\t\t<ul>\n";
			$output .= "\t\t\t\t<li><a href=\"admin_user.php\">View / Delete User</a></li>\n";
			$output .= "\t\t\t</ul>\n";
			$output .= "\t\t</li>\n";
		}
		$output .= "\t\t<li><a href=\"#\">User Management</a>\n";
		$output .= "\t\t\t<ul>\n";
		$output .= "\t\t\t\t<li><a href=\"c_pass.php\">Change Password</a></li>\n";
		$output .= "\t\t\t</ul>\n";
		$output .= "\t\t</li>\n";		
		$output .= "\t\t<li><a href=\"#\">Links</a>\n";
		$output .= "\t\t\t<ul>\n";
		$output .= "\t\t\t\t<li><a href=\"about.php\">About Us</a></li>\n";
		$output .= "\t\t\t\t<li><a href=\"how.php\">How to Use</a></li>\n";
		$output .= "\t\t\t</ul>\n";
		$output .= "\t\t</li>\n";	
		$output .= "\t</ul>\n";
		$output .= "</nav>\n";
		
		echo $output;
	}
	
        //Output navigation for not loggedin user
	public function navigationBlock()
	{
		$output  = "<nav id=\"navigation\">\n";
		$output .= "\t<ul>\n";
		$output .= "\t\t<li><a href=\"index.php\">Home</a></li>\n";
		$output .= "\t\t<li><a href=\"about.php\">About Us</a>\n";
		$output .= "\t\t<li><a href=\"how.php\">How to Use</a>\n";
		$output .= "\t</ul>\n";
		$output .= "</nav>\n";
		
		echo $output;
	}
}

?>