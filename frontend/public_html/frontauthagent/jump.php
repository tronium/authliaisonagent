<?php
/*
Direct Access Bridge

Provides a jump page to access the target server directly after the authentication process.

Author: Ori Novanda (cargmax-at-gmail.com)
*/

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

session_start();

include 'frontauthagent.conf.php';
include 'frontauthagent.lib.php';

if (!$allowJumpDemo) {
   header($_SERVER['SERVER_PROTOCOL'] . " 403 Forbidden\n", true, 403);
   die("Demo mode is disabled");
}

$token = requestToken();
$jumpUrl = "$backProto://$backHost$backPage";

?><html>
	<head>
		<title>AuthAgent Jump Page</title>
	</head>
	<body>
		Click the button bellow to access the target server directly.
		<form method='POST' action="<?php echo $jumpUrl; ?>">
			<input type="hidden" name="<?php echo $commandKey; ?>" value="<?php echo $cmdJump; ?>">
			<input type="hidden" name="token" value="<?php echo $token; ?>">
			<input type="hidden" name="sid" value="<?php echo session_id(); ?>">
			<input type="submit" value="Jump">
		</form>
		<p><a href="<?php echo dirname($_SERVER['SCRIPT_NAME']);?>">Click here to go to the main index</a></p>
	</body>
</html>
