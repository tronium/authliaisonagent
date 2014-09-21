<?php
/*
Frontend Agent Configuration File

Author: Ori Novanda (cargmax-at-gmail.com)
*/

$allowIndexDemo = true;
$allowJumpDemo= true;
$allowDemo = false;

$publicKeyFile = 'certificate/authagent-public.pem';
$passphrase = 'demoonly';

$okMsg = 'ok';
//$failedMsg = 'failed';

$commandKey = 'cmd';
$cmdOpen  = 'open';
$cmdClose  = 'close';
$cmdToken  = 'token';
$cmdJump  = 'jump';

$backProto = 'http';
$backHost = '-'; if($backHost == '-') die ("Please set the backend agent server host (and related stuff) in the configuration file");
$backPage = '/backauthagent/index.php';

if($backProto == "auto") {
	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') $backProto = 'https';
	else $backProto = 'http';
}

?>