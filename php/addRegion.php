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
?>
<link rel="stylesheet" type="text/css" href="css/tables.css">
<?php
	if(!$mysqli || $mysqli->connect_errno){
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
	if(!($stmt = $mysqli->prepare("INSERT INTO regions(name,adjacent) VALUES (?,?)"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}

	if ($_POST['Adjacent'] === '') {
		$_POST['Adjacent'] = null;
	}

	if(!($stmt->bind_param("ss",$_POST['Name'],$_POST['Adjacent']))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->execute()){
		echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
	} else {
		echo htmlspecialchars($_POST['Name']). " Region added to the International Trainer Consortium.";
	}
?>
<!--Take us back to the main page-->
<form action="../PokemonDB.php">
    <input type="submit" value="Return to Main Menu" />
</form>

