// This file is used update the data folder structure from older versions to v2.3

<?php

	$text .= "<Files ~ \"\.txt$\">\n"; 
	$text .=  "Order allow,deny \n";
	$text .=  "Deny from all \n";
	$text .=  "</Files>";
	
	$errors = array();
	
//pages
if(!file_exists("data/pages/")){
	
	if(! mkdir("data/pages/" , 0755)){ $errors[] = "Error: Failed to create pages folder"; }
				
	
	if( $fp = @fopen("data/pages/.htaccess","w") ){
		$ht = @fwrite($fp, $text);	
		fclose($fp);
	}
		else{ $errors[] = "Error: Could not create .htaccess file in pages folder";}
		
		
}

if(file_exists("data/pages/")){

	if(!file_exists("data/pages/.htaccess")){
	
			if( $fp = @fopen("data/pages/.htaccess","w") ){
				$ht = @fwrite($fp, $text);	
				fclose($fp);
			  }
				 else{ $errors[] = "Error: Could not create .htaccess file in pages folder";}
		}
}





//logs
if(!file_exists("data/logs/")){
	
	if(! mkdir("data/logs/" , 0755)){ $errors[] = "Error: Failed to create logs folder"; }
				
	
	if( $fp = @fopen("data/logs/.htaccess","w") ){
		$ht = @fwrite($fp, $text);	
		fclose($fp);
	}
		else{ $errors[] = "Error: Could not create .htaccess file in logs folder";}
		
		
}

if(file_exists("data/logs/")){

	if(!file_exists("data/logs/.htaccess")){
	
			if( $fp = @fopen("data/logs/.htaccess","w") ){
				$ht = @fwrite($fp, $text);	
				fclose($fp);
			  }
				 else{ $errors[] = "Error: Could not create .htaccess file in logs folder";}
		}
}
			






//stats
if(!file_exists("data/stats/")){
	
	if(! mkdir("data/stats/" , 0755)){ $errors[] = "Error: Failed to create stats folder"; }
					
	if( $fp = @fopen("data/stats/.htaccess","w") ){
		$ht = @fwrite($fp, $text);	
		fclose($fp);
	}
		else{ $errors[] = "Error: Could not create .htaccess file in stats folder";}
		
		
}

if(file_exists("data/stats/")){

	if(!file_exists("data/stats/.htaccess")){
	
			if( $fp = @fopen("data/stats/.htaccess","w") ){
				$ht = @fwrite($fp, $text);	
				fclose($fp);
				}
					else{ $errors[] = "Error: Could not create .htaccess file in stats folder";}
		}
}

if(!file_exists("data/stats/sessions/")){

	if(! mkdir("data/stats/sessions/" , 0755)){ $errors[] = "Error: Failed to create stats/sessions/ folder"; }
}



//files
if(!file_exists("data/files/")){
	
	if(! mkdir("data/files/" , 0755)){ $errors[] = "Error: Failed to create files folder"; }
				
	
	if( $fp = @fopen("data/files/.htaccess","w") ){
		$ht = @fwrite($fp, $text);	
		fclose($fp);
	}
		else{ $errors[] = "Error: Could not create .htaccess file in files folder";}
		
		
}

if(file_exists("data/files/")){

	if(!file_exists("data/files/.htaccess")){
	
			if( $fp = @fopen("data/files/.htaccess","w") ){
				$ht = @fwrite($fp, $text);	
				fclose($fp);
			  }
				 else{ $errors[] = "Error: Could not create .htaccess file in files folder";}
		}
}




// update galleries for tim_thumb
$all_galleries = 'data/img/gallery/*';

foreach (glob($all_galleries) as $gallery){
		
	if(file_exists($gallery) && !preg_match("/\./", $gallery) ){
							
			
				if(!file_exists($gallery."/cache")){
							
							$cac = mkdir($gallery. "/cache" , 0775);
								
							if($cac == false){
								
								$errors[] = "Error: Failed to create a cache folder for $gallery";
								
							}

					}
		
				if(!file_exists($gallery."/thumb.php")){						
												
						$text = "<?php ". "include('../../../../plugins/timthumb/tim_thumb.php')".";"." ?>";
			
						$fp = @fopen($gallery. "/thumb.php","w");
						$ph = @fwrite($fp, $text);
						fclose($fp);
						
						if( ($fp == false) || ($ph == false) ){ 
							
							$errors[] = "Error: Failed to create a \"thumb.php\" file for $gallery"; 
							
							}
				    }
		   
	}	
	
}


if(!empty($errors)){ 
	
	foreach($errors as $error){
	
		echo "<p>$error</p>";
	}
	
}
	else { echo "<p>Update complete!</p>";}


?>