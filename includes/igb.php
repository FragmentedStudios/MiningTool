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
	var $no_igb;
		
	function IGB()
	{
		//Define the IGB indentifying header
		$trusted = $_SERVER['HTTP_EVE_TRUSTED'];
		
		//Check the user's settings to see if NoIGB logins are allowed
		include('config.php');
		$this->no_igb = $no_igb_allowed;
	}
	
	//Check to see if IGB headers are present
	function checkIGB($no_igb)
	{
		//Check to see if IGB is required for access
		if ($no_igb == 0)
		{
			//If IGB is required, check if present
			if (!$trusted)
			{
				//If no IGB headers present, return an error
				return 0;
			}
			else if ($trusted == 0)
			{
				//If IGB is present, but site is not trustd, return an error
				return 1;
			}
			else if ($trusted == 1)
			{
				//If IGB is present and trusted, return no errors and allow user to continue
				return 2;
			}
			else
			{
				//If IGB is present, but is an invalid value return an error
				return 3;
			}
		}
		else
		{
			//Check to see if IGB is present
			if (!trusted)
			{
				//If IGB is not present, don't look for header info but let user pass
				return 0;
			}
			else if ($trusted == 1)
			{
				//If IGB is present and trusted, allow the user to pass and gather header info
				return 1;
			}
			else
			{
				//If IGB is present, but status unknown let the user pass but don't 
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
$IGB = new IGB;

?>	