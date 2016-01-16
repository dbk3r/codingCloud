<?php

	include_once 'config.php';
	include_once 'functions.php';
	include_once 'db_connect.php';

	if(isset($_POST['wf'])) {
		$db = DB;
		$uuid = $_POST['uuid'];		
		$sql = "SELECT * from cc_wf WHERE wf_short='" . $_POST['wf'] . "'";
		$result = $mysqli->query($sql);	
    	write_log($sql);	
	    while($row = $result->fetch_assoc()) {
			write_log($row["wf_pids"]);	
			// read processes		    	
			$pids = explode(',',$row["wf_pids"]);
			
			foreach($pids as $pid) {
				write_log($pid);
			    $sql2 = "SELECT * from cc_process where process_type='".$pid."'";
				$processes = $mysqli->query($sql2);
			    
	    		while($pidRow = $processes->fetch_assoc()) {
	    			$sql3 = "INSERT INTO `$db`.`cc_jobs` (uuid, job_type,state) VALUES ('".$uuid."','".$pidRow["process_type"]."','0');";
					$mysqli->query($sql3);
				}
			
			}
	    }
		
	}
		
	sleep (2);

	include_once 'db_disconnect.php';
	
?>