<?php 
$on='blog'; 
$lang_page_title = 'Edit Blog Post | Pulse'; 

$domain = $_SERVER['HTTP_HOST'];
$id = strip_tags(stripslashes(trim($_GET['post_id'])));

$opFile = "data/blog/blogfile.txt";
$fp   = @fopen($opFile,"r") or die("$lang_blog_error_reading"); 
$data = @fread($fp, filesize($opFile));
		fclose($fp);

$line = explode("\n", $data);			
$no_of_posts = count($line)-1;

if (!empty($_POST)) {

	$id = $_POST['post_id'];
	$comments = $_POST['post_comment'];
	$date = $_POST['post_date'];
	$title = htmlspecialchars(trim(stripslashes($_POST['title'])), ENT_QUOTES, "UTF-8");
	$content = strip_tags(stripslashes($_POST['content']), "<p><center><u><strong><audio><link><iframe><object><fieldset><dl><dt><dt><colgroup><col><font><label><em><embed><a><pre><b><i><style><table><tbody><td><textarea><tfoot><th><thead><title><tr><tt><ul><li><ol><img><h1><h2><h3><h4><h5><hr><address><span><div><blockquote><br><br /><button>");
	$content = str_replace("\n", "", $content);
	$content = str_replace("\r", "", $content);

	//turn off comments
	if($_POST['off_comments']==1 ){ 
		$off_comments = 1;
		 
		} else{ 
			$off_comments = 0; 
			}

for ($i=0; $i<$no_of_posts; $i++){

	$blog = explode("|", $line[$i]);
	if($blog[0] == $id) {	
	
		$new_data .=  $id .'|'.$comments.'|'.$date . '|' . $title . '|' . $content . '|'. $off_comments . "\n";
		
	  }else{
	  
		$new_data .= $line[$i] . "\n";
	}
}

$file    = @fopen($opFile,"w") or die($lang_blog_error_reading); 
$success = fwrite($file, $new_data);
		   fclose($file);
		   if($success==true){ $_SESSION["saved"]=true;}
 
		   $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		   header("Location: http://$domain$uri/index.php?p=edit-post&post_id=".$id);
		   die();
	
}

for ($i=0; $i<$no_of_posts; $i++){

	$blog = explode("|", $line[$i]);
	if($blog[0] != $id) continue;
	
	if ($blog[0] == $id){
		
		$post_comment = $blog[1];
        $edit_post_date = $blog[2];
        $edit_post_title = $blog[3];
        $edit_post_content = $blog[4];
        $off_comments = $blog[5];

		break;
	}
}
?> 

<div id="sub-head">
	<a href="index.php?p=manage-blog"><?php echo $lang_go_back; ?></a>
	<button onclick="document.editor.submit();"><?php echo $lang_blocks_save; ?></button>
	<a class="delete-post" href="index.php?p=del-post&post_id=<?php echo $blog[0] ; ?>"> <?php echo $lang_blog_post_delete ; ?></a>
	<?php greenCheckmark();?>
</div>

<div id="content" class="max">

<form class="editor" name="editor" id="edit_post" method="post" action="">
    <input type="hidden" name="post_id" value="<?php echo $id; ?>" />
    <input type="hidden" name="post_comment" value="<?php echo $post_comment; ?>" />
    <input type="hidden" name="post_date" value="<?php echo $edit_post_date; ?>" />
	<label><?php echo $lang_blog_label_title; ?></label>
	<input cols="100" class="new-title" type="text" name="title" value="<?php echo $edit_post_title; ?>" />
	<label><?php echo $lang_blog_label_body; ?></label>
	<textarea class="block_editor" id="redactor_content" cols="100" rows="10" name="content"><?php echo $edit_post_content; ?></textarea>	
	<br>
	
	<select name="off_comments">
			<option value="0" <?php if($off_comments != 1) { echo 'selected="selected"' ;}?>><?php echo $lang_blog_comment_on; ?></option>
			<option value="1" <?php if($off_comments == 1) { echo 'selected="selected"' ;}?>><?php echo $lang_blog_comment_off; ?></option>
	</select> 
	
</form>


<h2 class="comments-header"><?php echo $lang_blog_num_comment; ?></h2>
<?php 
$filename = "data/blog/comments.txt";

  $fp_comments = fopen($filename, "r") or die("$lang_blog_error_reading");
$data_comments = @fread($fp_comments, filesize($filename));
				 fclose($fp_comments);

$line = explode("\n", $data_comments);
$nb = count($line);

for($i=0; $i < $nb; $i++) { 

	$blog = explode("|", $line[$i]);
	
	if($blog[0] == $id) {
		
	   $date = explode( ' ' , $blog[1]);
	   $date = $date[2] . '-' . $date[1]  . '-' . $date[3];
	   $comment_id = $i+1;
	   
	    echo "<div class=\"comments-list\">
	    	  <span class=\"comment-title\">". $blog[2]." (". $blog[3].")</span> | <span >$date</span> | 
	    	  <a href=\"index.php?p=del-post&comment_id=". $comment_id ."&post_id=".$id."\" class=\"del-but\">$lang_blog_comment_delete</a>"; 
	    echo "</div>";
	
	}
}
?>
</div>