<?php
//Turn on error reporting
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
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<body>
<?php
if(!($stmt = $mysqli->prepare("INSERT INTO trainers (fname,badges,pokedex,region_id) VALUES (?,?,?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ssii",$_POST['Name'],$_POST['Badge'],$_POST['Pokedex'],$_POST['Region']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Added " . $stmt->affected_rows . " rows to pokemon.";
}
?>
	<!-------Pokemon info------->
	<table>
		<tr>
			<td>Trainer Info</td>
		</tr>
		<tr>
			<td>Name</td>
			<td>Evolution</td>
			<td>Pokedex</td>
		</tr>
		<?php
			if(!($stmt = $mysqli->prepare("SELECT fname, badges, pokedex FROM trainers"))){
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!$stmt->execute()){
				echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
			}
			if(!$stmt->bind_result($name, $age, $homeworld)){
				echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
			}
			while($stmt->fetch()){
			 echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $age . "\n</td>\n<td>\n" . $homeworld . "\n</td>\n</tr>";
			}
			$stmt->close();
			?>
	</table>

	<!-------Link pokemon to a trainer------->
	<form method="post" action="php/Pokemon.php">
		<fieldset>
			<legend>Does this pokmeon belong to a trainer? </legend>
				<select name="Trainer">
					<?php
					if(!($stmt = $mysqli->prepare("SELECT trainer_id, fname FROM trainers"))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($id, $pname)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
					 echo '<option value=" '. $id . ' "> ' . $pname . '</option>\n';
					}
					$stmt->close();
					?>
				</select>
		</fieldset>
		<input type="submit" value="Select" />
	</form>
	
	<input type="submit" value="Return to Main page" />
</body>
</html>