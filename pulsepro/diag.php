<?php session_start(); ?>

<?php include_once("../config.php"); ?>

<style>
body {
	font-family: sans-serif;
	line-height:1.4;
	padding: 20px;
	color: #333;
}
</style>

<h1>Pulse CMS Diagnostic Tool</h1>

<hr>

<h2>System Requirements</h2>

<p>Basic system requirements are an apache server with PHP 5 installed.</p>

<?php

function my_ini_get($name) {        
	$setting = (ini_get($name));        
	$setting = ($setting==1 || $setting=='On') ? 'On' : 'Off';
	return $setting;
	}

?>
<p><b>Server Type:</b> <?php print $_SERVER['SERVER_SOFTWARE']; ?><br> 
<b>PHP Version:</b> <?php print phpversion()?><br>
<b>File Uploads:</b> <?php print my_ini_get('file_uploads'); ?><br>
<b>Safe Mode:</b> <?php print my_ini_get('safe_mode'); ?><br>
<b>GD Support:</b> <?php 

	if(!function_exists("gd_info")){ 
		print "Off";
		} 
	else{
		if(function_exists("gd_info")){ 
			print "On"; 
			}
		}	
?><br>
<b>Zip Extension:</b> <?php if (extension_loaded('zip')) { echo "On"; } else{ echo "Off"; } ?></p> 

<hr>

<h2>Permissions Check</h2>

<p>Folders should have at least 755 and files 644 permissions.</p>

<?php clearstatcache(); ?>

data - <?php echo substr(sprintf('%o', fileperms('data')), -4); ?><br>
data/blocks - <?php echo substr(sprintf('%o', fileperms('data/blocks')), -4); ?><br>
data/blog - <?php echo substr(sprintf('%o', fileperms('data/blog')), -4); ?><br>
data/img - <?php echo substr(sprintf('%o', fileperms('data/img')), -4); ?><br>
data/files - <?php echo substr(sprintf('%o', fileperms('data/files')), -4); ?><br>
data/logs - <?php echo substr(sprintf('%o', fileperms('data/logs')), -4); ?><br>
data/pages - <?php echo substr(sprintf('%o', fileperms('data/pages')), -4); ?><br>
data/stats - <?php echo substr(sprintf('%o', fileperms('data/stats')), -4); ?><br>
config.php - <?php echo substr(sprintf('%o', fileperms('../config.php')), -4); ?><br><br>

<hr>

<h2>Folder Setting</h2>

<p>This the name of your Pulse folder. If you renamed it, it must be changed in settings. If you have it in a sub folder that must also be reflected in settings. Ex: domain.com/sub/pulsepro would be set as sub/pulsepro in settings.</p>

<p><b>Folder Name:</b> <?php echo $pulse_dir; ?></p>

<hr>

<h2>.Htaccess Check</h2>

<p>The .htaccess file is required for Pulse to work properly. If the file is missing, use the sample.htaccess file. Just remove the sample part and place it outside of the pulsepro folder.</p>

<p><?php
$filename = '../.htaccess';

if (file_exists($filename)) {
    echo "<b>The .htaccess file exists.</b>";
} else {
    echo "<b>The .htaccess file does not exist.</b>";
}
?></p>

<hr>

<h2>Session Handling</h2>

<p>If sessions are not working properly, it can cause problems with logging in and viewing blocks, etc.</p>

<?
if($_GET["test"] == '1'){
	
	if($_SESSION['atest'] == 'yes'){
	
		echo('<b>Your hosting supports sessions</b>');
		
		} else echo('<b>Your hosting does not support sessions</b>');
		
	} else {
			
			$_SESSION['atest'] = 'yes';
			echo '
				<head>
				<script>
					<!--
					function delayer(){
						window.location = "'.$_SERVER['PHP_SELF'].'?test=1";
					}
					//-->
				</script>
				</head>
				<body onLoad="setTimeout(\'delayer()\', 2000)">
				<br><br>
					Please wait...
				</body>
				';
		}
?>
<br><br><br><br>