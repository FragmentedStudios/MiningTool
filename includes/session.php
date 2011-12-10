<?php

//Check that the user is logged in
session_start();
if(isset($_SESSION['id']))
{
	//If user is not logged in, check if they here to log in.
	$page = $_GET['go'];
	if($page == 'login')
	{
		//If they are here to log in, do nothing
	}
	else
	{
		//If they are not here to log in, send them to log in.
		header("Location: index.php?go=login");
	}
}