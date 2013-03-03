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
	mysql_select_db($dbname, $con);

	//declare variables
	$user= $_SESSION['username'];
	$corp= $_GET['corpid'];
	//echo $corp;

	//Get User ID
	$sql = "SELECT User_Id FROM test_users WHERE UserName = '" . $user . "'";

	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	//echo $row['User_Id'];
	$userID= $row['User_Id'];

	//Find out if corp allows multi-clanning
	$sql2 = "SELECT AllowMulti FROM Test_Corporations WHERE Corp_Id = '" . $corp . "'";

	$query2 = mysql_query($sql2);
	$row2 = mysql_fetch_array($query2);
	//echo $row2['AllowMulti'];
	
	//TO DO: Implement multi-clanning functionality
	//Difficult, as it requires fetching Multi-clanning tags for all joined corps.
	
	$sql3 = "SELECT * FROM Corp_Membership WHERE User_Id like '" . $userID . "'";
	$rResult = mysql_query($sql3);
	$row3 = mysql_fetch_array($rResult);
	//echo $row3['Allow_Multi'];
	
	if ($row2['Allow_Multi'] == 'Y')
	{
		if ((($row3['Allow_Multi'] != 'Y') || ($row3['Corp_Id'] == $corp)) && mysql_num_rows($rResult) > 0)
		{
			echo "You can't join a corp that you're already part of or a corp that doesn't allow multi-clanning.<br/>
			<a href=\"corpdetails.php?corpid=" . $corp . "\">Go Back to Previous Page</a>";
			die();
		}
	}
	else
	{
		if (mysql_num_rows($rResult) > 0)
		{
			echo "You can't join a corp that you're already part of or a corp that doesn't allow multi-clanning.<br/>
			<a href=\"corpdetails.php?corpid=" . $corp . "\">Go Back to Previous Page</a>";
			die();
		}
	}
	if ($row2['AllowMulti'] == 'Y')
	{
			$sqladd="INSERT INTO Corp_Membership (User_Id, Corp_Id, Allow_Multi)
			VALUES('$userID','$corp', 'Y')";
	}
	else
	{
			$sqladd="INSERT INTO Corp_Membership (User_Id, Corp_Id)
			VALUES('$userID','$corp')";
	}
	
			if (!mysql_query($sqladd,$con))
			{
			die('Error: ' . mysql_error());
			}
			
	//check the action has worked
	$sqlverify = "SELECT * FROM Corp_Membership WHERE User_Id like '" . $userID . "'";
	$rResult = mysql_query($sqlverify);
	if (mysql_num_rows($rResult) > 0)

	echo 
	(
		"You have successfully joined this corp.<br />
		<a href=\"index.php\">Back to Main Page</a><br />
		<a href=\"corpdetails.php?corpid=" . $corp . "\">Back to Corp Details</a>"
	);
	//echo "PLACEHOLDER";
}
else
{
	echo "Please <a href=\"index.php\">log in</a> to join a corp.";
	die();
}
?>