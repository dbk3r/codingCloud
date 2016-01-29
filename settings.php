<?php
	include_once './includes/header.php';
	include_once './includes/menu-bar.php';	
	
?>

	<div id=settings-head class=settings-head>
		
		<?php
			if($_GET['show'] == "profile")
			{
				echo "User Profile";
			}
			if($_GET['show'] == "xtra")
			{
				echo "xtra Settings";
			}
		?>
		
		<div id-settings-content class=tbl-content>
			
			<?php
			if($_GET['show'] == "profile")
			{
				include_once 'includes/settings_profile.php';
			}
			
			if($_GET['show'] == "xtra")
			{
				include_once 'includes/settings_xtra.php';
			}
		?>
			
			
			<div id=save class="float-right"><a id=save-<?php echo $_GET['show'] ;?> href=index.php class=settings-btn>speichern</a></div>
		</div>
		
	</div>



<?php
	include_once './includes/footer.php';

?>	