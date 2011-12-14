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

//Our includes, pretty standard at this point
include('database.php');
include('mailer.php');
include('form.php');
include('language/en/common.php');

//Start the class to contain our Session functions
class Session
{
	//Define the variables to be used by Session
	var $username;
	var $userid;
	var $time;
	var $logged_in;
	var $userinfo = array();
	
	//Class constructor
	function Session()
	{
		$this->time = time();
		$this->startSession();
	}
	
	//Perfoms all the actions necessary to check if the user is logged in, and log them in
	function startSession()
	{
		//Establish database connections
		global $database;
		
		//Start the sessions
		session_start();
		
		//Check if the user is logged in
		$this->logged_in = $this->checkLogin();
	}
	
	//Check if the user is already logged in
	function checkLogin()
	{
		//Establish database connections
		global $database;
		
		//Cookies?
		if (isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'))
		{
			//If cookies are present, start the session for the user
			$this->username = $_SESSION['username'] = $_COOKIE['cookname'];
			$this->userid = $_SESSION['userid'] = $_COOKIE['cookid'];
		}
		
		//Verify username and ID match the database
		if (isset($_SESSION['username']) && isset ($_SESSION['userid']))
		{
			if($database->confirmUserID($_SESSION['username'], $_SESSION['userid']) != 0)
			{
				//Variables are incorrect, user is not logged in
				unset($_SESSION['username'];
				unset($_SESSION['userid'];
				return false;
			}
			
			//User is logged in, set class variables
			$this->userinfo = $database->getUserInfo($_SESSION['username'];
			$this->username = $this->userinfo['username'];
			$this->userid = $this->userinfo['userid'];
			return true;
		}
		else
		{
			//User is not logged in
			return false;
		}
	}
	
	//Log the user in
	function login($subuser, $subpass, $subremember)
	{
		//Establish database connection and gather form objects
		global $database, $form;
		
		//Username error checking
		$field = "user";
		if (!$subuser || strlen($subuser = trim($subuser)) == 0)
		{
			$form->setError($field, 'NO_USERNAME');
		}
		
		//Password error checking
		$field = "pass";
		if (!$subpass)
		{
			$form->setError($field, 'NO_PASSWORD')
		}
		
		//Return if form errors exist
		if ($form->num_errors > 0)
		{
			return false;
		}
		
		//Check that the username and password match in the DB
		$subuser = stripslashes($subuser);
		$result = $database->confirmUserPass($subuser, crypt($subpass));
		
		//Check error codes
		if ($result == 1)
		{
			$field = "user";
			$form->setError($field, 'BAD_USERNAME');
		}
		else if ($result == 2)
		{
			$field = "pass"l
			$form->setError($field, 'BAD_PASSWORD');
		}
		
		//Return if form errors exist
		if ($form->num_errors > 0)
		{
			return false;
		}
		
		//Username and password are correct, register session variables
		$this->userinfo = $database->getUserInfo($subuser);
		$this->username = $database->$_SESSION['username'] = $this->userinfo['username'];
		$this->userid = $database->$_SESSION['userid'] = $this->userinfo['userid'];
		
		//If the user has requested we remember them, set the cookies
		if ($subremember)
		{
			setcookie("cookname", $this->username, time()+COOKIE_EXPIRE, COOKIE_PATH);
			setcookie("cookid", $this->userid, time()+COOKIE_EXPIRE, COOKIE_PATH);
		}
		
		//Login completed successfully
		return true;
	}
	
	//Time to handle the logout functions
	function logout()
	{
		//Delete cookies, since the user wants to log out
		if (isset($_COOKIE['cookname']) && isset($_COOKIE['cookid']))
		{
			setcookie("cookname", "", time()-COOKIE_EXPIRE, COOKIE_PATH);
			setcookie("cookid", "", time()-COOKIE_EXPIRE, COOKIE_PATH);
		}
		
		//Unset PHP session variables
		unset($_SESSION['username']);
		unset($_SESSION['userid']);
		
		//Reflect that the user has logged out
		$this->logged_in = false;
	}
	
	//A new user, lets get them registered!
	function register($subuser, $subpass, $subemail, $subapi_key, $subapi_mask)
	{
		//Load database, form and mailer objects
		global $database, $form, $mailer;
		
		//Check for a legitimate username
		$field = "user"
		if (!$subuser || strlen($subuser = trim($subuser)) == 0)
		{
			$form->setError($field, 'NO_USERNAME');
		}
		else
		{
			//Clean up the username
			$subuser = stripslashes($subuser);
			
			//Check if the username is already in use
			if ($database->usernameTaken($subuser))
			{
				$form->setError($form, 'USERNAME_TAKEN');
			}
			else if ($database->usernameBanned($subuser))
			{
				$form->setError($form, 'USER_BANNED');
			}
		}
		
		//Check the user's password
		$field = "pass";
		if (!$subpass)
		{
			$form->setError($field, 'NO_PASSWORD');
		}
		else
		{
			//Clean up password and check the length
			$subpass = stripslashes($subpass);
			if (strlen($subpass) < 4)
			{
				$form->setError($form, 'PASSWORD_SHORT');
			}
			else if (!eregi("^([0-9a-z])+$", ($subpass = trim($subpass))))
			{
				$form->setError($form, 'PASSWORD_ILLEGAL');
			}
		}
		
		//Check the email for format and legality
		$field = "email";
		if (!$subemail || strlen($subemail = trim($subemail)) == 0)
		{
			$form->setError($form, 'NO_EMAIL');
		}
		else
		{
			//Check if the email is valid
			$regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{1,})*\.([a-z]{2,}){1}$";
			if (!eregi($regex,$subemail))
			{
				$form->setError($field, 'BAD_EMAIL');
			}
			$subemail = stripslashes($subemail);
		}
		
		//Errors exist, have the user correct them
		if ($form->num_errors > 0)
		{
			return 1;
		}
		else
		{
			//No errors, commit the new account
			if ($database->addNewUser($subuser, crypt($subpass), $subemail))
			{
				//Check if emails are to be sent on successful registration
				if (EMAIL_WELCOME)
				{
					$mailer->sendWelcome($subuser, $subemail, $subpass);
				}
				//Registration attempt successful?
				return 0;
			}
			else
			{
				//Registration attempt failed?
				return 2;
			}
		}
	}
	
	//Edit the user's account information
	function editAccount($subcurpass, $subnewpass, $subemail, $subapi_key, $subapi_mask)
	{
		//Get database and form objects
		global $database, $form;
		
		//Check if the user is trying to change their password
		if ($subnewpass)
		{
			//Check that they entered their current password
			$field = "curpass";
			if (!$subcurpass)
			{
				$form->setError($form, 'NO_CUR_PASSWORD');
			}
			else
			{
				//Check the current password given is correct
				if ($database->confirmUserPass($this->username, crypt($subcurpass)) != 0)
				{
					$form->setError($form, 'BAD_CUR_PASSWORD');
				}
			}
			
			//Check the new password for errors
			$field = "newpass";
			
			//Clean up the password and check length
			$subpass = stripslashes($subnewpass);
			if (strlen($subnewpass) < 4)
			{
				$form->setError($form, 'NEW_PASS_SHORT');
			}
			else if ((!eregi("^([0-9a-z])+$", ($subnewpass = trim($subnewpass))))
			{
				$form->setError($form, 'NEW_PASS_ILLEGAL;);
			}
		}
		else if ($subcurpass)
		{
			$field = "newpass";
			$form->setError($field, 'NO_NEW_PASS');
		}
		
		//Check email address for errors
		$field = "email";
		if ($subemail && strlen($subemail = trim($subemail)) > 0)
		{
			$regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{1,})*\.([a-z]{2,}){1}$";
			if (!eregi($regex, $subemail)
			{
				$form->setError($form, 'BAD_EMAIL');
			}
			$subemail = stripslashes($subemail);
		}
		
		//Errors exist, have user fix them
		if ($form->num_errors > 0)
		{
			return false;
		}
		
		//Update password since there were no errors
		if ($subcurpass && $subnewpass)
		{
			$database->updateUserField($this->username, "email", $subemail);
		}
		
		//It worked!
		return true;
	}
	
	//Random string generator
	function generateRandStr
	{
		$randstr = "";
		for ($i=0; $i<$length, $i++)
		{
			$randnum = mt_rand(0,61);
			if ($randnum < 10)
			{
				$randstr .= chr(randnum+48);
			}
			else if ($randnum <36)
			{
				$randstr .= chr(randnum+55);
			}
			else
			{
				$randstr .= chr(randnum+61);
			}
		}
		
		return $randstr;
	}
};

//Initialize the session object
$session = new Session;

//Initialize the form object
$form = new Form;

?>