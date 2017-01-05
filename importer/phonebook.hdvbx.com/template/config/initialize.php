<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting',~E_NOTICE);

header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: get-check=0, pre-check=0",false); session_cache_limiter(); session_start();

function checkLocalhost(){
	$testingip = array('phonebook.hdvbx.com');
	$localhost=array("theadw.local","localhost","10.0.1.2");
	if(in_array($_SERVER['HTTP_HOST'],$localhost) || in_array($_SERVER['SERVER_ADDR'],$localhost) || in_array($_SERVER['REMOTE_ADDR'],$localhost))
		return true;
	else if(in_array($_SERVER['HTTP_HOST'],$testingip) || in_array($_SERVER['SERVER_ADDR'],$testingip) || in_array($_SERVER['REMOTE_ADDR'],$testingip)){
		return NULL;
	}
}

?>