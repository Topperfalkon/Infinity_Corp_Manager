<?php
//Load config
include 'config.php';

//make sure the db is alive
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
 
$username=$_GET['user'];

//select the db
mysql_select_db($dbname);

//get the email address
$sql = "SELECT Email FROM test_users WHERE UserName = '" . $username . "'";

$query = mysql_query($sql);
$row = mysql_fetch_array($query); 
$email = $row['Email'];


//construct a hash to send as part of the email
$hash=hash('md5',$username . "keelhaul");

//now send the email	Change the address in the message and the first header
$headers = "From: topperfalkon@phoeniximperium.org\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$message = 
"Welcome to the Infinity Corporation Manager.\n
Please <a href=\"http://test.phoeniximperium.org/verify.php?user=" . $username . "&hash=" . $hash . "&verified=y\"> click here</a> to finish verification.";
mail($email,"Verify your email address for the Infinity Corporation Manager",$message,$headers);

//tell the user the email has been sent.
echo 
(
"A verification email has been sent to your email address. Please open it and follow the link to verify your account.<br />
<a href=\"index.php\">Click here to return to login page</a>"
);
?>