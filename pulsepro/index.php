<?php
error_reporting(0);

include_once("../config.php");
include_once("includes/path.php");

if($pulse_lang == 0){
	include_once("includes/lang.php");
	}
	
else if($pulse_lang == 1){
		include_once("includes/lang_de.php");
		}
		
include_once("includes/helpers/functions.php");

include_once("includes/login.php");

$page = (isset( $_GET['p']) && !empty($_GET['p'])) ? $_GET['p'] : 'home';

		$page = str_replace("/","", $page);
		$page = str_replace("\\","", $page);
		$page = htmlspecialchars($page, ENT_QUOTES, 'UTF-8');
		$page = preg_replace('/[^-a-zA-Z0-9_]/', '', $page);

ob_start();

include("includes/".$page.".php");

$content = ob_get_contents();

ob_end_clean();

include("includes/header.php");

echo $content;

include("includes/footer.php");
?>