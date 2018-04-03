<?php
session_start();
include("../../config.php");
$cmp_pass[] = md5("$pulse_pass");

if(in_array($_SESSION['mpass_pass'],$cmp_pass)){
	$_SESSION['mpass_pass'] = "";
	$_SESSION["mpass_attempts"] = 0;
	$_SESSION["mpass_session_expires"] = 0;
	setcookie ("mpass_pass","", time()+3600*24*3,'/');
}
header("Location: ../index.php");
?> 