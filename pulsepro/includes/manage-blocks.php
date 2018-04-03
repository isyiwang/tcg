<?php $on='blocks';?>

<div id="sub-head">

	<?php if($_GET["d"]){ 
	
			$folders = strtr($_GET["d"], "../","/");
			$folders = htmlspecialchars($folders, ENT_QUOTES, 'UTF-8');
			
	?>	    <a href="index.php?p=manage-blocks"><?php echo $lang_go_back; ?></a>
		    <a href="index.php?p=new-block&d=<?php echo $folders; ?>"><?php echo $lang_blocks_newblock; ?></a>
		    <a class="delete-folder" href="index.php?p=del-block&d=<?php echo $folders; ?>"><?php echo $lang_blocks_delfold; ?></a>
	
	<?php }else{ ?>
	
				<a href="index.php?p=home"><?php echo $lang_go_back; ?></a>
				<a href="index.php?p=new-block"><?php echo $lang_blocks_newblock; ?></a>
				<a href="index.php?p=new-folder"><?php echo $lang_blocks_newfold; ?></a>
	<?php } ?>  
	
</div>   

<div id="content"><?php

$folders_list = array();
$files_list = array();
$files = array();

if(!empty($_GET["d"] )) {

	$folders = strtr($_GET["d"], "../","/");
	$files = getFiles($folders);
	
	}else {

		$files = getFiles();
	}
	
if(count($files) >= 1){


	foreach ($files as $file) { 
	
		$nb++;		
		$info = preg_replace("/\\.[^.\\s]{3,4}$/", "", $file);

		if(!is_dir($file)) {
				
				if($folders){  ?>
						<div class="tab icon <?php echo basename($info); ?>">
							<a href="index.php?p=view&f=<?php echo $nb; ?>&d=<?php echo $folders; ?>"><?php echo basename($info); ?></a>
						</div>
			
				<?php }else{ 
							$files_list[] = array($nb, basename($info));
						}
			
						$blocks[$nb] = $file; 
			
		}else{		
			$file_name = basename($file);	
			$folders_list[] = $file_name;
			$blocks[$nb] = $file; 
			}
	}
	
	foreach($folders_list as $present_folder){
		?>	<div class="tab folder <?php echo $present_folder; ?>">
				<a href="index.php?p=manage-blocks&d=<?php echo $present_folder; ?>">	
					<?php
						echo $present_folder;
					?>
				 </a>
			</div>
		<?php		
	}
	
	foreach($files_list as $present_file_val){
		?>
		<div class="tab icon <?php echo $present_file_val[1]; ?>">
			<a href="index.php?p=view&f=<?php echo $present_file_val[0]; ?>"><?php echo $present_file_val[1]; ?></a>	
		</div>
		<?php
	}
	
	$_SESSION["blocks"] = $blocks; 
	
}else{

	echo "<div class=\"left-pad\"><p class=\"empty\">$lang_blocks_emptyfold</p></div>";
}	
?>
</div>