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
?>
<link rel="stylesheet" type="text/css" href="css/tables.css">
<?php
	if(!($stmt = $mysqli->prepare("INSERT INTO pokemons (name,species,evolution,type,experience,trainer_id) VALUES (?,?,?,?,?,?)"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!($stmt->bind_param("ssssii",$_POST['Name'],$_POST['Species'],$_POST['Evolution'],$_POST['Types'],$_POST['Exp'],$_POST['Trainer']))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->execute()){
		echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
	} else {
		echo $stmt->affected_rows . " Pokemon added ";
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<link rel="stylesheet" type="text/css" href="../css/tables.css">
	<body>
		<table>
			<tr>
				<th>Name</th>
				<th>Species</th>
				<th>Evolution</th>
				<th>Exp</th>
				<th>Type</th>
				<th>Region</th>
				<th>Trainer</th>
			</tr>
			<?php
			if(!($stmt = $mysqli->prepare("SELECT pokemons.name,pokemons.species,pokemons.evolution,pokemons.experience,pokemons.type,regions.name,trainers.fname FROM regions INNER JOIN regions_pokemons ON regions.region_id=regions_pokemons.region_id INNER JOIN pokemons ON regions_pokemons.poke_id=pokemons.poke_id INNER JOIN trainers ON pokemons.trainer_id = trainers.trainer_id WHERE pokemons.poke_id = ?"))){
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}
			if(!($stmt->bind_param("i",$savepoke))){
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}
			if(!$stmt->execute()){
				echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
			}
			if(!$stmt->bind_result($nFirst, $nPoke, $nEvo, $nExp, $nType, $nRegion, $nTrainer)){
				echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
			}
			while($stmt->fetch()){
				echo "<tr>\n<td>\n" . $nFirst . "\n</td>\n<td>\n" . $nPoke . "\n</td>\n<td>\n" . $nEvo . "\n</td>\n<td>\n" . $nExp . "\n</td>\n<td>\n" . $nType . "\n</td>\n<td>\n" . $nRegion . "\n</td>\n<td>\n" . $nTrainer . "\n</td>\n</tr>";
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