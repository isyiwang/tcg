<?php 
error_reporting(0);
include_once("path.php");
include(ROOTPATH."../../config.php");
include_once("helpers/gallery2-inc.php");
include_once("helpers/functions.php");

if($height == ""){$height = "100";}
if($width == ""){$width = "100";}

?>

<style type="text/css">

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

.gallery a {
	float: left;
}

</style>

<div class="gallery">

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
	    
	        echo '<a href="http://'. $_SERVER['HTTP_HOST'] .'/'. $pulse_dir .'/data/img/gallery/'. $gallery .'/'. $image[$i][2] .'" title="'. $image[$i][3] .'" >' . "\n";
	        
            echo '<img src="http://'. $_SERVER['HTTP_HOST'] .'/'. $pulse_dir .'/data/img/gallery/'.$gallery .'/'."thumb.php?src=" .$image[$i][2].'&h='.$height.'&w='.$width.'" alt="'. $image[$i][3] .'">';
            
            echo '</a>' . "\n\n";
	    }
    }
}
unset($image, $i, $test_line, $line, $data, $opFile, $gallery, $_GET["g"], $no_of_posts, $key, $val, $b, $xyn, $v);

?>
</div>

<script>
$('.gallery').each(function() {
    $(this).magnificPopup({
        delegate: 'a', 
        type: 'image',
        disableOn: 400,
        gallery:{enabled:true}
    });
}); 
</script>

<div style="clear:both"></div>