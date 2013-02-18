<?php 
/*
* Infinity Corp Manager - install.php
*
* By Harley Faggetter
*
* Database creation scripts for 
*/

//declare variables globally TODO: make sure all required variables are declared
$state = $GET_['state'];
$dbserver = $POST_['dbserver'];
$dbuser = $POST_['dbuser'];
$dbpass = = $POST_['dbpass'];

if ($state == 1)
{
	//TODO: Handle user input, create DB, supply response.
	$con = mysql_connect($dbserver,$dbuser,$dbpass);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	
	//TODO: Expand the mysql_query to do full create
	if (mysql_query("CREATE DATABASE my_db",$con))
	{
		echo "Database created";
	}
	else
	{
		echo "Error creating database: " . mysql_error();
	}

	mysql_close($con);
}

else
{
	//TODO: Generate form to capture details
	echo
	("
		<!-- TODO: Some HTML form here -->
		<form action=\"/install.php?state=1\" method=\"POST\">
			Database: <input type=\"text\" name=\"dbserver\">
			DB Username: <input type=\"password\" name=\"dbuser\">
			DB Password: <input type=\"password\" name=\"dbpass\">
		</form> 
	");
}









?>