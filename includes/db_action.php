<?php

	include_once 'config.php';
	include_once 'functions.php';
	include_once 'db_connect.php';

	if(isset($_POST['wf'])) {
			
		add_DBJob($mysqli, DB, $_POST['uuid'], $_POST['wf']);		
		
	}
		
	sleep (5);

	include_once 'db_disconnect.php';
	
?>