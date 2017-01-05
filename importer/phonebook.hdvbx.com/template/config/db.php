<?php

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($db->connect_errno > 0){
    $error = 'Unable to connect to database [' . $db->connect_error . ']';
}else{
	/*if ($mysqli->set_charset("utf8")) {
		printf("Current character set: %s\n", $mysqli->character_set_name());
	}else{
		printf("Error loading character set utf8: %s\n", $mysqli->error);
		exit();
	}*/
}

?>