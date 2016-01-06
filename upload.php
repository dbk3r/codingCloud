<?php

	include_once 'includes/config.php';


$output_dir = CONTENT_DIR;


if(isset($_FILES["myfile"]))
{
    $ret = array();

    $error =$_FILES["myfile"]["error"];
    if(!is_array($_FILES["myfile"]["name"])) //single file
    {
        $fileName = $_FILES["myfile"]["name"];
        move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
        $ret[]= $fileName;
    }
    else  //Multiple files, file[]
    {
        $fileCount = count($_FILES["myfile"]["name"]);
        for($i=0; $i < $fileCount; $i++)
        {
            $fileName = $_FILES["myfile"]["name"][$i];
            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
            $ret[]= $fileName;
        }

    }
    
	echo json_encode(array('status' => 'ok'));

}
?>