<?php
class NewUserForm extends DbConn
{
    public function createUser($usr, $uid, $email, $pw)
    {
        try {

            $db = new DbConn;
            $tbl_members = $db->tbl_members;
            $verified = 1;
            // prepare sql and bind parameters
            $stmt = $db->conn->prepare("INSERT INTO ".$tbl_members." (id, username, password, email,verified)
            VALUES (:id, :username, :password, :email,:verified)");
            $stmt->bindParam(':id', $uid);
            $stmt->bindParam(':username', $usr);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $pw);
            $stmt->bindParam(':verified', $verified);
            $stmt->execute();
            echo $db->conn->lastInsertId();exit;
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
}
