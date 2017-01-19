<?php

require(PATH_INCLUDE.'/template/config/db.php');
if (mysqli_connect_errno() || WEB_MAINTENANCE == 1) {
    include(PATH_INCLUDE.'/errordocs/db.php');
	exit;
}

if (isset($_GET['logout'])){session_destroy(); header('Location: '.PATH_DOMAIN); exit; }

include(PATH_INCLUDE.'/template/functions/system.php');

$uri = $_SERVER['REQUEST_URI'];

if($_SESSION['loggedin'] == ''){
	if($uri != '/' && strpos($uri, "register")===false && strpos($uri, "reset")===false && strpos($uri, "activate")===false && strpos($uri, "query")===false && strpos($uri, "template/")===false && strpos($uri, "export/")===false){
		header('Location: '.PATH_DOMAIN); exit;
	}else{
		require(PATH_INCLUDE.'/template/functions/no-session.php');
	}
}else{
	require(PATH_INCLUDE.'/template/functions/session.php');
}

$eachServices = $db->query("SELECT count(*) as `total_contact`, `service` FROM `client_contacts` where `client_id` = ".$_SESSION['client']['client_id']." GROUP BY `service`");
$generalAllservies = [];
if($eachServices->num_rows > 0){
    while($eachService = $eachServices->fetch_array(MYSQLI_BOTH)){
        $generalAllservies[$eachService['service']] = $eachService['total_contact'];
    }
}

?>