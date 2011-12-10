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

//Check for IGB headers
if($trusted == 1)
{
	//If IGB is present, output the registration form
	echo($uname_en . '<center><form action="newuser.php" method="post">: <input type="text" name="uname" readonly="readonly"><br />' .
	. $pwd_en . ': <input type="text" name="pwd"><br />' .
	. $email_en . ': <input type="text" name="email"><br />' .
	. '<a href="placeholder for API URL">' . $api_en . ': <input type="text" name="api">' .
	. '<input type="submit" value="Register"></form>');
}
else if($trusted == 0)
{
	//If IGB is present, but not trusted alert the user that trust is required
	echo('<center>' . $untrusted_en . '</center>');
}
else
{
	//If IGB is not present, alert the user they must use the IGB
	echo('<center>' . $oog_en . '</center>');
}