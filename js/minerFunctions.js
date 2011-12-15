// runs when the user submits the form with a given ore type
// ore type will be of type integer, because that's just how dropdowns roll
/*function submitOre(oreType){
	var yield;
	// use the known value of the user's m3 (ship bonuses + skills) and the size of the ore (from the db) (cache this since it cannot change)
	yield = ores[oreType] * user.m3;
	// add the value to the total in this current op
	addOre(oreType, Math.floor(yield));	
}*/

//loads all the different ore sizes into a dictionary
//returns the loaded ore dictionary
function loadOres(){
	var ores = {};
	//TODO: make all the ore names be the correct ID of the ore verses the DB
	ores[veldspar] = .1;
	ores[scordite] = .2;
	ores[pyroxeres] = .3;
	ores[plagioclase] = .4;
	ores[omber] = .6;
	ores[kernite] = 1.6;
	ores[jaspet] = 2.0;
	ores[hemorphite] = 3.0;
	ores[hedbergite] = 3.0;
	ores[gneiss] = 5.0;
	ores[darkochre] = 8.0;
	ores[crokite] = 16.0;
	ores[spodumain] = 16.0;
	ores[bistot] = 16.0;
	ores[arkanor] = 16.0;
	ores[mercoxit] = 40.0;
	return ores;
}

function addOre(oreType, yield){
	//some how add the amount in yield to the total ore of type oreType. should be injecting the values into 
	//the table or whatever used to display, as well as calling the a php file that adds the given ore to the op
	yield=Math.floor(yield)
	request = new XMLHttpRequest(); // create new request
	request.open("POST", "functions.php?function=5&oreType="+oreType+"&yield="+yield+"&user="+user.name,true); // send the request to the server with POST, to hide how we do it
	//we're done. we don't update clientside with this. let the timed checks of the DB load it.
}

// read the operation transactions from the database
// called every so often to refresh the elements in the transaction table
function refreshTransactions(){
	request = new XMLHttpRequest();
	request.onreadystatechange=function(){
		document.getElementById("transactionTable").innerHTML+=request.responseText;
	};
	request.open("POST","functions.php?function=6");
	request.send();	
}
