<?php
error_reporting(0);
include_once("path.php");
include(ROOTPATH."../../config.php");
if($pulse_lang == 0){ include_once("lang.php");} elseif($pulse_lang == 1){ include_once("lang_de.php");}
include_once("helpers/blog_lib.php");
include_once("helpers/functions.php");


if(!isset($_POST["question"])){	$question = array_rand($questions, 1); $answer = strtolower($questions[$question]); }

?>
<link rel="alternate" title="RSS" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/<?php echo $pulse_dir; ?>/rss.php" type="application/rss+xml" >
<link href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/<?php echo $pulse_dir; ?>/css/blog.css" rel="stylesheet" >
<div class="blog-wrap">
<?php

$blog_file_1 = new read_File("blog");
$amount = $blog_file_1->countLines();
$lines = $blog_file_1->getLines();

//id given - validating new comment and displaying a sepcific blog post
if(isset($_GET["d"]) && strlen($_GET["d"] > 0) && is_numeric($_GET["d"]) ) { $id_post = super_clean($_GET["d"]); 
		
	// security
	if(!empty($_POST["answers"]) 
		&&  $questions[stripslashes(html_entity_decode($_POST["question"]))] == strtolower(trim($_POST["answers"])) 
		&&  md5($questions[stripslashes(html_entity_decode($_POST["question"]))]) ==  $_POST["token"]) {
			$resp = 1;
			$question = array_rand($questions, 1);	
			$answer = strtolower($questions[$question]);
			} elseif (isset($_POST["answers"])) {
				$resp = 2;
				$question = array_rand($questions, 1);	
				$answer = strtolower($questions[$question]);	
			}
			
			if($blog_capcha == false){ $resp = 1;}


		if (strlen($_POST['comment'])> 1000){ $too_long = true; }	
			 
	//1.validate and save new comment -id and form
	if(!empty($_POST['name']) && !empty($_POST['mail']) && !empty($_POST['comment']) && empty($_POST['ph']) &&  $blog_comments && ($too_long != true) ) {

			//sanatizing content 	
			$email = strip_tags(htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8'));
			$name = strip_tags(trim(stripslashes($_POST['name'])));        
			$comment = strip_tags(stripslashes($_POST['comment']),'<p><br><a>');
			$comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
			$x=0;// for mail
		
			if(preg_match("/@/", $_POST['mail'])) {

				if($resp == 1) {
					$x=1;
			
					$comment = str_replace("\n", "<br />", $comment);
					$comment = str_replace("\r", "", $comment);
					$comment = str_replace("|", "&brvbar;", $comment);
					$postdate = date('D, d M Y H:i:s O');
					$blog = $id_post."|".$postdate."|".$name."|".$email."|".$comment."\n";					
			
						//check if comment already exists
							$comment_saved = 0; 
   									
							$comment_file_1 = new read_File("comment");
							$amount_c = $comment_file_1->countLines();
							$lines_c = $comment_file_1->getLines();
						
							for($i=0; $i < $amount_c; $i++) { 
								$comments = explode("|", $lines_c[$i]);
								if($comments[0] == $id_post) {      			
									if(($comments[0] == $id_post) && ($comments[2] == $name) && ($comments[3] == $email) && ($comments[4] == $comment)){
										$comment_saved = 1;
										}
									}
								}

					//validated new comment; save it
					if ($comment_saved == 0){			
				
						$add = new add_Content("comment", $blog);
						echo $add->appendData();
				
						//update Number of comments  
						for($i=0; $i < $amount; $i++) { 
							$blogg = explode("|", $lines[$i]);
						
							if($blogg[0] == $id_post){		  
								$blogg[1]++;
								$new_data .=  $blogg[0]. "|" . $blogg[1] ."|".$blogg[2]."|".$blogg[3]."|".$blogg[4]."|".$blogg[5]."\n";				   	
								} elseif($blogg[0] != "") {
									$new_data .=  $blogg[0]. "|" . $blogg[1] ."|".$blogg[2]."|".$blogg[3]."|".$blogg[4]."|".$blogg[5]."\n";
									}
							}
							$write = new add_Content("blog", $new_data);
							echo $write->writeData();
				
						//send mail
						if($x===1){				
							for($i=0; $i < $amount; $i++) { 
								$b = explode("|", $lines[$i]);
								if($b[0] == $id_post){ 
									$title = $b[3];
							     }
						     }  
						     
						     
						     $comment_dec = trim(strip_tags(stripslashes($_POST['comment'])));
						     $sender_Name = "PulseCMS"; 
						     $sender_email = $email_contact;
						     $recipient = $email_contact;
						     $mail_body = $lang_blog_notify."\n\n";
						     $mail_body .= $lang_blog_title.": ".$title."\n\n";
						     $mail_body .= $lang_blog_name.": ".$name."\n\n";
						     $mail_body .= $lang_blog_comment.": ".$comment_dec."\n\n";			
						     $subject = $lang_blog_subject;
						     $header = "From: ". $sender_Name . " <" . $sender_email . ">\r\n";
						     mail($recipient, $subject, $mail_body, $header);
						     
						  }//end mail
					} //end save new comment
				
					unset($email);
					unset($name);
					unset($comment);
					unset($_POST['submit']);
					unset($comment_file_1);
			
					$_POST['name'] = '';
					$_POST['mail'] = '';
					$_POST['comment'] = '';
					 
			} // end resp						
	} else { $error = 1;}//end pregmatch email						
 } else //end validating and saving new comment
		
		
 				//2.show specific blog post and comments - id
 				$no_posts_found=0;
 				
				$blog_file_1 = new read_File("blog");
				$amount = $blog_file_1->countLines();
				$lines = $blog_file_1->getLines();
				for($i=0; $i < $amount; $i++) { 
					$blog = explode("|", $lines[$i]);
				 
					if($blog[0] == $id_post) {
						$no_posts_found++;
						$date = explode( ' ' , $blog[2]);
						$date = $date[2] . ' ' . $date[1]  . ' ' . $date[3];
						$title = cleanUrlname($blog[3]);
	    
						echo "<h2 class=\"blog-title\">" .$blog[3]."</h2>\n";
	    
						if($date_format) { echo "<div class=\"blog-date\">" . date("d-m-Y", strtotime($date))."</div>\n"; } 
							else { echo "<div class=\"blog-date\">" . date("m-d-Y", strtotime($date))."</div>\n"; }
								echo "<div class=\"blog-content\">" . str_replace("##more##", "", $blog[4]) ."</div>\n\n";
								break;
					}
				 } if($no_posts_found == 0){
					 		echo "404 ~does not~ exist.";
					 		header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
					 		die();
				 		}

					echo "<script>document.title = \"$blog[3]\";</script>\n";
						
					// show comments 					
					if($blog_comments) {
					
					echo "<div class=\"comments\" id=\"comments\">";
						
						$comment_file_2 = new read_File("comment");
						$amount_c_2 = $comment_file_2->countLines();
						$lines_c_2 = $comment_file_2->getLines();
												
						for($i=0; $i < $amount_c_2; $i++) { 
								$comments = explode("|", $lines_c_2[$i]);
							if($comments[0] == $id_post) {
								
								$date = explode( ' ' , $comments[1]);
								$date = $date[2] . ' ' . $date[1]  . ' ' . $date[3];
	    
								echo "<div class=\"comment-line\">\n";
								
								if($date_format) { echo "<div class=\"comment-date\">". date("d-m-Y", strtotime($date))."</div>\n"; } 
									else { echo "<div class=\"comment-date\">". date("m-d-Y", strtotime($date))."</div>\n"; } 
										echo "<div class=\"comment-name\">". $comments[2]."</div>\n";
										echo "</div>\n";
										echo "<div class=\"blog-comment\">" .$comments[4]."</div>\n\n";
							}
						}
						
						
	//display comment form only if set to enable	
	for($i=0; $i < $amount; $i++) { 
		$blog = explode("|", $lines[$i]);
	
	if( ($blog[0] == $id_post) && ($blog[5] == 1) ){ echo "<p class=\"comments-off\">$lang_blog_off_comments</p>"; }				

	if( ($blog[0] == $id_post) && ($blog[5] != 1) ){					
					
						
	?>
	<form class="comment-form" action="<?php echo "blog-$id_post-".cleanUrlname($blog[3]); ?>" method="post">
	<?php $_POST = array_map('trim', $_POST);?>
	
		<p class="add"><b><?php echo $lang_blog_add_comment;?></b></p>
		
		<p><label class="comment-label"><?php echo $lang_blog_label_name; 
					if(isset($_POST['submit']) && empty($_POST['name'])) { echo "<span style=\"color:red\">  - $lang_blog_error_name</span>";}?></label><br />
		<input type="text" name="name" size="45" value="<?php echo strip_tags(trim(stripslashes($_POST['name']))); ?>" /></p>
		
		<p><label class="comment-label"><?php echo $lang_blog_label_email; 
					if((isset($_POST['submit']) && empty($_POST['mail']))|| $error==1) {echo "<span style=\"color:red\"> - $lang_blog_error_email</span>";}?></label><br />
		<input size="45" type="text" name="mail" value="<?php echo strip_tags(trim(stripslashes($_POST['mail']))); ?>" /></p>
		
		<p><label class="comment-label"><?php echo $lang_blog_label_comment; 
					if(isset($_POST['submit']) && empty($_POST['comment'])){ echo "<span style=\"color:red\">  - $lang_blog_error_comment</span>";} 
					if ($too_long == true){echo "<span style=\"color:red\">  -Your comment is too long</span>";}?></label><br />
		<textarea name="comment" cols="60" rows="7"><?php echo strip_tags(trim(stripslashes($_POST['comment']))); ?></textarea></p>

		<p><input id="ph" size="45" type="text" name="ph" value="<?php echo strip_tags(trim(stripslashes($_POST['ph']))); ?>" /></p>
		
				
<?php if( ($blog_capcha == true) || (!isset($blog_capcha))  ){ ?>
		<p><label class="comment-label"><?php echo $question; if ($resp == 2) {echo "<span style=\"color:red\">  - $lang_blog_error_captcha</span>";}?> </label><br /> 
		<input type="hidden" name="token" value="<?php echo md5($answer); ?>" />
		<input type="hidden" name="question" value="<?php echo htmlentities($question); ?>" />
		<input type="text" name="answers" /></p>
<?php } ?>		
		
		

		<p><button class="btn" type="submit" name ="submit"><?php echo $lang_blog_submit; ?></button></p>
		
	</form>
	<?php	
					}//blogcomments enables	
	}// end comment and ip-post
					echo '</div>';			
	
	}}//end display commment form if enabled

	
	//search		 
	else if(isset($_GET['search']) && strlen($_GET['search'])>0  && strlen($_GET['search'])<50 ) {
			include("blog_search.php");
			
		}
		
//blog default			
else {

	$result_per_page = $per_page ; 
	$total_pages = ceil($amount/$result_per_page);

	$cur_page = $_GET[page] ? $_GET[page] : 1;

	$start = $amount - (($cur_page-1) * $result_per_page);
	$end = $amount - (($cur_page) * $result_per_page);

	for ($n=$start-1  ;  $n>=$end  ;  $n-- ) { 
		$blog = explode("|", $lines[$n]);
		
		if (isset($blog[0]) & $blog[0] != '') {
			
			$date = explode( ' ' , $blog[2]);
			$date = $date[2] . ' ' . $date[1]  . ' ' . $date[3];
			
			echo "<div class=\"entry\">\n";
			echo "<h2 class=\"blog-title\"><a href=\"blog-". $blog[0] ."-".cleanUrlname($blog[3])."\">" .$blog[3]."</a></h2>\n"; 
			
			if($date_format) { echo "<div class=\"blog-date\">" . date("d-m-Y", strtotime($date))."</div>\n";} 
				 else { echo "<div class=\"blog-date\">" . date("m-d-Y", strtotime($date))."</div>\n"; } 
			
			if(preg_match("/^(.*)##more##/U", $blog[4], $m)) {
				     echo "<div class=\"blog-content\">" . $m[1] ." <a href=\"blog-". $blog[0] ."-".cleanUrlname($blog[3])."\" class=\"read-more\">$lang_blog_more</a></div>\n";
				  } else { echo "<div class=\"blog-content\">" . $blog[4] ."</div>\n"; }

			if($blog_comments) {
				if($blog[1]) {
				     echo  "<div class=\"num_comments\"><a href=\"blog-". $blog[0] ."-".cleanUrlname($blog[3])."#comments\">(". $blog[1] .") $lang_blog_num_comment</a></div>\n\n";
				      
				   } else {
						 echo "<div class=\"num_comments\"><a href=\"blog-". $blog[0] ."-".cleanUrlname($blog[3])."#comments\">$lang_blog_no_comment</a></div>\n\n";
								
					 }			
			} 
			echo "</div>\n\n";
		}// end if blog0
		else { continue; }
	}//end for
	echo '<div class="blog-pagination">';
		if ($cur_page<$total_pages) {
		 	 echo "<a href=\"". $prefix ."blog-page-" . ($cur_page+1) . "\">" . $lang_blog_older . "</a>" . "&nbsp;&nbsp;&nbsp;"; 
					
		}
		if ($cur_page>1) {		
			 echo  "<a href=\"". $prefix ."blog-page-" . ($cur_page-1) . "\">" . $lang_blog_newer . "</a>"; 	
         }
         
echo '</div>';

?>

<?php

}//default: blog post collection

echo '</div>';

?>