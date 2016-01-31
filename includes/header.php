<?php

	header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");  
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
	header ("Cache-Control: no-cache, must-revalidate");  
	header ("Pragma: no-cache");
	
	include_once 'includes/config.php';
	include_once 'includes/db_connect.php';
	
	
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">    	
    	<title>CC v-0.1c</title>   
    	 	
    	
    	<link rel="stylesheet" href="./includes/css/upload.css" rel="stylesheet" />
    	<link rel="stylesheet" href="./includes/css/jquery.dropdown.css" rel="stylesheet" />    	
    	<link rel="stylesheet" href="./includes/css/cc.css" rel="stylesheet" />
    	
    	<script type="text/javascript" src="./includes/js/jquery-2.1.4.min.js"></script>
    	<script type="text/javascript" src="./includes/js/jquery.knob.js"></script>
    	<script type="text/javascript" src="./includes/js/jquery.ui.widget.js"></script>
    	<script type="text/javascript" src="./includes/js/jquery-ui.js"></script>
    	<script type="text/javascript" src="./includes/js/jquery.iframe-transport.js"></script> 
    	<script type="text/javascript" src="./includes/js/jquery.fileupload.js"></script>   		
		<script type="text/javascript" src="./includes/js/file-upload.js"></script>				
		<script type="text/javascript" src="./includes/js/jquery.dropdown.js"></script>	
		<script type="text/javascript" src="./includes/js/VideoFrame.js"></script>		
		<script type="text/javascript" src="./includes/js/scripts.js"></script>			
		
    	<script type="text/javascript">
								
			$(window).resize(function(){				
				document.body.style.background = 'white';			
				$("#splitDiv").css("height", $("#leftDiv").height());
				fitCanvas();	
				
			});
			
			
		</script>
    	
	</head>
	<body oncontextmenu="return false;">
		<?php			
			include_once'includes/menus.php';
		?>		
		
		
		<div class=mainDiv id=mainDiv>
			