<?php
/*
Backend Agent Configuration File

Author: Ori Novanda (cargmax-at-gmail.com)
*/

$privateKeyFile = "certificate/authagent-private.pem";

$okMsg = 'ok';
$failedMsg = 'failed';

$commandKey = 'cmd';
$cmdOpen = 'open';
$cmdClose = 'close';
$cmdToken = 'token';
$cmdJump = 'jump';

$jumpProto = 'auto';
$jumpHost = $_SERVER['HTTP_HOST'];
$jumpPage = dirname($_SERVER['SCRIPT_NAME']). "/../usageexample/";

if($jumpProto == "auto") {
	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') $jumpProto = 'https';
	else $jumpProto = 'http';
}
?>