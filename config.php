<?php
//GLOBAL VARIABLES

	//DB VARIABLES
	$dbserver = "db457094783.db.1and1.com";
	$dbname = "db457094783";
	$dbuser = "dbo457094783";
	$dbpass = "testpass";
	$con = mysql_connect($dbserver,$dbuser,$dbpass);
	$condb = mysql_connect($dbserver,$dbuser,$dbpass,$dbname);
?>
			