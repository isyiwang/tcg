<?php $on='settings'; ?>

<form action="index.php?p=settings" method="post">

<div id="sub-head">
	<a href="index.php?p=home"><?php echo $lang_go_back; ?></a>
	<button type="submit"><?php echo $lang_blog_button_update; ?></button>
	<?php greenCheckmark();?>
</div>

<div id="content">

<?php
if($_POST["status"] == 1) {		

     if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"]) {
        
        $timestamp_old = time() - (60*60);

        if($_SESSION["token_time"] >= $timestamp_old) {
	   
	        foreach($_POST as $var => $key) {
                $$var = htmlspecialchars(trim(stripslashes($key)), ENT_QUOTES, "UTF-8");
            }

	        $config = '<?php    
$pulse_dir = "'. $directory .'";
$pulse_pass = "'. $password .'";
$height = "'. $height .'";
$width = "'. $width .'";
$blog_url = "'. $blog_url .'";
$per_page = "'. $posts_per .'";
$blog_title = "'. $blog_title .'";
$blog_description = "'. $blog_description .'";
$blog_comments = '. $comments .';
$blog_capcha = '. $blog_capcha .';
$questions["'. $question1 .'"] = "'. $answer1 .'";
$questions["'. $question2 .'"] = "'. $answer2 .'";
$questions["'. $question3 .'"] = "'. $answer3 .'";
$date_format = "'. $date_format .'";
$email_contact = "'. $email .'";
$pulse_lang = "'. $pulse_lang .'";
$custom_fieldname1 = "'. $custom_fieldname1 .'";
$custom_fieldname2 = "'. $custom_fieldname2 .'";
$formcap = "'. $formcap .'";
?>';

            if ($fp = fopen("../config.php", "w")) 
            {
                fwrite($fp, $config, strlen($config));
                
                $_SESSION["saved"]=true;
                $host  = $_SERVER['HTTP_HOST'];
				$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				header("Location: http://$host$uri/index.php?p=settings");
				die();

            }
            else 
            {
                echo "<p class=\"errorMsg\">$lang_settings_unwritable</p>"; 
            }

        }   
    
    }
}

if(empty($_SESSION["token"]) || $_SESSION["token_time"] <= $timestamp_old){
		 $_SESSION["token"] = md5(uniqid(rand(), TRUE));	
		 $_SESSION["token_time"] = time();
}

if(!isset($_POST["status"])) {
?>
    
<div class="settings">
   
   <h2><?php echo $lang_setting_general; ?></h2>
   
   <div class="setting">
	   <p><?php echo $lang_setting_folder ?></p>
	   <input class="med" type="text" name="directory" value="<?php echo $pulse_dir ?>"/>
	   <p class="settings-hints"><?php echo $lang_setting_folder_hint ?></p>
   </div>
   
   <div class="setting">
	   <p><?php echo $lang_setting_password ?></p>
	   <input class="med" type="password" name="password" value="<?php echo $pulse_pass ?>"/>
   </div>
   
   <div class="setting">
	   <p><?php echo $lang_email_contact  ?></p>
	   <input class="med" type="text" name="email" value="<?php echo $email_contact ?>"/>
   </div>
   
   <div class="setting">
	   <p><?php echo $lang_setting_lang ?></p>
	   <select name="pulse_lang">
			<option value="0" <?php echo ($pulse_lang) ? '' : 'selected="selected"';?>><?php echo $lang_setting_en ?></option>
			<option value="1" <?php echo ($pulse_lang) ? 'selected="selected"' : '';?>><?php echo $lang_setting_de ?></option>
	   </select> 
   </div>
  
    <br><br>
    
    <h2><?php echo $lang_setting_gallery_thumbnails ?></h2>
    
    <div class="setting">
    	<label><?php echo $lang_setting_tim_height ?></label>
    	<input name="height" type="text" style="width:75px" placeholder="100" value="<?php echo $height; ?>" >
    	<label><?php echo $lang_setting_tim_width ?></label>
    	<input name="width" type="text" style="width:75px" placeholder="100" value="<?php echo $width; ?>" >
    </div>
    
    <br><br>
    
    <h2><?php echo $lang_setting_blog; ?></h2>
        
    <div class="setting">
	    <p><?php echo $lang_setting_blog_desc ?></p>
	    <textarea class="long" rows="4" name="blog_description"><?php echo $blog_description ?></textarea>
	    <p class="settings-hints"><?php echo $lang_setting_blog_desc_hint ?></p>
    </div>
    
    <div class="setting">
	    <p><?php echo $lang_setting_blog_url ?></p>
	    <input class="long "type="text" name="blog_url" value="<?php echo $blog_url ?>" />
	    <p class="settings-hints"><?php echo $lang_setting_blog_url_hint ?></p>
    </div>
    
    <div class="setting">
	    <p><?php echo $lang_setting_blog_title ?></p>
	    <input class="long" type="text" name="blog_title" value="<?php echo $blog_title ?>" />
    </div>
    
    <div class="setting">
	    <p><?php echo $lang_setting_blog_posts ?></p>
	    <input width="20" type="text" name="posts_per" value="<?php echo empty($per_page)? 5 : $per_page; ?>" />
    </div>
    
    <div class="setting">
	    <p><?php echo $lang_setting_date ?></p>
	    <select name="date_format">
			<option value="0" <?php echo ($date_format) ? '' : 'selected="selected"';?>>MM/DD/YYYY</option>
			<option value="1" <?php echo ($date_format) ? 'selected="selected"' : '';?>>DD/MM/YYYY</option>
		</select> 
    </div>
    
    <div class="setting">
	    <p><?php echo $lang_setting_blog_comments ?></p>
	    <select name="comments">
	    	<option value="true" <?php echo ($blog_comments) ? 'selected="selected"' : '';?>><?php echo $lang_setting_blog_enabled ?></option>
	    	<option value="false" <?php echo ($blog_comments) ? '' : 'selected="selected"';?>><?php echo $lang_setting_blog_disabled ?></option>
	    </select>
    </div>
    
    <div class="setting">
	    <p><?php echo $lang_blog_capcha ?></p>
	    <select name="blog_capcha">
	    	<?php if(!isset ($blog_capcha)){$blog_capcha = true;} ?>
	    	<option value="true" <?php echo ($blog_capcha) ? 'selected="selected"' : '';?>><?php echo $lang_setting_blog_enabled ?></option>
	    	<option value="false" <?php echo ($blog_capcha) ? '' : 'selected="selected"';?>><?php echo $lang_setting_blog_disabled ?></option>
	    </select>
    </div>   

    
    
    <br><br>
     
    <h2><?php echo $lang_setting_spam_questions ?></h2>

    
	 <?php 
	 $bn = 1;
	 foreach($questions as $key => $val){ ?>
	    
	 <div class="setting">
	    <p><?php echo $lang_setting_spam_question ?> <?php $a = $bn++; echo $a?></p>
	    <input class="long" type="text" name="question<?php echo $a?>" value="<?php echo $key?>" />
     </div>
    
    <div class="setting">
	    <p><?php echo $lang_setting_spam_answer ?> <?php echo $a?></p>
	    <input class="med" type="text" name="answer<?php echo $a?>" value="<?php echo $val?>" />
	    
    </div>
    
    <?php } ?>
    
    <input name="custom_fieldname1" type="hidden" value="<?php echo $custom_fieldname1; ?>" >
    <input name="custom_fieldname2" type="hidden" value="<?php echo $custom_fieldname2; ?>" >
    <input name="formcap" type="hidden" value = "<?php echo $formcap; ?> ">
       
    <input type="hidden" name="status" value="1" />
    <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>" />
    
    </form>
    
<?php } ?>
</div>
</div>