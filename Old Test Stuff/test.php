<html>
<body>

<?php

//PHP Sandbox

//Basic declared variables
$txt="Hello World!";
$x=16;
//This one returns the three letters of the day of the week, but presumably can do the full date spectrum
$d=date("D");

//echo $d;

//decided to try a switch statement for the first time, ifelse is easy. 
//This was a bugger, but eventually worked

//This switch statement will check the date, then issue a response accordingly.
//It's important to escape a case properly, or the code will simply loop through all cases.
switch ($d)
{
case Mon:
	echo $txt . " Today is Monday.<br />";
	break;
case Tue:
	echo $txt . " Today is Tuesday.<br />";
	break;
case Wed:
	echo $txt . " Today is Wednesday.<br />";
	break;
case Thu:
	echo $txt . " Today is Thursday.<br />";
	break;
case Fri:
	echo $txt . " Today is Friday.<br />";
	break;
default:
	echo $txt . " Take a nap, it's the weekend.<br />";
	break;
}

//Time to practice looping for the hell of it.

while ($x>=10)
	{
	echo "<br /> The current number is " . $x . ". You plonker.";
	$x--;
	}


/*An interesting feature is the ability to declare functions and call them at a later date.
These perform a function similar to namespaces in .NET code in that they allow you to define
a common block of code and repeatedly call it.

So for instance:

function fooBar()
{
echo "foobar.";
}
echo "A common garbage word to denote an example is ";
fooBar();

The result is understandable

You can also add parameters...

function myCats($catName)
{
echo $catName . " ";
}

echo "I have two cats, called ";
myCats("Dennis");
echo "and ";
myCats("Dino");
echo "and I love them very much";

So that should return: "I have two cats, called Dennis and Dino and I love them very much"
Aww...
So I'll find a use for that somewhere.
*/

//Put in a couple of line breaks to make things tidy
echo "<br /><br />";

//Some time experiments
$tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
echo "Tomorrow is ".date("d/m/Y", $tomorrow);

?>

</body>
</html> 