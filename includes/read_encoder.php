<?php
	include_once 'functions.php';
	include_once 'db_connect.php';

	$sql = "SELECT * from cc_encoder";
	$result = $mysqli->query($sql);
	
	if ($result->num_rows > 0) {
    
		echo "	<div class=content-a>\n";	
		echo "		<table border=0 width=100%cellspacing=0 cellpadding=0>";	
		echo "      <tr class=content-head>";
		echo "			<td>Instanz</td>";
		echo "			<td>IP-Adresse</td>";
		echo "			<td width=50 align=center>CPU's</td>";		
		echo "			<td width=80 align=center>aktive Jobs</td>";
		echo "      </tr>";		
			
	    while($row = $result->fetch_assoc()) {   
			
			echo "      <tr>";
			echo "			<td>".$row['encoder_instance']."</td>";
			echo "			<td>".$row['encoder_ip']."</td>";
			echo "			<td align=center>".$row['encoder_cpus']."</td>";			
			echo "			<td align=center>".$row['encoder_used_slots']."</td>";
			echo "      </tr>";
			
	    }
		echo "		</table>";	
		echo "	</div>\n";	
		echo "<div class=content-head></div>";	
	} else {
	    echo "<div class=content-head><div class=content-head-a>keine Encoder vorhanden</div></div>";
	}
	
	
?>