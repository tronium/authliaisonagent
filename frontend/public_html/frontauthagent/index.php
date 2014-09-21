<?php
/*
Frontend Demonstration Page

Author: Ori Novanda (cargmax-at-gmail.com)
*/

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

include 'frontauthagent.conf.php';

if (!$allowIndexDemo) {
   header($_SERVER['SERVER_PROTOCOL'] . " 403 Forbidden\n", true, 403);
   die("Demo mode is disabled");
}
?>
<html>
	<head>
		<title>AuthAgent Index Demo</title>
	</head>
	<body>
		Pick one example below:
		<p><a href="loginexample.php">Login</a>
		<p><a href="logoutexample.php">Logout</a>
		<p><a href="jump.php">Jump</a>
	</body>
</html>
