<?php
//Load config
include 'config.php';

session_start();

//make sure you're actually logged out
if($_SESSION['login']===1)
{
	header( 'Location: /index.php');
}

else
{
	//make sure the db is alive
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	//declare variables

	$username= trim(mysql_real_escape_string($_POST['user']));
	$passone=crypt($_POST["passone"],'$1$test12345678$');
	$passtwo=crypt($_POST["passtwo"],'$1$test12345678$');
	$email= trim(mysql_real_escape_string($_POST['email']));
	$canEmail=$_POST['canEmail'];

	//echo $canEmail;

	//Checks for required fields

	if(!strlen($username) > 0)
	{
		echo "You missed some required data, please <a href=\"registerform.php\">try again</a>.";
		die();
	}

	if(!strlen($_POST["passone"]) > 0)
	{
		echo "You missed some required data, please <a href=\"registerform.php\">try again</a>.";
		die();
	}

	if(!strlen($_POST["passtwo"]) > 0)
	{
		echo "You missed some required data, please <a href=\"registerform.php\">try again</a>.";
		die();
	}

	//Check the two passwords are the same

	$passcomp=strcmp($passone , $passtwo);

	//failure path
	if ($passcomp != 0)
	{
		echo "The two passwords you entered did not match, please <a href=\"registerform.php\">try again</a>.";
	}
	//success path
	else
	{
		//select the db
		mysql_select_db($dbname, $con);
		//echo "PLACEHOLDER TEXT";
		//whilst the register step comes up because your user isn't on the system, make sure the user they're registering also isn't on the system either.
		$sql = "SELECT * FROM test_users WHERE UserName like '" . $username . "'";
		$rResult = mysql_query($sql);
		if (mysql_num_rows($rResult) > 0)
		//If the user already exists, the best option is to punt them back to the login page as punishment for doing it wrong or allow them to attempt to register again as a unique user
		{
			echo "This user already exists. Please <a href=\"index.php\">log in</a> or <a href=\"registerform.php\">try again.</a>";
			die();
		}
		else
		{
			//All good, now to add the new user to the database
			$sqladd="INSERT INTO test_users (UserName, Password, Email, CanEmail)
			VALUES('$username','$passone','$email','$canEmail')";

			if (!mysql_query($sqladd,$con))
			{
				die('Error: ' . mysql_error());
			}
			
			//Push them to the verification page
			header("Location: /vemail.php?user=" . $username);
		}
	}
}
?>