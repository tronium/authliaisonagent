<?php
/*
Frontend Support Functions

Author: Ori Novanda (cargmax-at-gmail.com)
*/

if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
   header($_SERVER['SERVER_PROTOCOL'] . " 403 Forbidden\n", true, 403);
   die("Error");
}

function createStreamContext($method, array $data = null, array $headers = null) {
	$proto = 'http';

	$params = array(
        $proto => array(
            'method' => $method
            ,'follow_location' => 0
        )
    );

    if ($method =="POST") {
        $params[$proto]['content'] = http_build_query($data);
	}

	$params[$proto]['header'] = '';
    if (!is_null($headers)) {
        foreach ($headers as $k => $v) {
            $params[$proto]['header'] .= "$k: $v\n";
        }
    }
	
	return stream_context_create($params);
}

function accessRemotePage($url, array $data = null, array $header = null) {
	if(is_null($data)) {
		$ctx = createStreamContext('GET', null, $header);
	} else {
		$ctx = createStreamContext('POST', $data, $header);
	}

	$fp = @fopen($url, 'rb', false, $ctx);
	if ($fp) {
		$r = @stream_get_contents($fp);
	}
	else {
		//$r = error_get_last()['message'];
		$r = null;
	}
	return $r;
}

function accessBackendPage($url, array $data = null, array $header = null) {
	if(is_null($header)) $header = array();
	$header['Cookie'] = "PHPSESSID=" . session_id();
	$header['Connection'] = 'close'; // force close
	return accessRemotePage($url, $data, $header);
}

if(!function_exists('session_status')) {
	if (session_status() != PHP_SESSION_ACTIVE) session_start();
} else {
	if(session_id() == '') session_start();
}

$backUrl = "$backProto://$backHost$backPage";

function makePair() {
	global $backUrl, $commandKey, $cmdOpen;
	global $publicKeyFile, $passphrase;
	global $okMsg;

	$publicKey = @file_get_contents($publicKeyFile);
	if(empty($publicKey)) return 'No Encription File';
	$res = openssl_get_publickey($publicKey);
	if(!$res) return 'Encryption Error' ;

	$challange = accessBackendPage($backUrl, null, $header);

	$res = openssl_public_encrypt($challange, $response, $res);
	if(!$res) return 'Encryption Error' ;

	$data = array (
		$commandKey => $cmdOpen
		,'response' => base64_encode($response)
		,'key' => $passphrase
	);
	$make = accessBackendPage($backUrl, $data, $header);
	return $make;
}

function openPair()
{
	global $okMsg;

	$make = makePair();
	if($make==$okMsg) {
		$_SESSION['authpair'] = microtime(); // the value has no particular meaning, yet
		return true;
	}
	else {
		return false;
	}
}

function checkPair() {
	return isset($_SESSION['authpair'])? true : false;
}

function closePair() {
	global $backUrl, $commandKey, $cmdClose;

	$breakUrl = "$backUrl?$commandKey=$cmdClose";
	$break = accessBackendPage($breakUrl);
	unset($_SESSION['authpair']);
	return $break;
}

function requestToken() {
	global $backUrl;

	$data = array (
		$GLOBALS['commandKey']  => $GLOBALS['cmdToken']
	);

	$key = accessBackendPage($backUrl, $data);
	return $key;
}
?>