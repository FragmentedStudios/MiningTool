<?php
/**
*
* @process.php
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

//Call for our session document
include('session.php');

//Create the class to handle the processing
class Process
{
	//Class constructor
	function Process()
	{
		global $session;
		
		//User submitted login form
		if (isset($_POST['sublogin']))
		{
			$this->procLogin();
		}
		//User submitted registration form
		else if (isset($_POST['subjoin']))
		{
			$this->procRegister();
		}
		//User submitted forgot password form
		else if (isset($_POST['subforgot']))
		{
			$this->procForgotPass();
		}
		//User submitted account edit form
		else if (isset($_POST['subedit']))
		{
			$this->procEditAccount();
		}
		//User is logged in, and wants to log out
		else if ($session->logged_in)
		{
			$this->procLogout();
		}
		//Something is wrong here, send the user back to the index
		else
		{
			header("Location: index.php");
		}
	}
	
	//Handle the user login
	function procLogin()
	{
		//Call the global variables
		global $session, $form;
		
		//Login attempt
		$retval = $session->login($_POST['user'], $_POST['pass'], isset($_POST['remember']));
		
		//Login successful
		if ($retval)
		{
			header("Location: index.php");
		}
		//Login failed
		else
		{
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: index.php");
		}
	}
	
	//Handle the user logout
	function procLogout()
	{
		//Call the global variables
		global $session;
		$retval = $session->logout();
		header("Location: index.php");
	}
	
	//Handle new user registration
	function procRegister()
	{
		//Call the global variables
		global $session, $form;
		
		//Registration attempt
		$retval = $session->register($_POST['user'], $_POST['pass'], $_POST['email'], $_POST['api_id'], $_POST['api_mask']);
		
		//Registration successful
		if ($retval == 0)
		{
			$_SESSION['reguname'] = $_POST['user'];
			$_SESSION['regsuccess'] = false;
			header("Location: index.php");
		}
	}
	
	//Handle forgotten password form
	function procForgotPass()
	{
		//Call the global variables
		global $database, $session, $mailer, $form;
		
		//Username error checking
		$subuser = $_POST['user'];
		$field = "user";
		if (!$subuser || strlen($subuser = trim($subuser)) == 0)
		{
			$form->setError($field, 'NO_USERNAME');
		}
		//Make sure username is in database
		else
		{
			$subuser = stripslashes($subuser);
			if (!$database->usernameTaken($subuser))
			{
				$form->setError($field, 'UNAME_NO_EXIST');
			}
		}
		
		//Errors exist, have the user correct them
		if ($form->num_errors > 0)
		{
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
		}
		//Generate new password and email it to user
		else
		{
			//Generate new password
			$newpass = $session->generateRandStr(8);
			
			//Get email of user
			$usrinf = $database->getUserInfo($subuser);
			$email = $usrinf['email'];
			
			//Attempt to send email with new password
			if ($mailer->sendNewPass($subuser, $email, $newpass))
			{
				//Email sent, update the password in the database
				$database->updateUserField($subuser, "password", crypt($newpass));
				$_SESSION['forgotpass'] = true;
			}
			//Email failure, do not change password
			else
			{
				$_SESSION['forgotpass'] = false;
			}
		}
		
		header("Location: index.php");
	}
	
	//Handle editing of user's account
	function procEditAccount()
	{
		//Call global functions
		global $session, $form;
		
		//Account edit attempt
		$retval = $session->editAccount($_POST['curpass'], $_POST['newpass'], $_POST['email'], $_POST['api_id'], $_POST['api_mask']);
		
		//Account edit successful
		if ($retval)
		{
			$_SESSION['useredit']= true;
			header("Location: index.php");
		}
		//Error found with form
		else
		{
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: index.php");
		}
	}
};

//Initialize process
$process = new Process;

?>