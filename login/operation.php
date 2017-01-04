<?php
error_reporting(0);
require 'includes/functions.php';
session_start();
$a = new NewContact;   
if($_GET['service']){
    $result = $a->getAllContacts($_GET['service'],$_GET['export'],$_GET['list']);
}
$count = 0;
?>
<table>
<?php

foreach($result as $key=>$value){
 if($count == 0){
     echo "<tr>";
     foreach($value as $col => $rValue){
         echo "<th>".$col."</th>";     
     }
     echo "</tr>";
     
     echo "<tr>";
     foreach($value as $col => $rValue){
         echo "<td>".$rValue."</td>";     
     }
     echo "</tr>";
     
 }else{
     echo "<tr>";
     foreach($value as $col => $rValue){
         echo "<td>".$col."</td>";     
     }
     echo "</tr>";
 }  
 $count++;
}

?>
</table>
