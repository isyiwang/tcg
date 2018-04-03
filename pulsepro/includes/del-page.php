<?php $on='pages'; ?>

<div id="sub-head">
	<a href="index.php?p=manage-pages"><?php echo $lang_go_back; ?></a>
</div>

<div id="content">
<?php 
			
	if(!empty($_GET["e"]) && is_numeric($_GET["e"])){
	
			$id = $_GET["e"];
			$fname = $_SESSION["pages"][$id];
			$fname = str_replace("..", "", $fname);
			
			if(file_exists ($fname)) {

				if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"]){
					$timestamp_old = time() - (15*60);
			
					if($_SESSION["token_time"] >= $timestamp_old){
					
						if(unlink($fname)){
						
							$host  = $_SERVER['HTTP_HOST'];
							$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
							header("Location: http://$host$uri/index.php?p=manage-pages");
							die();
						}
						
					}else{
					
						echo "<p class=\"errorMsg created\">$lang_pages_session_expire</p>";
					}
								
				}else{
				
					$token = md5(uniqid(rand(), TRUE));
					$_SESSION["token"] = $token;
					$_SESSION["token_time"] = time();
					
					echo "<p>$lang_pages_sure_del_block</p><br>";
					
					
					echo "<form action=\"index.php?p=del-page&e=". $id ."\" method=\"post\">";
					
					
					echo "<input type=\"hidden\" name=\"token\" value=\"$token\" />";
					echo "<button value=\"Yes\" type=\"submit\" class=\"btn\">$lang_yes</button>";
					echo "<a href=\"index.php?p=manage-pages" ."\" class=\"btn\">$lang_cancel</a>";
					echo "</form>";
			
				}
				
			}else{
			
				echo "<p class=\"errorMsg\">$lang_pages_cant_find_page</p>";
		}
			
	}else{
	
		echo "<p class=\"errorMsg\">$lang_pages_cant_find_page</p>";
	}
?>
</div>