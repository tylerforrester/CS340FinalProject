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



if(isset($_POST['u'])){

  //  var_dump($_POST);

  //  echo "Successfully Updated";


    if(!$mysqli || $mysqli->connect_errno){
        echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }


    $name =  $_POST['name'];
    $fname = $_POST['fname'];
    $pokedex =$_POST['pokedex'];
    $badges = $_POST['badges'];
    $id = $_POST['id'];

    $stmt = $mysqli->prepare("SELECT regions.region_id as id FROM regions WHERE regions.name=?");
    $stmt->bind_param('s', $name);

    /* execute prepared statement */
    $stmt->execute();
    $stmt->bind_result($id);

    while($stmt->fetch()){

        $ids=array($id);
        echo($id."\n");

    }

    /* close statement and connection */
    $stmt->close();


    $query = "UPDATE trainers SET fname=?, pokedex=?, badges=?, region_id =? WHERE trainer_id=?";


    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('siiii', $fname, $pokedex, $badges, $region_id, $id);


        $region_id = $ids[0];

    /* execute prepared statement */
    $stmt->execute();

    printf("\n%d Row Updated.\n", $stmt->affected_rows);


    /* close statement and connection */
    $stmt->close();


}  



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>

    <title>Trainer List</title>

</head>
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
        echo "<tr>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $badges . "\n</td>\n<td>\n" . $pokedex . "\n</td><td>\n".$region."\n</td><td>\n";
       /** TODO POST updateTrainer2 Broken */
        echo "<form method='get' action='updateTrainer2.php'>";
        echo "<input type='submit' name='update' value='update'>";
        echo "<input type ='hidden' name='id' value='$trainerid'></form></td></tr>";

    }
    $stmt->close();
    ?>
</table>


</body>
</html>