<?php
/**
*
* dashboard.php
*
* @package 
* @version 0.1
* @copyright (c) 2011 Fragmented Studios
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

//DO NOT EDIT THESE LINES
if (!defined('IS_LEGIT')
{
	exit;
}

//Check for IGB headers to wrap data from
if ($igb->checkIGB == 1)
{
	$charname = $igb->getIGBInfo['char'];
	$corpname = $igb->getIGBInfo['corp'];
	$corprole = $igb->getIGBInfo['corpr'];
	$region = $igb->getIGBInfo['region'];
	$const = $igb->getIGBInfo['const'];
	$solar = $igb->getIGBInfo['solar'];
	$ship = $igb->getIGBInfo['ship'];
}

//Start the output of the page
