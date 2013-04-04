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
	
	$username= trim(mysql_real_escape_string($_POST['user']));
	
	//Checks for required fields

	if(!$username || !$_POST['passone'] || !$_POST['passtwo'])
	{
		die ("You missed some required data, please <a href=\"registerform.php\">try again</a>.");
	}
	if ($_POST['passone'] !== $_POST['passtwo'])
	{
		die ("The two passwords you entered did not match, please <a href=\"registerform.php\">try again</a>.");
	}
	//declare variables
	
	$pass=crypt($_POST["passone"],'$1$test12345678$'); // MD5 is rubbish. Use BCrypt.
	$email= trim(mysql_real_escape_string($_POST['email']));
	$canEmail=$_POST['canEmail'];
	
	//select the db
	mysql_select_db($dbname);
	//echo "PLACEHOLDER TEXT";
	//whilst the register step comes up because your user isn't on the system, make sure the user they're registering also isn't on the system either.
	$rResult = mysql_query("SELECT * FROM test_users WHERE UserName like '{$username}'");
	if (mysql_num_rows($rResult) > 0)
	//If the user already exists, the best option is to punt them back to the login page as punishment for doing it wrong or allow them to attempt to register again as a unique user
	{
		die ("This user already exists. Please <a href=\"index.php\">log in</a> or <a href=\"registerform.php\">try again.</a>");
	else
	{
		//All good, now to add the new user to the database
		$sqladd="INSERT INTO test_users (UserName, Password, Email, CanEmail)
		VALUES('$username','$pass','$email','$canEmail')";

		if (!mysql_query($sqladd))
		{
			die('Error: ' . mysql_error());
		}
		
		//Push them to the verification page
		header("Location: /vemail.php?user=" . $username);
	}
	}
}
?>
