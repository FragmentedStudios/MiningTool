<?php
/**
*
* common [English]
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

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

//Define all the phrases used in the tool
$lang = array_merge($lang, array(
	'NO_USERNAME'		=> 'Username not entered',
	'NO_PASSWORD'		=> 'Password not entered',
	'NO_CUR_PASSWORD'	=> 'Current password not entered',
	'NO_NEW_PASSWORD'	=> 'New password not entered',
	'NO_EMAIL'			=> 'E-Mail address not entered',
	'BAD_USERNAME'		=> 'Username not found',
	'BAD_PASSWORD'		=> 'Invalid password',
	'BAD_CUR_PASSWORD'	=> 'Invalid current password',
	'BAD_EMAIL'			=> 'Invalid E-Mail Address',
	'USERNAME_TAKEN'	=> 'Username is already in use',
	'USER_BANNED'		=> 'This username has been banned',
	'PASSWORD_SHORT'	=> 'Password is too short',
	'NEW_PASS_SHORT'	=> 'New password is too short',
	'PASSWORD_ILLEGAL'	=> 'Password contains illegal characters',
	'NEW_PASS_ILLEGAL'	=> 'New password contains illegal characters',
	'UNAME_NO_EXIST'	=> 'Username does not exist'));
?>