<?php
/**
*
* @database.php
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

//Call for our constants
include('constants.php');

//Create the database class
class MySQLDB
{
	var $connection;		//The MySQL Connection
	var $num_active_users;	//Number of users currently logged in
	var $num_member;			//The number of registered users
	
	//Handle the connection to the database
	function MySQLDB()
	{
		$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
		mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());
		
		//Set default value for members until getNumMembers() called for the first time
		$this->num_members = -1;
		if (TRACK_VISITORS)
		{
			//Calculate number of users active
			$this->calcNumActiveUsers();
		}
	}
	
	//Handle the username and password checking
	function confirmUserPass($username, $password)
	{
		if(!get_magic_quotes_gpc())
		{
			$username = addslashes($username);
		}
		
		//Check that the username exists in the database
		$q = "SELECT password FROM " . TBL_USERS. "WHERE username = '$username'";
		$result = mysql_query($q, $this->connection);
		
		if (!$result || (mysql_num_rows($result) < 1))
		{
			return 1; //Returns a username failure
		}
		
		//Retrieve the password for entered username to check
		$dbarray = mysql_fetch_array($result);
		$password = crypt($password);
		
		//Validate that the password is correct
		if ($password == $dbarray['password'])
		{
			return 0; //Username and password came back okay
		}
		else
		{
			return 2; //Password was incorrect
		}
	}
	
	//Check if the username already exists when registerring a new user
	function usernameTaken($username)
	{
		if(!get_magic_quotes_gpc())
		{
			$username = addslashes($username);
		}
		
		//Check the database for the supplied username
		$q = "SELECT * FROM  " . TBL_USERS . " WHERE username = '$username'";
		$result = mysql_query($q, $this->connection);
		return (mysql_num_rows($result) > 0);
	}
	
	//Check if the user has been banned from the system
	function usernameBanned($username)
	{
		if (!get_magic_quotes_gpc())
		{
			$username = addslashes($username);
		}
		
		//Check for the username in the banned users table
		$q = "SELECT * FROM " . TBL_BANNED_USERS . " WHERE username = '$username";
		$result = mysql_query($q, $this->connection);
		return (mysql_num_rows($result) > 0);
	}
	
	//Handle the database insertion of a new user
	function addNewUser($username, $password, $email, $api_id, $api_mask)
	{
		//Get the date the user registered
		$signup = date();
		
		//Insert the data into the table
		$q = "INSERT INTO " . TBL_USERS . " (username, password, email, apiID, apiMask) VALUES ('$username', '$password', '$email', '$apiID', '$apiMask')";
		return mysql_query($q, $this->connection);
	}
	
	//Function for handling the updating of any of the user's information
	function updateUserField($username, $field, $value)
	{
		//Update the information in the table with the new information
		$q = "UPDATE " . TBL_USERS . " SET  " . $field . " = '$value' WHERE username = '$username'";
		return mysql_query($q, $this->connection);
	}
	
	//Return all information on a given username
	function getUserInfo($username)
	{
		//Select the user from the table
		$q = "SELECT * FROM " . TBL_USERS . "WHERE username = '$username'";
		$result = mysql_query($q, $this->connection);
		
		//If there was an error, return the username supplied for correction
		if (!$result || (mysql_num_rows($result) < 1))
		{
			return NULL;
		}
		
		//If all is well, return with the array of user data
		$dbarry = mysql_fetch_array($result);
		return $dbarray;
	}
	
	//Returns the number of registered members
	function getNumMembers()
	{
		//Check if this function has been called yet, and if not, count the member
		if ($this->num_members < 0)
		{
			$q = "SELECT * FROM " . TBL_USERS;
			$result = mysql_query($q, $this->connection);
			$this->num_members = mysql_num_rows($result);
		}
		return $this->num_members;
	}
	
	//Returns the number of currently active users
	function calcNumActiveUsers()
	{
		$q = "SELECT * FROM " . TBL_ACTIVE_USERS;
		$result = mysql_query($q, $this->connection);
		$this->num_active_users = mysql_num_rows($result);
	}
	
	//Add a user to the list of active users
	function addActiveUser($userid, $time, $opid, $shipid, $roles)
	{
		$q = "INSERT INTO " . TBL_ACTIVE_USERS . " (userID, opID, shipID, time, role) VALUES ('$userid', '$opid', '$shipid', '$time', $role')";
		$result = mysql_query($q, $this->connection);
		$this->calcNumActiveUsers;
	}
	
	//Look up the users ID for insertion into tables
	function getUserID($username)
	{
		//Find the username in the database and assign it to the $userid variable
		$q = "SELECT userID FROM " . TBL_USERS . " WHERE username = '$username'";
		$result = mysql_query($q, $this->connection);
		$dbarray = mysql_fetch_array($result);
		$userid = $dbarray['userid'];
		
		//Return the value
		return $userid;
	}
	
	//Return the username from the UserID provided
	function getUserName($userid)
	{
		//Find the selected ID, grab the name and return it
		$q = "SELECT username FROM " . TBL_USERS . " WHERE id = '$userid'";
		$result = mysql_query($q, $this->connection);
		$dbarray = mysql_fetch_array($result);
		$username = $dbarray['username'];
		
		//Return the value
		return $username;
	}
	
	//Create a new op in the mining table
	function newMiningOp($regionid, $constid, $systemid, $start, $end, $foreman)
	{
		$q = "INSERT INTO " . TBL_OPS . " (regionid, constid, systemid, start, end, foreman) VALUES ('$regionid', '$constid', '$systemid', '$start', '$end', '$foreman')";
		$result = mysql_query($q, $this->connection);
	}
	
	//Set the status of the mining op as "closed"
	function closeMiningOp($opid)
	{
		//Get the time the op was closed
		$end = time();
		
		//Update the table
		$q = "UPDATE " . TBL_OPS . " SET end = '$end' WHERE opid = '$opid'";
		$result = mysql_query($q, $this->connection);
	}
	
	//Remove users who sign off from the active users list
	function removeActiveUser($userid)
	{
		$q = "DELETE FROM " . TBL_ACTIVE_USERS . " WHERE userid = '$userid'";
		$result = mysql_query($q, $this->connection);
	}
	
	//Empty function to perform any query
	function query($query)
	{
		return mysql_query($query,$this->connection);
	}
};

//Create database connections
$database = new MySQLDB;
?>