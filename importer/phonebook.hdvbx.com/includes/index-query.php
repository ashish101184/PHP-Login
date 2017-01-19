<?php include ('../config.php'); $data = array();	

if(isset($_POST['g-recaptcha-response']) && $_POST["g-recaptcha-response"]) {
	include(PATH_INCLUDE.'/plugins/recaptchalib.php');
	$privatekey = "6LeOWiQTAAAAAPtcl-gilhywjUoHEGv8tImcPS92";
	$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
	if (!$resp->isSuccess()){
		$data['response'] = "fail_captcha";
    	exit();
	}
}

if(isset($_POST['action']) && $_POST['action'] == 'register'){
	$firstname = htmlentities($_POST['firstname']); 
	$lastname = htmlentities($_POST['lastname']); 
	$country = htmlentities($_POST['country']); 
	$email = htmlentities($_POST['email']); 
	$password = htmlentities($_POST['p']);
	$password_confirm = htmlentities($_POST['pc']);

	if($firstname == '' || $lastname == '' || $country == '' || $email == '' || $password == '' || $password_confirm == ''){
		$data['response'] = 'fail';
	}elseif($password !== $password_confirm){
		$data['response'] = 'fail_match';
	}else{
		$result = $db->query("SELECT * FROM clients WHERE email = '$email'");
		if($result->num_rows == 0){
			$password = hash('sha256', $password);

                        //Generate a random string.
                        $token = openssl_random_pseudo_bytes(64);

                        //Convert the binary data into hexadecimal representation.
                        $token = bin2hex($token);
                       
			if(!$db->query("INSERT INTO clients (firstname,lastname,country,email,password,status,access,external_authkey,external_ipaddress,external_status) VALUES ('$firstname','$lastname','$country','$email','$password','0','u','".$token."','',0)")){
				 $data['response'] = 'fail_db';
				 $data['details'] = 'DB Insert error: '.$db->error;
			}else{
				$client_id = $db->insert_id;

				$result = $db->query("SELECT * FROM clients WHERE client_id = '".$db->insert_id."'");
				while($sql2 = $result->fetch_assoc()){
					$authkey = hash('sha256', $sql2['email'].$sql2['datecreated'].$sql2['lastlogin']);
					$db->query("UPDATE clients SET authkey = '".$authkey."' WHERE client_id='".$client_id."'");
				}						
				$confimation_link = PATH_DOMAIN.'/activate?'.$authkey;

				$headers = 'From: HD VBX <info@hdvbx.com>'."\r\n";
				$headers.= 'Content-Type: text/html; charset=ISO-8859-1 ';
				$headers .= 'MIME-Version: 1.0 ';

				$body = '
				Dear <strong>'.ucwords($firstname).' '.ucwords($lastname).'</strong>,
				<p>Thank you for registering with HD VBX - PhoneBook. To confirm your email address, click the link below or copy and paste it into your web browser.</p>
				<p><a href="'.$confimation_link.'">'.$confimation_link.'</a></p>
				';
				mail($email, 'Confirm Email', $body, $headers);

				detect_log('update', '', 'Login: Register', $metatitle);
				$data['response'] = 'success';
			}
		}else{
			$data['response'] = 'fail_exists';
		}
	}
}

if(isset($_POST['action']) && $_POST['action'] == 'login'){
	$email = htmlentities($_POST['email']); 
	$password = htmlentities($_POST['password']);
	$password = hash('sha256', $password);             
	$result = $db->query("SELECT * FROM clients WHERE email = '$email' AND password = '".$password."'");
	if($result->num_rows > 0){
		while($sql = $result->fetch_assoc()){
			if($sql['status'] == '1'){

				include(PATH_INCLUDE.'/template/functions/session.php');

				if($_POST['remember']){
					setcookie('remember_me', $email, time() + (10 * 365 * 24 * 60 * 60), "/"); //10 years
				}
				
				$lastlogin = date('Y-m-d H:i:s');
				$db->query("UPDATE clients SET lastlogin = '".$lastlogin."' WHERE client_id='".$sql['client_id']."'");

				$_SESSION['client'] = $sql;
				$_SESSION['loggedin'] = 1;
				detect_log('update', '', 'Login: Success', $metatitle);
				$data['response'] = 'success';                   
			 }elseif($sql['status'] == '2'){ 
				detect_log('select', '', 'Login: User Locked Out', $metatitle);
				$data['response'] = 'fail_acclocked';

			}
			elseif($sql['status'] == '3'){ 
				detect_log('select', '', 'Login: Not Verified', $metatitle);
				$data['response'] = 'fail_verify';

			}
			elseif($sql['status'] == '0'){ 
				detect_log('select', '', 'Login: Not Verified', $metatitle);
				$data['response'] = 'fail_verify';

			}
			else{
				detect_log('1', $metatitle, 'General', 'Login: Invalid');
				detect_log('select', '', 'Login: Success', $metatitle);
				$data['response'] = 'fail_login';
			}
		}
	}else{
		detect_log('select', '', 'Login: Invalid', $metatitle);
		$data['response'] = 'fail_login';
	}
}

if(isset($_POST['action']) && $_POST['action'] == 'forgot'){
	if ($_POST["email"] == ""){
		$data['response'] = 'fail';
	}else{
		$email = htmlentities($_POST['email']);
		$result = $db->query("SELECT * FROM clients WHERE email = '$email'");
		if($result->num_rows > 0){
			while($sql = $result->fetch_array(MYSQLI_BOTH)){

				$confimation_link = PATH_DOMAIN.'/reset?'.$sql['authkey'];

				$headers = 'From: HD VBX <info@hdvbx.com>'."\r\n";
				$headers.= 'Content-Type: text/html; charset=ISO-8859-1 ';
				$headers .= 'MIME-Version: 1.0 ';

				$body = '
				Dear <strong>'.ucwords($sql['firstname']).' '.ucwords($sql['lastname']).'</strong>,
				<p>Thank you for registering with HD VBX. To confirm your email address, click the link below or copy and paste it into your web browser.</p>
				<p><a href="'.$confimation_link.'">'.$confimation_link.'</a></p>
				';

				mail($email, 'Forgot Password', $body, $headers);

				detect_log('update', '', 'Login: Forgot Password', $metatitle);
				$data['response'] = 'success';
			}
		}else{
			detect_log('select', '', 'Login: Invalid', $metatitle);
			$data['response'] = 'fail_invalid';
		}
	}
}

if(isset($_POST['action']) && $_POST['action'] == 'reset'){
	if ($_POST["r"] == "" || $_POST["p"] == "" || $_POST["pc"] == ""){
		$data['response'] = 'fail';
	}elseif ($_POST['p'] == "" || $_POST["pc"] == ""){
		$data['response'] = 'fail_match';
	}else{
		$reset = htmlentities($_POST['r']);
		$result = $db->query("SELECT * FROM clients WHERE authkey = '".$reset."'");
		if($result->num_rows > 0){
			while($sql = $result->fetch_array(MYSQLI_BOTH)){
				//STATUS: 0=NotVerified, 1=VerifiedEmail, 2=LockedOut
				if($sql['status'] == 0){
					detect_log('select', '', 'Login: Not Verified', $metatitle);
					$data['response'] = 'fail_verify';
				}elseif($sql['status'] == 2){
					detect_log('select', '', 'Login: User Locked Out', $metatitle);
					$data['response'] = 'fail_acclocked';
				}else{	
					$password = htmlentities($_POST['p']);
					$password = hash('sha256', $password);
					
					//Generate new user_auth key
					$lastlogin = date('Y-m-d H:i:s');
					$authkey = hash('sha256', $sql['datecreated'].$lastlogin);
					
					$db->query("UPDATE clients SET password = '".$password."', authkey = '".$authkey."', lastlogin = '".$lastlogin."' WHERE client_id='".$sql['client_id']."'");
					
					$headers = 'From: HD VBX <info@hdvbx.com>'."\r\n";
					$headers.= 'Content-Type: text/html; charset=ISO-8859-1 ';
					$headers .= 'MIME-Version: 1.0 ';

					$body = '
					Dear <strong>'.ucwords($sql['firstname']).' '.ucwords($sql['lastname']).'</strong>,
					<p>Your password on HD VBX has been reset. If this was not you, please contact HD VBX immediately.</p>
					';

					mail($sql['email'], 'Password has been reset', $body, $headers);
					
					detect_log('update', '', 'Login: Password has been reset', $metatitle);
					$data['response'] = 'success';
				}
			}
		}else{
			detect_log('select', '', 'Login: Invalid Password Reset Link', $metatitle);
			$data['response'] = 'fail_invalid';
		}
	}
}

header('Content-Type: application/json');
echo json_encode($data);	

?>