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
	echo "Added " . $stmt->affected_rows . " rows to trainers.";
}
?>
	<!-------Trainer info------->
	<table>
		<tr>
			<td>Trainer Info</td>
		</tr>
		<tr>
			<td>Name</td>
			<td>Badges</td>
			<td>Pokedex</td>
	    </tr>
		<?php
			if(!($stmt = $mysqli->prepare("SELECT fname, badges, pokedex FROM trainers"))){
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}

			if(!$stmt->execute()){
				echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
			}
			if(!$stmt->bind_result($fname, $badges, $pokedex)){
				echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
			}
			while($stmt->fetch()){
			 echo "<tr>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $badges . "\n</td>\n<td>\n" . $pokedex . "\n</td>\n</tr>";
			}
			$stmt->close();
			?>
	</table>
	<!-------Form to add new Pokemon------->
	<form method="post" action="addPokemon.php"> 
		<fieldset>
			<legend>You caught a wild Pokemon? </legend>
			<p>Name: <input type="text" name="Name" /></p>
			<p>Species: <input type="text" name="Species" /></p>
			<p>Evolution: <input type="text" name="Evolution" /></p>
			<p>Types: <input type="text" name="Types" /></p>
			<p>Experience: <input type="number" min="0" name="Exp" /></p>
			<p>From the: <select name="Region">
				<?php
				if(!($stmt = $mysqli->prepare("SELECT region_id, name FROM regions"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($region_id, $name)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $region_id . ' "> ' . $name . '</option>\n';
				}
				$stmt->close();
				?>
			</select> Region</p>
		<input type="submit"/>
		</fieldset>
	</form>
	<!-------Link a previously added Pokemon------->
	<form method="post" action="filter.php">
		<fieldset>
			<legend>The pokemon is already in the system. </legend>
				<select name="Trainer">
					<?php
					if(!($stmt = $mysqli->prepare("SELECT poke_id, name FROM pokemons"))){
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
		<!--Should take us to the Trainer info page-->
		<input type="submit" value="Select" />
	</form>
</body>
</html>