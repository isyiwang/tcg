<?php

class read_File{
	
	function __construct($name){		
		$this->name = $name;	
		
		if($this->name == "blog"){$this->name = ROOTPATH . "/data/blog/blogfile.txt";}
		else if($this->name == "comment"){$this->name = ROOTPATH . "/data/blog/comments.txt";}
		else { echo $lang_blog_error_reading;}			
	 }	

	function getData(){
		$open = fopen($this->name , "r");
		$data = @fread($open, filesize($this->name));
		fclose($open);		
		return $data;		
	}	

	function getLines(){				
		$lines = explode("\n", $this->getData());
		return $lines;
	}
	
	function countLines(){	
		$amount_of_lines = count($this->getLines());
		return $amount_of_lines-1;		
	}	
				
	
}//end class

class add_Content{

		function __construct($name,$data){		
		$this->name = $name;
		$this->data = $data;	
		
		if($this->name == "blog"){$this->name = ROOTPATH . "/data/blog/blogfile.txt";}
		else if($this->name == "comment"){$this->name = ROOTPATH . "/data/blog/comments.txt";}
		else { echo $lang_blog_error_reading;}
		}
		
		function appendData(){
			$open = fopen($this->name, "a");
			fwrite($open, $this->data);
			fclose($open);
		}
		
		function writeData(){			
			$open = fopen($this->name, "w");
			fwrite($open, $this->data);
			fclose($open);			
		}			
}//end class

//sanatize input
function super_clean($text){	
	$text = trim(stripslashes(strip_tags(htmlspecialchars($text, ENT_QUOTES, 'UTF-8'))));	
	return $text;
}			
?>