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
	
	public function navigationBlockLogged($isadmin = 0)
	{
		$output  = "<nav id=\"navigation\">\n";
		$output .= "\t<ul>\n";
		$output .= "\t\t<li><a href=\"index.php\">Home</a></li>\n";
		$output .= "\t\t<li><a href=\"#\">Quiz Management</a>\n";
		$output .= "\t\t\t<ul>\n";
		$output .= "\t\t\t\t<li><a href=\"c_catagory.php\">Create / Edit Quiz Title</a></li>\n";
		$output .= "\t\t\t\t<li><a href=\"c_quiz.php\">Create / Edit Quiz Contents</a></li>\n";
		$output .= "\t\t\t</ul>\n";
		$output .= "\t\t</li>\n";
		$output .= "\t\t<li><a href=\"#\">User Management</a>\n";
		$output .= "\t\t\t<ul>\n";
		$output .= "\t\t\t\t<li><a href=\"c_uinfo.php\">Edit User Info</a></li>\n";
		$output .= "\t\t\t\t<li><a href=\"c_pass.php\">Profile Overview</a></li>\n";
		$output .= "\t\t\t</ul>\n";
		$output .= "\t\t</li>\n";
		if($isadmin == 1)
		{
			$output .= "\t\t<li><a href=\"#\">Admin Panel</a>\n";
			$output .= "\t\t\t<ul>\n";
			$output .= "\t\t\t\t<li><a href=\"admin_log.php\">Latest User Log</a></li>\n";
			$output .= "\t\t\t\t<li><a href=\"admin_e_user.php\">View / Delete User</a></li>\n";
			$output .= "\t\t\t</ul>\n";
			$output .= "\t\t</li>\n";
		}
		$output .= "\t\t<li><a href=\"faq.php\">FAQ</a></li>\n";
		$output .= "\t</ul>\n";
		$output .= "</nav>\n";
		
		echo $output;
	}
	
	public function navigationBlock()
	{
		$output  = "<nav id=\"navigation\">\n";
		$output .= "\t<ul>\n";
		$output .= "\t\t<li><a href=\"index.php\">Home</a></li>\n";
		$output .= "\t\t<li><a href=\"about.php\">About Us</a>\n";
		$output .= "\t\t<li><a href=\"how.php\">How to Use</a>\n";
		$output .= "\t\t<li><a href=\"faq.php\">FAQ</a></li>\n";
		$output .= "\t</ul>\n";
		$output .= "</nav>\n";
		
		echo $output;
	}
}

?>