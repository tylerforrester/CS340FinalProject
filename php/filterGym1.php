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
        <td>Gym Badge</td>
        <td>Type</td>
        <td>Difficulty</td>
        <td>Trainer Count</td>
        <td>Region</td>
    </tr>
    <?php
    if(!($stmt = $mysqli->prepare("SELECT gyms.name, gyms.pokeType,gyms.badges, members.counted, regions.name FROM regions INNER JOIN gyms ON regions.region_id=gyms. r_id INNER JOIN (SELECT gyms.gym_id AS gym, COUNT(trainers.trainer_id) AS counted FROM gyms INNER JOIN gym_trainer ON gyms.gym_id = gym_trainer.gym_id INNER JOIN trainers ON gym_trainer.trainer_id = trainers.trainer_id GROUP BY gyms.gym_id ORDER BY counted) AS members ON gyms.gym_id = members.gym WHERE members.counted > ?"))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!($stmt->bind_param("i",$_POST['Count']))){
        echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->bind_result($nGym, $nType, $nDifficulty, $nCount, $nRegion)){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    while($stmt->fetch()){
        echo "<tr>\n<td>\n" . $nGym . "\n</td>\n<td>\n" . $nType . "\n</td>\n<td>\n" . $nDifficulty . "\n</td>\n<td>\n" . $nCount . "\n</td>\n<td>\n" . $nRegion ."\n</td>\n</tr>";
    }
    echo $stmt->num_rows . " account(s) were found.";
    $stmt->close();
    ?>
</table>

<!-------Re-search------->
<form method="post" action="filterGym1.php">
    <fieldset>
        <legend>Want to find a gym with the most competition? </legend>
        <p><input type="number" min="0" name="Count" /> sound like a good number. </p>
        <input type="submit" value="Check"/>
    </fieldset>
</form>

<!--Take us back to the main page-->
<form action="../PokemonDB.php">
    <input type="submit" value="Return to Main Menu" />
</form>
</body>
</html>