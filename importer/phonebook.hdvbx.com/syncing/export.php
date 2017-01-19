<?php

if($query_string != ''){
    $result = $db->query('
	SELECT cc.*
	FROM client_contacts cc, client_services cs
	WHERE cc.client_id = cs.client_id AND cs.authkey="'.htmlentities($query_string).'"
	');
	if($result->num_rows > 0){
		print '<table>';
		while($sql = $result->fetch_array(MYSQLI_BOTH)){
			print '<tr>
				<td>'.$sql['first_name'].'</td>
				<td>'.$sql['last_name'].'</td>
				<td>'.$sql['email'].'</td>
				<td>'.$sql['address'].'</td>
				<td>'.$sql['dob'].'</td>
				<td>'.$sql['phone'].'</td>
				<td><img src="'.PATH_DOMAIN.'/contacts/'.$sql['client_id'].'/'.$sql['contact_id'].'.jpg" /></td>
				<td>'.$sql['website'].'</td>
				<td>'.$sql['notes'].'</td>
				<td>'.$sql['last_modified'].'</td>
			</tr>';
		}
		print '</table>';
	}else{
		echo 'Invalid URL';
	}
}

?>