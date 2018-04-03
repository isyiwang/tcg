<?php 
$on='images';

$image = getimagesize($_FILES["file"]["tmp_name"]);

// Allowed file types for upload
$ext = array('jpg','jpeg','gif','png');

if(isset($_GET["g"]) && !empty($_GET["g"]) && is_dir("../data/img/gallery/". $_GET["g"])) {
	
	$gallery = strtr($_GET["g"], "../","/");
	
	$fileName = preg_replace('/[^\w\._]+/', '', $_FILES["file"]['name']);
	
	if($_FILES["file"]["size"] < 5200000
	&& in_array( strtolower(substr(strrchr($fileName, '.'), 1)), $ext) 
	&& (($image[2] == 1 ) || ($image[2] == 2) || ($image[2] == 3))){

		  if ($_FILES["file"]["error"] > 0){
		  
				echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
				
		  }else{
		  
				echo "Upload: " . $fileName . "<br />";
				echo "Type: "   . $_FILES["file"]["type"] . "<br />";
				echo "Size: "   . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
				
				if (file_exists("../data/img/gallery/" . $gallery ."/". $fileName)) { 
				
				     $fileName = rand() . $fileName;
				}
                
                if(move_uploaded_file($_FILES["file"]["tmp_name"],
                "../data/img/gallery/". $gallery ."/". $fileName))
                chmod("../data/img/gallery/". $gallery ."/". $fileName,0777);
                
                //Update gallery.txt
                $opFile = "../data/img/gallery/". $gallery ."/gallery.txt";
                
                if(file_exists($opFile)){
                
                $fp = fopen($opFile,"r+");
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
                
                }
                $pos = $no_of_posts+1;
                
                if(is_array($images)){$nb = end($images);} else { $nb = $images;}

                $new_data = $nb[0]+1 ."|". $gallery ."|". $fileName."||".$pos ."\n";

                $fp = @fopen($opFile,"a+") or die($lang_blog_error_reading); 
                $success = fwrite($fp, $new_data);
                fclose($fp);
		}
	}else{
		// Invalid file, echo $lang_gal_file_invalid;
	}
		
} else {
     // Invalid file, echo $lang_gal_invalid_gal;	  

}
?>