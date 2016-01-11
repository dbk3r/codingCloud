<?php
	include_once 'functions.php';
	include_once 'db_connect.php';
	
?>

		<div class=content-head>			
			<div class=content-head-a>Dateiname</div>				
			<div class=content-head-b>Aktion</div>
			<div class=content-head-c>Status</div>						
		</div>	
			
			<?php
				db_read_content($mysqli);			
			?>

	