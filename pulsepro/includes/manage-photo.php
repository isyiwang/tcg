<?php $on='images'; ?>

<div id="sub-head">
	<a href="index.php?p=manage-gallery"><?php echo $lang_go_back; ?></a>
	<a href="index.php?p=choose-img&g=<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>"><?php echo $lang_gal_upload; ?></a>
	<a class="delete-gallery" href="index.php?p=del-gal&g=<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>"><?php echo $lang_gal_del_gallery; ?></a>
	<a target="_blank" href="includes/gallery-preview.php?g=<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>"><?php echo $lang_gal_preview; ?> &rarr;</a>    
</div>

<div id="content">

<?php 

if(!empty($_GET["g"])) {
	$gallery = strip_tags(trim(stripslashes(htmlspecialchars($_GET["g"], ENT_QUOTES, 'UTF-8'))));
	$gallery = str_replace("/","", $gallery);
	$gallery = str_replace("\\","", $gallery);	
    $gallery = str_replace("..", "",  $_GET["g"]);
    
    $opFile = ROOTPATH . "/data/img/gallery/". $gallery ."/gallery.txt";
    
    if(file_exists($opFile)) {
    
    	$fp = fopen($opFile,"r");
        $data = @fread($fp, filesize($opFile));
        fclose($fp);

        $line = explode("\n", $data);
        $nb = count($line)-1;
               
		$image = sortImages($line);
          
?><ul id="sortable" > <?php
              
   for ($i=0; $i<$nb+1; $i++) {
            
	  if($image[$i][1] == $gallery) { 
	  	        	       	 		        		        				     		        		        
		    ?>		        
	           <ul class="thumb" id="one_<?php echo $image[$i][0]; ?>"><?php
		          
                echo '<a href="index.php?p=captions&f='. $image[$i][0] .'&g='. $image[$i][1] .'">';
                echo '<img src="data/img/gallery/'. $gallery .'/'. $image[$i][2] .'" alt="'. $image[$i][3] .'"  class="thumb-pic"/>';
                echo '</a>';
                echo '<a href="index.php?p=captions&f='. $image[$i][0] .'&g='. $image[$i][1] .'">';
                echo '<img src="img/pencil-icon.png" class="mag-glass" />';
                echo '</a>';
                echo "<a href=\"index.php?p=del-img&f=". $image[$i][0] ."&g=". $gallery ."\" class=\"del-img\">$lang_gal_delete</a>";
               
            ?> </ul> <?php 
                
	        }
        }
        
        ?> </ul> <div id="result"></div> <?php
    } 
    
if($nb <= 0) {
    
        echo "<p class=\"empty\">". $lang_gal_empty ."</p><br><br>";
        
    }
}
?>
 
<script type="text/javascript">

	$(function() {

		$("#sortable").sortable({ 
			
			update: function() {
			
			var order = $(this).sortable("serialize")+ '&gallery=<?php echo $gallery;  ?>';
			
				$.post("includes/helpers/gal-sort.php", order, function(theResponse){

					$("#result").html(theResponse);
					
				});
		  } });
	});

</script>

<div class="clear"></div>
	 	
<div class="howto">
	<a class="embed_toggle" href="#"><?php echo $lang_embed; ?></a>
	<div id="main" style="display:none;">
		<p><?php echo $lang_embed_desc; ?></p>
		<p><b>Slider</b></p>
		<input value='&lt;?php $gallery ="<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>"; include($_SERVER["DOCUMENT_ROOT"]."/<?php echo $pulse_dir; ?>/includes/<?php echo 'gallery.php'; ?>"); ?&gt;' onClick="select_all(this)" >             
		<p><b>Thumbnail Gallery</b></p>
		<input value='&lt;?php $gallery ="<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>"; include($_SERVER["DOCUMENT_ROOT"]."/<?php echo $pulse_dir; ?>/includes/<?php echo 'gallery2.php'; ?>"); ?&gt;' onClick="select_all(this)" >             
		<br><?php echo $lang_embed_desc2; ?>
	</div>
</div>

</div>