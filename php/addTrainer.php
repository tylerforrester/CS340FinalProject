<?php
ini_set('display_errors', 'On');

$host = 'mysql.eecs.oregonstate.edu';
$user = 'cs290_forrestt';
$password = '5955';
$database = 'cs290_forrestt';

$mysqli = new mysqli($host, $user, $password, $database);
if($mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

/**
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","louiet-db","9TmtE8qLdKO48ggx","louiet-db");
if(!$mysqli || $mysqli->connect_errno){
echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

 **/
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
if(!($stmt = $mysqli->prepare("INSERT INTO trainers (fname,badges,pokedex,region_id) VALUES (?,?,?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ssii",$_POST['Name'],$_POST['Badge'],$_POST['Pokedex'],$_POST['Region']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Added " . $stmt->affected_rows . " rows to trainers.";
}

//need to account for linking the trainer to the gym
?>