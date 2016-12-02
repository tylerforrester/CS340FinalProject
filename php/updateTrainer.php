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


/*** CURRENTLY BROKEN ****/
/**

if(isset($_POST['u'])){

    var_dump($_POST);

    echo "Successfully Updated";


    if(!$mysqli || $mysqli->connect_errno){
        echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }

    if(!($stmt = $mysqli->prepare("Select region_id FROM regions where name=?"))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!($stmt->bind_param("s",$_POST['name']))){
        echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
    } else {

        //   echo "Updated " . $stmt->affected_rows . " rows to trainers.";
    }

    if(!$stmt->bind_result($region)){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }

   $stmt->close();

    echo($region);

    if(!($stmt = $mysqli->prepare("Update trainers SET badges=?, pokedex=?, fname=?, region_id = ?WHERE id=?  "))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!($stmt->bind_param("iisi",$_POST['badges'],$_POST['pokedex'],$_POST['fname'], $region, $_POST['id']))){
        echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
    } else {
        echo "Updated " . $stmt->affected_rows . " rows to trainers.";
    }


    $stmt->close();


}  **/



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<body>

<!-- Select Pokemon from a List  -->

<table>
    <tr>
        <td>List of Trainers</td>
    </tr>
    <tr>
        <th>Name</th>
        <th>Badges</th>
        <th>Pokedex</th>
        <th>Region</th>
        <th>Update</th>
    </tr>

    <?php
    if(!($stmt = $mysqli->prepare("SELECT trainer_id, fname, badges, pokedex, name FROM trainers INNER JOIN regions ON regions.region_id = trainers.region_id GROUP BY fname"))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!$stmt->execute()){
        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    if(!$stmt->bind_result($trainerid, $fname, $badges, $pokedex, $region)){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    while($stmt->fetch()){
        echo "<tr>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $badges . "\n</td>\n<td>\n" . $pokedex . "\n</td><td>\n".$region."\n</td>
               <td><form method='get' action='updateTrainer2.php'/> <input type='submit' name='update' value='update'/> 
               <input type ='hidden' name='id' value='". $trainerid ."'/></form></td></tr>";
    }
    $stmt->close();
    ?>
</table>


</body>
</html>