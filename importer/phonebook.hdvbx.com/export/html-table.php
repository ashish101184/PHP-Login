<table>

<?

foreach ($contact_array as $key){
	print_r($key);
	if($key['imageurl']!=''){
		$imageurl = '<a href="'.PATH_DOMAIN.$url.'" target="_new"><img src="'.PATH_DOMAIN.$url.'" class="img-responsive" /></a>';
	}

	print '<tr>
		<td>'.$key['first_name'].'</td>
		<td>'.$key['last_name'].'</td>
		<td>'.$key['email'].'</td>
		<td>'.$key['address'].'</td>
		<td>'.$key['dob'].'</td>
		<td>'.$key['phone'].'</td>
		<td>'.$imageurl.'</td>
		<td>'.$key['website'].'</td>
		<td>'.$key['notes'].'</td>
		<td>'.$key['last_modified'].'</td>
	</tr>';
	
}

?>
	
</table>