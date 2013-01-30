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
//make sure the db is alive
$con = mysql_connect("db405409244.db.1and1.com","dbo405409244","testpass");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

//select the db
mysql_select_db("db405409244", $con);

$corp=$_GET['corpid'];

//Get a db query  
$result = mysql_query("SELECT * FROM Test_Corporations WHERE Corp_Id = " . $corp);

//echo $corp;

//Get the results
$row = mysql_fetch_array($result);

//Change the checkbox output to something easier on the eye
if($row['AllowMulti'] === "Y")
{
	$allowMulti = "Yes";
}
else
{
	$allowMulti = "No";
}

if($row['IsOpen'] === "Y")
{
	$isOpen = "Yes";
}
else
{
	$isOpen = "No";
}

//pass back the record in a formatted table
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
		"</div>
	<body>
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
	<th>Creator</th>
	<td>" . $row['CreatorName'] . "</td>
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
	</table>
	<br />
	<br />
	</body>
	</html>
	"
);

///Include a Join Corp link if the Corp is open for members
if ($isOpen === "Yes")

{
	echo "<a href=\"corpjoin.php?corpid=" . $corp . "\">Click to Join Corp</a>";
}
//TO DO: add a registration option here

//When users are done, they'll want a simple route back to the main page
//echo "<br />" . $row['IsOpen'] . "<br />" . $isOpen;
echo "<br /><br />Return to <a href=\"index.php\">Main Page</a>";

?>
