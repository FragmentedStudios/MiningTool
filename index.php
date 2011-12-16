<?php
/**
*
* @package 
* @version 0.1
* @copyright (c) 2011 Fragmented Studios
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

//Don't touch any of this, things will break if you do
define('IS_LEGIT', true);
include('config.php');
include('includes/session.php');
include('includes/igb.php');

?>
<html>
	<head>
	<script src="js/login.js"></script>
		<title>
			TnH Industries Mining Tool - v0.1
		</title>
	</head>
	<body>
		<table>
			<tr>
				<th colspan="2">TnH Industries Mining Tool - v0.1</th>
			</tr>
		</table>
	<form action="javascript:login()" method="post">
		<input name="userName" type="text" id="usernameLogin" value=""/>
		<input name="password" type="password" id="passwordLogin" value=""/>
		<input type="submit" name="Submit" value="Login"/>
	</form>
	<div id="loginResponse"></div>
	</body>

<?

//Check if the user is logged in


/* if ($session->logged_in)
{
	//Check the IGB settings
	if ($igb->no_igb == 0)
	{
		//If IGB headers are not present, return an error to the user
		if ($igb->checkIGB == 0)
		{
			echo("<tr><td colspan=2 align=center>This is can only be accessed from the EVE In-Game Browser.</td></tr>");
		}
		//If IGB headers are present but site is not trusted, return an error to use
		else if ($igb->checkIGB == 1)
		{
			echo("<tr><td colspan=2 align=center>Please add this site your \"trusted sites\" list to continue.</td></tr>");
		}
		//As long as IGB headers are alright, go ahead and display the page to the user
		else if ($igb->checkIGB == 2)
		{
			include("dashboard.php");
		}
		//If IGB headers are present, but the status remains unknown, return an error to the user
		else
		{
			echo("<tr><td colspan=2 align=center>Something went terribly wrong, try clearing the game cache or contacting your CEO.</td></tr>");
		}
	}
	else
	{
		//Output the page regardless of the IGB header settings
		include("dashboard.php");
	} */
include("dashboard.php");

?>