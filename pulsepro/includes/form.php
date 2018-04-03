<?php
error_reporting(0);
include_once("path.php");
include(ROOTPATH."../../config.php"); 
$domain = $_SERVER['HTTP_HOST'];

if($pulse_lang == 0){
include_once("lang.php");}
else
if($pulse_lang == 1){
include_once("lang_de.php");}

if(empty($_POST["question"])){
	$question = array_rand($questions, 1);
	$answer = strtolower($questions[$question]);
} 

if(!empty($_POST["answers"]) 
   &&  $questions[stripslashes(html_entity_decode($_POST["question"]))] == strtolower(trim($_POST["answers"])) 
   &&  md5($questions[stripslashes(html_entity_decode($_POST["question"]))]) ==  $_POST["token"]) {
	$resp = 1;
} elseif (isset($_POST["answers"])) {
	$resp = 2;
	$question = array_rand($questions, 1);	
	$answer = strtolower($questions[$question]);	
	
}

if($formcap == 1){ $resp = 1; }


if(isset($_POST['email']) && preg_match("/@/", $_POST['email']) ){

     $name = stripslashes(strip_tags(trim($_POST['name'])));
     $email =stripslashes(strip_tags(trim($_POST['email'])));
     $custom_message1 = stripslashes(strip_tags(trim($_POST['custom1'])));
     $custom_message2 = stripslashes(strip_tags(trim($_POST['custom2'])));
     $_POST['comment'] = trim($_POST['comment']);
          
     if(!empty($_POST['comment'])){   
          
    	 if(isset($_POST['custom1']) && (isset($_POST['custom2']))){
	    	 $comment = "$custom_fieldname1: ". $custom_message1 ."\n"."\n"."$custom_fieldname2: ". $custom_message2 ."\n". "\n". stripslashes(strip_tags($_POST['comment']));}
     
	    	 elseif(isset($_POST['custom1'])){
		    	 $comment = "$custom_fieldname1: ". $custom_message1 ."\n"."\n". stripslashes(strip_tags($_POST['comment']));}
         
		     elseif(isset($_POST['custom2'])){
			     $comment = "$custom_fieldname2: ". $custom_message2 ."\n"."\n". stripslashes(strip_tags($_POST['comment']));}
     
			     else{ $comment = stripslashes(strip_tags($_POST['comment']));}
    } 
         
     $headers  = "From: '". $name ."' <". $email .">\n";
     $headers .= "Reply-To: '". $name ."' <". $email .">\n";
     $headers .= "Content-Type: text/plain; charset=\"utf-8\"\n";
     $headers .= "Content-Transfer-Encoding: 8bit\n";
     $headers .= "MIME-Version: 1.0\n";

     if($name && $comment && empty($_POST['human']) && ($resp == 1) ){
     
         if(mail($email_contact, "$lang_form_subject", $comment, $headers)){
              
			  $_POST['name'] = '';
			  $_POST['email'] = '';
			  $_POST['custom1'] = '';
			  $_POST['custom2'] = '';
			  $_POST['comment'] = '';
			  $name = '';
			  $email = '';
			  $comment = '';
              
              echo "<p class=\"msg-green\">$lang_form_message_sent</p>";
                    $question = array_rand($questions, 1);	
					$answer = strtolower($questions[$question]);

         }else{
              echo "<p class=\"msg-red\">$lang_form_not_sent</p>";
                    $question = array_rand($questions, 1);	
					$answer = strtolower($questions[$question]);

         }
     }else{
            echo "<p class=\"msg-red\">$lang_form_all_fields</p>";
                    $question = array_rand($questions, 1);	
					$answer = strtolower($questions[$question]);

     } 
                
	}elseif(isset($_POST['email'])){     
    
    echo "<p class=\"msg-red\">$lang_form_valid_email</p>";
                    $question = array_rand($questions, 1);	
					$answer = strtolower($questions[$question]);
        
}
if ($resp == 2) {
				  echo "<p class=\"msg-red\">$lang_blog_error_captcha</p>";
			  }
			  
?>
<link rel="stylesheet" href="http://<?php echo $domain ?>/<?php echo $pulse_dir ?>/css/form.css" media="all">

<form id="contact" method="post" action="">

<fieldset>
<label for="name"><?php echo $lang_form_label_name; ?></label><br>
<input id="name" name="name" type="text" value="<?php echo stripslashes(strip_tags(trim($_POST['name']))); ?>" >
</fieldset>

<fieldset>
<label for="email"><?php echo $lang_form_label_email; ?></label><br>
<input id="email" name="email" type="email" value="<?php echo stripslashes(strip_tags(trim($_POST['email']))); ?>" >
</fieldset>

<!-- Custom Field 1 -->
<?php  if(!empty($custom_fieldname1)) {?>
<fieldset>
<label for="custom1"><?php echo "$custom_fieldname1"; ?></label><br>
<input id="custom1" name="custom1" type="text" value="<?php echo stripslashes(strip_tags(trim($_POST['custom1']))); ?>" >
</fieldset>
<?php } ?>

<!-- Custom Field 2 -->
<?php  if(!empty($custom_fieldname2)) {?>
<fieldset>
<label for="custom2"><?php echo "$custom_fieldname2"; ?></label><br>
<input id="custom2" name="custom2" type="text" value="<?php echo stripslashes(strip_tags(trim($_POST['custom2']))); ?>" >
</fieldset>
<?php } ?>

<fieldset>
<input id="human" name="human" type="text" value="<?php echo stripslashes(strip_tags($_POST['human']));?>" >  
<label for="comment"><?php echo $lang_form_label_comment; ?></label><br>
<textarea id="comment" name="comment" rows="8"><?php echo stripslashes(strip_tags(trim($_POST['comment']))); ?></textarea>
</fieldset>

<!-- Captcha -->
<?php if($formcap !=1){ ?>
<fieldset>
<label for="name"><?php echo $question; ?> </label> 
<input type="hidden" name="token" value="<?php echo md5($answer); ?>" >
<input type="hidden" name="question" value="<?php echo htmlentities($question); ?>" >
<input id="answers" type="text" name="answers" />
</fieldset>
<?php } ?>

<button class="btn" type="submit"><?php echo $lang_form_send; ?></button>

</form>