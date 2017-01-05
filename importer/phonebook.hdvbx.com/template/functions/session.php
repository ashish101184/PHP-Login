<?php

function random_string($length){
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));
    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $key;
}

function get_Contact($contact_id){
	global $db;
	$array = array();
	$result = $db->query('SELECT * FROM contacts WHERE api_id = "'.$api_id.'"');
	$array['results_exists'] = $result->num_rows;
	if ($array['results_exists'] > 0){
		while($sql = $result->fetch_assoc()){
			$array['number'][$sql['number_id']] = $sql;
		}
	}
	return $array;
}

function DateConvert($date, $format='sql'){
	if($format == 'sql'){
		$date = date_create_from_format('D, j M Y H:i:s O', $date); //PHP DATE_RFC2822 format.
		$converted_date = date_format($date, 'Y-m-d H:i:s'); //SQL DateTime format.
	}else{
		//$date = date_create_from_format('Y-m-d H:i:s', $date); //PHP DATE_RFC2822 format.
		$converted_date = date('D, j M Y H:i:s O', strtotime($date)); //SQL DateTime format.			
	}
	return $converted_date;
}

?>