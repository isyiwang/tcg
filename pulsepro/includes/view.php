<?php 
$on='blocks'; 
$domain = $_SERVER['HTTP_HOST'];
$timestamp_old = time() - (60*60);

// edit/save the block content
if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"] && isset($_POST["filename"])){
	
	if($_SESSION["token_time"] >= $timestamp_old){
	
		$id = stripslashes($_POST["filename"]);
		$fname = $_SESSION["blocks"][$id];

		$fname = strip_tags($fname);
		$fname = str_replace("..", "", $fname);
		$fname = ltrim($fname, "/");
		$block = stripslashes( $_POST["block"]);
		
		// Optionally disable php and js
		/* $block = stripslashes(str_replace(array("<?","?>"), array("",""), $block )); */
		/* $block = stripslashes(str_replace(array("<script>","</script>"), array("",""), $block )); */
		
		if($_POST["move"]){
		
			$fmove = str_replace("..", "", $_POST["move"]);
			$info = pathinfo($fname);
			$fname = "data/blocks". $fmove.$info["basename"];
			$fp = @fopen($fname, "w");
			
			if ($fp) {
				fwrite($fp, $block);
				fclose($fp);
				
				if(unlink($_SESSION["blocks"][$id])){
					$_SESSION["blocks"][$id] = $fname;
				}
			 $_SESSION["saved"]=true;

			}
					
		 }else{
		
		 	$fp = @fopen($fname, "w");
		 	
		 	if ($fp) {
				fwrite($fp, $block);
				fclose($fp);
				$_SESSION["saved"]=true;
			}		
		 }
		
		unset($_SESSION["token"]);	
		unset($_SESSION["token_time"]);
	}
}

// read the block content
if(isset($_GET["f"]) && isset($_SESSION["blocks"])) {

	$id = stripslashes(htmlentities($_GET["f"]));
	$fname = $_SESSION["blocks"][$id];
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
	<a href="index.php?p=manage-blocks&d=<?php echo $folders; ?>"><?php echo $lang_go_back; ?></a>
	<button onclick="document.mark.submit();"><?php echo $lang_blocks_save; ?></button>

<?php  $info = pathinfo($fname); 

	 	if($folders){
?> 			
			<a class="block-rename" href="index.php?p=rename-block&f=<?php echo $id; ?>&d=<?php echo $folders; ?>" title="Rename" ><?php echo $lang_blocks_rename_btn; ?></a>
			<a class="block-delete" href="index.php?p=del-block&f=<?php echo $id; ?>&d=<?php echo $folders; ?>" title="Delete" ><?php echo $lang_blocks_delblock; ?></a>

<?php 	}
	
		else{ ?>
		    <a class="block-rename" href="index.php?p=rename-block&f=<?php echo $id; ?>" title="Rename" ><?php echo $lang_blocks_rename_btn; ?></a>
		    <a class="block-delete" href="index.php?p=del-block&f=<?php echo $id; ?>" title="Delete" ><?php echo $lang_blocks_delblock; ?></a>
<?php 		}

	greenCheckmark();	

?>
</div>

<div id="content" class="max"> 

<form class="editor" name="mark" method="post" action="">	

	<input type="hidden" name="filename" value="<?php echo $id; ?>">
	<input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
	<textarea class="sb_content" name="block" <?php if(strstr($fname, "sb_") == false){ ?> id="redactor_content" <?php } ?> ><?php echo $loadblock; ?></textarea>
	<br>
	<p class="moveto"><select name="move">
	<option value=""><?php echo $lang_blocks_move; ?></option>
	
<?php
		$folders = glob("data/blocks/*", GLOB_ONLYDIR);
		$fil = pathinfo($fname);
			
			if($fil["dirname"] != "data/blocks"){
				echo "<option value=\"/\">/</option>";
			}

			foreach ($folders as $file) { 	
				
				if ($file != "." && $file != ".." && $fil["dirname"] != $file) {
					echo "<option value=\"/". basename($file) ."/\">/". basename($file) ."</option>";	
				}
			}
?>	
    </select>
	</p>	
</form>
		
<div class="howto">
	<a class="embed_toggle" href="#"><?php echo $lang_embed; ?></a>
	<div id="main" style="display:none;">
	<p><?php echo $lang_embed_desc; ?></p>
	<input value='&lt;?php include($_SERVER["DOCUMENT_ROOT"]."/<?php echo $pulse_dir; ?>/<?php echo $fname; ?>"); ?&gt;' onclick="select_all(this)" > 
	<br><?php echo $lang_embed_desc2; ?>
</div>

</div>	 
                      
<?php 
	}else{
	
?>
<div id="sub-head">&nbsp;</div>
<div id="content">
<p class="errorMsg"><?php echo $lang_blocks_cant_find_block; ?></p>
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