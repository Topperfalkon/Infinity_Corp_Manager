<?php

$dbserver = $POST_["dbserver"];
$dbname = $POST_["dbname"];
$dbuser = $POST_["dbuser"];
$dbpass = $POST_["dbpass"];

//TODO: Handle user input, create DB, supply response.
//		Check user input if DB already exists. If not, create it
$con = mysql_connect($dbserver,$dbuser,$dbpass);
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

if (!mysql_select_db($dbname))
{
	//TODO: Expand the mysql_query to do full create
	/*if (mysql_query("CREATE DATABASE my_db",$con))
	{
		echo "Database created";
	}*/
	//else
	//{
		echo "Error creating database: " . mysql_error();
	//}
}
else
{
	echo "SUCCESS!";
}

mysql_close($con);

?>