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
	if(isset($_GET['newnam'])) {
		$query = "UPDATE gyms SET name=? WHERE gym_id=?";

		$stmt = $mysqli->prepare($query);
		$stmt->bind_param('si', $name, $id);

		$name = $_GET["newnam"]. " Badge";
		$id = $_GET["id"];

		/* execute prepared statement */
		$stmt->execute();

		printf("Congratulations, you've just renamed gym ".$id.", ".$name."!!");
		/* close statement and connection */
		$stmt->close();
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
	<link rel="stylesheet" type="text/css" href="css/tables.css">
	<title>Pokemon Trainer Database</title>
	<body>
		<h1> Pokemon Database</h1>
		<hr>
		<h2> Welcome to the Pokemon Trainer Database. </h2>

		<a href="pokefacts.php"> See our new Interesting Poke Fact Page! </a>
		<br>
		<h3 style="color:#FF0000" > Are you by chance a new Pokemon Trainer? </h3>
			<!-------Adding a new trainer to the DB------->
			<form method="post" action="php/addTrainer.php">
				<fieldset>
					<legend>Yes, let me enter my Trainer information. </legend>
					<p>Name: <input type="text" name="Name" /></p>
					<p>Obtained: <input type="number" min="0" name="Badge" /> badges</p>
					<p>Recorded: <input type="number" min="0" name="Pokedex" /> pokemon</p>
					<p>Currently at the: <select name="Gym">
						<?php
							if(!($stmt = $mysqli->prepare("SELECT gym_id, name FROM gyms"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($gym_id, $name)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value=" '. $gym_id . ' "> ' . $name . '</option>\n';
							}
							$stmt->close();
						?>
					</select>
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
					</select>
					<p><input type="submit" value="Register"/></p>
				</fieldset>
			</form>
			<!-----------Update Trainer Info, Should take us to the Trainer info page-------------->
			<form action="php/updateTrainer.php">
				<fieldset>
					<legend>No, I'm already in the system. </legend>
					<h4>Need to change some information about your trainer?</h4>
					<input type="submit" name="update" value="Update Trainer"</input>
				</fieldset>
			</form>
		<!-------Find a Trainer based on Trainer or Pokemon Info------->
		<h3 style="color:#FF0000" > Looking for a Trainer to battle? </h3>
		<form method="post" action="php/filterTrainer1.php">
			<fieldset>
				<legend>Enter the information to search. </legend>
				<p>Pokemon Type to battle against: <input type="text" name="Type" /></p>
				<p>In the: <select name="Region">
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
					</select> Region. <p>
					<input type="submit" value="Find"/></p>
			</fieldset>
		</form>
			<!--------------Section for non-trainer addition-------------->
			<h3 style="color:#FF0000"> Not a trainer? </h3>

			<!-------Adding a new pokemon to the system------->
			<form method="post" action="php/addPokemon.php">
				<fieldset>
					<legend>You found a Pokemon? </legend>
					<p>Name: <input type="text" name="Name" /></p>
					<p>Species: <input type="text" name="Species" /></p>
					<p>Evolution: <input type="text" name="Evolution" /></p>
					<p>Types: <input type="text" name="Types" /></p>
					<p>Experience: <input type="number" min="0" name="Exp" /></p>
					<p>Belongs to Trainer
					<select name="Trainer">
						<?php
							if(!($stmt = $mysqli->prepare("SELECT trainer_id, fname FROM trainers"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($trainer_id, $fname)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
							 echo '<option value=" '. $trainer_id . ' "> ' . $fname . '</option>\n';
							}
							$stmt->close();
						?>
					</select></p>
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

			<!-------Create a New Gym------->
			<form method="post" action="php/addGym.php">
				<fieldset>
					<legend>Hipster place to battle other trainers? You're say I probably never heard of it before?</legend>
					<p>Name: <input type="text" name="Name" /></p>
					<p>Badge: <input type="number" min="1" max="8" name="Badges" /></p>
					<p>Type: <input type="text" name="Types" /></p>
					<p>In the: <select name="Region">
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
		<!-------Check the number of people at Gym------->
		<form method="post" action="php/filterGym1.php">
			<fieldset>
				<legend>Want to stay away from busy Gyms?</legend>
				<p><input type="number" min="1" name="Pokedex" /> is too many people. </p>
				<input type="submit" value="Check"/>
			</fieldset>
		</form>

			<!-------Rename your Gym------->
		<form method="get" action="php/updateGymName2.php">
			<fieldset>
				<legend> Bored with the Gym Names. Change Them!</legend>
				<p> Select Gym <select name="gym_id">
						<!---->
						<?php
							if(!($stmt = $mysqli->prepare("SELECT gym_id, name FROM gyms"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($gym_id, $name)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
								echo '<option value="'. $gym_id . '"> ' . $name . '</option>\n';
							}
							$stmt->close();
						?>
					</select> Gym </p>
				<input type="submit" value="Change It!"/>
			</fieldset>
		</form>
		<!------ See a complete list of gyms ----->


		<form action="php/gymList.php">
			<fieldset>

		    	<legend>Checkout our Gyms!</legend>

			    <input type="submit" value="Complete List of Gyms">

			</fieldset>
		</form>



		<!-------Create a New Region------->
		<form method="post" action="php/addRegion.php">
			<fieldset>
				<legend>A region just joined the International Trainer Consortium?</legend>
				<p>Name: <input type="text" name="Name" /></p>
				<p>Adjacent to the: <select name="Adjacent">
					<option value="">None</option>
					<?php
						if(!($stmt = $mysqli->prepare("SELECT name, region_id FROM regions"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}
						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						if(!$stmt->bind_result($name, $region_id)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						while($stmt->fetch()){
							echo '<option value=" '. $name . ' "> ' . $name . '</option>\n';
						}
						$stmt->close();
					?>
				</select> Region</p>
			<input type="submit"/>
			</fieldset>
		</form>

	</body>
</html>