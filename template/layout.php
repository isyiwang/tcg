<!DOCTYPE html>
<html>

<head>	
	<title><?php echo $page_title; ?></title>
	<meta charset="utf-8">
	<meta name="description" content="<?php echo $page_desc; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="template/css/kube.css">
	<link rel="stylesheet" href="template/css/master.css">
	<script src="template/js/jquery.js"></script>	
	<script src="template/js/nav-toggle.js"></script>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,600" rel="stylesheet">
</head>

<body>
	<div id="header" class="group">
		<div id="header-inner">
			<a href="./"><img class="logo" src="template/img/logo.png"></a>
			<a class="nav_toggle" href="#"> + </a>
			<?php include("$pulse_dir_one/data/blocks/nav.html"); ?>
		</div>					
	</div>
	
	<div id="content">
		<?php echo $content; ?>
	</div>

	<footer id="footer" class="group">
		<div id="footer-inner">
			<p class="copyright">Copyright Acme Inc. 2013</p>
		</div>
	</footer>
	
	<script src="/<?php echo $pulse_dir; ?>/includes/tracker.php?uri=<?php echo $_SERVER['REQUEST_URI']; ?>&ref=<?php echo $_SERVER['HTTP_REFERER']; ?>"></script>
	
</body>

</html>