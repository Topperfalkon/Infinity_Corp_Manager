<?php
//This is an example config file. You don't need to upload it, but it may help fix install issues.

//GLOBAL VARIABLES

	//DB VARIABLES
	$dbserver = "db.example.com"; //Address for Database Server
	$dbname = "database";				//The name of the Database being connected to
	$dbuser = "dbo";				//Database Username
	$dbpass = "test";					//Database Password
	$con = mysql_connect($dbserver,$dbuser,$dbpass);			//Command to connect to the DB Server
	$condb = mysql_connect($dbserver,$dbuser,$dbpass,$dbname);	//Command to directly connect to a database
?>
			