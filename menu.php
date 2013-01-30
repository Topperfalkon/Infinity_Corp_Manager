<?php 
echo
	(
	"<html>
	<head>
	<link rel=\"stylesheet\" type=\"text/css\" href=\"test.css\" />
	</head>
	<body>
	<p>Welcome " . $_SESSION['username'] . "<br />"
	);

if($_SESSION['corpowner']===1)
	{
	echo "<p><a href=\"mycorp.php\" target=\"_top\">My Corp</a><br />";
	}	
elseif($_SESSION['corpowner']!=1)
	{	
	echo "<p><a href=\"corpreg.php\" target=\"_top\">Corp Registration</a><br />";
	}
echo
	(
	"<p><a href=\"corpdir.php\" target=\"_top\">Corp Directory</a><br />
	<p><a href=\"logout.php\" target=\"_top\">Logout</a></p>
	</body>
	</html>"	
	);
?>