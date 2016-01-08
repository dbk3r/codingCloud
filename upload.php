<?php

include_once 'includes/config.php';
include_once 'includes/functions.php';


$upload_dir = UPLOAD_DIR;
// A list of permitted file extensions
$allowed = array('mov', 'mxf', 'mp4', 'png', 'jpg', 'gif','zip');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
	
	$org_filename = $_FILES['upl']['name'];
	

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
	$uuid = generate_uuid() . "." . $extension;
	
	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}

	if(move_uploaded_file($_FILES['upl']['tmp_name'], $upload_dir.$uuid)){
		echo '{"status":"success"}';
		exit;
	}
}

echo '{"status":"error"}';
exit;

