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

	//Pass the results into the forms
	echo
	(
	"
	<html>
	<head>
		<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\" />
	</head>
	<iframe src= \"index.php\" width= \"150\" height= \"100%\" align= \"left\" scrolling= \"no\" frameborder=\"0\"></iframe>
	<body>
		<form name=\"input\" action=\"corpeditaction.php\" method=\"post\">
		<table border='1'>
		<tr>
		<th>Ticker</th>
		<td><input type=\"text\" id=\"Textbox\" name=\"CorpTicker\"/ value=\"" . $row['CorpTicker'] . "\" maxlength=\"6\" /></td>
		</tr>
		<tr>
		<th>Logo URL</th>
		<td><input type=\"text\" id=\"Textbox\" name=\"LogoURL\" value=\"" . $row['Logo'] . "\" maxlength=\"255\"/></td>
		</tr>
		<tr>
		<th>Corp Name</th>
		<td><input type=\"text\" id=\"Textbox\" name=\"CorpName\" value=\"" . $row['CorpName'] . "\" maxlength=\"255\" /></td>
		</tr>
		<tr>
		<th>Description</th>
		<td><textarea name=\"Desc\" cols=\"40\" rows=\"7\">" . $row['CorpDesc'] . "</textarea></td>
		</tr>
		<tr>
		<th>Homepage</th>
		<td><input type=\"text\" id=\"Textbox\" name=\"CorpURL\" value=\"" . $row['CorpURL'] . "\" maxlength=\"255\" /></td>
		</tr>"
		);
		
		//check the checkboxes if they were checked originally.
		if($row['AllowMulti'] = "Y")
		{
			echo(
			"<tr>
			<th>Allows Multiclanning?</th>
			<td><input type=\"checkbox\" name=\"allowMulti\" value=\"Y\" checked=\"checked\" />(MUST be checked to continue to display as allowing Multiclanning)</td>
			</tr>"
			);
		}
		else echo(
		"<tr>
		<th>Allows Multiclanning?</th>
		<td><input type=\"checkbox\" name=\"allowMulti\" value=\"Y\" />(MUST be checked to continue to display as allowing Multiclanning)</td>
		</tr>"
		);
		
		if($row['IsOpen'] = "Y")
		{
			echo(
			"<tr>	
			<th>Recruiting?</th>
			<td><input type=\"checkbox\" name=\"isOpen\" value=\"Y\" checked=\"checked\" /> (MUST be checked to continue to display as Recruiting)</td>
			</tr>"
			);
		}
		else echo(
		"<tr>	
		<th>Recruiting?</th>
		<td><input type=\"checkbox\" name=\"isOpen\" value=\"Y\" /> (MUST be checked to continue to display as Recruiting)</td>
		</tr>"
		);
		
		echo(
		"</table>
		<input type=\"submit\" value=\"Edit\" />
		</form>
		<br />
		<a href=mycorp.php>Cancel and return to corp page</a><br />
		<a href=index.php>Return to Main Page</a>
		</body>
		</html>"
	);
}
else
{
	//go to index
	header( 'Location: http://test.phoeniximperium.org/index.php');
}
?>