<?php
/*
Usage Example

Author: Ori Novanda (cargmax-at-gmail.com)
*/

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

include "../backauthagent/backauthagent.lib.php";

if(checkValidAccess()) {
	$msg = "authorised";
}
else {
	$msg = "<b>not</b> authorised";
}
?><html>
	<head>
		<title>AuthAgent Access Demo Page</title>
	</head>
	<body>
		Access to this page is: <?php echo $msg;?>.
	</body>
</html>