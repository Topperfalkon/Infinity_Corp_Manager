<?php
//This is an example config file. You don't need to upload it, but it may help fix install issues.

//DB VARIABLES
$dbserver = "db.example.com"; //Address for Database Server
$dbname = "database";				//The name of the Database being connected to
$dbuser = "dbo";				//Database Username
$dbpass = "test";					//Database Password
$mysqli = new mysqli($dbserver, $dbuser, $dbpass);

//OTHER VARIABLES
$siteURL = "http://test.test.com";
?>