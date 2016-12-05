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
}**/

//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","louiet-db","9TmtE8qLdKO48ggx","louiet-db");
if(!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<link rel="stylesheet" type="text/css" href="../css/tables.css">
<body>

<table>
    <tr>
        <td>Trainer Name</td>
        <td>Location</td>
        <td>Pokemon Species</td>
        <td>Type</td>
        <td>Pokemon Name</td>
        <td>Region</td>
    </tr>
    <?php
    if(!($stmt = $mysqli->prepare("SELECT fname as Trainer, gyms.name, pokemons.species AS Species, pokemons.type, pokemons.name AS Pokemon, regions.name AS Region  from trainers INNER JOIN gym_trainer ON trainers.trainer_id = gym_trainer.trainer_id INNER JOIN gyms ON gym_trainer.gym_id = gyms.gym_id
INNER JOIN pokemons ON trainers.trainer_id = pokemons.trainer_id
INNER JOIN regions_pokemons ON pokemons.poke_id = regions_pokemons.poke_id
INNER JOIN regions  ON regions_pokemons.region_id = regions.region_id
WHERE regions.region_id = ? AND pokemons.type LIKE ?
GROUP BY trainers.fname, pokemons.name"))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!($stmt->bind_param("is",$_POST['Region'],$_POST['Type']))){
        echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->bind_result($nFirst, $nGym, $nSpecies, $nType, $nPoke, $nRegion)){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    while($stmt->fetch()){
        echo "<tr>\n<td>\n" . $nFirst . "\n</td>\n<td>\n" . $nGym . "\n</td>\n<td>\n" . $nSpecies . "\n</td>\n<td>\n" . $nType . "\n</td>\n<td>\n" . $nPoke . "\n</td>\n<td>\n" . $nRegion ."\n</td>\n</tr>";
    }
    echo $stmt->num_rows . " account(s) were found.";
    $stmt->close();
    ?>
</table>

<!-------Re-search------->
<form method="post" action="filterTrainer1.php">
    <fieldset>
        <legend>Enter the information to search. </legend>
        <p>Pokemon Type: <input type="text" name="Type" /></p>
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
            </select><p>
            <input type="submit" value="Find"/></p>
    </fieldset>
</form>

<!--Take us back to the main page-->
<form action="../PokemonDB.php">
    <input type="submit" value="Return to Main Menu" />
</form>
</body>
</html>