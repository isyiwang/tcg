<?php

include_once("../../config.php");
include_once("login.php");

copy($_FILES['file']['tmp_name'], '../data/files/'.$_FILES['file']['name']);
					
$array = array(
    'filelink' => '/'.$pulse_dir.'/data/files/'.$_FILES['file']['name'],
    'filename' => $_FILES['file']['name']
);
 
echo stripslashes(json_encode($array));	
?>