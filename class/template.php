<?php

class Template
{
	private $title;
	private $script;
	private $style;
		
	function __construct($input="",$inputTwo=array(),$inputThree=array()) {
		$this->setTitle($input);
		$this->setScript($inputTwo);
		$this->setStyle($inputThree);
	}
	
	protected function setTitle($input)
	{
		$this->title = $input;
	}
	
	protected function setScript($input)
	{
		for($i=0;$i<count($input);$i++)
		{
			$this->script[$i] = $input[$i];
		}
	}
	
	protected function setStyle($input)
	{
		for($i=0;$i<count($input);$i++)
		{
			$this->style[$i] = $input[$i];
		}
	}
	
	public function outPutHeader()
	{
		$output  = "<!doctype html>\n";
		$output .= "<html>\n";
		$output .= "<head>\n";
		$output .= "<title>".$this->title." ".count($this->script)."</title>\n";
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
	
	public function outputFooter()
	{
		$output  = "</div>\n</body>\n";
		$output .= "</html>";
		
		echo $output;
	}
	
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
	
	public function navigationBlock()
	{
		$output  = "<div id=\"navigation\">\n";
		$output .= "\t<ul>\n";
		$output .= "\t\t<li><a href=\"index.php\">Home</a></li>\n";
		$output .= "\t\t<li><a href=\"doc.php\">How to Use</a></li>\n";
		$output .= "\t\t<li><a href=\"about.php\">About Us</a></li>\n";
		$output .= "\t\t<li><a href=\"contact.php\">Contact Us</a></li>\n";
		$output .= "\t\t<li><a href=\"review.php\">Review</a></li>\n";
		//$output .= "\t\t<li><input type=\"text\" value=\"Search QuizBuilder\" /></li>\n";
		$output .= "\t</ul>\n";
		$output .= "</div>\n";
		
		echo $output;
	}
	
	public function sidebarBlock($isadmin = 0)
	{
		$output  = "<div id=\"sidebar\">\n";
		$output .= "\t<nav>\n";
		$output .= "\t\t<ul>\n";
		$output .= "\t\t\t<li><a class=\"header\">Quiz Management</a></li>\n";
		$output .= "\t\t\t<li><a href=\"c_catagory.php\" class=\"items\">Create / Edit Catagory</a></li>\n";
		$output .= "\t\t\t<li><a href=\"c_quizorflash.php\" class=\"items\">Create Quiz</a></li>\n";
		$output .= "\t\t\t<li><li><a href=\"e_quizorflash.php\" class=\"items\">Edit Quiz</a></li>\n";
		$output .= "\t\t\t<li><a href=\"d_quizorflash.php\" class=\"items\">Delete Quiz</a></li>\n";
		$output .= "\t\t\t<li><a class=\"header\">User Management</a></li>\n";
		$output .= "\t\t\t<li><a href=\"e_uinfo.php\" class=\"items\">Edit User Info</a></li>\n";
		$output .= "\t\t\t<li><a href=\"c_pass.php\" class=\"items\">Change Password</a></li>\n";
		if($isadmin == 1)
		{
			$output .= "\t\t\t<li><a class=\"header\">Admin Panel</a></li>\n";
			$output .= "\t\t\t<li><a href=\"admin_log.php\" class=\"items\">Latest User Log</a></li>\n";
			$output .= "\t\t\t<li><a href=\"admin_e_user.php\" class=\"items\">Edit / View / Delete User</a></li>\n";
		}
		$output .= "\t\t</ul>\n";
		$output .= "\t</nav>\n";
		$output .= "</div>\n";
		
		echo $output;
	}
}

?>