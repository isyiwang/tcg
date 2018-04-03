<?php $on='blog'; ?>

<div id="sub-head">
	<a href="index.php?p=manage-blog"><?php echo $lang_go_back; ?></a>
</div>

<div id="content">
<?php 

if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"]){
	$timestamp_old = time() - (15*60);

	if($_SESSION["token_time"] >= $timestamp_old){
		if(!empty($_GET['post_id']) && empty($_GET['comment_id'])) {
			
			$post_id = $_GET['post_id']; 
			$opFile = "data/blog/blogfile.txt";

			// read data from file
			$fp = fopen($opFile,"r") or die($lang_blog_error_reading); 
			$data = @fread($fp, filesize($opFile));
            fclose($fp);

            $line = explode("\n", $data);
			
			$no_of_posts = count($line)-1;
            
			for ($i=0; $i<$no_of_posts; $i++){
	            $blog = explode("|", $line[$i]);
	            
	            if($blog[0] == $post_id) continue;
					$posts .= $line[$i]. "\n";
			}
               
			$file = fopen($opFile,"w") or die($lang_blog_error_reading); 
			$success = fwrite($file, $posts);
			fclose($file); 
			
			$filename = "data/blog/comments.txt";
			$fp = fopen($filename,"r") or die($lang_blog_error_reading); 

			while (!feof($fp)) {
			  
			  $comments[] = fgets($fp);
			}
			fclose($fp); 

			$no_of_comments = count($comments)-1;
		    
			for ($i=0; $i<$no_of_comments; $i++){
			
				$comment = explode("|", $comments[$i]);
				
				if($comment[0] != $post_id) {			  
			   		$comments_new .=  $comments[$i];
		 	    }	
			}

			$file = fopen($filename, "w") or die($lang_blog_error_reading); 
			$success = fwrite($file, $comments_new);
			fclose($file);

		} elseif(!empty($_GET['comment_id'])) {

			$comment_id = $_GET['comment_id']-1; 
			$post_id = $_GET['post_id'];
			$opFile = "data/blog/comments.txt";

			// read data from file
			$fp = fopen($opFile,"r") or die($lang_blog_error_reading); 

			while (!feof($fp)) {
			  
			  $posts[] = fgets($fp);
			}
			fclose($fp); 

			$no_of_posts = count($posts)-1;

			for ($i=0; $i<$no_of_posts; $i++){

				if ($i== $comment_id) {
					$delete = 1;
				} else {
			 		$new_data .= $posts[$i];
			 	}	
			}

			$file = fopen($opFile,"w") or die("$lang_blog_error_reading"); 
			$success = fwrite($file, $new_data);
			fclose($file);

			if($delete == 1) {
			
				$opFile = "data/blog/blogfile.txt";
				$fp = fopen($opFile,"r") or die("$lang_blog_error_reading");
				$data = fread($fp, filesize($opFile));
				fclose($fp); 

				$line = explode("\n", $data);

				$nb = count($line);
               
				for($i=0; $i < $nb; $i++) { 
					$blog = explode("|", $line[$i]);
					
					if($blog[0] == $post_id) {			  
					   	 $blog[1]--;
					   	 $posts_new .=  $blog[0]. "|" . $blog[1] ."|".$blog[2]."|".$blog[3]."|".$blog[4]."|".$blog[5]."\n";
					   	
					} elseif($blog[0] != "") {
						 $posts_new .=  $blog[0]. "|" . $blog[1] ."|".$blog[2]."|".$blog[3]."|".$blog[4]."|".$blog[5]."\n";
					}
				}

				$file = fopen($opFile,"w") or die("$lang_blog_error_reading"); 
				$success = fwrite($file, $posts_new);
				fclose($file); 
			}
		}

		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("Location: http://$host$uri/index.php?p=manage-blog");
		die();
		
	}else{
		echo "<p class=\"errorMsg created\">$lang_blog_session_expire</p>";
	}
				
}else{
	
	if(!empty($_GET['post_id']) || !empty($_GET['comment_id'])) {
		$post_id = $_GET['post_id']; 
		
		$token = md5(uniqid(rand(), TRUE));
		$_SESSION["token"] = $token;
		$_SESSION["token_time"] = time();
		
		echo "<p>$lang_blog_sure_delete</p><br>";
		
		if(!empty($_GET['comment_id'])) {
		
			$comment_id = $_GET['comment_id']; 
			
			echo "<form action=\"index.php?p=del-post&post_id=". $post_id ."&comment_id=". $comment_id ."\" method=\"post\">";
			
		}else{
		
			echo "<form action=\"index.php?p=del-post&post_id=". $post_id ."\" method=\"post\">";
		}
		echo "<p><input type=\"hidden\" name=\"token\" value=\"$token\" />";
		echo "<button value=\"Yes\" type=\"submit\" class=\"btn\">$lang_yes</button>";
		echo "&nbsp;&nbsp;&nbsp;<a href=\"index.php?p=manage-blog\" class=\"btn\">$lang_cancel</a>";
		echo "</form>";
		
	}else{
	
		echo "<p class=\"errorMsg\">$lang_blog_cant_find</p>";
	}
}								
?>
</div>