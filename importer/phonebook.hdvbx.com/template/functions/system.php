<?php
function checkExists($val = ''){
	//added this as we using to initialize object with new stdClass from  this getNewObject(), thus when that empty object is passed for empty it return true(i.e exists value), so in order to avoid that mistake, just convert object to array and then when array will be check against for empty then it will return false(i.e no value exists)
	
	if(is_object($val) && in_array(strval(get_class($val)),array('stdClass')))
		$val = get_object_vars($val);
	
	if(is_string($val))
		$val=trim($val);
	
	if(empty($val) || is_null($val))
		return false;
	else
		return true;
}

function inputbutton($type = '', $action = '', $id = '', $value = '', $size = '', $style = '', $onclick = '', $title = '', $url = ''){
	if(checkExists($id)){
		$id = ' id="'.$id.'"';
	}
	if(checkExists($value)){
		$value = ' value="'.$value.'"';
	}
	if(checkExists($onclick)){
		$onclick = ' onclick="'.$onclick.'"';
	}
	if(checkExists($title)){
		$title = ' title="'.$title.'"';
	}
	if(checkExists($style)){
		if($type == 'span'){
			$style .= 'cursor: pointer; '.$style;
		}
		$style = ' style="'.$style.'"';
	}
	
	/* SIZE */
	if(checkExists($size)){
		if($size == '' || $size == 'default'){ $size = ' btn-default'; }
		if($size == 'small'){ $size = ' btn-sm'; }
		if($size == 'large'){ $size = ' btn-lg'; }
	}
	
	if($action == 'delete' || $action == 'disable'){
		$icon = 'glyphicon glyphicon-remove'; //glyphicon-remove-circle | glyphicon-remove-sign | glyphicon-remove
		$color = 'text-red';
	}elseif($action == 'enable' || $action == 'save'){
		$icon = 'glyphicon glyphicon-ok'; //glyphicon-ok-circle | glyphicon-ok-sign | glyphicon-ok
		$color = 'text-green';
	}elseif($action == 'edit'){
		$icon = 'glyphicon glyphicon-pencil';
		$color = 'text-light-blue';
	}elseif($action == 'cancel'){
		$icon = 'glyphicon glyphicon-remove-sign';
		$color = 'text-muted';
	}elseif($action == 'link'){
		$icon = 'glyphicon glyphicon-link';
		$color = 'text-light-blue';
	}elseif($action == 'search' || $action == 'preview'){
		$icon = 'glyphicon glyphicon-search';
		$color = 'text-light-blue';
	}elseif($action == 'location'){
		$icon = 'glyphicon glyphicon-screenshot';
		$color = 'text-muted';
	}else{
		$icon = $action;
		$color = '';
	}
				
	if($type == 'span' || $type == 'a'){
		$button = ($type=='a'?'<a href="'.$url.'">':'').'<span class="'.$icon.' '.$color.$size.'"'.$id.$value.$onclick.$title.$style.'></span>'.($type=='a'?'</a>':'');
	}
	
	if($type == 'button' || $type == 'input'){
		$button = '<input type="'.$type.'" class="'.$icon.' '.$color.$size.'"'.$id.$value.$onclick.$title.$style.'>';
	}
	
	return $button;
}

function get_Countries(){
	global $db;
	$que = "SELECT country, iso2 FROM world_country";
	$rs=$db->query($que);
    if($rs === false) {
         trigger_error($db->error, E_USER_ERROR);
       }
    else{
		while($row = $rs->fetch_assoc()){
			$nei[$row['iso2']] = $row['country'];
		}
		return $nei;
	}
}
function get_States(){
	global $db;
	$que = "SELECT state as state FROM world_state";
	$rs=$db->query($que);
    if($rs === false) {
         trigger_error($db->error, E_USER_ERROR);
       }
    else{
		while($row = $rs->fetch_assoc()){
			$nei[] = $row['state'];
		}
		return $nei;
	}
}

function get_User($user_id){
	global $db;
	$array = array();
	$result = $db->query('SELECT * FROM clients WHERE client_id="'.$user_id.'"');
	$array['results_exists'] = $result->num_rows;
	if ($array['results_exists'] > 0){
		$array = array_merge($array, $result->fetch_assoc());
	}
	return $array;
}

/* Simple encryption and decryption for password */
function encrypt_simple($string){
    return base64_encode(base64_encode(base64_encode($string)));
}
 
function decrypt_simple($string){
    return base64_decode(base64_decode(base64_decode($string)));
}

/******* ENCRYPTION/DECRYPTION *******/
function encrypt($data) {
	$iv = mcrypt_create_iv( mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM );
	return base64_encode(
		$iv .
		mcrypt_encrypt(
			MCRYPT_RIJNDAEL_128,
			hash('sha256', HDVBX_ENCRYPTION_KEY, true),
			$data,
			MCRYPT_MODE_CBC,
			$iv
		)
	);
}

function decrypt($encrypted) {
	$data = base64_decode($encrypted);
	$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
	return rtrim(
		mcrypt_decrypt(
			MCRYPT_RIJNDAEL_128,
			hash('sha256', HDVBX_ENCRYPTION_KEY, true),
			substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
			MCRYPT_MODE_CBC,
			$iv
		),
		"\0"
	);
}

function get_client_ip_address() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED',
       'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR')
          as $key) {
     
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    return $ip;
                }
            }
        }
    }
}

function ip2geolocation($ip)
{
    # api url
    $apiurl = 'http://freegeoip.net/json/' . $ip;
 
    # api with curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiurl);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $data = curl_exec($ch);
    curl_close($ch);
 
    # return data
    return json_decode($data);
}

/************* USER LOG *************/
function detect_log($type, $subject_id, $description, $pagemetatitle, $forceinsert=0){
	global $db;
	$detect_log = array();
	$detect_log['activity_type']		= $type;
	$detect_log['subject_id'] 			= $subject_id;
	$detect_log['activity_description'] = $description;
	if($_SESSION['use_site_as_another_user'] == ''){
		$detect_log['user_id'] 			= $_SESSION['user']['id'];
	}else{
		$detect_log['user_id'] 			= $_SESSION['use_site_as_another_user'];
	}
	$detect_log['activity_ipaddress'] 	= $_SERVER["REMOTE_ADDR"];
	$detect_log['activity_pagemetatitle'] = $pagemetatitle;
	if($_SERVER['QUERY_STRING'] != ''){ $query_string = '?'.$_SERVER['QUERY_STRING']; }
	$detect_log['activity_pageurl'] 		= $db->real_escape_string($_SERVER['SCRIPT_URI'].$query_string);
	$detect_log['activity_pagereferer'] 	= $db->real_escape_string($_SERVER['HTTP_REFERER']);
	if($detect_log['activity_pagereferer'] == $detect_log['url']){
		$detect_log['activity_pagereferer'] = '';
	}
	$detect_log['activity_pagehttp'] 	= $_SERVER["HTTP_USER_AGENT"];
	
	if($forceinsert == 1 || $_SESSION['use_site_as_another_user'] == ''){
		$db->query("INSERT INTO system_activity (activity_type, subject_id, activity_description, user_id, activity_ipaddress, activity_pagemetatitle, activity_pageurl, activity_pagereferer, activity_pagehttp) VALUES (
		'".$detect_log['activity_type']."',
		'".$detect_log['subject_id']."',
		'".$detect_log['activity_description']."',
		'".$detect_log['user_id']."',
		'".$detect_log['activity_ipaddress']."',
		'".$detect_log['activity_pagemetatitle']."',
		'".$detect_log['activity_pageurl']."',
		'".$detect_log['activity_pagereferer']."',
		'".$detect_log['activity_pagehttp']."'
		)");
	}
	return $detect_log;
}

?>