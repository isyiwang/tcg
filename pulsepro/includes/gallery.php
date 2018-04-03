<?php 
error_reporting(0);
include_once("path.php");
include(ROOTPATH."../../config.php"); 
include_once("helpers/gallery-inc.php");
include_once("helpers/functions.php");
?>

<script>
	$(window).load(function() {
	$('.flexslider').flexslider({
	slideshowSpeed: 6000,
	slideshow: true,
	keyboardNav: true,
	directionNav: true,
	controlNav: false,
	animationDuration: 600, 
	pauseOnAction: true
	});
	});
</script>
	
<div class="flex-container">
<div class="flexslider">
<ul class="slides">

<?php 
if(!empty($_GET["g"])) {
	$gallery = strip_tags(trim(stripslashes(htmlspecialchars($_GET["g"], ENT_QUOTES, 'UTF-8'))));
	$gallery = str_replace("/","", $gallery);
	$gallery = str_replace("\\","", $gallery);	
}

$opFile = ROOTPATH . "/data/img/gallery/". $gallery ."/gallery.txt";

if(file_exists($opFile)) {

	  $fp = fopen($opFile,"r");
    $data = @fread($fp, filesize($opFile));
    		fclose($fp);

    $line = explode("\n", $data);
    $no_of_posts = count($line)-1;
 
 	$image = sortImages($line);
 
 for ($i=0; $i<$no_of_posts+1; $i++) {
 
	    if($image[$i][1] == $gallery) { 
	        
            echo "<li>\n";            
            echo '<img  src="http://'. $_SERVER['HTTP_HOST'] .'/'. $pulse_dir .'/data/img/gallery/'. $gallery .'/'. $image[$i][2] .'" alt="'. $image[$i][3] .'" />' . "\n";
            
            if(!empty($image[$i][3])){
            
           	 	echo '<p class="flex-caption">'. $image[$i][3] .'</p>' . "\n";
           	 	
            }
            echo "</li>\n\n";
	    }
    }
} 
unset($image, $i, $test_line, $line, $data, $opFile, $gallery, $_GET["g"], $no_of_posts, $key, $val, $b, $xyn, $v);

?>
</ul>
</div>
</div>