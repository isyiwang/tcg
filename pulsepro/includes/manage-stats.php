<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<?php $on = "stats";?>

<script>
$(function() {
     $(".bar-container").css("height","0%").animate({height:"120px"},500); 
});
</script>

<script src="plugins/jquery/tooltip.js"></script>

<div id="sub-head">
	<a href="index.php?p=home"><?php echo $lang_go_back; ?></a>
	<a href="#" onClick="window.location.href=window.location.href"><?php echo $lang_stats_refresh; ?></a>
</div>

<div id="content">
<?php

foreach (glob(ROOTPATH . "/data/stats/sessions/sess_*") as $filename) {
    if (filemtime($filename) + 240 < time()) {    
      @unlink($filename);     
    }
}

session_save_path(ROOTPATH . "/data/stats/sessions");
function getUsersOnline() { 

	$count = 0; 
	$handle = opendir(session_save_path()); 
	
		if ($handle == false){ 
			return -1;
		} 
		while (($file = readdir($handle)) != false) { 
		
				if (ereg("^sess", $file)) {
				
					$count++; 
				}
			} 
			
	closedir($handle); 
	return $count; 
} 

	//calculating stats
	$visitors = array();
	$referers = array();
	$pages = array();
	$day_list = array();
	$file_data = array();
	$show_date = date('m.d.y');

foreach( (glob(ROOTPATH . "/data/stats/*.txt")) as $fl){

	$collection[]= $file;
	
	$file = basename($fl,".txt");	
	
	$month = substr($file, 0,2);
	$day = substr($file, 3,2);
	$year= substr($file, 6,2);
	$file_mk = mktime(0,0,0,$month, $day, $year);

	$file_adr = "data/stats/$file.txt";

	//reading data
	$open = fopen($file_adr,"r");
	$file_data = fread($open, filesize($file_adr));
	fclose($open);
				
	$conts = explode("\n", $file_data);	
	$conts = array_reverse($conts);
			
	foreach($conts as $visit){
			
		$visit = explode("|", $visit);
		
		$day = trim($visit[3]);
		$month = trim($visit[4]);
		$ip = trim($visit[0]);
		$page = trim($visit[1]);
		$referer = trim($visit[2]);
					
			//referers 
			$referer_host = parse_url($referer,PHP_URL_HOST);
		
			if ($referer_host!= "" && $referer_host != false ){
		
				if(stripos (parse_url($referer,PHP_URL_HOST) , $_SERVER["HTTP_HOST"]) === false  
					&& stripos ($_SERVER["HTTP_HOST"] , parse_url($referer,PHP_URL_HOST))=== false){
					
				if(!isset($referers[$file][$referer])){ $referers[$file][$referer]=1; } else { $referers[$file][$referer]++; }
			  }
			}
		
			// pages 
			if(!isset($pages[$file][$page])){ $pages[$file][$page] = 1; } else{ $pages[$file][$page]++; }
							
	
			//visitors
			if(!isset($visitors[$file][$ip])){ $visitors[$file][$ip]= 1; } else{ $visitors[$file][$ip]++; }
			
			//pageviews
			$page_views = 0;
			$page_views = count($conts)-1;
			
	}
	
$all[$file] = array('visitors' => $visitors ,'pageviews' => $page_views , 'refers'=>$referers, 'pages'=> $pages, 'date'=>$file);

}	

#of unique visitors
$counter = $all[$show_date]['visitors'];
$counter = $counter[$show_date];
$counter = isset($counter) ? count($counter)-1 : "0";

#pages 
$page_views = 0;
$page_views = isset($all[$show_date]['pageviews']) ? ($all[$show_date]['pageviews']) : "0";

#average
$actions = 0;
$actions = ($counter >0) ? $actions = $page_views/$counter : $actions = 0;
$actions = round($actions, 1);

$show_date1 = $show_date;
if($counter == 0){ $show_date1 = $file;}

$big_array_visitors = $all[$show_date1]['visitors'];

if(!empty($big_array_visitors)){

foreach($big_array_visitors as $la=>$val){	
	$lav[] = $la;
}	

for ($i=0; $i<count($lav); $i++) {
	$dat = $lav[$i];
	$each_day_unique = $all[$dat]['visitors'];
	$each_day_unique = $each_day_unique[$dat];
	$each_day_unique = isset($each_day_unique) ? count($each_day_unique)-1 : "0";
	
	$chart_data[] = array($dat, $each_day_unique);
	$all_vs += $each_day_unique;
}
	
foreach($chart_data as $bardata){	
	$perc[$bardata[0]] = $bardata[1]/$all_vs*100;
	$max_array[] = $bardata[1];
}

$ratio = $all_vs/max($max_array);

}
?>

<div class="stats-group">
<p class="stat-title"><?php echo $lang_stats_thisweek; ?></p>

<?php

if(empty($big_array_visitors)){ echo '<p style="color:#aaa">'.$lang_stats_nodata.'</p>';}

else{

//bar chart
foreach($perc as $perc_day => $perc_val) {

	$month_per = substr($perc_day, 0,2);
	$day_per = substr($perc_day, 3,2);
	$year_per = substr($perc_day, 6,2);
	$file_perc = mktime(0,0,0,$month_per, $day_per, $year_per);
	$perc_day = date('M d',$file_perc); 
?>
	
	<div class="bar-container">
		<div title="<?php echo $perc_val/100*$all_vs . ' - '. $perc_day; ?>" rel="tooltip" class="bar-fill <?php if($perc_day == date('M d')){ echo 'blue-bar'; } ?>" style="height:<?php echo $ratio * (round($perc_val,2))."%"; ?> ;">
		</div>
	</div>
	
<?php }}?>

</div>

<?php

echo "<div class=\"stats-group\">\n";
echo "<p class=\"stat-title\">$lang_stats_todays_stats</p>\n\n";

// Users online
$online = getUsersOnline();
echo "<div class=\"black\">\n";
echo "<p class=\"num\">$online</p>\n";
echo "<p class=\"desc\">$lang_stats_online</p></div>\n\n";

// Number of visitors
echo "<div class=\"black\">\n";
echo "<p class=\"num\">".$counter."</p>\n";
echo "<p class=\"desc\">$lang_stats_today</p></div>\n\n";

//Number of page views
echo "<div class=\"black\">\n";
echo "<p class=\"num\">".$page_views."</p>\n";
echo "<p class=\"desc\">$lang_stats_pageviews</p></div>\n\n";

//Number of page views per visit
echo "<div class=\"black\">\n";
echo "<p class=\"num\">".$actions."</p>\n";
echo "<p class=\"desc\">$lang_stats_per_visit</p></div>\n\n";

echo "</div>\n\n";

echo '<div style="clear:both"></div>';

//Top 10 pages 
echo '<div class="stats-group stats-list">';
echo "<p class=\"stat-title\">$lang_stats_pages</p>";
$pages = $all[$show_date]['pages'];
$pages = $pages[$show_date];
$nb_pages = 10;

if(!is_array($pages)){ $pages[] = $pages; }

asort($pages);
$pages = array_reverse($pages, true);

foreach ($pages as $key => $value ){
	
		if ($nb_pages >0 ){
		
			if ($key!=""){	
		
				if (!(preg_match("/tracker.php/i",$key))) {
			
					echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "<a target=\"_blank\" class=\"stats-link\" href='".htmlspecialchars($key, ENT_QUOTES, 'UTF-8')."'>" . substr(htmlspecialchars($key, ENT_QUOTES, 'UTF-8'), 0,30) . "</a><br>\n"; 
			$nb_pages--;
			
				}
			}
		}
	else { break; }
}
echo "</div>\n\n";

// Top 10 referers
echo '<div class="stats-group stats-list">';
echo "<p class=\"stat-title\">$lang_stats_refers</p>";

$referers = $all[$show_date]['refers'];
$referers = $referers[$show_date];
$nb_referers = 10;

if(!is_array($referers)){ $referers[] = $referers;}

	asort($referers);
	$referers = array_reverse($referers, true);

foreach ($referers as $key => $value){

	if ($nb_referers >0){
	
		if ($key!=""){
		
			if (!(preg_match("/google/i",$key)) && !(preg_match("/localhost/i",$key)) && !(preg_match("/yahoo/i",$key)) && !(preg_match("/bing/i",$key)) && !(preg_match("/yandex/i",$key))){
			
			$key= str_replace("http://","", $key);
			$key= str_replace("www.","", $key);
						
			echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . " &nbsp; " . "<a target=\"_blank\" class=\"stats-link\" href='http://".htmlspecialchars($key, ENT_QUOTES, 'UTF-8')."'>" . substr(htmlspecialchars($key, ENT_QUOTES, 'UTF-8'), 0,30) . "</a><br>\n"; 
			$nb_referers--;
		}
	}
  }	
	else {break;}	
}
echo "</div>\n\n";

?>

<div class="clear"></div>

<div class="howto">
	<a class="embed_toggle" href="#"><?php echo $lang_embed; ?></a>
	<div id="main" style="display:none;">
	 	<p><?php echo $lang_stats_embed; ?></p>
	 	<textarea onclick="select_all(this)">&lt;script src="/<?php echo $pulse_dir; ?>/includes/tracker.php?uri=&lt;?php echo $_SERVER['REQUEST_URI']; ?&gt;&ref=&lt;?php echo $_SERVER['HTTP_REFERER']; ?&gt;">&lt;/script&gt;</textarea>
	</div>
</div>
</div>