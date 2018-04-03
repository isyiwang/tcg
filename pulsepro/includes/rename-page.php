<?php $on='pages'; ?>

<div id="sub-head">
	<a href="index.php?p=manage-pages"><?php echo $lang_go_back; ?></a>
</div>

<div id="content">
<?php
 
$success = false;	
	
if(!empty($_GET["e"]) && is_numeric($_GET["e"])){
		
			$id = $_GET["e"];
			$fname = $_SESSION["pages"][$id];
			$fname = str_replace("..", "", $fname);
			
			$info1 = preg_replace("/\\.[^.\\s]{3,4}$/", "", $fname);
		    $info1 = basename($info1);

}
else { 
	$success = true;
	echo "<p class=\"errorMsg\">$lang_pages_cant_find_page</p>";
}
	    
if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"]){
				$timestamp_old = time() - (15*60);
			
			if($_SESSION["token_time"] <= $timestamp_old){ die("<p class=\"errorMsg created\">$lang_pages_session_expire</p>") ;}
				
			if($_POST['rename'] && !empty($_POST['rename']) && $_POST['submit'] && isset($_POST["filename"]) && ($_POST["filename"]==$id  ) ){
										
					$clean_name = cleanUrlname($_POST['rename']);						
					
					if(file_exists("data/blocks/".$clean_name.".html")){ 
						
						echo "<p class=\"errorMsg\"><b>$lang_pages_file_exists</b></p><br>"; 					
					}					
					
				   else{
								rename("$fname", "data/pages/".$clean_name.".html");
								$_SESSION["pages"][$id] = "data/pages/".$clean_name.".html";
								$success = true;
								
								$host  = $_SERVER['HTTP_HOST'];
								$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
							    header("Location: http://$host$uri/index.php?p=manage-pages");
								die();

					}
					
				
					unset($_SESSION["token"]);	
					unset($_SESSION["token_time"]);	
			}			
						
							 
			 else{
			 
			 	$success = false;
			 	echo "<p class=\"errorMsg\"><b>$lang_blocks_rename_try_again</b></p>"; 
			 	}
					
}
	
if(empty($_SESSION["token"]) || $_SESSION["token_time"] <= $timestamp_old){
		 $_SESSION["token"] = md5(uniqid(rand(), TRUE));	
		 $_SESSION["token_time"] = time();
}

if($success != true){ ?>

<div class="create-new">	
<form name="mark" method="post" action="">	

	<input type="hidden" name="filename" value="<?php echo $id; ?>">
	<input type="text" name="rename" class="rename-block" value="<?php echo $info1; ?>">
	<input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
	<input type="submit" name="submit" value="<?php echo $lang_blocks_rename_btn; ?>" class="btn">				

</form>
</div></div>
<div style="clear: both;"></div> 

</div></div>
<?php } ?>