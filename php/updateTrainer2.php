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


$query = "SELECT fname, badges, pokedex, trainer_id, name FROM trainers INNER JOIN  regions ON regions.region_id = trainers.region_id WHERE trainer_id = ? GROUP BY fname";

$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $id);

$id = (integer)$_GET["id"];

if($id < 1){

$id = 1;

}

/* execute prepared statement */
$stmt->execute();
$stmt->bind_result($fname, $badges, $pokedex, $trainer_id, $name);
while($stmt->fetch()){

    $row = array(
            "fname" => $fname,
            "badges" => $badges,
            "pokedex" => $pokedex,
            "trainer_id" => $trainer_id,
            "name" => $name


    );


}

/* close statement and connection */
$stmt->close();


?>


<!doctype html><html>

<head>
    <link rel="stylesheet" type="text/css" href="../css/tables.css">
        <title>Updating Trainer</title>

</head>

<body>
<h1> Please Update the Trainer's Information.</h1>
<br>
<br>
<br>
<div class="uform">
 <form method="post" action="updateTrainer.php">
     <label for="f">Trainer Name</label>
    <input type="text" name="fname" value="<?php echo $row["fname"]; ?>" id="f">

     <p> Region <select name="name" value='<?php echo($row["name"]); ?>'>
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
         </select></p>

     <p> Pokedex <select name="pokedex" value="<?php echo($row["pokedex"]); ?>">
         <?php

         echo '<option value=" '. $row["pokedex"]  . ' " selected="selected"> ' . $row["pokedex"] . '</option>\n';
         if(!($stmt = $mysqli->prepare("SELECT DISTINCT pokedex FROM trainers ORDER BY pokedex+0 ASC"))){
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
         </select> </p>

     <p>Badges <select name="badges" value"<?php echo($row["badges"]); ?>">


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
         </select> </p>

     <input type="hidden" name="id" value="<?php echo $row["trainer_id"]; ?>">
     <input type="submit" name="u" value="Submit to Update">


 </form>
   </div>
</body>


</html>




