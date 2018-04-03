<?php $on='images'; ?>

<div id="sub-head">
    <a href="index.php?p=manage-photo&g=<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>"><?php echo $lang_go_back; ?></a>     
</div>

<div id="content">
	
<?php 	
	if(!empty($_GET["f"]) && is_numeric($_GET["f"]) && !empty($_GET["g"])){
		$id = $_GET["f"];
		
		$gallery = strtr($_GET["g"], "../","/");
			
		$upload_dir = "./data/img/gallery/". $gallery ."/";

		$opFile =  ROOTPATH . "/data/img/gallery/". $gallery ."/gallery.txt";
		if($fp = fopen($opFile,"r")) {
            $data = @fread($fp, filesize($opFile));
            fclose($fp);

            $line = explode("\n", $data);
            $no_of_posts = count($line)-1;

		    for ($i=0; $i<$no_of_posts; $i++) {
                $image = explode("|", $line[$i]);
                
                if($image[1] == $gallery && $id == $image[0]) {
                    $filename = $image[2];
                } 
                	else {
                    	$new_data .= $image[0] ."|". $image[1]."|". $image[2] ."|". $image[3] ."|". $image[4] ."\n";
                }
            }	
		}
		          
		if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"]){
			$timestamp_old = time() - (15*60);
		
			if($_SESSION["token_time"] >= $timestamp_old){
				                         
                    $fp = @fopen($opFile,"w") or die($lang_blog_error_reading); 
                    $success = fwrite($fp, $new_data);
                    fclose($fp);
                    
                    if(is_file($upload_dir.$filename)) {
				        unlink($upload_dir.$filename);
				        
				        $host  = $_SERVER['HTTP_HOST'];
						$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
						header("Location: http://$host$uri/index.php?p=manage-photo&g=$gallery");
						die();

				    
				    } else {
				    
				        echo "<p class=\"errorMsg\">$lang_gal_cant_find_file</p>";
				    }    
				
			} else {
			
				echo "<p class=\"errorMsg created\">$lang_gal_session_expired</p>";
			}	
					
		} else {
		
			$token = md5(uniqid(rand(), TRUE));
			$_SESSION["token"] = $token;
			$_SESSION["token_time"] = time();
			
			echo "<p>$lang_gal_sure_delete_file<b>" . $filename . "</b>?</p><br>";
			echo "<form action=\"index.php?p=del-img&f=". $id ."&g=". $gallery ."\" method=\"post\">";
			echo "<p><input type=\"hidden\" name=\"token\" value=\"$token\" />";
			echo "<button value=\"Yes\" type=\"submit\" class=\"btn\">$lang_yes</button>";
			echo "&nbsp;&nbsp;&nbsp;<a href=\"index.php?p=manage-photo&g=". $gallery ."\" class=\"btn\">$lang_cancel</a>";
			echo "</form>";
		
		}	
			
	} else {
	
		echo "<p class=\"errorMsg\">$lang_gal_cant_find_file</p>";
	}
			
?>
</div>