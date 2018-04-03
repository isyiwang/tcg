<?php $on='blocks'; ?>

<div id="sub-head">
	<a href="index.php?p=manage-blocks"><?php echo $lang_go_back; ?></a>
</div>

<div id="content">
<?php 
			
	if(!empty($_GET["d"]) && empty($_GET["f"])){
		
		$folders = strtr($_GET["d"], "../","/");
		$folder = "./data/blocks/". $folders ."/";

		if(is_dir($folder)) {

			if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"]){
				$timestamp_old = time() - (15*60);
			
				if($_SESSION["token_time"] >= $timestamp_old){
					
					delTree($folder);
					
					$host  = $_SERVER['HTTP_HOST'];
					$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
					header("Location: http://$host$uri/index.php?p=manage-blocks");
					die();
					
				}else{
				
					echo "<p class=\"errorMsg created\">$lang_blocks_session_expire</p>";
				}
							
			}else{
			
				$token = md5(uniqid(rand(), TRUE));
				$_SESSION["token"] = $token;
				$_SESSION["token_time"] = time();
				
				echo "<p>$lang_blocks_sure_delete_fold</p><br>";
				echo "<form action=\"index.php?p=del-block&d=". $folders ."\" method=\"post\">";
				echo "<p><input type=\"hidden\" name=\"token\" value=\"$token\" />";
				echo "<button value=\"Yes\" type=\"submit\" class=\"btn\">$lang_yes</button>";
				echo "<a href=\"index.php?p=manage-blocks&d=". $folders ."\" class=\"btn\">$lang_cancel</a>";
				echo "</form>";
			}
					
		}else{
		
			echo "<p class=\"errorMsg\">$lang_blocks_cant_find_fold</p>";
		}
	
	}elseif(!empty($_GET["f"]) && is_numeric($_GET["f"])){
	
			$id = $_GET["f"];
			$folders = strtr($_GET["d"], "../","/");
			$fname = $_SESSION["blocks"][$id];
			$fname = str_replace("..", "", $fname);
			
			if(file_exists ($fname)) {

				if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"]){
					$timestamp_old = time() - (15*60);
			
					if($_SESSION["token_time"] >= $timestamp_old){
					
						if(unlink($fname)){
						
							$host  = $_SERVER['HTTP_HOST'];
							$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
							header("Location: http://$host$uri/index.php?p=manage-blocks");
							die();
						}
						
					}else{
					
						echo "<p class=\"errorMsg created\">$lang_blocks_session_expire</p>";
					}
								
				}else{
				
					$token = md5(uniqid(rand(), TRUE));
					$_SESSION["token"] = $token;
					$_SESSION["token_time"] = time();
					
					echo "<p>$lang_blocks_sure_del_block</p><br>";
					
					if($folders){
					
						echo "<form action=\"index.php?p=del-block&f=". $id ."&d=". $folders ."\" method=\"post\">";
						
					}else{
					
						echo "<form action=\"index.php?p=del-block&f=". $id ."\" method=\"post\">";
					}
					
					echo "<input type=\"hidden\" name=\"token\" value=\"$token\" />";
					echo "<button value=\"Yes\" type=\"submit\" class=\"btn\">$lang_yes</button>";
					echo "<a href=\"index.php?p=manage-blocks&d=". $folders ."\" class=\"btn\">$lang_cancel</a>";
					echo "</form>";
			
				}
				
			}else{
			
				echo "<p class=\"errorMsg\">$lang_blocks_cant_find_block</p>";
		}
			
	}else{
	
		echo "<p class=\"errorMsg\">$lang_blocks_cant_find_block</p>";
	}
?>
</div>