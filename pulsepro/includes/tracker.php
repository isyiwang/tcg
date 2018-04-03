<?php
error_reporting(0);
include_once("../../config.php"); 
include_once("path.php");

$today = date("m.d.y");
$today_mk =  mktime(0,0,0,date('m'),date('d'),date('y'));  
$last_week_mk =  mktime(0,0,0,date('m'),date('d')-7,date('y'));
  

define("_TRACK_FILE_", ROOTPATH . "/data/stats/$today.txt");

session_save_path(ROOTPATH . "/data/stats/sessions");

  foreach (glob(ROOTPATH . "/data/stats/sessions/sess_*") as $filename) {
  
    if (filemtime($filename) + 240 < time()) {
    
      @unlink($filename);
    }
  }

session_start();
$_SESSION["hi"] = 'there';

if($_SERVER['HTTP_USER_AGENT'] != 'FeedBurner/1.0 (http://www.FeedBurner.com)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Googlebot/2.1 (+http://www.googlebot.com/bot.html)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Googlebot/2.1 (+http://www.google.com/bot.html)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'DoCoMo/2.0 N905i(c100;TB;W24H16) (compatible; Googlebot-Mobile/2.1; +http://www.google.com/bot.html' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'ia_archiver (+http://www.alexa.com/site/help/webmasters; crawler@alexa.com)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; MJ12bot/v1.4.0; http://www.majestic12.co.uk/bot.php?+)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'msnbot/2.0b (+http://search.msn.com/msnbot.htm)._' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'scour/1.0' &&
   $_SERVER['HTTP_USER_AGENT'] != 'msnbot-media/1.1 (+http://search.msn.com/msnbot.htm)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)')
{

$uri = $_GET[uri];
$ref = $_GET[ref];

$all = $_SERVER['REMOTE_ADDR']."|".$uri."|".$ref."|".date('d')."|".date('m')."|".date('y')."\n";

$all = htmlspecialchars($all, ENT_QUOTES, 'UTF-8');
$all = str_replace("<","", $all);
$all = str_replace(">","", $all);

foreach( (glob(ROOTPATH . "/data/stats/*.txt")) as $fl){
	
	$file= basename($fl,".txt");	
	
	$month = substr($file, 0,2);
	$day = substr($file, 3,2);
	$year= substr($file, 6,2);
	$file_mk = mktime(0,0,0,$month, $day, $year);

		if( $file_mk  < $last_week_mk){
			
			unlink(ROOTPATH . "/data/stats/$file.txt");
			
		}			
}
	
$file_han = @fopen(_TRACK_FILE_,"a");
  
if (flock($file_han, LOCK_EX)) {    
    	
    	fwrite($file_han,$all);
    	flock($file_han, LOCK_UN); 
   }
    fclose($file_han);
}
?>