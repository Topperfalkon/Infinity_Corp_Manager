<?php
session_start();

//make sure you're actually logged out
if($_SESSION['login']===1)
{
	header( 'Location: http://test.phoeniximperium.org/index.php');
}

else
{
	//make sure the db is alive
	$con = mysql_connect("db405409244.db.1and1.com","dbo405409244","testpass");
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
		mysql_select_db("db405409244", $con);
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
			
			//Now we can log them in
			//$_SESSION['login']=1;
			//$_SESSION['username']=$_POST['user'];
			//header( 'Location: http://test.phoeniximperium.org/index.php'); //This returns us back to the default page with session details
			header("Location: http://test.phoeniximperium.org/vemail.php?user=" . $username);
			
			//Send a verification email
			/*$headers = "From: topperfalkon@phoeniximperium.org\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message = 
			"Welcome to the Infinity Corporation Manager.\n
			Please <a href=\"http://test.phoeniximperium.org/verify.php?user=" . $username . "&verified=y\"> click here</a> to finish verification.";
			mail($email,"Verify your email address for the Infinity Corporation Manager",$message,$headers);
			echo 
			(
			"A verification email has been sent to your email address. Please open it and follow the link to verify your account.<br />
			<a href=\"index.php\">Click here to return to login page"
			);*/
		}
	}
}
?>