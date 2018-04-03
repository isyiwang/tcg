<?php $on='backup'; ?>

<div id="sub-head">
	<a href="index.php?p=manage-backups"><?php echo $lang_go_back; ?></a>
</div>

<div id="content">

<?php

$t= htmlentities($_GET["f"]);
$t = str_replace("/","", $t);

$file= "data/backups/". "$t".".zip";

if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"]){
			$timestamp_old = time() - (15*60);
		
			if($_SESSION["token_time"] >= $timestamp_old){
								
					if(isset($_POST['del']) && file_exists($file)===true){	
					
						unlink($file);
									$host  = $_SERVER['HTTP_HOST'];
									$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
									header("Location: http://$host$uri/index.php?p=manage-backups");
									die();
					}	
			} else {
					echo "<p class=\"errorMsg created\">$lang_backup_session_expired</p>";
			}
}else {
			$token = md5(uniqid(rand(), TRUE));
			$_SESSION["token"] = $token;
			$_SESSION["token_time"] = time();
			
			echo "<p>$lang_backup_del_confirm</p><br>"; 

?>
<form action="" method=post>
<input class="btn" type=submit name="del" value="<?php echo $lang_yes; ?>" />
<input type=hidden name="token" value="<?php echo $token ?>" />
<a class="btn" href="index.php?p=manage-backups"><?php echo $lang_cancel; ?></a>
</form>

<?php } ?>

</div>