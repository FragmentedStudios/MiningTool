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
<?php

include('login.php');
//Check if the user is logged in

// if the user wants IGB only, no_igb will equal 0
if ($igb->no_igb == 0)
{

	// use the checkIGB method to find out if we have all we need
	switch($igb->checkIGB()){
		// not an eve igb
		case 0:
			echo("<tr><td colspan=2 align=center>This is can only be accessed from the EVE In-Game Browser.</td></tr>");
			break;
		// eve igb is present, but our site isn't trusted
		case 1:
			echo("<tr><td colspan=2 align=center>Please add this site your \"trusted sites\" list to continue.</td></tr>");
			break;	
		// eve igb is present, and we are trusted		
		case 2:
			// everything is good. Need to check for log in;
			if ($session->logged_in){
				include("dashboard.php");
			}
			break;
		// catastrophe
		default:
			echo("<tr><td colspan=2 align=center>Something went terribly wrong, try clearing the game cache or contacting your CEO.</td></tr>");
			break;
	}
}
// we don't care if it is the IGB or not; everyone is allowed to view it
else
{
	//Output the page regardless of the IGB header settings
	if($session->logged_in){
		include("dashboard.php");
	}
}


?>