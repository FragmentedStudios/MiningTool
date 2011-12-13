<?php
/**
*
* @constants.php
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

//Include the config files
include('config.php');

//Define the database constants
define("DB_SERVER", $dbhname);
define("DB_USER", $dbuname);
define("DB_PASS", $dbpass);
define("DB_NAME", $dbname);

//Define the constants for the EVE Data database
define("EVE_DB_SERVERR", $eve_dbhname);
define("EVE_DB_USER", $eve_dbuname);
define("EVE_DB_PASS", $eve_dbpass);
define("EVE_DB_NAME", $eve_dbname);

//Define all tables used
define("TBL_USERS", $dbprefix . 'users');
define("TBL_OPS", $dbprefix . 'ops');
define("TBL_ACTIVE_USERS", $dbprefix . 'active_users');
define("TBL_ACTIVE_GUESTS", $dbprefix . 'active_guests');
define("TBL_ACTIVE_CANS", $dbprefix . 'active_cans');
define("TBL_ORE_VALUES", $dbprefix . 'ore_values');
define("TBL_BANNED_USERS", $dbprefix . 'banned_users');

//Define email parameters
define("EMAIL_FROM_NAME", $admins_name);
define("EMAIL_FROM_ADDR", $admins_email);
define("EMAIL_WELCOME", $send_email);