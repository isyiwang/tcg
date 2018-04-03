<?php $on='images'; ?>

<div id="sub-head">
    <a href="index.php?p=manage-gallery"><?php echo $lang_go_back; ?></a>     
</div>

<div id="content">

<?php
if($_POST['gallery']) {
    
 function remove_accents($str){ 
    $from = array(
        "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", 
        "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", 
        "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", 
        "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç"
    ); 
    $to = array(
        "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", 
        "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", 
        "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", 
        "O", "O", "U", "U", "U", "U", "C"
    );    
    return str_replace($from, $to, $str); 
 }

    $clean_name = remove_accents($_POST['gallery']);
	$clean_name = cleanUrlname($clean_name);   
	$name = ucfirst($clean_name);

       
	if(file_exists("data/img/gallery/".$name)) {
	
		echo "<p class=\"errorMsg created\"> $lang_gal_error </p>";
		
	} else {
		
		$gal = mkdir("data/img/gallery/". $name , 0755);
		$cac = mkdir("data/img/gallery/$name/". "cache" , 0775);
			
			$text = "<?php ". "$"."_SERVER". "['DOCUMENT_ROOT'] "."= dirname"."( __FILE__ )"."; "."include('../../../../plugins/timthumb/tim_thumb.php')".";"." ?>";
			
			$fp = @fopen("data/img/gallery/$name/". "thumb.php","w");
			$ph = @fwrite($fp, $text);
			fclose($fp);

		if($gal && $cac && $fp && $ph ){
				
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			header("Location: http://$host$uri/index.php?p=manage-gallery");
			die();

		  }else{ 
		  
		  	echo "<p class=\"errorMsg created\">$lang_gal_error</p>";
		  	
		  	}		  	
		 }			
}

?>

<div class="create-new">

<h1><?php echo $lang_gal_newgal; ?></h1>
	
<form action="index.php?p=new-gallery" method="post" class="create-form">
	<input type="text" name="gallery" maxlength="20" placeholder="<?php echo $lang_gal_newname; ?>" /> 
	<input type="submit" value="<?php echo $lang_gal_create_gal; ?>" class="btn"/>
	</form>
</div>

</div>