<?php $on='images'; ?>

<div id="sub-head">
    <a href="index.php?p=manage-gallery"><?php echo $lang_go_back; ?></a>     
</div>

<div id="content">
<?php 
			
	if(!empty($_GET["g"])){
		
		$gallery = strtr($_GET["g"], "../","/");		
		$upload_dir = "./data/img/gallery/". $gallery ."/";
		
		if(is_dir($upload_dir)) {

			if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"]){
				$timestamp_old = time() - (15*60);
			
				if($_SESSION["token_time"] >= $timestamp_old){
				
					delTree($upload_dir);
					
					$host  = $_SERVER['HTTP_HOST'];
					$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
					header("Location: http://$host$uri/index.php?p=manage-gallery");
					die();
					
				}else{
				
					echo "<p class=\"errorMsg created\">$lang_gal_session_expired</p>";
				  }
							
			}else{
			
				$token = md5(uniqid(rand(), TRUE));
				$_SESSION["token"] = $token;
				$_SESSION["token_time"] = time();
				
				echo "<p>$lang_gal_sure_delete</p><br>";
				echo "<form action=\"index.php?p=del-gal&g=". $gallery ."\" method=\"post\">";
				echo "<input type=\"hidden\" name=\"token\" value=\"$token\" />";
				echo "<button value=\"Yes\" type=\"submit\" class=\"btn\">$lang_yes</button>";
				echo "&nbsp;&nbsp;&nbsp;<a href=\"index.php?p=manage-photo&g=". $gallery ."\" class=\"btn\">$lang_cancel</a>";
				echo "</form>";
			
			}
					
		}else{
		
			echo "<p class=\"errorMsg\">$lang_gal_cant_find</p>";
		}
			
	}else{
	
		echo "<p class=\"errorMsg\">$lang_gal_cant_find</p>";
	}
?>
</div>