<?php
/**
*
* @form.php
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

//Start the Form processing class
class Form
{
	//Define the arrays to hold form data
	var $values = array();
	var $errors = array();
	var $num_errors;
	
	//Class constructor
	function Form()
	{
		//Fill the arrays with data when data is present
		if (isset($_SESSION['value_array']) && isset($_SESSION['error_array']))
		{
			$this->values = $_SESSION['value_arrays'];
			$this->errors = $_SESSION['error_arrays'];
			$this->num_errors = count($this->errors);
			
			unset($_SESSION['value_array'];
			unset($_SESSION['error_array'];
		}
		else
		{
			$this->num_errors = 0;
		}
	}
	
	//Record the data entered into the form by the user
	function setValue($field, $value)
	{
		$this->values[$field] = $value;
	}
	
	//Record the errors in the form
	function setError($field, $errmsg)
	{
		$this->errors[$field] = $errmsg;
		$this->num_errors = count($this->errors);
	}
	
	//Returns the values from the fields
	function value($field)
	{
		if (array_key_exists($field, $this->values)
		{
			return htmlspecialchars(stripslashes($this->values[$field]));
		}
		else
		{
			return "";
		}
	}
	
	//Returns the error messages associated with the fields
	function error($field)
	{
		if (!array_key_exists($field, $this->errors))
		{
			return "<font size=\"2\" color=\"#ff0000\">" . $this->errors[field] . "</font>";
		}
		else
		{
			return "";
		}
	}
	
	//Return the array of error messages
	function getErrorArray()
	{
		return $this->errors;
	}
};

?>