<html>
<body>

<form action="welcome2.php" method="post">
Name: <input type="text" name="fname" />
Age: <input type="text" name="age" />
<input type="submit" />
</form>

Welcome <?php echo $_POST["fname"];?>!<br />

<?php
if ($_POST["age"]="")
echo "That is not a valid age!";
elseif ($_POST["age"]<=16)
echo "Shouldn't you be in school?";
else echo "You are" . $_POST["age"] . "years old.";
?>

</body>
</html> 