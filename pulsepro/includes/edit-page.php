<?php 
$on='pages'; 
$domain = $_SERVER['HTTP_HOST'];
$timestamp_old = time() - (60*60);

// edit/save the block content
if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"] && isset($_POST["filename"])){
	
	if($_SESSION["token_time"] >= $timestamp_old){
	
		$id = stripslashes($_POST["filename"]);
		$fname = $_SESSION["pages"][$id];

		$fname = strip_tags($fname);
		$fname = str_replace("..", "", $fname);
		$fname = ltrim($fname, "/");
		$block = stripslashes( $_POST["page"]);
		
		// Optionally disable php and js
		/* $block = stripslashes(str_replace(array("<?","?>"), array("",""), $block)); */
		/* $block = stripslashes(str_replace(array("<script>","</script>"), array("",""), $block)); */
		
		
		 	$fp = @fopen($fname, "w");
		 	
		 	if ($fp) {
				fwrite($fp, $block);
				fclose($fp);
				$_SESSION["saved"]=true;
			}		
		 
		
		unset($_SESSION["token"]);	
		unset($_SESSION["token_time"]);
	}
}

// read the page content
if(isset($_GET["e"]) && isset($_SESSION["pages"])) {

	$id = stripslashes(htmlentities($_GET["e"]));
	$fname = $_SESSION["pages"][$id];
	$fname = str_replace("..", "", $fname);
	$fname = ltrim($fname, "/");
	$folders = strtr($_GET["d"], "../","/");
	
	if(file_exists($fname)) { 
			$fp = @fopen($fname, "r");
		
		if(filesize($fname) !== 0) {
				$loadblock = fread($fp, filesize($fname));
				$loadblock = htmlspecialchars($loadblock);
				fclose($fp);
			}	
	}
	
	if(empty($_SESSION["token"]) || $_SESSION["token_time"] <= $timestamp_old){
		$_SESSION["token"] = md5(uniqid(rand(), TRUE));	
		$_SESSION["token_time"] = time();
	}
					
?>

<div id="sub-head">
	<a href="index.php?p=manage-pages"><?php echo $lang_go_back; ?></a>
	<button onclick="document.mark.submit();"><?php echo $lang_blocks_save; ?></button>

<?php  $info = pathinfo($fname); ?>

<a class="block-rename" href="index.php?p=rename-page&e=<?php echo $id; ?>" title="Rename" ><?php echo $lang_blocks_rename_btn; ?></a>

<a class="block-delete" href="index.php?p=del-page&e=<?php echo $id; ?>" title="Delete" ><?php echo $lang_blocks_delblock; ?></a>
<?php 		

	greenCheckmark();	

?>
</div>

<div id="content" class="max"> 

<form class="editor" name="mark" method="post" action="">	

	<input type="hidden" name="filename" value="<?php echo $id; ?>">
	<input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
	<textarea class="sb_content" name="page" ><?php echo $loadblock; ?></textarea>
</form>

</div>	 
                      
<?php 
	}else{
	
?>
<div id="sub-head">&nbsp;</div>
<div id="content">
<p class="errorMsg"><?php echo $lang_pages_cant_find_page; ?></p>
</div>
<?php } ?>

<script>
/* Allows tabbing in textarea */
$(document).delegate('.sb_content', 'keydown', function(e) { 
  var keyCode = e.keyCode || e.which; 

  if (keyCode == 9) { 
    e.preventDefault(); 
    var start = $(this).get(0).selectionStart;
    var end = $(this).get(0).selectionEnd;

    // set textarea value to: text before caret + tab + text after caret
    $(this).val($(this).val().substring(0, start)
                + "\t"
                + $(this).val().substring(end));

    // put caret at right position again
    $(this).get(0).selectionStart = 
    $(this).get(0).selectionEnd = start + 1;
  } 
});
</script>