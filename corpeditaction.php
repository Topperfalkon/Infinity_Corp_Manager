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
session_start();

//make sure you're actually logged in
if($_SESSION['login']===1)
{
	//make sure the db is alive
	$con = mysql_connect("db405409244.db.1and1.com","dbo405409244","testpass");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

	//select the db
	mysql_select_db("db405409244", $con);

	$user= $_SESSION['username'];

	//Get a db query  
	$result = mysql_query("SELECT * FROM Test_Corporations WHERE CreatorName = \"" . $user . "\"");

	//Get the results
	$row = mysql_fetch_array($result);

	//declare variables from inputs
	$username= mysql_real_escape_string ($_SESSION['username']);
	$corpname= mysql_real_escape_string ($_POST['CorpName']);
	$corpdesc= mysql_real_escape_string ($_POST['Desc']);
	$corptick= mysql_real_escape_string ($_POST['CorpTicker']);
	$logoURL= mysql_real_escape_string ($_POST['LogoURL']);
	$corpURL= mysql_real_escape_string ($_POST['CorpURL']);
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
		$rResult = mysql_query($sql);
		if (mysql_num_rows($rResult) > 0) 
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
			mysql_query("UPDATE Test_Corporations
						set CorpName = '" . $corpname ."'
						where CreatorName = '" . $username . "'");

			}
	}
	if(strcmp($corptick,$row['CorpTicker']) != 0)
	{
		$sql2= "SELECT * FROM Test_Corporations WHERE CorpTicker like '" . $corptick . "'";
		$rResult2 = mysql_query($sql2);
		if (mysql_num_rows($rResult2) > 0) 
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
			mysql_query("UPDATE Test_Corporations
						set CorpTicker = '" . $corptick ."'
						where CreatorName = '" . $username . "'");

			}
	}
	if(strcmp($corpdesc,$row['CorpDesc']) != 0)
	{
	mysql_query("UPDATE Test_Corporations
				set CorpDesc = '" . $corpdesc ."'
				where CreatorName = '" . $username . "'");

	}

	if(strcmp($corpURL,$row['CorpURL']) != 0)
	{
	mysql_query("UPDATE Test_Corporations
				set CorpURL = '" . $corpURL ."'
				where CreatorName = '" . $username . "'");

	}if(strcmp($logoURL,$row['LogoURL']) != 0)
	{
	mysql_query("UPDATE Test_Corporations
				set LogoURL = '" . $logoURL ."'
				where CreatorName = '" . $username . "'");

	}

	echo "Edit successful. Return to <a href=\"mycorp.php\">corp page</a> or <a href=\"index.php\">the main page</a>.";
}
else
{
	header( 'Location: http://test.phoeniximperium.org/index.php');
}
?>
