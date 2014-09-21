<?php
/*
Backend Authorisation Agent

Provides authorisation service to the target program.

Author: Ori Novanda (cargmax-at-gmail.com)
*/

if(!function_exists('session_status')) {
	if (session_status() != PHP_SESSION_ACTIVE) session_start();
} else {
	if(session_id() == '') session_start();
}

function makePair() {
	$_SESSION['pairtime'] = microtime(); // no particular meaning, yet
}

function breakPair() {
	unset($_SESSION['pairtime']);
}

function checkValidAccess() {
	if(empty($_SESSION['pairtime'])) return false;
	return true;
}
?>