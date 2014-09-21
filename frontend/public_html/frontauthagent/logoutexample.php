<?php
/*
Frontend Logout Demonstration Page

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


function your_deauthenticator() {
}

if(checkPair()) {
	closePair();
	your_deauthenticator();
	$msg = "You have successfully logged out.";
}
else
{
	$msg = "There is nothing to do here.";
}
?><html>
	<head>
		<title>AuthAgent Logout Demo</title>
	</head>
	<body>
		<p><?php echo $msg;?></p>
		<p><a href="<?php echo dirname($_SERVER['SCRIPT_NAME']);?>">Click here to go to the main index</a></p>
	</body>
</html>
