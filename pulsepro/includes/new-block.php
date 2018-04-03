<?php $on='blocks'; ?>

<div id="sub-head">
	<a href="index.php?p=manage-blocks"><?php echo $lang_go_back; ?></a>
</div>

<div id="content">
<?php

if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"] && !empty($_POST['blockname'])){
	
	$timestamp_old = time() - (15*60);
		
	if($_SESSION["token_time"] >= $timestamp_old){
	
			$clean_name = cleanUrlname($_POST['blockname']);
					
			@$blockname = $clean_name . ".html";
		
		if(!empty($_GET["d"] )) {
			
			$folders = strtr($_GET["d"], "../","/");
			$block_total = "data/blocks/". $folders ."/". $blockname;
			
			}else{
			
				$block_total = "data/blocks/" . $blockname;
			}
		
		if(file_exists($block_total)){ 
		
				echo "<p class=\"errorMsg\"><b>$lang_blocks_file_exists</b></p>";
			
			}else { 
			
				$block_handle = fopen($block_total, 'w') or die("{$blockname} $lang_blocks_not_created");
				fclose($block_handle);
				$_SESSION["blocks"]["new"] = $block_total;
			
				$host = $_SERVER['HTTP_HOST'];
				$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				header("Location: http://$host$uri/index.php?p=manage-blocks");
				die();
		
				unset($_SESSION["token"]);	
				unset($_SESSION["token_time"]);
			 }	
					
	}else{
	
		echo "<p class=\"errorMsg created\">$lang_blocks_session_expire</p>";
	}
}

if(empty($_SESSION["token"]) || $_SESSION["token_time"] <= $timestamp_old){
		 $_SESSION["token"] = md5(uniqid(rand(), TRUE));	
		 $_SESSION["token_time"] = time();
}
			
?>	
<div class="create-new">	
	<h1><?php echo $lang_blocks_newblock; ?></h1>
	
	<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="create-form">
	<input type="text" name="blockname" id="blockname" placeholder="<?php echo $lang_blocks_blockname; ?>">
	<input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
	<input type="submit" value="<?php echo $lang_blocks_create; ?>" class="btn">				
	</form>
</div>
<div style="clear: both;"></div> 

</div></div>