<?php

//Import functions for database, language and header handling.
require_once('includes/database.php');
require_once('includes/language.php');
require_once('includes/headers.php');

//Check the user is logged in
require_once('includes/session.php');

//Output the relevant page information to the user
include('includes/page_header.php');

//Check what the user is here to do
if($page == 'login')
{
	//Start the output of the login page if the user is here to log in.
	echo('<center>' . $login_en . '<br /><br />');
	
	//Check for IGB and fill in username value if present
	if($trusted == 1}
	{
		echo('<form action="login.php" method="post">' . $uname_en . ': <input type="text" name="uname" readonly="readonly"> ' . $pwd_en . '<input type="text" name="pwd"><br /><input type="submit" value="Log In">');
	}
	else
	{
		echo('<form action="login.php" method="post">' . $uname_en . ': <input type="text" name="uname"> ' . $pwd_en . '<input type="text" name="pwd"><br /><input type="submit" value="Log In">');
	}

//Output the footer information
include('includes/page_footer.php');

?>