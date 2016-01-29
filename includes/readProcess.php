<?php

	include_once 'config.php';
	include_once 'functions.php';
	include_once 'db_connect.php';
	
	$sql2 = "SELECT * from cc_jobs where uuid=".$_GET['uuid']." order by id DESC";
	write_log("SELECT * from cc_jobs where uuid='".$_GET['uuid']."' order by id DESC");
			$ps = $mysqli->query($sql2);
			if ($ps->num_rows > 0) {    
	    		while($obj = mysqli_fetch_object($ps)) {
					$var[] = $obj;
				}
				echo '{"ps":'.json_encode($var).'}';

			}
	

?>