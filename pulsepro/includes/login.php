<?php
ob_start();
session_start();

$max_session_time = 36000;
$cmp_pass = Array();
$cmp_pass[] = md5($pulse_pass);
$max_attempts = 10;
$session_expires = $_SESSION["mpass_session_expires"];
$max_attempts++;

function getIp(){
	$pattern = "/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/";
	$ip_m = $_SERVER['REMOTE_ADDR'];
	
	   if( $ip_m && (strlen($ip_m)>0) && preg_match($pattern, $ip_m) ){ 
	   		
	   		$ip = $ip_m; 
	   		
	   	}else { 		   		
		   		$ip = "no ip"; 
		   		
		   		}
	   return $ip;	   
}

if(isset($_COOKIE["mpass_pass"])){
		$_SESSION["mpass_pass"] = $_COOKIE['mpass_pass'];
}

if(!empty($_POST["mpass_pass"])){

if(is_dir("data/logs/")){
		
	$date = date("M");

	$month_1 = mktime(0, 0, 0, date("m")-1, date("d"),date("Y"));
	$month_1 = date("M", $month_1);

	$month_2 = mktime(0, 0, 0, date("m")-2, date("d"),date("Y"));
	$month_2 = date("M", $month_2);

	$months = array($date, $month_1, $month_2 );

		foreach( (glob("data/logs/*.txt")) as $fl){
		
			$log_file = basename($fl,".txt");	

				if( !in_array( $log_file, $months )){
			
					@unlink("data/logs/$log_file.txt");
				}
			
		}	

//current log_file	
$opFile = "data/logs/$date.txt";	

}
                                
	if(in_array(md5($_POST["mpass_pass"]), $cmp_pass) ){
               
            if(is_dir("data/logs/") && is_writeable($opFile) ){
               
			    //Update log.txt - success
			    $time = date("r");
			    $ip = getIp();
			    $new_data.= "success"."|". $ip ."|". $time ."\n";
                               
                $fp = @fopen($opFile,"a+"); 
                
                if (flock($fp, LOCK_EX)) {    
                	
                	$success = fwrite($fp, $new_data);
                	flock($fp, LOCK_UN); 
                }

                @fclose($fp);
                
             }
                
		$_SESSION["mpass_pass"] = md5($_POST["mpass_pass"]);
		setcookie ("mpass_pass", md5($_POST["mpass_pass"]), time()+3600*24*7,'/');
		header("Location: index.php");
		die();
		
	} else{
	
			if(is_dir("data/logs/") && is_writeable($opFile) ){
				
				//Update log.txt - failed
			    $time = date("r");
			    $ip = getIp();			    
			    $new_data.= "failed"."|". $ip ."|". $time ."\n";
                               
                $fp = @fopen($opFile,"a+"); 
                
                if (flock($fp, LOCK_EX)) {    
                	$success = fwrite($fp, $new_data);
                	flock($fp, LOCK_UN); 
                }
                
                @fclose($fp);
                
             }
	}
		
}

if(empty($_SESSION["mpass_attempts"])){
	
	$_SESSION["mpass_attempts"] = 0;
	
}

if(($max_session_time>0 && !empty($session_expires) && time()>$session_expires) || empty($_SESSION["mpass_pass"]) || !in_array($_SESSION["mpass_pass"],$cmp_pass)){
	
	if(!in_array($_SESSION["mpass_pass"],$cmp_pass)){
	
		$_SESSION["mpass_attempts"]++;
				
	}
	
	if($max_attempts>1 && $_SESSION["mpass_attempts"]>=$max_attempts){
		
		exit("Too many login failures.");
	}

	$_SESSION["mpass_session_expires"] = "";
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lang_page_title; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/style.css" media="all">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/ios-icon-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/ios-sm-precomposed.png" />
    <script type="text/javascript" src="plugins/jquery/jquery.min.js"></script>
</head>

<body id="login-page">
    
    <form name="login" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="login">
    	<?php
			if (!empty($_POST["mpass_pass"]) && !in_array(md5($_POST["mpass_pass"]), $cmp_pass))
			echo "<p class=\"errorMsg\">$lang_login_incorrect</p>"; 
		?>
        <input type="password" size="27" name="mpass_pass" placeholder="Password" autofocus>
        <button class="login-btn"><?php echo $lang_login_button; ?></button>
    </form>

</body>
</html>
<?php 
exit();
}
$_SESSION["mpass_attempts"] = 0;
$_SESSION["mpass_session_expires"] = time()+$max_session_time;
?>