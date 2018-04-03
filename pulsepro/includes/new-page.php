<?php $on='pages'; ?>

<div id="sub-head">
	<a href="index.php?p=manage-pages"><?php echo $lang_go_back; ?></a>
</div>

<div id="content">
<?php

if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"] && !empty($_POST['pagename'])){
	
	$timestamp_old = time() - (15*60);
		
	if($_SESSION["token_time"] >= $timestamp_old){
	
			$clean_name = cleanUrlname($_POST['pagename']);
					
			@$pagename = $clean_name . ".html";
		
			$page_total = "data/pages/".$pagename;
			
		
		if(file_exists($page_total)){ 
		
				echo "<p class=\"errorMsg\"><b>$lang_pages_file_exists</b></p>";
			
			}else { 
			
				$block_handle = fopen($page_total, 'w') or die("{$pagename} $lang_pages_not_created");
				fclose($block_handle);
				$_SESSION["pages"]["new"] = $page_total;
			
				$host = $_SERVER['HTTP_HOST'];
				$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				header("Location: http://$host$uri/index.php?p=manage-pages");
				die();
		
				unset($_SESSION["token"]);	
				unset($_SESSION["token_time"]);
			 }	
					
	}else{
	
		echo "<p class=\"errorMsg created\">$lang_pages_session_expire</p>";
	}
}

if(empty($_SESSION["token"]) || $_SESSION["token_time"] <= $timestamp_old){
		 $_SESSION["token"] = md5(uniqid(rand(), TRUE));	
		 $_SESSION["token_time"] = time();
}
			
?>	
<div class="create-new">	
	<h1><?php echo $lang_pages_newpage; ?></h1>
	
	<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="create-form">
	<input type="text" name="pagename" id="blockname" placeholder="<?php echo $lang_pages_pagename; ?>">
	<input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
	<input type="submit" value="<?php echo $lang_blocks_create; ?>" class="btn">				
	</form>
</div>
<div style="clear: both;"></div> 

</div></div>