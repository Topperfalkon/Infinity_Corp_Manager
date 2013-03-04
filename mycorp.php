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

	//select the db
	mysql_select_db($dbname);

	$user= $_SESSION['username'];

	//Get a db query  
	$result = mysql_query("SELECT * FROM Test_Corporations WHERE CreatorName = \"" . $user . "\"");

	//Get the results
	$row = mysql_fetch_array($result);

	if(strlen($row['CorpTicker']) > 0)
	{
		//Change the checkbox output to something easier on the eye
		if($row['AllowMulti'] = "Y")
		{
			$allowMulti = "Yes";
		}
		else
		{
			$allowMulti = "No";
		}

		if($row['IsOpen'] = "Y")
		{
			$isOpen = "Yes";
		}
		else
		{
			$isOpen = "No";
		}

		//pass back the record in a formatted table
		echo
		(
			"
			<html>
			<head>
			<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\" />
			</head>
			<!-- <iframe src= \"index.php\" width= \"150\" height= \"100%\" align= \"left\" scrolling= \"no\" frameborder=\"0\"></iframe> -->
			<body>
			<div class=\"menu\">
		");
		include "menu.php";
		echo
		("
			</div>
			<div class=\"main\">
			<table border='1'>
			<tr>
			<th>Ticker</th>
			<td>" . $row['CorpTicker'] . "</td>
			</tr>
			<tr>
			<th>Logo</th>
			<td><img src=\"" . $row['Logo'] . "\" width=\"256\" height=\"256\" /></td>
			</tr>
			<tr>
			<th>Corp Name</th>
			<td>" . $row['CorpName'] . "</td>
			</tr>
			<tr>
			<th>Description</th>
			<td>" . $row['CorpDesc'] . "</td>
			</tr>
			<tr>
			<th>Homepage</th>
			<td><a href=\"" . $row['CorpURL'] . "\">" . $row['CorpURL'] . "</td>
			</tr>
			<tr>
			<th>Allows Multiclanning?</th>
			<td>" . $allowMulti . "</td>
			</tr>
			<tr>
			<th>Recruiting?</th>
			<td>" . $isOpen . "</td>
			</tr>
			</table>"
		);

		echo 
		(
			"<br />
			<form name=\"input\" action=\"corpedit.php\" method=\"link\">
			<input type=\"submit\" value=\"Edit\" />
			</form>"
		);
		//TO DO: add an edit option here

		//When users are done, they'll want a simple route back to the main page
		echo "<br /><br />Return to <a href=\"index.php\">Main Page</a></body></html>";
	}

	else
	{
		echo "You don't appear to own a corp. Please go to <a href=\"corpreg.html\">the corp registration page.</a><br />";
		echo $validate;
		die();
	}
}
else
{
	header( 'Location: /index.php');
}
?>