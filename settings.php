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
			
			<div id=save class="settings-btn float-right">speichern</div>
		</div>
		
	</div>



<?php
	include_once './includes/footer.php';

?>	