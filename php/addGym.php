<?php
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



echo "arrived\n";
if(!($stmt = $mysqli->prepare("INSERT INTO gyms(name,badges,pokeType,r_id) VALUES (?,?,?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("sssi",$_POST['Name'],$_POST['Badges'],$_POST['Types'],$_POST['Region']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo " " . $stmt->affected_rows . " gym was created.";
}
?>
<!--Take us back to the main page-->
<form action="../PokemonDB.php">
    <input type="submit" value="Return to Main Menu" />
</form>
