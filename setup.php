<?php

	include_once 'includes/config.php';
	
	$mysqladmin = "root";
	$mysqladmin_password = "nulleins";
	
	$CC_table_prefix = TABLE_PREPIX;
	
	// Create connection
	$conn = new mysqli(HOST, $mysqladmin, $mysqladmin_password);		
	
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	
	// deleting Database
	$sql = "DROP DATABASE IF EXISTS ".DB;
	if ($conn->query($sql) === TRUE) {
    	echo "Database ".DB." deleted successfully\n";
	} else {
	    echo "Error deleting database: " . $conn->error . "\n";
	}
	
		
	// Create database
	$sql = "CREATE DATABASE IF NOT EXISTS ". DB;
	if ($conn->query($sql) === TRUE) {
	    echo "Database ".DB." created successfully\n";
	} else {
	    echo "Error creating database: " . $conn->error . "\n";
	}
	
	$sql = "GRANT ALL PRIVILEGES ON ".DB.".* TO '".CC_ADMIN."'@'%' IDENTIFIED BY '".CC_ADMIN_PASSWORD."' WITH GRANT OPTION;";
	if ($conn->query($sql) === TRUE) {
		echo "user added successfully.\n";
	} else {
		echo "Error adding user: " . $conn->error . "\n";
	}
	
	$conn->close();
	
	// connecting with new db_admin
	
	$conn = new mysqli(HOST, CC_ADMIN, CC_ADMIN_PASSWORD, DB);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	// adding needed tables
	$table = $CC_table_prefix."members";
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
	
	// add Table login_attemps
	$table = $CC_table_prefix."login_attempts";
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
	
	// add table content
	$table = $CC_table_prefix."content";
	$db = DB;
	$sql = "CREATE TABLE IF NOT EXISTS `$db`.`$table` (
	    	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	        `user_id` INT(11) NOT NULL,
			`content_description` VARCHAR(255),
			`content_filename` VARCHAR(255),
			`content_type` VARCHAR(255),	
			`content_state` VARCHAR(255),	
			`content_uuid` VARCHAR(255) );
	        ";
	if ($conn->query($sql) === TRUE) {
	    echo "$table created successfully\n";
	} else {
	    echo "Error creating $table: " . $conn->error . "\n";
	}
	
	// add table workflow
	$table = $CC_table_prefix."wf";
	$db = DB;
	$sql = "CREATE TABLE IF NOT EXISTS `$db`.`$table` (
	    	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	        `user_id` INT(11) NOT NULL,
			`wf_description` VARCHAR(255),
			`wf_short` VARCHAR(255),
			`wf_pids` VARCHAR(255),
			`wf_icon` VARCHAR(255),
			`wf_state` TINYINT(1) );
	        ";
	if ($conn->query($sql) === TRUE) {
	    echo "$table created successfully\n";
	} else {
	    echo "Error creating $table: " . $conn->error . "\n";
	}
	// insert wf delete Content
	$sql = "INSERT INTO `$db`.`$table` (wf_description, wf_short, wf_pids ,wf_icon) VALUES ('delete Content','delContent', 'delContentDB,delContent', 'img/trash.png');";
	$conn->query($sql);
	
	// add table process
	$table = $CC_table_prefix."process";
	$db = DB;
	$sql = "CREATE TABLE IF NOT EXISTS `$db`.`$table` (
	    	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	        `process_description` VARCHAR(255),
			`process_type` VARCHAR(255),			
			`process_cmd` VARCHAR(1024),
			`process_state` TINYINT(1) );
	        ";
	if ($conn->query($sql) === TRUE) {
	    echo "$table created successfully\n";
	} else {
	    echo "Error creating $table: " . $conn->error . "\n";
	}
	$sql = "INSERT INTO `$db`.`$table` (process_description, process_type) VALUES ('delete Content DB ','delContentDB');";
	$conn->query($sql);	
	$sql = "INSERT INTO `$db`.`$table` (process_description, process_type) VALUES ('delete File Content','delContent');";
	$conn->query($sql);	
	
	// add table encoder
	$table = $CC_table_prefix."encoder";
	$db = DB;
	$sql = "CREATE TABLE IF NOT EXISTS `$db`.`$table` (
	    	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	        `encoder_used_slots` INT(2),
			`encoder_max_slots` INT(2),
			`encoder_ffmpeg` TINYINT(1),
			`encoder_ffmbc` TINYINT(1),
			`encoder_blender` TINYINT(1),
			`encoder_bmxtranswrap` TINYINT(1),
			`encoder_mediainfo` TINYINT(1),
			`encoder_curl` TINYINT(1),
			`encoder_cpus` INT(2),
			`encoder_ip` VARCHAR(25) );
	        ";
	if ($conn->query($sql) === TRUE) {
	    echo "$table created successfully\n";
	} else {
	    echo "Error creating $table: " . $conn->error . "\n";
	}
		
	// add table jobs
	$table = $CC_table_prefix."jobs";
	$db = DB;
	$sql = "CREATE TABLE IF NOT EXISTS `$db`.`$table` (
	    	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,	        
	        `uuid` VARCHAR(255),
	        `src_filename` VARCHAR(512),
	        `dest_filename` VARCHAR(512),
	        `content_type` VARCHAR(255),
	        `job_type` VARCHAR(255),
	        `coder_bin` VARCHAR(255),
	        `cmd` VARCHAR(1024),
	        `progress` INT(3),	        
	        `state` INT(1),
	        `encoder_id` INT(11),
	        `pid` INT(11),
	        `encoder_slot` INT(2),
	        `prio` INT(1) );
	        ";
	if ($conn->query($sql) === TRUE) {
	    echo "$table created successfully. \n";
	} else {
	    echo "Error creating $table: " . $conn->error . "\n";
	}
	
	$conn->close();

?>

	