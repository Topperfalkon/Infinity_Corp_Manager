<?php
//Load config
include 'config.php';
session_start();

//make sure you're actually logged in
if($_SESSION['login']===1)
{
	//make sure the db is alive
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

	//declare inputs as variables
	$username= mysql_real_escape_string ($_SESSION['username']);
	$corpname= mysql_real_escape_string ($_POST['corpname']);
	$corpdesc= mysql_real_escape_string ($_POST['Desc']);
	$corptick= mysql_real_escape_string ($_POST['ticker']);
	$logoURL= mysql_real_escape_string ($_POST['logoURL']);
	$corpURL= mysql_real_escape_string ($_POST['corpURL']);
	$isOpen= $_POST['isOpen'];
	$allowMulti= $_POST['allowMulti'];
	  
	//select the db
	mysql_select_db($dbname);

	//Check required fields are populated
	if(!strlen($corpname) > 0)
	{
		echo "You missed some required data, please <a href=\"corpreg.php\">try again</a>.";
		die();
	}

	if(!strlen($corptick) > 0)
	{
		echo "You missed some required data, please <a href=\"corpreg.php\">try again</a>.";
		die();
	}

	//check you don't already exist
	$sql = "SELECT * FROM Test_Corporations WHERE CorpName like '" . $corpname . "'";
	$rResult = mysql_query($sql);
	$sqltwo = "SELECT * FROM Test_Corporations WHERE CorpTicker like '" . $corptick . "'";
	$rResulttwo = mysql_query($sqltwo);
	//$sqlthree = "SELECT * FROM Corp_Membership WHERE Username ='" . $username . "' and Allow_Multi = Null"
	if (mysql_num_rows($rResult) > 0) 
	{
		//The corp's already registered, so give the user a couple of options on how to proceed
		echo 
		(
		"<p>Your corp is already registered, please choose a different name instead.</p><br />
		<a href=\"corpreg.php\">Back to Corp Registration</a><br />
		<a href=\"index.php\">Back to Main Menu</a><br />"
		);
	}
	//check you don't already exist

	elseif (mysql_num_rows($rResulttwo) > 0) 
	{
		//die('Your corp is already registered, please choose a different name'); //dying here is awful. I'd rather try and echo to the server instead
		echo 
		(
		"<p>Your corp ticker is already in use. Sorry about that.<br />
		Try another ticker name</p><br />
		<a href=\"corpreg.php\">Back to Corp Registration</a><br />
		<a href=\"index.php\">Back to Main Menu</a><br />"
		);
	}
	//We have to put the users into the database now
	else
	{
		$sqladd="INSERT INTO Test_Corporations (CorpName, CreatorName, IsOpen, CorpTicker, CorpDesc, AllowMulti, CorpURL, Logo)
		VALUES('$corpname','$username','$isOpen','$corptick','$corpdesc','$allowMulti','$corpURL','$logoURL')";

		if (!mysql_query($sqladd))
		{
			die('Error: ' . mysql_error());
		}

		$_SESSION['corpowner']= 1;

		echo 
		(
			"Your corp has now been created.
			<br />
			<p><a href=\"index.php\">Return to main menu</a></p>"
		);
	} 
}
else
{
	header( 'Location: /index.php');
}
?>