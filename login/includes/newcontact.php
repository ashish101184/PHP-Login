<?php
class NewContact extends DbConn
{
    public function createContact($service,$data)
    {
        try {
            $db = new DbConn;
            $tbl_contacts = $db->tbl_contacts;
            $id = 0;
            $dob = $data['birthday']['month']."-".$data['birthday']['day']."-".$data['birthday']['year'];
            // prepare sql and bind parameters
            $stmt = $db->conn->prepare("INSERT INTO ".$tbl_contacts." (id,service, first_name,last_name,email,address1,address2,dob,phone,last_modified,member_id)
            VALUES (:id, :service, :first_name,:last_name,:email,:address1,:address2,:dob,:phone,:last_modified,:member_id)");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':service', $service);
            $stmt->bindParam(':first_name', ($data['name']['first_name'])?$data['name']['first_name']:"");
            $stmt->bindParam(':last_name', ($data['name']['last_name'])?$data['name']['last_name']:"");
            $stmt->bindParam(':email', ($data['email'][0])?$data['email'][0]:"");
            $stmt->bindParam(':address1', (isset($data['address'][0]))?$data['address'][0]:"");
            $stmt->bindParam(':address2', (isset($data['address'][1]))?$data['address'][1]:"");
            $stmt->bindParam(':phone', (isset($data['phone'][0]))?$data['phone'][0]:"");
            $stmt->bindParam(':dob', ($dob)?$dob:"");
            $stmt->bindParam(':member_id', $_SESSION['id']);
            $stmt->bindParam(':last_modified', date("Y-m-d H:i:s"));
//            echo $stmt->queryString;exit;
            $stmt->execute();

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
        $db = new DbConn;
            $tbl_contacts = $db->tbl_contacts;
            
            if($service){
                $stmt = $db->conn->prepare("select * from ".$tbl_contacts." where member_id= :id and service = :service");
                $stmt->bindParam(':service', $service);
            }else{
                $stmt = $db->conn->prepare("select * from ".$tbl_contacts." where member_id= :id");
            }
            $stmt->bindParam(':id', $_SESSION['id']);
           
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

