<?php 
/**
 * Installer for Infinity Corp Manager
 *
 * This file performs the following functions:
 *
 * * Gets configuration settings from user via HTML form
 * * Creates database if not exists
 * * Creates tables
 * * Stores settings in config.php
 * 
 * @package Infinity_Corp_Manager
 */

header('Content-Type: text/html; charset=utf-8');

// Form to output, unless form has been submitted
if (!isset($_POST['submit'])) {
	echo "<html>
	<head>
		<title>ICM Installation</title>
	</head>
	<body>
		<p>Enter your database connection details here. The database will be created if it does not exist.<br />If you are using shared hosting you will have to create the database via your hosting control panel. Please use utf8.</p>
		<form action=\"install.php\" method=\"post\">
			<p>Database Server: <input type=\"text\" name=\"dbserver\" /></p>
			<p>Database Name: <input type=\"text\" name=\"dbname\" /></p>
			<p>DB Username: <input type=\"text\" name=\"dbuser\" /></p>
			<p>DB Password: <input type=\"password\" name=\"dbpass\" /></p>
			<p><input type=\"submit\" name=\"submit\" value=\"Submit\">
		</form> 
	</body>
</html>";
	
} else {

	// Copy form data into variables for better code readability
	$dbserver = $_POST["dbserver"];
	$dbname = $_POST["dbname"];
	$dbuser = $_POST["dbuser"];
	$dbpass = $_POST["dbpass"];
	
	$mysqli = new mysqli($dbserver, $dbuser, $dbpass);
	
	if ($mysqli->connect_errno) {
		die ("Failed to connect to MySQL server: ({$mysqli->connect_errno}) {$mysqli->connect_error}");
	}
	
	$mysqli->set_charset("utf8");

	// Connection established
	
	if (!$mysqli->select_db($dbname)) {
		echo "Database <em>$dbname</em> does not exist, attempting to create it... ";
		if ($mysqli->query("CREATE DATABASE $dbname DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci")) {
			echo "Database <em>$dbname</em> created successfully.<br/>";
		} else if ($mysqli->errno == 1044) { // 1044	SQLSTATE: 42000 (ER_DBACCESS_DENIED_ERROR) Access denied for user '%s'@'%s' to database '%s'
			die ("Failed to create database: User <em>$dbuser</em> does not have the required privilege<br/>");
		} else { // Other error
			die ("Failed to create database: ({$mysqli->errno}) {$mysqli->error}<br/>");
		}
	} else {
		$result = $mysqli->query("SELECT default_character_set_name FROM information_schema.SCHEMATA WHERE schema_name = '$dbname'");
		$row = $result->fetch_row();
		if ($row[0]!=='utf8') {
			die ("It looks like you have created the database <em>$dbname</em>, but you didn't set the character encoding to utf8. Did you know that every time you use something other than utf8, a kitten dies under a pile of quest�on m�rks�<br/>
	Please change the character encoding to utf8 and the collation to utf8_general_ci (You can use a different collation if you know which non-english language is going to be most commonly used.)");
		} else {
			echo "Database exists.<br />";
		}
	}
	
	// Database created. Let's create the tables
		
	if (($mysqli->multi_query("
		CREATE TABLE IF NOT EXISTS `icmdb`.`Users` (
			`UserID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
			`UserName` VARCHAR(45) NOT NULL,
			`Password` CHAR(60) NOT NULL,
			`Email` VARCHAR(80) NOT NULL,
			`EmailVisible` TINYINT(1) NULL,
			`EmailVerified` TINYINT(1) NULL,
			PRIMARY KEY (`UserID`),
			UNIQUE INDEX `UserName_UNIQUE` (`UserName` ASC) )
			ENGINE=MyISAM;

		CREATE TABLE IF NOT EXISTS `icmdb`.`Corporations` (
			`CorporationID` INT UNSIGNED NOT NULL,
			`CorpName` VARCHAR(80) NOT NULL,
			`LeaderID` INT UNSIGNED NOT NULL,
			`Ticker` VARCHAR(6) NULL DEFAULT NULL,
			`Description` TEXT NULL,
			`JoinMode` TINYINT NULL DEFAULT 0 COMMENT '0 = Corp hidden | 1 = Anyone can join | 2 = Anyone can apply, application must be accepted | 3 = Invitation only',
			`AllowMulti` TINYINT(1) NULL,
			`HasLogo` TINYINT(1) NULL DEFAULT 0,
			`Website` VARCHAR(80) NULL,
			`DefaultPermissions` BINARY(1) NULL COMMENT 'Bitfield',
			PRIMARY KEY (`CorporationID`),
			INDEX `LeaderID` (`LeaderID` ASC) )
			ENGINE=MyISAM;

		CREATE TABLE IF NOT EXISTS `icmdb`.`Membership` (
			`UserID` INT UNSIGNED NOT NULL,
			`CorporationID` INT UNSIGNED NOT NULL,
			`Status` TINYINT NULL COMMENT '0 = Applied | 1 = Member | 2 = Invited',
			`Permissions` BINARY(1) NULL COMMENT 'Bitfield',
			PRIMARY KEY (`UserID`, `CorporationID`),
			INDEX `Corporation` (`CorporationID` ASC) )
			ENGINE=MyISAM;"
	)) && ($mysqli->next_result()) && ($mysqli->next_result())) {
		echo "Tables created.";
	} else {
		die ("Failed to create table(s): ({$mysqli->errno}) {$mysqli->error}<br />");
	}
	$mysqli->close();

	// Create config.php
	file_put_contents('config.php', array(
		'<?php',
		'// Database',
		"\$dbserver = '{$dbserver}';",
		"\$dbuser   = '{$dbuser}';",
		"\$dbname   = '{$dbname}';",
		"\$dbpass   = '{$dbpass}';",
		'?>')
	);
	
	echo ('Congratulations on succesfully installing the Infinity Corporation Manager Database. For added security, please delete install.php.<br />Settings have been saved to config.php.');
}
?>