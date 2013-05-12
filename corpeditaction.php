<?php
/************************************************
*	Infinity Corp Manager Index Page
*	
*	Created by Harley Faggetter
*
*
*
*
*************************************************/
//Load config
include 'config.php';

session_start();

$mysqli = new mysqli($dbserver, $dbuser, $dbpass);

//make sure you're actually logged in
if($_SESSION['login']===1)
{
	//make sure the db is alive
	if ($mysqli->connect_errno) {
		die ("Failed to connect to MySQL server: ({$mysqli->connect_errno}) {$mysqli->connect_error}");
	}

	//select the db
	$mysqli->select_db($dbname);

	$user= $_SESSION['username'];

	//Get a db query  
	$result = $mysqli->query("SELECT * FROM Test_Corporations WHERE CreatorName = \"" . $user . "\"");

	//Get the results
	$row = $result->fetch_array();

	//declare variables from inputs
	$username= $mysqli->real_escape_string ($_SESSION['username']);
	$corpname= $mysqli->real_escape_string ($_POST['CorpName']);
	$corpdesc= $mysqli->real_escape_string ($_POST['Desc']);
	$corptick= $mysqli->real_escape_string ($_POST['CorpTicker']);
	$logoURL= $mysqli->real_escape_string ($_POST['LogoURL']);
	$corpURL= $mysqli->real_escape_string ($_POST['CorpURL']);
	$isOpen= $_POST['isOpen'];
	$allowMulti= $_POST['allowMulti'];

	//Pass in the page stylesheet and index menu
	echo 
	("
		<html>
		<head>
		<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\" />
		</head>
		<div class=\"menu\">"
	);
	include 'menu.php';
	echo
	(
		"</div>"
	)

	//We need to build a query, but make sure it doesn't update unless all the required fields are the right length.

	//Check required fields are populated
	if(!strlen($corpname) > 0)
	{
		echo ("You missed some required data, please <a href=\"corpedit.php\">try again</a>.<br />
		Alternatively, return to <a href=\"mycorp.php\">your corp page</a> or the <a href=\"index.php\">main menu</a>."
		);
		die();
	}

	if(!strlen($corptick) > 0)
	{
		echo ("You missed some required data, please <a href=\"corpedit.php\">try again</a>.<br />
		Alternatively, return to <a href=\"mycorp.php\">your corp page</a> or the <a href=\"index.php\">main menu</a>."
		);
		die();
	}

	//Now that's out of the way, it should be easier to just do the updates individually

	if(strcmp($corpname,$row['CorpName']) != 0)
	{
		//check you don't already exist
		$sql = "SELECT * FROM Test_Corporations WHERE CorpName like '" . $corpname . "'";
		$rResult = $mysqli->query($sql);
		if ($mysqli->num_rows($rResult) > 0) 
		{
			//The corp's already registered, so give the user a couple of options on how to proceed
			echo 
			(
			"<p>Your corp is already registered, please choose a different name instead.</p><br />
			<a href=\"corpedit.php\">Edit your Corp</a><br />
			<a href=\"index.php\">Back to Main Menu</a><br />"
			);
		}
		else
			{
			$mysqli->query("UPDATE Test_Corporations
						set CorpName = '" . $corpname ."'
						where CreatorName = '" . $username . "'");

			}
	}
	if(strcmp($corptick,$row['CorpTicker']) != 0)
	{
		$sql2= "SELECT * FROM Test_Corporations WHERE CorpTicker like '" . $corptick . "'";
		$rResult2 = $mysqli->query($sql2);
		if ($mysqli->num_rows($rResult2) > 0) 
		{
			//The corp's already registered, so give the user a couple of options on how to proceed
			echo 
			(
			"<p>Your corp is already registered, please choose a different ticker instead.</p><br />
			<a href=\"corpedit.php\">Edit your Corp</a><br />
			<a href=\"index.php\">Back to Main Menu</a><br />"
			);
		}
		else
			{
			$mysqli->query("UPDATE Test_Corporations
						set CorpTicker = '" . $corptick ."'
						where CreatorName = '" . $username . "'");

			}
	}
	if(strcmp($corpdesc,$row['CorpDesc']) != 0)
	{
		$mysqli->query("UPDATE Test_Corporations
				set CorpDesc = '" . $corpdesc ."'
				where CreatorName = '" . $username . "'");

	}

	if(strcmp($corpURL,$row['CorpURL']) != 0)
	{
	$mysqli->query("UPDATE Test_Corporations
				set CorpURL = '" . $corpURL ."'
				where CreatorName = '" . $username . "'");

	}
	if(strcmp($logoURL,$row['LogoURL']) != 0)
	{
		$mysqli->query("UPDATE Test_Corporations
				set LogoURL = '" . $logoURL ."'
				where CreatorName = '" . $username . "'");

	}

	echo "Edit successful. Return to <a href=\"mycorp.php\">corp page</a> or <a href=\"index.php\">the main page</a>.";
}
else
{
	header( 'Location: /index.php');
}
?>
