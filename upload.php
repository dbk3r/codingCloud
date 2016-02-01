<?php

include_once 'includes/config.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';


$upload_dir = UPLOAD_DIR;
$content_dir = CONTENT_DIR;

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
	
	$org_filename = $_FILES['upl']['name'];
	

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
	$uuid = generate_uuid();
	
	if(!in_array(strtolower($extension), $allowed)){
		echo '{"error":"notAllowed"}';		
		exit;
	}
	
	if(move_uploaded_file($_FILES['upl']['tmp_name'], $upload_dir.$org_filename)){		
		mkdir($content_dir.$uuid);		
		if(strtolower($extension) == "zip") {
			
			if(unzip_file($upload_dir.$org_filename, $content_dir.$uuid)) {
				
				unlink($upload_dir.$org_filename);
				
				// parse unziped root folder
				$dh  = opendir($content_dir.$uuid);
				while (false !== ($filename = readdir($dh))) {
					
					if($filename == "." || $filename == "..") // ignore dots
					{ continue; } else {
					    $f_ext = pathinfo($filename, PATHINFO_EXTENSION);					
						$content_type = getContentType($f_ext);
						
						
						if($f_ext == "blend") {
							// adding blendfile to Database							
							add_DBContent($mysqli, $filename, $uuid, "blender", $f_ext);	
							rename($content_dir.$uuid."/".$filename, $content_dir.$uuid."/".$uuid.".".$f_ext);
						} else {
							if(in_array(strtolower($f_ext), $allowed)){
								// add file to Database																					
								add_DBContent($mysqli, $filename, $uuid, $content_type, $f_ext);
								rename($content_dir.$uuid."/".$filename, $content_dir.$uuid."/".$uuid.".".$f_ext);						
							} else {
								// delete file								
								unlink($content_dir.$uuid."/".$filename);
							}					
						}
					} //end ignore dots
				} // end while  dirscan	
							
			} // end unzip
		add_DBJob($mysqli, DB, $uuid, "IngestContent");
		echo '{"success":"success"}';	
		exit;	
		} // end if zip
		
		rename($upload_dir.$org_filename, $content_dir.$uuid."/".$uuid.".".$extension);
		if ($extension == "blend") {
			# add blend-file to Database
			add_DBContent($mysqli, $org_filename, $uuid, "blender", $extension);			
		}
		else {
			# add uploaded File to Database
			$content_type = getContentType($extension);					
			add_DBContent($mysqli, $org_filename, $uuid, $content_type, $extension);
			
		}
		add_DBJob($mysqli, DB, $uuid, "IngestContent");
		echo '{"success":"success"}';
		exit;
	}
}

echo '{"error":"upload failed"}';
exit;

