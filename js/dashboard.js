// functions for the dashboard

// lifetime ore numbers
function getLifetimeOre(){
	// based on this username we create a query and get the info
	// we need from the database.
	var request = createObject();
	request.open('post', 'functions.php?function=1&uid='+uid);
	// when we get the response, put it into the html element with id 'lifetimeOreAmount'
	request.onreadystatechange = showResponse('lifetimeOreAmount');
	request.send();	
}

function getOnlineUsers(){
	// query again to get the online users. display it as well	
	var request = createObject();
	
	request.open('post', 'functions.php?function=2');
	// when we get the response, put it into the html element with id 'onlineUserList'
	request.onreadystatechange = showResponse('onlineUserList');
	request.send();
}

// gets all mining operations with endTime > current time, but startTime < currentTime.
function getCurrentOps(){
	// query to get the operation schedule from the operations table
	var request = createObject();
	// send our request to functions.php
	request.open('post', 'functions.php?function=3');
	// when we get the response, put it into the html element with id 'operationSchedule'
	request.onreadystatechange = showResponse('currentOpSchedule');
	request.send();	
}

// gets all mining operations with startTime > currentTime
function getFutureOps(){
	var request = createObject();
	
	request.open('post','functions.php?function=4');
	request.onreadystatechange = showResponse('futureOpsSchedule');
}

function showResponse(element){
	if (request.readyState == 4 && request.status == 200){
		document.getElementById(element).innerHTML = request.responseText;
	}
}

//creates the XMLHTTPRequest for immediate use. does the correct thing for all browsers
function createObject(){
	var requestType; // holds the object we're going to return
	var browser = navigator.appName; // get the name of the browser the user is using
	// if we're using Internet Explorere, we make an ActiveXObject
	if (browser == "Microsoft Internet Explorer"){
		requestType = new ActiveXObject("Microsoft.XMLHTTP");
	}
	// otherwise, we are using a more sane browser; XMLHttpRequest will do
	else{
		requestType = new XMLHttpRequest();
	}
	return requestType; // return the proper object
}

// Starts the timer for the functions. set to 30 seconds initially for testing purposes
function startTimer(){
	var a = setTimeout("getCurrentOps()",30000);
	var b = setTimeout("getFutureOps()",30000);
	var c = setTimeout("getOnlineUsers()",30000);
	var d = setTimeout("getLifetimeOre()",30000);	
}

// run when the page loads. starts all of the timers and does the initial calls
function onload(){
	getCurrentOps();
	getFutureOps();
	getOnlineUsers();
	getLifetimeOre();
	startTimer();
}

