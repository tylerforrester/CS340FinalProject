<?php

/**
 * Created by PhpStorm.
 * User: tylerf
 * Date: 12/2/16
 * Time: 10:01 AM
 *//* check connection */

$host = 'mysql.eecs.oregonstate.edu';
$user = 'cs290_forrestt';
$password = '5955';
$database = 'cs290_forrestt';


ini_set('display_errors', 'On');
//Connects to the database
//$mysqli = new mysqli("oniddb.cws.oregonstate.edu","forrestt-db","l4myA80j8wUoQmDi","forrestt-db");
$mysqli = new mysqli($host, $user, $password, $database);



if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
/** TODO Gym redirect button on main page */

/** TODO Query gym by name */

/* TODO Populate a form which re-names gym */


/* TODO Submit this form to redirect page */

/* TODO move from get to post   */





$id=$_GET["gym_id"];
$stmt = $mysqli->prepare("SELECT name FROM gyms WHERE gyms.gym_id=?");
$stmt->bind_param('i', $id);

/* execute prepared statement */
$stmt->execute();
$stmt->bind_result($name);

while($stmt->fetch()){

    $names=array($name);
    // echo($id."\n");

}

   $tempnames = explode(" ",$names[0]);
   $names[0] = $tempnames[0];
/* close statement and connection */
$stmt->close();



?>



<!doctype html> <html>
<head>

    <title> Poke Gym Title </title>


</head>




<body>

<h1>Pokemon Trainer Database</h1>

<form action="../PokemonDB.php">

<label for="n"> Enter the gym's new name </label>
<input type="text"  name="newnam" value="<?php echo($names[0]); ?>" id="n">		<!--Header for name section-->
<input type="hidden" name="id" value="<?php echo($id); ?>" >
<input type="submit"/>

</form>

</body>


</html>



