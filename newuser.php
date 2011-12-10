<?php

//Import functions for database, language and header handling.
require_once('includes/database.php');
require_once('includes/language.php');
require_once('includes/headers.php');

//Output the header information and website top banner
?>
<html>
	<head>
		<title>
			TnH Industries Mining Tracker - v0.1
		</title>
	</head>
	<center>
		<h2>
			TnH Industries Mining Tracker - v0.1
		</h2>
	</center>
</html>
<?

//Ensure there are no sessions open
session_start();
session_destroy();

//Get data from the form
$username = $_POST['uname'];
$password = $_POST['pwd'];
$email = $_POST['email'];
$api = $_POST['api'];

//Connect to authentication database
$con = mysql_connect($auth_host, $auth_username, $auth_pwd) or die(mysql_error());
$db = mysql_select_db($auth_database, $con) or die(mysql_error());

//Check for existing registration
$sql = 'SELECT * FROM `' . $auth_prefix . 'users` WHERE `name` = $username');
$query  mysql_query($sql);
$rows = mysql_num_rows($query);

if($rows != 0)
{
	echo($existing_en);
}