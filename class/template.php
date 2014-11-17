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
		$output .= "<body>\n";
		
		echo $output;
	}
	
	public function outputFooter()
	{
		$output  = "</body>\n";
		$output .= "</html>";
		
		echo $output;
	}
}

?>