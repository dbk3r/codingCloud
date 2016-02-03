<?php
	include_once './includes/header.php';
	include_once './includes/menu-bar.php';		
?>

	<div id=settings-head class=settings-head>
		
		<?php
			if($_GET['show'] == "wf")
			{
				echo "ADD/EDIT Workflows";
				$btn = "speichern";
			}
			if($_GET['show'] == "p")
			{
				echo "ADD/EDIT Processes";
				$btn = "speichern";
			}
			if($_GET['show'] == "m")
			{
				echo "Coder/Worker Monitor<br><br>";
				$incl = "./includes/monitor.php";
				$btn = "zur&uuml;ck";
			}
			
		?>
		
		<div id-settings-content class=tbl-content>
			<div id="monContent" class="content2">				
				<?php include_once $incl; ?>				
			</div>
			
			<div class=float-right><a id=save-<?php echo $_GET['show'] ;?> href=index.php class=settings-btn><?php echo $btn; ?></a></div>
		</div>
		
	</div>


<?php
	include_once './includes/footer.php';

?>	