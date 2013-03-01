<?php 
/*
* Infinity Corp Manager - install.php
*
* By Harley Faggetter
*
* Database creation scripts for  ICM
*
* NOTES:
* - This project uses deprecated PHP MySQL functions. I should change them in the future.
*
*
* TODO:
* Move actual db stuff to installaction.php
*
*/

//declare variables globally TODO: make sure all required variables are declared
$state = $_GET["state"];
$dbserver = $_POST["dbserver"];
$dbname = $_POST["dbname"];
$dbuser = $_POST["dbuser"];
$dbpass = $_POST["dbpass"];

//TEST STUB
//echo ("<br />State is:" . $state . ", " . $dbuser . "," . $dbpass );

if ($state === "1")
{
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
		if (mysql_query("CREATE DATABASE " . $dbname,$con))
		{
			echo "Database created";
		}
		else
		{
			echo "Error creating database: " . mysql_error();
		}
	}
	else
	{
		//TEST STUB
		echo "SUCCESS!";
		
		$condb = mysql_connect($dbserver,$dbuser,$dbpass,$dbname);
		
		//TODO: Modify the 'quotes' to check if causing error.
		$sql="CREATE TABLE IF NOT EXISTS Corp_Membership` (
			`ID` int(11) NOT NULL AUTO_INCREMENT,
			`User_Id` varchar(255) COLLATE latin1_german2_ci NOT NULL,
			`Username` varchar(255) COLLATE latin1_german2_ci NOT NULL,
			`Corp_Id` varchar(255) COLLATE latin1_german2_ci NOT NULL,
			`Is_approved` varchar(1) COLLATE latin1_german2_ci DEFAULT NULL,
			`Allow_Multi` varchar(1) COLLATE latin1_german2_ci DEFAULT NULL,
			PRIMARY KEY (`ID`),
			UNIQUE KEY `ID` (`ID`)
			) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=2;";
			
			// $sql="CREATE TABLE IF NOT EXISTS Corp_Membership` (
			// `ID` int(11) NOT NULL AUTO_INCREMENT,
			// `User_Id` varchar(255) COLLATE latin1_german2_ci NOT NULL,
			// `Username` varchar(255) COLLATE latin1_german2_ci NOT NULL,
			// `Corp_Id` varchar(255) COLLATE latin1_german2_ci NOT NULL,
			// `Is_approved` varchar(1) COLLATE latin1_german2_ci DEFAULT NULL,
			// `Allow_Multi` varchar(1) COLLATE latin1_german2_ci DEFAULT NULL,
			// PRIMARY KEY (`ID`),
			// UNIQUE KEY `ID` (`ID`)
			// ) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=2;";
		
		
		if (mysql_query($con,$sql))
		{
			//Create config.php then write to it. Apparently it's quite literal abour the writing part. Tabs and all.
			$file = fopen("config.php",x);
			fwrite($file,
"<?php
//GLOBAL VARIABLES

	//DB VARIABLES
	\$dbserver = \"$dbserver\";
	\$dbname = \"$dbname\";
	\$dbuser = \"$dbuser\";
	\$dbpass = \"$dbpass\";
	\$con = mysql_connect(\$dbserver,\$dbuser,\$dbpass);
	\$condb = mysql_connect(\$dbserver,\$dbuser,\$dbpass,\$dbname);
?>
			");
			fclose($file);
		}
		else
		{
			echo "\nSomething went wrong, " . mysql_error();
		}
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
		<form action=\"install.php?state=1\" method=\"POST\">
			Database Server: <input type=\"text\" name=\"dbserver\"><br />
			Database Name: <input type=\"text\" name=\"dbname\"><br />
			DB Username: <input type=\"text\" name=\"dbuser\"><br />
			DB Password: <input type=\"password\" name=\"dbpass\"><br />
			<input type=\"submit\" value=\"Submit\">
		</form> 
	");

}








?>