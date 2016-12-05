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

	$newGym = $mysqli->insert_id;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<link rel="stylesheet" type="text/css" href="../css/tables.css">
<body>
<table>
	<tr>
		<th>Name</th>
		<th>Badge Number</th>
		<th>Type</th>
		<th>Region</th>
	</tr>
	<?php
	if(!($stmt = $mysqli->prepare("SELECT gyms.name,gyms.badges,gyms.pokeType,regions.name FROM gyms INNER JOIN regions ON regions.region_id = gyms.r_id WHERE gyms.gym_id = ?"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!($stmt->bind_param("i",$newGym))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->execute()){
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	if(!$stmt->bind_result($gName, $gBadge, $gType, $gRegion)){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	while($stmt->fetch()){
		echo "<tr>\n<td>\n" . $gName . "\n</td>\n<td>\n" . $gBadge . "\n</td>\n<td>\n" . $gType . "\n</td>\n<td>\n" . $gRegion . "\n</td>\n</tr>";
	}
	$stmt->close();
	?>
</table>

<!--Take us back to the main page-->
<form action="../PokemonDB.php">
	<input type="submit" value="Return to Main Menu" />
</form>
</body>
</html>