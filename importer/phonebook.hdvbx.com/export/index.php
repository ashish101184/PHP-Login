<?php

include('../config.php');

$debug_mode = 1;
$continue = 1;
$specific_service = '';

$query_string = 'authkey='.$_SERVER['QUERY_STRING'];
parse_str($query_string, $query_string_array);

if(isset($query_string_array['format']) && $query_string_array['format'] == 'xml'){
	$format = 'xml';
}else{
	$format = '';
}

if($query_string != '' && isset($query_string_array['authkey']) && $query_string_array['authkey'] != ''){
    $result = $db->query('
	SELECT *
	FROM clients
	WHERE external_authkey="'.htmlentities($query_string_array['authkey']).'"
	');
	if($result->num_rows == 1){
		while($sql = $result->fetch_array(MYSQLI_BOTH)){
			
			//CHECK IF EXTERNAL ENABLED
			if($sql['external_status'] == 1){
				
				//CHECK IF IP ADDRESS LIMITATION
				if($sql['external_ipaddress'] != ''){
					
					$continue = 0;
				}
				
				if($continue == 1){
					
					if($query_string_array['service'] != ''){
						$result_service = $db->query('
						SELECT *
						FROM system_syncservices
						WHERE socialinviter_name = "'.htmlentities($query_string_array['service']).'" AND service_status = 1');
						if($result_service->num_rows == 1){
							//GET CONTACTS FROM A SPECIFIC SERVICE
							$sql_service = $result_service->fetch_array(MYSQLI_BOTH);
							$specific_service = ' AND cs.service_id = "'.$sql_service['service_id'].'"';
						}else{
							$continue = 0;
							echo ($debug_mode==1?'Service does not exist or disabled':'Invalid URL');
						}
					}
					
					if($continue == 1){
						
						$result_contacts = $db->query('
						SELECT cc.*
						FROM client_services cs, client_contacts cc
						WHERE cs.client_id = "'.$sql['client_id'].'" AND cs.status = 1 AND cs.linkedservice_id = cc.linkedservice_id'.$specific_service);

						if($result_contacts->num_rows > 0){
							$contact_array = array();
							while($sql2 = $result_contacts->fetch_array(MYSQLI_BOTH)){
								if($sql2['imageurl']!=''){
									$url = '/contacts/'.$sql['client_id'].'/'.$sql2['contact_id'].'.jpg';
									if(file_exists(PATH_INCLUDE.$url)){
										$sql2['imageurl'] = PATH_DOMAIN.$url;
									}else{
										$sql2['imageurl'] = '';
									}
								}
								
								$contact_array[$sql['client_id']] = $sql2;
								
							}
							
							//WHICH FORMATTING/LAYOUT TO USE
							if($query_string_array['phone'] == '' || $query_string_array['phone'] == 'table'){
								include('html-table.php');
							}elseif($query_string_array['phone'] == 'yealink'){
								include('yealink.php');
							}
							
						}else{
							echo ($debug_mode==1?'No Contacts found':'Invalid URL');
						}
						
					}
					
				}else{
					echo ($debug_mode==1?'External Access - IP Address not allowed':'Invalid URL');
				}
			}else{
				echo ($debug_mode==1?'External Access is not allowed':'Invalid URL');
			}
		}
		
	}else{
		echo ($debug_mode==1?'Invalid AuthKey':'Invalid URL');
	}
}else{
	echo ($debug_mode==1?'Query String Missing':'Invalid URL');
}

?>