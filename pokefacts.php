<?php
/**
 * Created by PhpStorm.
 * User: tylerf
 * Date: 12/2/16
 * Time: 3:24 PM
 */



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

$query = "SELECT COUNT(pokemons.poke_id) AS \"Number of Pokemon in Region\", regions.name AS Region FROM pokemons INNER JOIN regions_pokemons ON pokemons.poke_id = regions_pokemons.poke_id
INNER JOIN regions ON regions_pokemons.region_id = regions.region_id
GROUP BY regions.name";

$query1 ="SELECT COUNT(poke_id), trainers.fname AS Trainer  FROM trainers 
INNER JOIN pokemons ON trainers.trainer_id = pokemons.trainer_id
GROUP BY trainers.fname ORDER BY COUNT(poke_id)+0 DESC LIMIT 3";


$query2="SELECT COUNT(pokemons.poke_id), regions.name AS Region from pokemons 
INNER JOIN trainers ON trainers.trainer_id = pokemons.trainer_id
INNER JOIN regions_pokemons ON pokemons.poke_id = regions_pokemons.poke_id
INNER JOIN regions  ON regions_pokemons.region_id = regions.region_id
WHERE pokemons.name IS NULL
GROUP BY regions.name
ORDER BY COUNT(pokemons.poke_id) DESC LIMIT 1";

$query3="SELECT type, max(experience), trainers.fname FROM pokemons INNER JOIN trainers ON trainers.trainer_id = pokemons.trainer_id";
//$stmt = $mysqli->prepare($query3);
/* execute prepared statement
$stmt->execute();
$stmt->bind_result($pokemon, $experience, $trainer );
while($stmt->fetch()){

    $rows[] = array(
        "pokemon" => $pokemon,
        "trainer" => $trainer,
        "experience"=>$experience
    );

  } */
//var_dump($rows);
/* close statement and connection */
//$stmt->close();




?>






<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>

    <title>Pokefacts!</title>
    <link rel="stylesheet" type="text/css" href="css/tables.css">
</head>
<body>

<!-- Select Pokemon from a List  -->
<h1>Interesting Pokefacts!</h1>
<div id = "1" class="table">
<table>

   <caption style='text-align: center' > Number of Pokemon in Each Region  </caption>

  <thead>
     <tr>

        <th>Region</th>
        <th>Number</th>
    </tr>
  </thead>
    <tbody>
    <?php
    if(!($stmt = $mysqli->prepare($query))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!$stmt->execute()){
        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    if(!$stmt->bind_result($number, $region)){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    while($stmt->fetch()){
        echo "<tr>\n<td style='text-align: center'>\n" . $region . "\n</td>\n<td>\n" . $number . "\n</td>";

    }
    $stmt->close();
    ?>
    </tbody>
</table>
</div>

<div id="2" class="table">
<table>
    <caption style='text-align: center' > Top 3 Pokemon Trainers by Pokemon owned </caption>
    <thead>

    <tr>

        <th>Trainer</th>
        <th>Number</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(!($stmt = $mysqli->prepare($query1))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!$stmt->execute()){
        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    if(!$stmt->bind_result($number, $trainer)){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    while($stmt->fetch()){
        echo "<tr>\n<td style='text-align: center'>\n" . $trainer . "\n</td>\n<td>\n" . $number . "\n</td>";

    }
    $stmt->close();
    ?>
    </tbody>
</table>
</div>

<div id="3" class="table">
<table>
    <caption style='text-align: center' > Top Region for Unnamed Pokemon </caption>
    <thead>
    <tr>
        <th>Region</th>
        <th>Pokemon</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(!($stmt = $mysqli->prepare($query2))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!$stmt->execute()){
        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    if(!$stmt->bind_result($number, $region)){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    while($stmt->fetch()){
        echo "<tr>\n<td style='text-align: center'>\n" . $region . "\n</td>\n<td>\n" . $number . "\n</td>";

    }
    $stmt->close();
    ?>
    </tbody>
</table>

</div>

<div id="4" class ="table">

<table>
    <caption style='text-align: center' > Biggest Most Experienced Pokemon</caption>
    <thead>
    <tr>

        <th>Trainer</th>
        <th>Type</th>
        <th>Experience</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(!($stmt = $mysqli->prepare($query3))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!$stmt->execute()){
        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    if(!$stmt->bind_result($trainer, $type, $experience)){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    while($stmt->fetch()){
        echo "<tr><td style='text-align: center'>\n" . $trainer. "\n</td><td>\n" . $type . "\n</td><td>\n" . $experience. "\n</td>";

    }
    $stmt->close();
    ?>
    </tbody>
</table>

</div>




</body>
</html>
