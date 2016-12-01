<?php
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 12/1/2016
 * Time: 3:05 PM
 */
  $host = 'mysql.eecs.oregonstate.edu';
  $user = 'cs290_forrestt';
  $password = '5955';
  $database = 'cs290_forrestt';


ini_set('display_errors', 'On');
//Connects to the database
//$mysqli = new mysqli("oniddb.cws.oregonstate.edu","forrestt-db","l4myA80j8wUoQmDi","forrestt-db");
$mysqli = new mysqli($host, $user, $password, $database);
if($mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

if(!($stmt = $mysqli->prepare('




'))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
else{


echo "Successful";
}
if(!$stmt->execute()){
    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
else{


    echo "Twice";
}
if(!$stmt->bind_result($region_id, $name)){
    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
    echo '<option value=" '. $region_id . ' "> ' . $name . '</option>\n';
}
$stmt->close();



?>