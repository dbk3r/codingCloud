<?php
	include_once 'functions.php';
	include_once 'db_connect.php';
	
	if (!empty($_GET))
	{
		$f_audio = $_GET['f_audio']; 
		$f_video = $_GET['f_video'];
		$f_blender = $_GET['f_blender'];
	}
	else
	{
		$f_audio = ""; 
		$f_video = "";
		$f_blender = "";
	}
	
	
?>

		<div class=content-head>			
			<div class=content-head-a>Content</div>						
		</div>	
			
<?php
	db_read_content($mysqli, $f_audio, $f_video , $f_blender);	
		
?>

	