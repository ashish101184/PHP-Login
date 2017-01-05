<?php include ('../config.php'); $data = array();	

if(isset($_POST['action']) && ($_POST['action'] == 'authorize' || $_POST['action'] == 'unauthorize') ){
	
	if($_POST['action'] == 'authorize'){ $status = 1; }else{ $status = 0; }
	
	$service_id = htmlentities($_POST['service_id']); 
	if($service_id == ''){
		$data['response'] = 'fail';
		$data['details'] = 'Value missing.';
	}else{
		
		$result = $db->query("SELECT * FROM client_services WHERE service_id = '".$service_id."' AND client_id='".$_SESSION['client']['client_id']."'");
		if($result->num_rows == 0){
			$db->query("INSERT INTO client_services VALUES ('', '".$_SESSION['client']['client_id']."', '".$service_id."', '', '".$status."')");
		}else{
			$db->query("UPDATE client_services SET status = '".$status."' WHERE client_id='".$_SESSION['client']['client_id']."' AND service_id='".$service_id."'");
		}
		
		$data['response'] = 'success';
		$data['details'] = 'Updated!';
		
	}
}

header('Content-Type: application/json');
echo json_encode($data);	

?>