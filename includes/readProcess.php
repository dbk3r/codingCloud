<?php

	include_once 'config.php';
	include_once 'functions.php';
	include_once 'db_connect.php';
	
	$sql2 = "SELECT * from cc_jobs where uuid=".$_GET['uuid']." order by id DESC";
	write_log("SELECT * from cc_jobs where uuid='".$_GET['uuid']."' order by id DESC");
			$ps = $mysqli->query($sql2);
			if ($ps->num_rows > 0) {
				
				echo "<table width=100% border=0 cellpadding=4 cellspacing=5>" ;
	    		while($p = $ps->fetch_assoc()) {					
				
				$restartBtn = "<img onClick=\"restartJob('".$p['id']."');\" valign=middle id=rJob".$p['id']." class=restartJob src=img/restart.png>";
				echo "<tr class=proc><td>".$p['job_type']."</td><td>".$restartBtn."</td><td align=center class='state-". $states[$p["state"]] ." p_font'>".$p['progress']."</td></tr>" ;				
				}
				echo "</table>"; 

			}
	

?>