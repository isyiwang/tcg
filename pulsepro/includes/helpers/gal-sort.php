<?php
error_reporting(0);
include_once("../../config.php"); 
include_once("../path.php");

if($pulse_lang == 0){
	include_once("../lang.php");
	}
 else if($pulse_lang == 1){
	include_once("../lang_de.php");
	}

if(!empty($_POST['gallery']) && !empty($_POST['one'])) {

	$gallery = strip_tags(trim(stripslashes(htmlspecialchars($_POST['gallery'], ENT_QUOTES, 'UTF-8'))));
	$gallery = str_replace("/","", $gallery);
	$gallery = str_replace("\\","", $gallery);	
    $gallery = str_replace("..", "",  $_POST['gallery']);
    
	$order = str_replace("/","", $_POST['one']);
	$order = str_replace("\\","", $order);	
    $order = str_replace("..", "", $order);
    
}

foreach ($order as $key => $value){		
					
			$position_new[] = array($value,$key);
				
}

// Get images
$opFile =  ROOTPATH . "/data/img/gallery/". $gallery ."/gallery.txt";
    
if(file_exists($opFile)) {
    
    	$fp = fopen($opFile,"r");
    	
	    $data = @fread($fp, filesize($opFile));
	    
        fclose($fp);

        $line = explode("\n", $data);
        
        $no_of_posts = count($line)-1;
               
	for ($i=0; $i<$no_of_posts+1; $i++) {
	    
            $image = explode("|", $line[$i]);
            
		    if($image[1] == $gallery) {
		    
		      	$images[] = $image;
		      	
		    }
	 }
}
			
foreach($images as $pic){ 	        		

	  foreach ($position_new as $new){
	  	  	                         
             if( ($new[0] == $pic[0]) && ($pic[1] == $gallery) ) {
                
                    $position = $new[1]; 
                    
                 }
          }

                $new_data .= $pic[0] ."|". $pic[1]."|". $pic[2] ."|". $pic[3] ."|". $position."|". "\n";
                
}

if(file_exists($opFile)) {
                        
if ($fp = @fopen($opFile,"w")){
             
   $success = fwrite($fp, $new_data);
                
   fclose($fp);
   	                
}
               
  else {
            
    	 echo "<p class=\"errorMsg\">Error</p>"; 
    }
}	
?>