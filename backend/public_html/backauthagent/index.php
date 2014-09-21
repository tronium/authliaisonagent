<?php
/*
Backend Agent

Provides services for the frontend Agent.

Author: Ori Novanda (cargmax-at-gmail.com)
*/

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 01:23:45 GMT");

include 'backauthagent.conf.php';
include 'backauthagent.lib.php';

session_start();

function generateChallange() {
	$val = md5(microtime());
	$_SESSION['challange'] = $val;
	return $val;
}

function validateChallange($response64, $passphrase) {
	global $okMsg, $failedMsg;
	global $privateKeyFile;
	
	$privateKey = @file_get_contents($privateKeyFile);
	if(empty($privateKey)) return $failedMsg . ": no certificate";

	$res = openssl_get_privatekey($privateKey, $passphrase);
	if(!$res) return $failedMsg;

	$res = openssl_private_decrypt(base64_decode($response64), $response, $res);
	if(!$res) return $failedMsg;

	if($response == $_SESSION['challange']) {
		unset($_SESSION['challange']);
		return $okMsg;
	}
	else {
		return $failedMsg;
	}
}

function generateToken() {
	if(checkValidAccess()) {
		$val = md5(microtime());
		$_SESSION['token'] = $val;
		return $val;
	}
	else
	{
		return $GLOBALS['failedMsg'];
	}
}

function validateJumpToken($val) {
	session_write_close();
	$oldSID = session_id($_POST['sid']);
	session_start();
	if(!empty($val) && $_SESSION['token'] == $val) {
		unset($_SESSION['token']);
		return true;
	}
	else {
		session_write_close();
		$oldSID = session_id($oldSID);
		session_start();
		return false;
	}
}

if($_POST[$commandKey] == $cmdJump) {
	if(validateJumpToken($_POST['token'])) {
	}
	header("Location: " . "$jumpProto://$jumpHost$jumpPage");
}
else if($_POST[$commandKey] == $cmdToken) {
	echo generateToken();
}
else if($_POST[$commandKey] == $cmdOpen) {
	$msg = validateChallange($_POST['response'], $_POST['key']);
	if($msg == $okMsg) {
		makePair();
	}
	echo $msg;
}
else if ($_GET[$commandKey] == $cmdClose) {
	breakPair();
	echo $okMsg;
}
else {
	echo generateChallange();
}
?>