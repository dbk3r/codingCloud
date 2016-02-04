<?php
	include_once 'functions.php';
	include_once 'db_connect.php';

	$sql = "SELECT * from cc_jobs";
	$result = $mysqli->query($sql);
	
	if ($result->num_rows > 0) {
    
		echo "	<div class=content-a>\n";	
		echo "		<table border=0 width=100%cellspacing=0 cellpadding=0>";	
		echo "      <tr class=content-head>";
		echo "			<td>UUID</td>";
		echo "			<td>Content</td>";
		echo "			<td>Job</td>";		
		echo "			<td>Essential</td>";
		echo "			<td>Command</td>";
		echo "			<td align=center>Action</td>";
		echo "			<td align=center>State</td>";
		echo "      </tr>";		
			
	    while($row = $result->fetch_assoc()) {
	    	
			
			$restartBtn = "<img onClick=\"restartJob('".$row['id']."');\" valign=middle id=rJob".$row['id']." class=restartJob src=img/restart.png>";
			
			echo "      <tr class=content2>";
			echo "			<td>".$row['uuid']."</td>";
			echo "			<td>".$row['src_filename']."</td>";
			echo "			<td>".$row['job_type']."</td>";					
			echo "			<td>".$row['job_essential']."</td>";
			echo "			<td>".$row['job_cmd']."</td>";
			echo "			<td align=center>".$restartBtn."</td>";
			echo "			<td align=center class='state-".$states[$row['state']]." p_font'>".$row['progress']."</td>";
			echo "      </tr>";
			
	    }
		echo "		</table>";	
		echo "	</div>\n";	
		echo "<div class=content-head></div>";	
	} else {
	    echo "<div class=content-head><div class=content-head-a>keine Encoder vorhanden</div></div>";
	}
	
	
?>