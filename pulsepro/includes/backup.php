<?php $on='backup'; ?>

<div id="sub-head">
	<a href="index.php?p=manage-backups"><?php echo $lang_go_back; ?></a>
</div>

<div id="content">

<?php
include_once("helpers/backup-zip.php");

$today = date("m.j.y-gi");

$zip = Zip(array('./data/blocks','./data/blog','./data/files','./data/img','./data/stats') , "./data/backups/" . $today . ".zip");

if($zip==true){

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	header("Location: http://$host$uri/index.php?p=manage-backups");
	die();

}

$_SESSION["backups"] = $backups; ?>

</div>