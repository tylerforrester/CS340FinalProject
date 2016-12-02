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
if ($result = $mysqli->query("SELECT fname, badges, pokedex, trainer_id, name FROM trainers INNER JOIN  regions ON regions.region_id = trainers.region_id WHERE trainer_id = 5 GROUP BY fname")) {
    $row = $result->fetch_array();


    $result->close();
}
else{

   echo ("Please Supply a Trainer Id");
    exit;
}

?>


<!doctype html>

<head>
        <title>Updating Trainer</title>

</head>

<body>
 <form action="updateTrainer.php">
     <label for="f">Trainer Name</label>
    <input type="text" name="fname" value="<?php echo $row["fname"]; ?>" id="f">

     <p>In the: <select name="name" value='<?php echo($row["name"]); ?>'>
             <?php

             echo '<option value="'. $row["name"]  . '" selected="selected"> ' . $row["name"] . '</option>\n';
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
                 if($name != $row["name"])
                 echo '<option value="'. $region_id . '"> ' . $name . '</option>\n';
             }
             $stmt->close();
             ?>
         </select> Region</p>

     <p>In the: <select name="pokedex" value="<?php echo($row["pokedex"]); ?>">
         <?php

         echo '<option value=" '. $row["pokedex"]  . ' " selected="selected"> ' . $row["pokedex"] . '</option>\n';
         if(!($stmt = $mysqli->prepare("SELECT DISTINCT pokedex FROM trainers ORDER BY pokedex ASC"))){
             echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
         }
         if(!$stmt->execute()){
             echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
         }
         if(!$stmt->bind_result($pokedex)){
             echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
         }
         while($stmt->fetch()){
             if($pokedex != $row["pokedex"])
             echo '<option value="'. $pokedex . '"> ' . $pokedex . '</option>\n';
         }
         $stmt->close();
         ?>
         </select> Pokedex</p>

     <p>In the: <select name="badges" value"<?php echo($row["badges"]); ?>">


         <?php
         echo '<option value=" '. $row["badges"]  . ' " selected="selected"> ' . $row["badges"] . '</option>\n';

         if(!($stmt = $mysqli->prepare("SELECT DISTINCT badges FROM gyms"))){
             echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
         }
         if(!$stmt->execute()){
             echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
         }
         if(!$stmt->bind_result($badges)){
             echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
         }
         while($stmt->fetch()){
             if($badges != $row["badges"])
             echo '<option value="'. $badges . '"> ' . $badges . '</option>\n';
         }
         $stmt->close();
         ?>
         </select> Badges</p>

     <input type="hidden" name="id" value="<?php echo $row["trainer_id"]; ?>">
     <input type="submit" name="u" value="Submit to Update">


 </form>

</body>






