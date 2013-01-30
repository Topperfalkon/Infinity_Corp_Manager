<html>
<body>
<?php
//make sure the db is alive
$con = mysql_connect("db405409244.db.1and1.com","dbo405409244","testpass");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  
//declare variables from form
$user = mysql_real_escape_string($_POST['user']);  //sanitising the input to protect db integrity
$pass=crypt($_POST["loginP"],'$1$test12345678$'); //yummy, encryption so that people don't leave plaintext passwords in the db (and for a bonus sanitises them too!)
  
//select the db
mysql_select_db("db405409244", $con);

//check you don't already exist
$sql = "SELECT * FROM test_users WHERE UserName like '" . $user . "'";
$rResult = mysql_query($sql);
if (mysql_num_rows($rResult) > 0) {
    die('You are already registered, please sign in instead!');
}

//We have to put the users into the database now
else
{
$sqladd="INSERT INTO test_users (UserName, Password)
VALUES('$user','$pass')";

if (!mysql_query($sqladd,$con))
  {
  die('Error: ' . mysql_error());
  }
echo 
(
"You are now registered.
<p><a href=\"default.php\">Return to Main Page</a></p>"
);
} 

?>
</body>
</html>