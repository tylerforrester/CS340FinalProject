<?php
//Turn on error reporting
ini_set('display_errors', 'On');
/**
$host = 'mysql.eecs.oregonstate.edu';
$user = 'cs290_forrestt';
$password = '5955';
$database = 'cs290_forrestt';

$mysqli = new mysqli($host, $user, $password, $database);
if($mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

 **/
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","louiet-db","9TmtE8qLdKO48ggx","louiet-db");
if(!$mysqli || $mysqli->connect_errno){
echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}


if(!($stmt = $mysqli->prepare("INSERT INTO pokemons (name,species,evolution,type,experience,trainer_id) VALUES (?,?,?,?,?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ssssii",$_POST['Name'],$_POST['Species'],$_POST['Evolution'],$_POST['Types'],$_POST['Exp'],$_POST['Trainer']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Entry " . $stmt->affected_rows . " added ";
}
$savepoke = $mysqli->insert_id;

if(!($stmt = $mysqli->prepare("INSERT INTO regions_pokemons (region_id,poke_id) VALUES (?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ii",$_POST['Region'],$savepoke))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
    echo "and " . $stmt->affected_rows . " linked to region.";
}
?>