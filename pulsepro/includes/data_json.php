<?php

include_once("../../config.php");

header('Content-type: application/json');
$files = glob('../data/img/uploads/*.*');
$arr = array();
foreach($files as $file)
{	
	$file = basename($file);
    $arr[] = array("thumb" => "/$pulse_dir/data/img/uploads/".$file, 'image'=> "/$pulse_dir/data/img/uploads/".$file);
}

exit (str_replace('\/','/',json_encode($arr)));
?>