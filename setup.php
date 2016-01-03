<?php

	include_once 'includes/config.php';
	
	$mysqladmin = "root";
	$mysqladmin_password = "DPSadm1n";
	
	$brc_table_prefix = "brc_";
	
	// Create connection
	$conn = new mysqli(HOST, $mysqladmin, $mysqladmin_password);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	
	// Create database
	$sql = "CREATE DATABASE IF NOT EXISTS ". DB;
	if ($conn->query($sql) === TRUE) {
	    echo "Database created successfully\n";
	} else {
	    echo "Error creating database: " . $conn->error . "\n";
	}
	
	$sql = "GRANT ALL PRIVILEGES ON ".DB.".* TO '".BRC_ADMIN."'@'%' IDENTIFIED BY '".BRC_ADMIN_PASSWORD."' WITH GRANT OPTION;";
	if ($conn->query($sql) === TRUE) {
		echo "user added successfully.\n";
	} else {
		echo "Error adding user: " . $conn->error . "\n";
	}
	
	$conn->close();
	
	// connecting with new db_admin
	
	$conn = new mysqli(HOST, BRC_ADMIN, BRC_ADMIN_PASSWORD, DB);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	// adding needed tables
	$table = $brc_table_prefix."members";
	$db = DB;
	$sql = "CREATE TABLE IF NOT EXISTS `$db`.`$table` (
	    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	    `username` VARCHAR(30) NOT NULL,
	    `email` VARCHAR(50) NOT NULL,
	    `password` CHAR(128) NOT NULL,
	    `salt` CHAR(128) NOT NULL );
		";
	
	if ($conn->query($sql) === TRUE) {
	    echo "$table  created successfully\n";
	} else {
	    echo "Error creatingi $table: " . $conn->error . "\n";
	}
	
	$table = $brc_table_prefix."login_attempts";
	$db = DB;
	$sql = "CREATE TABLE IF NOT EXISTS `$db`.`$table` (
		`user_id` INT(11) NOT NULL,
	    	`time` VARCHAR(30) NOT NULL );   
	        ";
	if ($conn->query($sql) === TRUE) {
	    echo "$table created successfully\n";
	} else {
	    echo "Error creating $table: " . $conn->error . "\n";
	}
	
	$table = $brc_table_prefix."projects";
	$db = DB;
	$sql = "CREATE TABLE IF NOT EXISTS `$db`.`$table` (
	    	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	        `user_id` INT(11) NOT NULL,
		`project_name` VARCHAR(255),
		`project_Description` VARCHAR(255),
		`project_id` VARCHAR(255) );
	        ";
	if ($conn->query($sql) === TRUE) {
	    echo "$table created successfully\n";
	} else {
	    echo "Error creating $table: " . $conn->error . "\n";
	}
	
	$table = $brc_table_prefix."jobs";
	$db = DB;
	$sql = "CREATE TABLE IF NOT EXISTS `$db`.`$table` (
	    	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	        `startframe` INT(11) NOT NULL,
	        `endframe` INT(11) NOT NULL,
	        `output_folder` VARCHAR(255),
	        `sourcefile` VARCHAR(255),
	        `project_name` VARCHAR(255),
	        `scene_name` VARCHAR(255),
	        `progress` INT(3),
	        `last_error` varchar(255),
	        `workflow` varchar(50),
	        `state` INT(1),
	        `encoder_id` INT(11),
	        `encoder_slot` INT(2),
	        `prio` INT(1),
	        `output_format` VARCHAR(10) );
	        ";
	if ($conn->query($sql) === TRUE) {
	    echo "$table created successfully\n";
	} else {
	    echo "Error creating $table: " . $conn->error . "\n";
	}
	
	$conn->close();

?>

	