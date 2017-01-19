<?php
include 'dbconn.php';
class NewContact extends DbConn
{
    public function createContact($service,$data)
    {
        try {
            $db = new DbConn;
            $tbl_contacts = $db->tbl_contacts;
            $id = 0;
            $service_id = $this->getServiceIdByName($service);
            $dob = $data['birthday']['month']."-".$data['birthday']['day']."-".$data['birthday']['year'];
            // prepare sql and bind parameters
            $stmt = $db->conn->prepare("INSERT INTO client_contacts (client_id, service,linkedservice_id, first_name, last_name, email, address, street, city, state, zip, country, dob, phone, imageurl, website, notes,last_modified)
            VALUES (:client_id, :service,:linkedservice_id, :first_name, :last_name, :email, :address1, :street, :city, :state, :zip, :country, :dob, :phone, :imageurl, :website, :notes,:last_modified)");
            
            $stmt->bindParam(':client_id', $_SESSION['client']['client_id']);
            $stmt->bindParam(':service', $service);
            $stmt->bindParam(':linkedservice_id', $service_id);
            $stmt->bindParam(':first_name', ($data['name']['first_name'])?$data['name']['first_name']:"");
            $stmt->bindParam(':last_name', ($data['name']['last_name'])?$data['name']['last_name']:"");
            $stmt->bindParam(':email', ($data['email'][0])?$data['email'][0]:"");
            $stmt->bindParam(':address1', (isset($data['address'][0]['street']))?$data['address'][0]['street']:"");
            
            $stmt->bindParam(':street', (isset($data['address'][0]['street']))?$data['address'][0]['street']:"");
            $stmt->bindParam(':city', (isset($data['address'][0]['city']))?$data['address'][0]['city']:"");
            $stmt->bindParam(':state', (isset($data['address'][0]['state']))?$data['address'][0]['state']:"");
            $stmt->bindParam(':zip', (isset($data['address'][0]['zip']))?$data['address'][0]['zip']:"");
            $stmt->bindParam(':country', (isset($data['address'][0]['country']))?$data['address'][0]['country']:"");
            
            $stmt->bindParam(':phone', (isset($data['phone'][0]))?$data['phone'][0]:"");
            $stmt->bindParam(':imageurl', (isset($data['imageurl']))?$data['imageurl']:"");
            $stmt->bindParam(':website', (isset($data['website'][0]))?$data['website'][0]:"");
            $stmt->bindParam(':notes', (isset($data['notes']))?$data['notes']:"");
            $stmt->bindParam(':dob', ($dob)?$dob:"");
            $stmt->bindParam(':notes', (isset($data['notes']))?$data['notes']:"");
            $stmt->bindParam(':last_modified', date("Y-m-d H:i:s"));
			//echo $stmt->queryString;exit;
            $stmt->execute();
			
			if($data['imageurl'] != ''){
                                $contact_id = $db->conn->lastInsertId();
				$img = $_SERVER['DOCUMENT_ROOT'].'/contacts/'.$_SESSION['client']['client_id'].'/'.$contact_id.'.jpg';
                                if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/contacts/'.$_SESSION['client']['client_id'])){
                                    mkdir($_SERVER['DOCUMENT_ROOT'].'/contacts/'.$_SESSION['client']['client_id'],0755);
                                }
				file_put_contents($img, file_get_contents($data['imageurl']));
				
//				$ch = curl_init($data['imageurl']);
//				$fp = fopen($img, 'wb');
//				curl_setopt($ch, CURLOPT_FILE, $fp);
//				curl_setopt($ch, CURLOPT_HEADER, 0);
//				curl_exec($ch);
//				curl_close($ch);
//				fclose($fp);
			}
			
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
            echo $err = "Error: " . $e->getMessage();

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
        $db = new DbConn;
            $tbl_contacts = "client_contacts";
            
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
                    $emails[$result['contact_id']] = $result['email'];
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
    
    function updateContactLastModified($id){
        $db = new DbConn;
        $tbl_contacts = "client_contacts";
        $stmt = $db->conn->prepare("UPDATE ".$tbl_contacts." set last_modified = :last_modified where contact_id = :contact_id");
        $stmt->bindParam(':last_modified', date("Y-m-d H:i:s"));
        $stmt->bindParam(':contact_id', $id);
        $stmt->execute();
    }
    
    function updateClientServices($service){
        try{
            $db = new DbConn;
            
            $service_id = $this->getServiceIdByName($service);
            $tbl_client_services = 'client_services';

            $stmtExist = $db->conn->prepare("SELECT * FROM ".$tbl_client_services." WHERE service_id = :service_id AND client_id = :client_id");
            $stmtExist->bindParam(':service_id', $service_id);
            $stmtExist->bindParam(':client_id', $_SESSION['client']['client_id']);
            $stmtExist->execute();
            $resultExist = $stmtExist->fetch(PDO::FETCH_ASSOC);        
            if(!empty($resultExist)){
                $stmt1 = $db->conn->prepare("UPDATE ".$tbl_client_services." SET lastsync = :lastsync WHERE client_id= :client_id AND service_id= :service_id");
            }else{
                $stmt1 = $db->conn->prepare("INSERT INTO ".$tbl_client_services." VALUES ('', :client_id, :service_id, :lastsync, 1)");
            }
            
            $stmt1->bindParam(':service_id', $service_id);
            $stmt1->bindParam(':lastsync', date("Y-m-d H:i:s"));
            $stmt1->bindParam(':client_id', $_SESSION['client']['client_id']);
            $stmt1->execute();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function getServiceIdByName($service){
        $db = new DbConn;
        $tbl_system_syncservices = "system_syncservices";

        $stmt = $db->conn->prepare("SELECT * FROM ".$tbl_system_syncservices." WHERE socialinviter_name= :socialinviter_name");
        $stmt->bindParam(':socialinviter_name', $service);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['service_id'];        
    }
}

?>