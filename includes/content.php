<?php
	include_once 'functions.php';
	include_once 'db_connect.php';
?>

		<table width=100% cellpadding="4" cellspacing="0">
			<tr class=tbl-header>
				<td width=400>Dateiname</td>
				<td width=100>Content</td>
				<td align=right>Aktion</td>
				<td width=100 align=center>Status</td>						
			</tr>
			
			<?php
				db_read_content($mysqli);			
			?>
			
			
		</table>	
	
<?php
	include_once 'db_disconnect.php';
?>