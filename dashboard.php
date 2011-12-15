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
if (!defined('IS_LEGIT'))
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

?>
// javascript includes
<html>
<head>
	<script type="text/javascript" src="minerScripts.js"></script>
	<script type="text/javascript" src="haulerScripts.js"></script>
	<script type="text/javascript" src="operationScripts.js"></script>
</head>


<body>
//The dropdown that will be populated by the server, ore types
<form id="oreSelector">
	<select name="oreTypes" id="oreTypes">
		<option value="1">Veldspar</option>
		<option value="2">Scordite</option>
		<option value="3">Pyroxeres</option>
		<option value="4">Plagioclase</option>
		<option value="5">Omber</option>
		<option value="6">Kernite</option>
		<option value="7">Jaspet</option>
		<option value="8">Hemorphite</option>
		<option value="9">Hedbergite</option>
		<option value="10">Gneiss</option>
		<option value="11">Dark Ochre</option>
		<option value="12">Crokite</option>
		<option value="13">Spodumain</option>
		<option value="14">Bistot</option>
		<option value="15">Arkonor</option>
		<option value="16">Mercoxit</option>
	</select>
	<input type="text" style="text-align: right" value="Enter yield here" name="yield"/>
	<input type="button" onClick="addOre(oreTypes.value, yield.value)" value="Submit Transaction" name="submit"/>
</form>
<br />

<div id="transactionTable"><b>Transaction information goes here.</b></div>
</body>

</html>
