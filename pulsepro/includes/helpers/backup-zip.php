<?php

function Zip($sources, $destination){

    if (extension_loaded('zip') === true){
	
			$zip = new ZipArchive();

			if ($zip->open($destination, ZIPARCHIVE::CREATE) === true){
				
				foreach ($sources as $source){
				
					if (file_exists($source) === true){
					
						$source = realpath($source);

						if (is_dir($source) === true){
						
							$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
								
								foreach ($files as $file){
								
									$file = realpath($file);

									if (is_dir($file) === true){
												
										$zip->addEmptyDir(basename($source).DIRECTORY_SEPARATOR.str_replace($source . DIRECTORY_SEPARATOR, '', $file ));
										}

									else if (is_file($file) === true){
										
										$zip->addFromString(basename($source).DIRECTORY_SEPARATOR. str_replace($source . DIRECTORY_SEPARATOR, '', $file), file_get_contents($file));
										}
								 }
						 }

						else if (is_file($source) === true){
						
								$zip->addFromString(basename($source), file_get_contents($source));
						}
					}
				}
			}
			else echo $lang_backup_err_destination;

			return $zip->close();
	
    }
	else echo $lang_backup_err_zip_extention ;

    return false;
}


?>