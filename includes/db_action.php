<?php

	include_once 'config.php';
	include_once 'functions.php';
	include_once 'db_connect.php';

	if(isset($_POST['del'])) {
		$db = DB;
		$id = $_POST['del'];
 		$sql = "delete from ".$db.".cc_content where content_uuid='$id'";
		$mysqli->query($sql) ;
		
	}


	include_once 'db_disconnect.php';
	
?>