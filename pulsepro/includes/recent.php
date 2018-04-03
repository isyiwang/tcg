<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<?php
error_reporting(0);
include_once("../../config.php"); 
include_once("path.php");
include_once("helpers/blog_lib.php");
include_once("helpers/functions.php");


if($pulse_lang == 0){
include_once("lang.php");}
else
if($pulse_lang == 1){
include_once("lang_de.php");}

$blog_file = new read_File("blog");
$amount = $blog_file->countLines();
$lines = $blog_file->getLines();

$amount_view = 3 ;

echo "<div class=\"latest-posts\">\n\n";
        			
for ($n=$amount-1  ;  $n>=($amount - $amount_view)  ;  $n-- ) { 
	$blog = explode("|", $lines[$n]);
		
	if (isset($blog[0]) & $blog[0] != '') {
		
		$date = explode( ' ' , $blog[2]);
		$date = $date[2] . ' ' . $date[1]  . ' ' . $date[3];
			
		include("clean_url.php");
			
		if($rewrite) {
		
			if ($blog_comments) {
			
				echo "<p><a href=\"/blog-". $blog[0] ."-".cleanUrlname($blog[3])."\">" .$blog[3]. "</a> (" .$blog[1]. ")<br>";
				
			} else {
			
				echo "<p><a href=\"/blog-". $blog[0] ."-".cleanUrlname($blog[3])."\">" .$blog[3]. "</a><br>";
			}
			
		} else { 
		
			if ($blog_comments) {
			
				echo "<p><a href=\"". $blog_url ."?d=". $blog[0] ."\">" .$blog[3]."</a> (" .$blog[1]. ")<br>";
				
			} else {
			
				echo "<p><a href=\"". $blog_url ."?d=". $blog[0] ."\">" .$blog[3]."</a><br>";
				
			}
		}
			
		if($date_format) {
		
			echo date("d.m.Y", strtotime($date))."</p>\n\n";
			
		} else {
		
			echo date("m-d-Y", strtotime($date))."</p>\n\n";
		} 
	}
}

echo "<p class=\"all-posts\"><a href=\"". $blog_url ."\">$lang_blog_see_all</a></p>";
echo "\n\n</div>";
?>