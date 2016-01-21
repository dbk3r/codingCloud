<?php
	include_once './includes/header.php';
	include_once './includes/menu-bar.php';		
?>

	<div id=settings-head class=settings-head>
		
		<?php
			if($_GET['show'] == "wf")
			{
				echo "ADD/EDIT Workflows";
			}
			if($_GET['show'] == "p")
			{
				echo "ADD/EDIT Processes";
			}
		?>
		
		<div id-settings-content class=tbl-content>
			
			<div class=float-right><a id=save-<?php echo $_GET['show'] ;?> href=index.php class=settings-btn>Zur&uuml;ck</a></div>
		</div>
		
	</div>


<?php
	include_once './includes/footer.php';

?>	