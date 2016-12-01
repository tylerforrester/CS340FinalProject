<!---->
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

<!--Start of the HTML example file portion-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!--Headers of the columns-->
<html>
<body>
	<h1>Pokemon Trainer Database</h1>
	<form method="post" action="addTrainer.php">

		<fieldset>
			<!--Header for name section-->
			<legend>Add Trainer</legend>
			<!--field for adding first name-->
			<p>Name: <input type="text" name="Name" /></p>
			<!--field for inputting age-->
			<p>Obtained: <input type="number" min="0" name="Badge" /> badges</p>
			<p>Recorded: <input type="number" min="0" name="Pokedex" /> pokemon</p>
			<!--Select drop down select box-->
			<p>From the: <select name="Region">
				<!---->
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
			</select></p>
			<p>Currently at: <select name="Gym">
				<!---->
				<?php
				if(!($stmt = $mysqli->prepare("SELECT gym_id, name, badges FROM gyms"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($gym_id, $name, badges)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo '<option value=" '. $gym_id . ' "> ' . $name .'-'. $badges .' </option>\n';
				}
				$stmt->close();
				?>
			</select></p>
		</fieldset>
		<p><input type="submit" /></p>
	</form>
</html>
</body>
