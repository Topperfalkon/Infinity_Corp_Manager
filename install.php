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
*/

//declare variables globally TODO: make sure all required variables are declared
$state = $_GET["state"];
$dbserver = $_POST["dbserver"];
$dbname = $_POST["dbname"];
$dbuser = $_POST["dbuser"];
$dbpass = $_POST["dbpass"];

//function to allow passing all SQL queries BEFORE moving on to writing to config
function createTables()
{
	//One bigass array to hold all the SQL DB CREATE scripts
	$sql=array
	(
		"CREATE TABLE IF NOT EXISTS `test_users` (
		`UserName` varchar(255) COLLATE latin1_german2_ci NOT NULL,
		`Password` varchar(255) COLLATE latin1_german2_ci NOT NULL,
		`User_Id` int(11) NOT NULL AUTO_INCREMENT,
		`Email` varchar(254) COLLATE latin1_german2_ci NOT NULL,
		`CanEmail` varchar(1) COLLATE latin1_german2_ci NOT NULL,
		`Verified` varchar(1) COLLATE latin1_german2_ci DEFAULT NULL,
		PRIMARY KEY (`User_Id`),
		UNIQUE KEY `User_Id` (`User_Id`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci",
		"CREATE TABLE IF NOT EXISTS `Test_Corporations` (
		`Corp_Id` int(11) NOT NULL AUTO_INCREMENT,
		`CorpName` varchar(255) COLLATE latin1_german2_ci NOT NULL,
		`CreatorName` varchar(255) COLLATE latin1_german2_ci NOT NULL,
		`IsOpen` varchar(1) COLLATE latin1_german2_ci NOT NULL,
		`CorpTicker` varchar(6) COLLATE latin1_german2_ci DEFAULT NULL,
		`CorpDesc` text COLLATE latin1_german2_ci,
		`AllowMulti` varchar(1) COLLATE latin1_german2_ci NOT NULL,
		`Logo` varchar(255) COLLATE latin1_german2_ci DEFAULT NULL,
		`CorpURL` varchar(255) COLLATE latin1_german2_ci DEFAULT NULL,
		PRIMARY KEY (`Corp_Id`),
		UNIQUE KEY `Corp_Id` (`Corp_Id`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci",
		"CREATE TABLE IF NOT EXISTS `Corp_Membership` (
		`ID` int(11) NOT NULL AUTO_INCREMENT,
		`User_Id` varchar(255) COLLATE latin1_german2_ci NOT NULL,
		`Username` varchar(255) COLLATE latin1_german2_ci NOT NULL,
		`Corp_Id` varchar(255) COLLATE latin1_german2_ci NOT NULL,
		`Is_approved` varchar(1) COLLATE latin1_german2_ci DEFAULT NULL,
		`Allow_Multi` varchar(1) COLLATE latin1_german2_ci DEFAULT NULL,
		PRIMARY KEY (`ID`),
		UNIQUE KEY `ID` (`ID`)
		) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci"
	);
		
	//One loop to iterate through the array. Will switch to foreach when I'm more confident with its implementation
	for($i = 0; $i < 3; $i++)
	{
		$query=mysql_query($sql[$i]);
	}
	return 1;
}


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
		
		mysql_select_db($dbname, $con);

		if (createTables() == 1)
		{
			//Create config.php then write to it. Apparently it's quite literal about the writing part. Tabs and all.
			//In other words, making sure that file stays readable makes this file a bit messy.
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
			echo 
			("
				Congratulations on succesfully installing the Infinity Corporation Manager Database. For added security, consider deleting install.php.<br />
				Settings will be accessible in config.php.
			");
		}
		//We need to show an error if something's gone wrong.
		else
		{
			echo "<br />Something went wrong, " . mysql_error();
		}
	}
	mysql_close($con);
}

else
{
	//TODO: Generate form to capture details
	echo
	("
		<!--TODO: Make stuff prettier and more informative and stuff -->
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