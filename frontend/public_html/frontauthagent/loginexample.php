<?php
/*
Frontend Login Demostration Page

Author: Ori Novanda (cargmax-at-gmail.com)
*/

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 01:23:45 GMT");

include 'frontauthagent.conf.php';
include 'frontauthagent.lib.php';

if (!$allowDemo) {
   header($_SERVER['SERVER_PROTOCOL'] . " 403 Forbidden\n", true, 403);
   die("Demo mode is disabled");
}

function your_authenticator() {
	return true; // should return the result of an actual authentication process
}

function your_postauthenticator() { //will be called after the authorisation link to the target server has been establish
}

function authenticator() { // an example
	if(your_authenticator()) {
		$paired = openPair(); // if authenticated then establish the link
		if($paired) {
			your_postauthenticator();
			return true;  // pair connection is successful
		}
		else {
			return false; // pair connectios is failed
		}
	}
	else {
		return false; // authentication is failed
	}
}

$msg = "
		Click this button below to open the access.
		<form method='post'>
			<input type='submit' value='Open Sesame'>
		</form>
"			;

if($_SERVER['REQUEST_METHOD'] == 'POST') { // replace with a proper detection
	if(your_authenticator()) {
		$paired = openPair();
		if($paired) {
			your_postauthenticator();
			$msg = "<p>Access authorised and the link is established.</p>";
		}
		else {
			$msg = "<p>Unable to establish the link with the remote server.</p>";
		}
	}
	else {
		$msg  = "<p>Authentication is failed.</p>\n$msg";
	}
}
else if(checkPair()) {
	$msg  = "<p>You have been logged in. Nothing to do here.</p>";
}
?><html>
	<head>
		<title>AuthAgent Login Demo</title>
	</head>
	<body>
<?php echo $msg; ?>
		<p><a href="<?php echo dirname($_SERVER['SCRIPT_NAME']);?>">Click here to go to the main index</a></p>
	</body>
</html>
