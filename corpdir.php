<?php
/************************************************
*	Infinity Corp Manager Index Page
*	
*	Created by Harley Faggetter
*
*
*
*************************************************/
//Load config
include 'config.php';

//start the session
session_start();
//make sure the db is alive
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

//select the db
mysql_select_db($dbname);

//Get a db query  
$result = mysql_query("SELECT * FROM Test_Corporations");

//Put in a decent header
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
("
	</div>
	<div class=\"main\"><br /><h1>Corp Directory</h1><br />
");

//print it in a HTML table
echo 
("
	<table border='1' class=\"directory\">
	<tr>
	<th>Ticker</th>
	<th>Corporation Name</th>
	<th>Creator</th>
	<th>Recruiting?</th>
	<th>Allow Multi-Clanning?</th>
	<th>Homepage URL</th>
	</tr>
)";

//pass the values into an array loop
while($row = mysql_fetch_array($result))
{
	echo "<tr>";
	echo "<td>" . $row['CorpTicker'] . "</td>";
	echo "<td><a href=\"corpdetails.php?corpid=" . $row['Corp_Id'] ."\">" . $row['CorpName'] . "</a></td>";
	echo "<td>" . $row['CreatorName'] . "</td>";
	echo "<td>" . $row['IsOpen'] . "</td>";
	echo "<td>" . $row['AllowMulti'] . "</td>";
	echo "<td><a href=\"". $row['CorpURL'] ."\">" . $row['CorpURL'] . "</a></td>";
	echo "</tr>";
}
echo "</table>";

//Let people go back the nice way if they haven't found what they're looking for
echo "<br /><br /><p class=\"dirhp\"><a href=\"index.php\">Return to Main Page</a></p></html></div>";

//Don't need the db connection any more, so close it.
mysql_close($con); 
?>
