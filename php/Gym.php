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
			<legend>Add Gym</legend>
			<p>Name: <input type="text" name="Name" /></p>
			<p>Badge: <input type="number" min="1" max="8" name="Badges" /></p>
			<p>Type: <input type="text" name="Types" /></p>
			<!--Select drop down select box-->
			<p>In the: <select name="Region">
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
			</select> Region</p>
		<input type="submit"/>
		</fieldset>
	</form>
</body>
</html>