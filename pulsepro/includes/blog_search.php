<link href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/<?php echo $pulse_dir ?>/css/blog.css" rel="stylesheet" >


<form id="search" name="blog_search" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
	<input id="searchword" name="search" type="text" maxlength="50" value="<?php echo super_clean(strip_tags(stripslashes($_GET['search']))); ?>" placeholder="<?php echo $lang_blog_search; ?>" >
</form>

<?php

if (isset($_GET['search']) && strlen($_GET['search'])>0 && strlen($_GET['search'])<50 ) {

	$search = trim(stripslashes(stripcslashes(strip_tags($_GET['search']))));
	$search = str_replace("/", "", $search);
	$search = str_replace("\\", "", $search);

	$results = 0;
	
  if (strlen($search) <= 2) {
		echo $lang_blog_too_short_search;
							
   } else {
	 	
	 	$search1 = super_clean($search);
	 	
		echo "<p>$lang_blog_search_results <b>$search1</b></p>";
		
		for($i=$amount; $i>=0; $i--) { 
			
			$blog = explode("|", $lines[$i]);
		    $date = explode( ' ' , $blog[2]);
			$date = $date[2] . ' ' . $date[1]  . ' ' . $date[3];

			if(preg_match("/$search/i",$blog[4]) || preg_match("/$search/i",$blog[3]) ){
			
				$results ++;

				$content = str_replace("##more##", "", $blog[4]);
				$content = str_replace("\n", "", $content);
				$content = str_replace("\r", "", $content);
				$content = str_replace(".", ". ", $content);

				$content = strip_tags($content);
				$content = stripslashes($content);
				
				$searchterm_position = stripos($content, $search);								
				if($searchterm_position > 30) { $a = $searchterm_position - 30; } else { $a = 0; }
				
				$b = strrpos(substr($content, 0, $a), " ");
				
				if( $b != 0 ){ $begin = "..."; } else{ $begin = ""; }
				if(strlen($content) > ($b + 170) ){ $end = "..." ;} else { $end = "";}
				
				$content = substr($content, $b , 170);				
				$content = preg_replace("/$search/i", "<span class=searchword>$search</span>", $content);
				
				$title = trim(stripslashes(strip_tags($blog[3])));
				$title = preg_replace("/$search/i", "<span class=searchword>$search</span>", $title);

				$blog_number = htmlentities($blog[0]);				
				
				echo "<div class=\"search-title\"> ". "<a href=\"blog-". $blog_number ."-.".cleanUrlname($blog[3])."\">" .$title."</a></div>\n"; 

				echo "<div class=\"search-content\">". $begin. $content. $end ."</div>\n\n";
						
				echo "<hr>";
			}
		}
		if ($results == 0) { echo $lang_blog_search_no_found; }
	}
}
?>