<?php

include('config.php');

if(strpos($_SERVER['REQUEST_URI'], '/export', 0)=== 0){
	if(isset($_GET)){
		$query_string = htmlentities(str_replace('/export/&', '', $_SERVER['QUERY_STRING']));
		include(PATH_INCLUDE.'/sync/export.php');
	}else{
		echo 'Invalid URL.';
		exit;
	}
}else{

	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1){
		include(PATH_INCLUDE.'/includes/index-session.php');
	}else{
		if(strpos($_SERVER['REQUEST_URI'], '/register', 0)=== 0){
			$pagename = "Register";

			$publickey = "6LeOWiQTAAAAAJJgYFjPmWF7kBYnYNoau1NNVwaZ";
			include(PATH_INCLUDE.'/template/php-plugins/recaptchalib.php');

			include(PATH_INCLUDE.'/template/php-nosession/header.php');
			include(PATH_INCLUDE.'/includes/login-register.php');
		}elseif(strpos($_SERVER['REQUEST_URI'], '/reset', 0)=== 0){
			if(isset($_GET)){
				$reset = htmlentities(str_replace('/reset&', '', $_SERVER['QUERY_STRING']));
				$result = $db->query("SELECT * FROM clients WHERE authkey = '".$reset."'");
				if($result->num_rows == 0){ $invalid = 1; }
			}else{
				$invalid = 1;
			}
			$pagename = "Reset Password";
			include(PATH_INCLUDE.'/template/php-nosession/header.php');
			include(PATH_INCLUDE.'/includes/login-reset.php');
		}else if(strpos($_SERVER['REQUEST_URI'], '/activate', 0)=== 0){
			if(isset($_GET)){
				$activate = htmlentities(str_replace('/activate&', '', $_SERVER['QUERY_STRING']));
				$result = $db->query("SELECT client_id FROM clients WHERE authkey = '".$activate."' AND status=0");
				$sql = $result->fetch_array(MYSQLI_BOTH);
				if($result->num_rows == 0){
					$invalid = 1;
				}else{
					$db->query("UPDATE clients SET status='1' WHERE client_id='".$sql['client_id']."'");
				}
			}else{
				$invalid = 1;
			}
			$pagename = "Activation";
			include(PATH_INCLUDE.'/template/php-nosession/header.php');
			include(PATH_INCLUDE.'/includes/login-activate.php');
		}else{
			$pagename = "Login";

			$publickey = "6LeOWiQTAAAAAJJgYFjPmWF7kBYnYNoau1NNVwaZ";
			include(PATH_INCLUDE.'/template/php-plugins/recaptchalib.php');

			include(PATH_INCLUDE.'/template/php-nosession/header.php');
			include(PATH_INCLUDE.'/includes/login.php');
		}
	}

}

?>