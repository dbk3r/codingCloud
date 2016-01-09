<?php

include_once 'includes/config.php';
//include_once 'includes/db_connect.php';
include_once 'includes/functions.php';


$upload_dir = UPLOAD_DIR;
$content_dir = CONTENT_DIR;




if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
	
	$org_filename = $_FILES['upl']['name'];
	

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
	$uuid = generate_uuid();
	
	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}
	
	if(move_uploaded_file($_FILES['upl']['tmp_name'], $upload_dir.$org_filename)){		
		mkdir($content_dir.$uuid);		
		if(strtolower($extension) == "zip") {
			
			if(unzip_file($upload_dir.$org_filename, $content_dir.$uuid)) {
				
				unlink($upload_dir.$org_filename);
				
				// parse unziped folder
				$dh  = opendir($content_dir.$uuid);
				while (false !== ($filename = readdir($dh))) {
					
					if($filename == "." || $filename == "..") // ignore dots
					{ continue; } else {
					    $f_ext = pathinfo($filename, PATHINFO_EXTENSION);					
						$content_type = getContentType($f_ext);
						
						
						if($f_ext == "blend") {
							// add blendfile to Database
							add_DBContent($filename, end(explode(".", $filename)), $content_dir.$uuid."/", "Blender");	
						} else {
							if(in_array(strtolower($f_ext), $allowed)){
								// add file to Database									
								add_DBContent($filename, end(explode(".", $filename)), $content_dir.$uuid."/", $content_type);						
							} else {
								// delete file								
								unlink($content_dir.$uuid."/".$filename);
							}					
						}
					} //end ignore dots
				} // end while  dirscan	
							
			} // ende unzip
			
		} // end if zip
		rename($upload_dir.$org_filename, $content_dir.$uuid."/".$org_filename);
		if ($extension == "blend") {
			# add blend-file to Database
			add_DBContent($org_filename, end(explode(".", $org_filename)), $content_dir.$uuid."/", "Blender");
		}
		else {
			# add uploaded File to Database
			$content_type = getContentType($extension);
			add_DBContent($org_filename, end(explode(".", $org_filename)), $content_dir.$uuid."/", $content_type);
			
		}
		
		echo '{"status":"success"}';
		exit;
	}
}

echo '{"status":"error"}';
exit;

