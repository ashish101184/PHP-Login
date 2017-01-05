<?php

class NewContact
{
    public function createContact($service,$data)
    {
        try {
            global $db;
            $tbl_contacts = $db->tbl_contacts;
            $id = 0;
            $dob = $data['birthday']['month']."-".$data['birthday']['day']."-".$data['birthday']['year'];
            // prepare sql and bind parameters
            $stmt = $db->conn->prepare("INSERT INTO client_contacts (client_id, service, first_name, last_name, email, address, dob, phone, imageurl, website, notes)
            VALUES (:client_id, :service, :first_name, :last_name, :email, :address1, :address2, :dob, :phone, :imageurl, :website, :notes)");
            $stmt->bindParam(':client_id', $_SESSION['client']['client_id']);
			$stmt->bindParam(':service', $service);
            $stmt->bindParam(':first_name', ($data['name']['first_name'])?$data['name']['first_name']:"");
            $stmt->bindParam(':last_name', ($data['name']['last_name'])?$data['name']['last_name']:"");
            $stmt->bindParam(':email', ($data['email'][0])?$data['email'][0]:"");
            $stmt->bindParam(':address', (isset($data['address'][0]))?$data['address'][0]:"");
            $stmt->bindParam(':phone', (isset($data['phone'][0]))?$data['phone'][0]:"");
			$stmt->bindParam(':imageurl', (isset($data['imageurl']))?$data['imageurl']:"");
			$stmt->bindParam(':website', (isset($data['website']))?$data['website']:"");
            $stmt->bindParam(':dob', ($dob)?$dob:"");
			$stmt->bindParam(':notes', (isset($data['notes']))?$data['notes']:"");
			//echo $stmt->queryString;exit;
            $stmt->execute();
			
			/*{
			"name":{"first_name":"Alexander","last_name":"Elston"},
			"email":["alexelston1987@gmail.com","badboyvtec@gmail.com"],
			"address":[{"street":"","city":"London,+Greater+London,+United+Kingdom","state":"","zip":"","country":"","formattedaddress":"London,+Greater+London,+United+Kingdom"}],
			"phone":["+447946116024"],
			"imageurl":"https://www.google.com/m8/feeds/photos/media/nebmo88%40gmail.com/580e330108e568a7/eWpUZQNdfCt7I2A7O2QNFAV3RU5HBFN4Tgg?access_token=ya29.CjDKA52dJBuWucWkWDAm5ye4MbmOpsc6ppoWCLTirr0MyxPbQR9cf4T8DbE57k79-1k",
			"website":["https://www.facebook.com/badboyvtec","http://www.google.com/profiles/102047623153094485083"],
			"birthday":{"day":"25","month":"02","year":"1987"},
			"notes":""
			}*/

            $err = '';

        } catch (PDOException $e) {
            $err = "Error: " . $e->getMessage();

        }
        //Determines returned value ('true' or error code)
        if ($err == '') {

            $success = 'true';

        } else {

            $success = $err;

        };
        return $success;

    }
    
    public function getAllContacts($service = '',$export = false,$returnResult = false){
        error_reporting(0);
        global $db;
            $tbl_contacts = $db->tbl_contacts;
            
            if($service){
                $stmt = $db->conn->prepare("SELECT * FROM ".$tbl_contacts." WHERE client_id= :client_id AND service = :service");
                $stmt->bindParam(':service', $service);
            }else{
                $stmt = $db->conn->prepare("SELECT * FROM ".$tbl_contacts." WHERE client_id= :client_id");
            }
            $stmt->bindParam(':client_id', $_SESSION['client']['client_id']);
           
            $stmt->execute();
            if(!$export){
                $emails = [];
                $allResult = [];
                while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $emails[] = $result['email'];
                    $allResult[] = $result; 
                }
                if($returnResult){
                    return $allResult; 
                }
                return $emails;
            }else{
                $this->query_to_csv($stmt,'',true);
            }

    }
    

function query_to_csv($stmt,$filename = '', $attachment = false, $headers = true) {
        
        if($attachment) {
            // send response headers to the browser
            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment;filename=export.csv');
            $fp = fopen('php://output', 'w');
        } else {
            $fp = fopen($filename, 'w');
        }
        
//        $result = mysql_query($query, $db_conn) or die( mysql_error( $db_conn ) );
        
        if($headers) {
            // output header row (if at least one row exists)
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row) {
                fputcsv($fp, array_keys($row));
                // reset pointer back to beginning
                mysql_data_seek($result, 0);
            }
        }
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($fp, $row);
        }        
        fclose($fp);
    }
}

?>