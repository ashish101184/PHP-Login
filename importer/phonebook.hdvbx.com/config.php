<?php

/* DO NOT EDIT: START */
include('template/config/initialize.php');
/* DO NOT EDIT: FINISH */

define('WEB_MAINTENANCE', '0'); //0=WebsiteLive, 1=WebsiteDISABLED
define('WEB_TESTMODE', '1'); //0=TestingOFF, 1=TestingON, 2=Testing(LiveTwilio TestStripe)
define('DEBUGGER', '1'); //Only Admin can see. 0=Off, 1=On

if(checkLocalhost()){
	define('PATH_DOMAIN', 'https://localhost');
	define('PATH_INCLUDE', $_SERVER['DOCUMENT_ROOT']);
	
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'hdvbx_phonebook');
}else{
	define('PATH_DOMAIN', 'https://phonebook.hdvbx.com');
	define('PATH_INCLUDE', $_SERVER['DOCUMENT_ROOT']);
	
	define('DB_HOST', 'mysql.hdvbx.com');
	define('DB_USER', 'hdvbx_phonebook');
	define('DB_PASS', 'PQa2*mN-');
	define('DB_NAME', 'hdvbx_phonebook');
}

define('authpageUrl', 'https://phonebook.hdvbx.com/oauth.html');
define('cilicense', 'lic_8f9536da-4490-4288-b848-2a56c');
define('crmcilicense', 'your CRM contacts license key here');
define('filicense', 'your friends inviter license key here');
define('sclicense', 'lic_473d7a02-7efc-412e-952b-fedc0');

// SparkPost API Credentials
define('API_EMAIL_AUTHTOKEN', 'c6106ae1d2973a684239ee99bc45e110d6751f8a');


/* DO NOT EDIT: START */
include('template/config/system.php');
/* DO NOT EDIT: FINISH */

?>