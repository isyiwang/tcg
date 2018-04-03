<?php 
error_reporting(0);
include('../../config.php'); 
include_once("path.php");
include_once("helpers/gallery2-inc.php");
include_once("helpers/functions.php");

if($height == ""){$height = "100";}
if($width == ""){$width = "100";}

if($pulse_lang == 0){
	include_once("lang.php");	
	
	}elseif($pulse_lang == 1){
		include_once("lang_de.php");
		
		}

?>
<!DOCTYPE html> 
<html> 

<head> 
	<title><?php echo $lang_gal_gallery_preview; ?></title> 
	<meta charset="utf-8" /> 
	<style type="text/css">
	
body {
	background-color: #f5f5f5;
	font-family: sans-serif;
	font-size: 14px;
	color: #333;
}

.wrap {
	max-width: 600px;
	margin-left: auto;
	margin-right: auto;
	padding: 10px;
	margin-top: 30px;
}

a {
	color: #444;
	text-decoration: none;
}

.close {
	background-color: white;
	padding: 7px 15px;
	border-radius: 4px;
	border-color: #ddd;
	border-style: solid;
	border-width: 1px;
}

h3 {
	margin-bottom: 25px;
	padding-bottom: 7px;
	color: #444;
	border-bottom: 2px solid #e5e5e5;
}

.gallery {
  float: left;
  margin-bottom: 20px;
}

.gallery img {
  margin: 10px 20px 10px 0px;
  padding: 0;
  float: left;
  border: 0px;
}

.gallery img:hover {
  opacity: .8;
  -webkit-transition: all .2s ease;
  -moz-transition: all .2s ease;
  -o-transition: all .2s ease;
  transition: all .2s ease;
}

.gallery li {
  padding: 0;
  margin: 0;
  list-style-type: none;
}
</style>
</head> 
	
<body id="gal-prev"> 

<div class="wrap">

<a class="close" href="" onclick="window.open('', '_self', ''); window.close();"><?php echo $lang_gal_close_preview; ?></a>

<br><br><br>

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
   			   
?><h3><?php echo $lang_gal_preview_thumb_preview; ?></h3>

<div class="gallery">

<?php for ($i=0; $i<$no_of_posts+1; $i++) {
              
	    if($image[$i][1] == $gallery) { 
	    
	        echo '<a href="http://'. $_SERVER['HTTP_HOST'] .'/'. $pulse_dir .'/data/img/gallery/'. $gallery .'/'. $image[$i][2] .'" title="'. $image[$i][3] .'" >' . "\n";
	        
            echo '<img src="http://'. $_SERVER['HTTP_HOST'] .'/'. $pulse_dir .'/data/img/gallery/'.$gallery .'/'."thumb.php?src=" .$image[$i][2].'&h='.$height.'&w='.$width. " alt=". $image[$i][3] .'" />';
            
            echo '</a>' . "\n\n";
	    }
    }
    
?> 
</div>

<div style="clear:both"></div>

<h3><?php echo $lang_gal_preview_slider_preview; ?></h3>
    
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $pulse_dir; ?>/plugins/flex/flexslider.css" />
<script src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $pulse_dir; ?>/plugins/flex/jquery.flexslider.js"></script>

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
   
<?php  for ($i=0; $i<$no_of_posts+1; $i++) {
 
	    if($image[$i][1] == $gallery) { 
	        
            echo "<li>\n";
            
            echo '<img  src="http://'. $_SERVER['HTTP_HOST'] .'/'. $pulse_dir .'/data/img/gallery/'. $gallery .'/'. $image[$i][2] .'" alt="'. $image[$i][3] .'" />' . "\n";
            
            if(!empty($image[$i][3])){
            
           	 	echo '<p class="flex-caption">'. $image[$i][3] .'</p>' . "\n";
           	 	
            }
            
            echo "</li>\n\n";
	    }
    }
?>
</ul>
</div>
</div>    
    
<?php  } ?>

</div>	

<script>
$('.gallery').magnificPopup({
  delegate: 'a', 
  type: 'image',
  disableOn: 400,
  gallery:{enabled:true}
});
</script>

</body> 	
</html>