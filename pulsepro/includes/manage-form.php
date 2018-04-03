<?php 
$on='form'; 
$question = array_rand($questions, 1); 

if($_POST){ 

			if(!empty($_POST['formcap']) && ($_POST['formcap']==1) ){ $formcap = 1; } else { $formcap = 0; }					
			
			$_POST["custom_fieldname1"] = trim($_POST["custom_fieldname1"]);
			$_POST["custom_fieldname2"] = trim($_POST["custom_fieldname2"]);
			
			if(!empty($_POST["custom_fieldname1"])){ $custom_fieldname1 = $_POST["custom_fieldname1"]; } else { $custom_fieldname1 = ""; }
			if(!empty($_POST["custom_fieldname2"])){ $custom_fieldname2 = $_POST["custom_fieldname2"]; } else { $custom_fieldname2 = ""; }


$opFile = "../config.php";

    	$fp = fopen($opFile,"r");
	    $data = @fread($fp, filesize($opFile));
        fclose($fp);

        $line = explode("\n", $data);
        $no_of_lines = count($line)-1;
               
	    for ($i=0; $i<$no_of_lines; $i++) {
	    
           	 $caps[] = explode("=", $line[$i]);
            
            }
            
         $nb= count($caps);

         	$capcha_yes=false;
         	$custom1_yes=false;
         	$custom2_yes=false;

         for ($i=1; $i<$nb-1; $i++) {
           
            if(preg_match("/formcap/", $caps[$i][0]) ){
		      	
		      	 $caps[$i][1] = "\"$formcap\";";
		      	 
		      	 $capcha_yes = true;
		      	 		      	 		      	
		    }
		    
		     if(preg_match("/custom_fieldname1/", $caps[$i][0]) ){
		      	
		      	 $caps[$i][1] = "\"$custom_fieldname1\";";
		      	 
		      	 $custom1_yes = true;
		      	 		      	
		    }
		     if(preg_match("/custom_fieldname2/", $caps[$i][0]) ){
		      	
		      	 $caps[$i][1] = "\"$custom_fieldname2\";";
		      	 
		      	 $custom2_yes = true;
		      	 		      	
		    }
		    
		    
		    
		      $new_data .= $caps[$i][0]. "=". $caps[$i][1]. " \n";

		  }
		  if($capcha_yes == false){ $new_data .= "$"."formcap" ."=". "\"$formcap\"". "; \n";}
		  if($custom1_yes == false){ $new_data .= "$"."custom_fieldname1" ."=". "\"$custom_fieldname1\"". "; \n";}
		  if($custom2_yes == false){ $new_data .= "$"."custom_fieldname2" ."=". "\"$custom_fieldname2\"". "; \n";}
		  
		  $all_conf = "<?php"."\n".$new_data."\n"."?>";
		  
	    	$fp = @fopen("../config.php","w");
			$ph = @fwrite($fp, $all_conf);
			fclose($fp);
			if($ph==true){ $_SESSION["saved"]=true;}
				
			
}
?>

<div id="sub-head">
	<a href="index.php?p=home"><?php echo $lang_go_back; ?></a>
	<button onclick="document.options.submit();"><?php echo $lang_save; ?></button>
	<?php greenCheckmark();?>
</div>

<div id="content">
<link rel="stylesheet" href="css/form.css" media="all">

<div class="form-options">
	<?php include("../config.php");?>
	<p><b><?php echo $lang_form_options;?> </b></p><br>

	<form name="options" id="options" method="post" action="">
		<input id="name" name="custom_fieldname1" type="text" placeholder="Optional Field 1" value="<?php echo $custom_fieldname1; ?>" >
		<input id="name" name="custom_fieldname2" type="text" placeholder="Optional Field 2" value="<?php echo $custom_fieldname2; ?>" >
		<input name="formcap" type="checkbox" value ="1"<?php if($formcap == 1){?> checked="checked" <?php }?> ><?php echo $lang_form_capcha_option ?> 
	</form>

</div>

<br>

<p><?php echo $lang_form_preview_only ?></p>
<div class="form-preview">

<form id="contact">

<fieldset>
<label for="name"><?php echo $lang_form_label_name; ?></label><br>
<input id="name" name="name" type="text" value="" >
</fieldset>

<fieldset>
<label for="email"><?php echo $lang_form_label_email; ?></label><br>
<input id="email" name="email" type="email" value="" >
</fieldset>

<!-- Custom Field 1 -->
<?php  if(!empty($custom_fieldname1)) {?>
<fieldset>
<label for="custom1"><?php echo $custom_fieldname1; ?></label><br>
<input id="custom1" name="custom1" type="text" value="" >
</fieldset>
<?php } ?>

<!-- Custom Field 2 -->
<?php  if(!empty($custom_fieldname2)) {?>
<fieldset>
<label for="custom2"><?php echo $custom_fieldname2; ?></label><br>
<input id="custom2" name="custom2" type="text" value="" >
</fieldset>
<?php } ?>

<fieldset>
<input id="human" name="human" type="text" value="" >  
<label for="comment"><?php echo $lang_form_label_comment; ?></label>
<textarea id="comment" name="comment" rows="8"></textarea>
</fieldset>

<!-- Captcha -->
<?php if($formcap !=1){ ?>
<fieldset>
<label for="name"><?php echo $question; ?> </label> 
<input id="answers" type="text" name="answers" />
</fieldset>
<?php } ?>

<a class="btn"><?php echo $lang_form_send; ?></a>

</form>

</div>

<div class="howto">
	<a class="embed_toggle" href="#"><?php echo $lang_embed; ?></a>
	<div id="main" style="display:none;">
		<p><?php echo $lang_embed_desc; ?></p>
		<input value='&lt;?php include($_SERVER["DOCUMENT_ROOT"]."/<?php echo $pulse_dir; ?>/includes/form.php"); ?&gt;' onclick="select_all(this)" > 
		<br><?php echo $lang_embed_desc2; ?>
	</div>
</div>

</div>