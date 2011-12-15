// function to login 
// makes a call to login.php with required parameters
function login(){
	document.getElementById('loginResponse').innerHTML = "Logging in...";
	// verify that we have legitimate data to pass
	var un = encodeURI(document.getElementById('usernameLogin').value);
	var pwd = encodeURI(document.getElementById('passwordLogin').value);
	
	var request = createObject();
	
	request.open('post', 'login.php?user='+un+'&pwd='+password);
	request.onreadystatechange = loginResult;
	request.send();
}

// function that displays the result of the login operation
function loginResult(){
	// successful return; set the html to the result
	if (request.readyState == 4 && request.status == 200){
		document.getElementById('loginResponse').innerHTML = request.responseText;
	}
}

// creates the XMLHTTPRequest for immediate use. does the correct thing for all browsers
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

