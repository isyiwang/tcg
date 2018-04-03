<?php $on='images';

if(!empty($_GET["g"]) && !empty($_GET["f"])) {

    $gallery = str_replace("..", "", $_GET["g"]);
    $id = $_GET["f"];
    
    // Get images
    $opFile =  ROOTPATH . "/data/img/gallery/". $gallery ."/gallery.txt";
    
    if(file_exists($opFile)) {
    
    	$fp = fopen($opFile,"r");
	    $data = @fread($fp, filesize($opFile));
        fclose($fp);

        $line = explode("\n", $data);
        $no_of_posts = count($line)-1;
               
	    for ($i=0; $i<$no_of_posts; $i++) {
	    
            $image = explode("|", $line[$i]);
            
		    if($image[1] == $gallery) {
		    
		      $images[] = $image;
		    }
	    }
        $nb = count($images);
        
        // Update caption
        if(isset($_POST['image']) && isset($_POST['caption']) ) {
        
            $image_id = $_POST['image'];
            $caption_new = $_POST['caption'];
                        
            for ($i=0; $i<$no_of_posts; $i++) {
            
                $caption = $images[$i][3]; 
               
                if($image_id ==  $images[$i][0]) {
                
                    $caption = trim(strip_tags(stripslashes($caption_new)));
                }  

                $new_data .= $images[$i][0] ."|". $images[$i][1]."|". $images[$i][2] ."|". $caption ."|". $images[$i][4] ."|"."\n";
                
                $images[$i][3] = $caption;
                
            }
                      
             if ($fp = @fopen($opFile,"w")){
             
                $success = fwrite($fp, $new_data);
                fclose($fp);
                
                $_SESSION["saved"]=true;

               }
               
			   else {
               		 echo "<p class=\"errorMsg\">$lang_blog_error_reading</p>"; 
            }            
        }        
      ?> <div id="sub-head">
		  		<a href="index.php?p=manage-photo&g=<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>"><?php echo $lang_go_back; ?></a> 
		  		<?php greenCheckmark(); ?>    
		 </div>

		 	<div id="content">
			 	<form action="" method="post">

				 	<?php 
					 	$nb = count($images);
					 	if(count($images) != 0) {
            
						 	for($i=0; $i<$nb; $i++) {
            
							 	if($images[$i][0] == $id) {
                
								 	echo '<div class="caption_page">';
								 	echo '<img src="data/img/gallery/'. $gallery .'/'. $images[$i][2] .'" class="caption_img"/>';
								 	echo '<div>';
								 	echo '<textarea name="caption" placeholder="'. $lang_gal_caption_gallery .'">'. stripslashes($images[$i][3]) .'</textarea>'."<p></p>";
                    
								 	echo '<input type="hidden" name="image" value="'. $images[$i][0] .'" /><br />';
								 	echo '<button type="submit" class="btn">'. $lang_blocks_save .'</button>'; 
								 	echo '</div></div>';
								 }
							} 
               
        
					} else {  
							
							echo '<p class="errorMsg">'. $lang_gal_empty .'</p>';
						}
				} else {
					
					echo '<p class="errorMsg">'. $lang_gal_empty .'</p>';
				}

?>
					</form>
</div>
<?php }else {
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			header("Location: http://$host$uri/index.php?p=manage-gallery");
			die();
}