<?php
//blocks
function getFiles($folder="") {
	if($folder) {	
		$files = glob("data/blocks/". $folder ."/*");		
	}else {	
		$files =  glob("data/blocks/*");
	}	

	foreach ($files as $file) { 
		if ($file != "." && $file != ".." ) {		
			if($folder) {			
				$dm[] = $file;;
			}else {			
				$dm[] = $file;
			}				
		}
	}	
	return $dm;
}

function cleanUrlname($input){
			$clean_name = trim($input);
			$clean_name = str_replace(' ', '-', $clean_name);
			$clean_name = str_replace(',', '', $clean_name);
			$clean_name = str_replace('&', '', $clean_name);
			$clean_name = str_replace('!', '', $clean_name);
			$clean_name = str_replace(')', '', $clean_name);	
			$clean_name = str_replace('(', '', $clean_name);
			$clean_name = str_replace('.', '', $clean_name);	
			$clean_name = str_replace(':', '', $clean_name);
			$clean_name = str_replace('#039;', '', $clean_name);
			$clean_name = str_replace('/', '', $clean_name);
			$clean_name = str_replace('&', '', $clean_name);
			$clean_name = str_replace('amp;', '', $clean_name);
			$clean_name = str_replace('--', '-', $clean_name);
			$clean_name = str_replace('\'', '', $clean_name);
			$clean_name = str_replace('<', '', $clean_name);
			$clean_name = str_replace('>', '', $clean_name);
			$clean_name = str_replace('\\', '', $clean_name);
			$clean_name = str_replace('/', '', $clean_name);
			$clean_name = strtolower($clean_name);

			return $clean_name;
}

//del-blocks, del-gal
function delTree($dir) {
    $files = glob( $dir . '*', GLOB_MARK );    
    foreach( $files as $file ){    
        if( substr( $file, -1 ) == '/' )        
            delTree( $file );            
        else
            unlink( $file );
    }
    rmdir( $dir );
} 

//sorts images, gallery, gallery2, manage-photo, preview 
function sortImages($line){
 foreach($line as $test){
       		 $test_line[] = explode("|", $test);      		     	        
   }
         $xyn = false;  
              	              	
 foreach ($test_line as $k => $v){ 	
		if (trim($v['4']) == ''){		 	
		 	$v['4'] = 99; 		 	
		 }
		$b[$k] = $v['4'];
	
		if($b[$k]!= 99){ 		
			$xyn = true; 			
		 }				
   }
		
 if ($xyn == true) { 	
	 asort($b); 
	
		foreach($b as $key=>$val){								
			$image[] = $test_line[$key];					
		  }			
   } else {    		
   			$image = array_reverse($test_line);
   			}    			
   			return $image;
}//end sort


//save checkmark, settings,manage-form,view,edit-post
function greenCheckmark(){
	?><span class="green" style="display: none; font-size:16px;" id="fade">&#10003;</span>
	<?php if($_SESSION["saved"] == true){		
		   ?><script>
				$('#fade').show('fast');
				$('#fade').fadeOut(3000);
			</script>
	<?php } unset($_SESSION["saved"]);
}

?>