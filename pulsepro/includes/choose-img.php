<?php $on='images'; ?>

<div id="sub-head">
    <a href="index.php?p=manage-photo&g=<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>"><?php echo $lang_go_back; ?></a>     
</div>

<div id="content">
<script type="text/javascript" src="plugins/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="plugins/plupload/jquery.plupload.queue.min.js"></script>

<script type="text/javascript">
// Convert divs to queue widgets when the DOM is ready
$(function() {
	$("#uploader").pluploadQueue({
		// General settings
		runtimes : 'html5,html4',
		url : 'includes/upload-img.php?g=<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>',
		max_file_size : '5200ko',
		unique_names : false,
        preinit: attachCallbacks,
		// Resize images on clientside if we can
		resize : {width : 1000, height : 1000, quality : 90},

		// Specify what files to browse for
		filters : [
			{title : "Image files", extensions : "jpg,jpeg,gif,png"}
		]
	});

	function attachCallbacks(Uploader) {
          Uploader.bind('FileUploaded', function(Up, File, Response) {
              if( (Uploader.total.uploaded + 1) == Uploader.files.length)
              {
                window.location = 'index.php?p=manage-photo&g=<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>';
              }
          });
    }
	
	
});
</script>

<form class="uploader-form" action="" method="post" enctype="multipart/form-data">
<div id="uploader">
		<p>Your browser doesn't have HTML5 or html4 support.</p>
</div>
</form>
<br>
<p><?php echo $lang_gal_max; ?></p>
</div>