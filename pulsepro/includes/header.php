<!DOCTYPE html>
<html>
<head>
	<title><?php echo $lang_page_title; ?></title>
	<meta charset="utf-8" />
	
	<link rel="stylesheet" href="css/style.css" media="all" />
	<link rel="stylesheet" href="css/hide.css" media="all" />
	<link rel="stylesheet" href="plugins/plupload/css/plupload.queue.css" media="all" />
	<link rel="stylesheet" href="plugins/redactor/css/redactor.css" />
	
	<meta name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/ios-icon-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/ios-sm-precomposed.png" />
	
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="plugins/redactor/redactor.min.js"></script>
	<script src="plugins/jquery/jquery_ui.js"></script>
	
	<!-- <script src="plugins/redactor/de.js"></script> -->
	
	<!-- Redactor's plugin -->
    <script src="plugins/redactor/fullscreen.js"></script>
    <script src="plugins/redactor/fontsize.js"></script>
    <script src="plugins/redactor/fontfamily.js"></script>
    <script src="plugins/redactor/fontcolor.js"></script>
	
	<script>
		$(document).ready(function(){
			$('a.embed_toggle').on('click', function(e) {    
			e.preventDefault();    
			$('#main').slideToggle(400);})		
		});
	</script>
	
	<script>
		$(document).ready(
			function()
			{
				$('#redactor_content').redactor({ 
					lang: 'en',
					imageUpload: 'includes/editor_images.php',
					imageGetJson: 'includes/data_json.php',
					fileUpload: 'includes/editor_files.php',
					convertDivs: false,
					autoresize: true,
					minHeight: 350,
					phpTags: true,
					 deniedTags: ['html'],
					linkEmail: true,
					plugins: ['fullscreen','fontsize','fontfamily','fontcolor']
				});
			}
		);
	</script>
	
</head>
	
<body>

<script> 
	function select_all(obj) 
		{ var text_val=eval(obj); 
			text_val.select(); 
		} 
</script>
		
<div id="header">

<a href="index.php?p=home">
<div class="logo"></div>
</a>

<a class="logout" href="includes/logout.php"><?php echo $lang_nav_logout; ?></a>

</div>