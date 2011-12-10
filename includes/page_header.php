<?php

//Output the header information and website top banner
?>
<html>
	<head>
		<title>
			TnH Industries Mining Tracker - v0.1
		</title>
	</head>
</html>
<?
//Check for IGB and trust
if($trusted == 0)
{
	//Player is IGB, but site is not trusted.
	echo('<center><font color="red"><strong>' . $untrusted_en . '</strong></font></center><br /><br />');
}
else if ($trusted == '')
{
	//Player is not IGB.
	echo('<center><font color="red"><strong>' . $oog_en . '</strong></font></center><br /><br />');
}

echo('<center><h2>TnH Industries Mining Tracker - v0.1</h2></center><br /><br /><br />');

?>