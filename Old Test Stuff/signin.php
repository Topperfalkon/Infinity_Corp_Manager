<?php 
//create a session
session_start();
//make sure the db is alive
$con = mysql_connect("db405409244.db.1and1.com","dbo405409244","testpass");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

//declare variables from form
$user = mysql_real_escape_string($_POST['user']);  //sanitising the input to protect db integrity
$pass = crypt($_POST["loginP"],'$1$test12345678$'); //yummy, encryption so that people don't leave plaintext passwords in the db (and for a bonus sanitises them too!)

mysql_select_db("db405409244", $con); //I could kill the script if it fails to return the database, but I assume it's there because we've successfully connected to the server.
$sql = "SELECT Password FROM test_users WHERE UserName = '" . $user . "'";

$query = mysql_query($sql);
$row = mysql_fetch_array($query); //stupidly you still need to get the row from that query.
$passcomp = $row['Password']; //but having fetched an array of the rows, you can specify the password from the array and pass it into a variable
$comp=strcmp($pass,$passcomp); //compare the two strings
if($comp !== 0) //path to execute code if strings are not identical
	{
	die ('Credentials invalid');
	}
//echo "You are now signed in!";

//Session stuff here

$_SESSION['login']=1;
$_SESSION['username']=$_POST['user'];

header( 'Location: http://test.phoeniximperium.org/default.php'); //This returns us back to the default page with session details

?>
