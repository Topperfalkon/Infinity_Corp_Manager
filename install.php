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
$dbname = $POST_['dbname'];
$dbuser = $POST_['dbuser'];
$dbpass = $POST_['dbpass'];

if ($state == 1)
{
	//TODO: Handle user input, create DB, supply response.
	//		Check user input if DB already exists. If not, create it
	$con = mysql_connect($dbserver,$dbuser,$dbpass);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	
	//TODO: Expand the mysql_query to do full create
	/*if (mysql_query("CREATE DATABASE my_db",$con))
	{
		echo "Database created";
	}*/
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
		<p>
			Enter your database connection details here. <br />
			Many database providers will supply you with a name for your database, otherwise, pick a name.
		</p><br />
		<form action=\"/install.php?state=1\" method=\"POST\">
			Database Server: <input type=\"text\" name=\"dbserver\"><br />
			Database Name: <input type=\"text\" name=\"dbname\"><br />
			DB Username: <input type=\"password\" name=\"dbuser\"><br />
			DB Password: <input type=\"password\" name=\"dbpass\"><br />
			<input type=\"submit\" value=\"Submit\">
		</form> 
	");
}









?>