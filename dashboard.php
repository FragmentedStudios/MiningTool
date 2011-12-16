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
<html>
<head>
<script type="text/javascript" src="js/dashboard.js"></script>
<script type="text/javascript">
function startTime(){
	var a = setTimeout("getCurrentOps()",3000);
	var b = setTimeout("getFutureOps()",3000);
	var c = setTimeout("getOnlineUsers()",3000);
	var d = setTimeout("getLifetimeOre()",3000);	
}

</script>
</head>
<body onload="startTimer()">
	<!-- table containing current operations -->
	<h2>Current Operations</h2>
	<div id="currentOpSchedule"><b>Current Operations are listed here...</b></div>
	<h2>Future Operations</h2>
	<div id="futureOpsSchedule"><b>Future Operations are listed here...</b></div>
	<h2>Online Users</h2>
	<div id="onlineUserList"><b>The list of online users is here...</b></div>
	<h2>Lifetime Ore Mined</h2>
	<div id="lifetimeOreAmount"><b>1000000</b></div>
</body>

</html>
