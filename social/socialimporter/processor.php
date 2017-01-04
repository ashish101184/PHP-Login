<?php
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'contacts':
            storeLoadedContacts();
            break;
        case 'friends':
            storeLoadedFriends();
            break;
        case 'profile':
            storeImportedProfile();
            break;
        case 'selectedcontacts':
            storeSelectedContacts();
            break;
        case 'selectedfriends':
            storeSelectedFriends();
            break;
    }
}

function storeImportedProfile(){
    $profile = json_decode($_POST['data'],true);
    $emails = $profile["email"];
    $id = $profile["id"];
    $aboutMe = $profile.aboutMe;
    $displayName = $profile.displayName;
    $dob = $profile.dob;
    $firstName = $profile.firstName;
    $lastName = $profile.lastName;
    $gender = $profile.gender;
    $location = $profile.location;
    $photo = $profile.photo;
    $profileUrl = $profile.profileUrl;
    echo $profile["displayName"];
}

function storeSelectedFriends() {
    $selectedfriends = json_decode($_POST['data'],true);
    echo sizeof($selectedfriends);
    exit;
}

//Sending email to selected recipients
//You should use your email server to send email
function storeSelectedContacts() {
    $selectedcontacts = json_decode($_POST['data'],true);
    $len = sizeof($selectedcontacts);
    for($i=0;$i<$len;$i++){
        if(gettype($selectedcontacts[$i])=="string"){
            $to = $selectedcontacts[$i];
        }
        else{
            $to = $selectedcontacts[$i]['email'][0];
        }
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $from = "support@socialinviter.com";
        mail($to,$subject,$message,$from);
    }
    echo sizeof($selectedcontacts);
    exit;
}



//store loaded contacts
function storeLoadedContacts() {
    $addressbook = json_decode($_POST['data'],true);
    echo sizeof($addressbook);
    exit;
}




//store loaded friends
function storeLoadedFriends() {
    $friends = json_decode($_POST['data'],true);
    echo sizeof($friends);
    exit;
}
?>