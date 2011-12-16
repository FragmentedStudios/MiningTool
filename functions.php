<?php include('config.php'); ?>

<?php
// write all the functions first, with queries
// all of the functions return HTML to be popped into relevant elements with javascript
$function = $_POST['function'];

switch ($function){
	// case 1 = get Lifetime Ore amount
	case 1:
		getLifetimeOre();
		break;
	// case 2 = get list of logged in users
	case 2:
		getOnlineUsers();
		break;
	case 3:
		getCurrentOps();
		break;
	case 4:
		getFutureOps();
		break;
}

// function to return all results from the operations database with startTime > currentTime
function getFutureOps(){
	$currentTime = time();
	
	$query = "SELECT * FROM ".$dbuname." WHERE startTime > ".$currentTime;
	$queryResult = mysql_query($query);
	
	// simple echo of a table. stylize later
	// probably won't need this. have empty table in the dashboard.php straight away.
	echo "<table border='1'>
	<tr>
	<th>SystemID</th>
	<th>Start Time</th>
	<th>End Time</th>
	<th>Sponsor</th>
	</tr>";

	// populate the table with everything matching our query
	// $row['columnname'] is the format. 
	while ($row=mysql_fetch_array($queryResult)){
		echo "<tr>";
		echo "<td>".$row['systemID']."</td>";
		echo "<td>".$row['startTime']."</td>";
		echo "<td>".$row['endTime']."</td>";
		echo "<td>".$row['sponsor']."</td>";
		echo "</tr>";
	}
	echo "</table>";
}

// function to return all results with endTime > currentTime && currentTime > startTime
function getCurrentOps(){
	$currentTime = time();
	
	$query = "SELECT * FROM ".$dbuname." WHERE ".$currentTime." > startTime AND endTime > ".$currentTime;
	$queryResult = mysql_query($query);
	
	//probably won't need this. 
	echo "<table border='1'>
	<tr>
	<th>SystemID</th>
	<th>Start Time</th>
	<th>End Time</th>
	<th>Sponsor</th>
	</tr>";
	
	// continue writing out html for each entry we have taht meets the criteria
	while ($row=mysql_fetch_array($queryResult)){
		echo "<tr>";
		echo "<td>".$row['systemID']."</td>";
		echo "<td>".$row['startTime']."</td>";
		echo "<td>".$row['endTime']."</td>";
		echo "<td>".$row['sponsor']."</td>";
		echo "</tr>";
	}
	echo "</table>";
}

// function to return a list of all users currently logged on
function getOnlineUsers(){
	// this query is wrong certainly. inserted for concept
	$query = "SELECT playerName FROM ".$dbuname." WHERE loggedOn = 1"; 
	$queryResult = mysql_query($query);
	// not quite sure about the specifics of this one! where is the logged on information 
	// stored? not sure about the query specifics
	echo "<table border='1'>
	<tr>
	<th>Player Name</th>
	</tr>";

	while ($row=mysql_fetch_array($queryResult)){
		echo "<tr>";
		echo "<td>".$row['playerName']."</td>";
		echo "</tr>";
	}
	echo "</table>";
}

// function that gets and returns a given user's lifetime ore amount
function getLifetimeOre(){
	// this function has additional parameters. 
	$uid=$_POST["uid"];
	// get the lifetime ore for this uid
	
	//again, this query is not correct, but this is a proof of concept
	$query = "SELECT lifetimeOre FROM ".$dbuname." WHERE playerID = ".$uid;
	$queryResult = mysql_query($query);
	echo $queryResult['lifetimeOre'];	
}




?>