<?php

	include_once 'config.php';
	include_once 'functions.php';
	include_once 'db_connect.php';

	if(isset($_POST['rJob'])) {
		$restart = "UPDATE cc_jobs set state='0' where id='".$_POST['rJob']."'";
		write_log($restart);
		$mysqli->query($restart);
		echo '{"status":"success"}';
		$restart = NULL;
	}

	if(isset($_GET['getWF'])) {
		
		// read Workflows
			$sql2 = "SELECT wf_description,wf_short,wf_icon from cc_wf order by id DESC";
			$workflows = $mysqli->query($sql2);
			if ($workflows->num_rows > 0) {    
	    		while($obj = mysqli_fetch_object($workflows)) {
					$var[] = $obj;
				}
				echo '{"workflow":'.json_encode($var).'}';

			}
	}

	if(isset($_POST['wf'])) {
			
		add_DBJob($mysqli, DB, $_POST['uuid'], $_POST['wf']);	
		sleep (5);	
		
	}
		
	

	include_once 'db_disconnect.php';
	
?>