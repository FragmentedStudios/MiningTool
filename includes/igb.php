<?php
/**
*
* IGB Header Check
*
* @package 
* @version 0.1
* @copyright (c) 2011 Fragmented Studios
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

//DO NOT EDIT THESE LINES
if (!defined('IS_LEGIT'))
{
	exit;
}

//Setup the IGB handling system
class IGB
{
	
	//Define global vars to be set by the functions
	var $no_igb, $trusted;
		
	function IGB()
	{
		//Define the IGB indentifying header
		$this->trusted = $_SERVER['HTTP_EVE_TRUSTED'];
		
		//Check the user's settings to see if NoIGB logins are allowed
		include('config.php');
		$this->no_igb = $no_igb_allowed;
	}
	
	//Check to see if IGB headers are present
	function checkIGB()
	{
		//Check to see if IGB is required for access
		if ($this->no_igb == 0)
		{
			
			switch ($this->trusted){
				case "":
					return 0; // doesn't exist. says so in browser
				case "No":
					return 1; // igb used, but not trusted.
				case "Yes":
					return 2; // igb used and trusted
			}
		}
		else // the in game browser isnt' required. 
		{
			switch ($this->trusted){
				case "Yes":
					return 2; // they are using igb and have headers for us to gather
				default: // anything other than a 'yes' in the trusted field returns 0
					return 0;
			}
		}
	}
	
	//Gather IGB information on the connected user
	function getIGBInfo()
	{
		//Gather the IGB Headers for the user
		$character = $_SERVER['HTTP_EVE_CHARNAME'];
		$regionid = $_SERVER['HTTP_EVE_REGIONID'];
		$constid = $_SERVER['HTTP_EVE_CONSTELLATIONID'];
		$solarid = $_SERVER['HTTP_EVE_SOLARSYSTEMID'];
		$shipid = $_SERVER['HTTP_EVE_SHIPID'];
		$corp = $_SERVER['HTTP_EVE_CORPNAME'];
		$corprole = $_SERVER['HTTP_EVE_CORPROLE'];
		
		//Assign the IGB information to an array
		$igb_headers = array(	'char' => '$character',
								'region' => '$regionid',
								'const' => '$constid',
								'solar' => '$solarid',
								'ship' => '$shipid',
								'corp' => '$corp',
								'corpr' => '$corprole');								
		//Return the array as the value of the function
		return $igb_headers;
	}
}

//Activate the class
$igb = new IGB;

?>	