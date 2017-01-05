<?php
session_start();
require('createContactClass.php');
$service = $_POST['service'];
$a = new NewContact;   
$emails = $a->getAllContacts();
$addedCount = 0;
foreach($addressbook as $contact){
    if(!in_array($contact['email'][0],$emails)){
        $response = $a->createContact($service,$contact);
        if($response){
            $addedCount++;
        }
    }
}
?>

