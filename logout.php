<?php
session_start();

//remove all the variables in the session 
//session_unset(); 
$_SESSION = array();
// destroy the session 
session_destroy(); 

//test stuff
//$session=isset($_SESSION['login']);
//echo $session;
header( 'Location: http://test.phoeniximperium.org/index.php');
?>