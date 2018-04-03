<?php

$on='blog';

if (!empty($_POST)) {

$filename = "data/blog/blogfile.txt";

if (isset($_POST['message'])) {
	$date = $_POST['date'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];

	$fp = fopen($filename,"r") or die($lang_blog_error_reading); 
	$data = @fread($fp, filesize($filename));
    fclose($fp);

    $line = explode("\n", $data);
    $no_of_posts = count($line)-1;
           
	
	for ($i=0; $i<$no_of_posts; $i++) {
        $blog = explode("|", $line[$i]);
		$posts[$i] = $blog[0];
	}
    
    if(count($posts) > 0) {
	    $no_of_posts = max($posts)+1;
	} else {
	     $no_of_posts = 1;
	}
	
	$subject = htmlspecialchars(trim(stripslashes($subject)), ENT_QUOTES, "UTF-8");
	$message = strip_tags(stripslashes($message), "<p><center><u><strong><audio><iframe><link><object><fieldset><dl><dt><dt><colgroup><col><font><label><embed><a><pre><b><i><style><table><tbody><td><textarea><tfoot><th><thead><title><tr><tt><ul><li><ol><img><h1><h2><h3><h4><h5><hr><address><span><div><blockquote><br><br /><button>");

	$message = trim($message);
	$postdate = date("D, d M Y H:i:s O");
	$message = str_replace("\n", "", $message);
	$message = str_replace("\r", "", $message);
	$message = str_replace("|", "&brvbar;", $message);

	$blog = $no_of_posts ."|0|". $postdate ."|". $subject ."|". $message."\n";

	$data = fopen($filename, "a");
	fwrite($data, $blog);
	fclose($data);
	
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	header("Location: http://$host$uri/index.php?p=manage-blog");
	die();
}}

?>

<div id="sub-head">
	<a href="index.php?p=manage-blog"><?php echo $lang_go_back; ?></a>
	<button onclick="document.editor.submit();"><?php echo $lang_blocks_save; ?></button>
</div>

<div id="content" class="max">
	<form class="editor" name="editor" action="" method="post" name="post">
		<label><?php echo $lang_blog_label_title; ?></label>
		<input class="new-title" type="text" name="subject" maxlength="70" value="" />
		<label><?php echo $lang_blog_label_body; ?></label>
		<textarea class="block_editor" id="redactor_content" name="message" rows="10" cols="35" wrap="virtual"></textarea>
	</form>
</div>