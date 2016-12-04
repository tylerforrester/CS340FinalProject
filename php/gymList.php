<?php
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 12/4/2016
 * Time: 9:15 AM
 */


ini_set('display_errors', 'On');
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


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Trainer List</title>
        <link rel="stylesheet" type="text/css" href="../css/tables.css">
    </head>
    <body>
    <!-- Select Pokemon from a List  -->
        <div class="table">
        <table>
            <caption>
List of Gyms
</caption>
            <tr>
                <th>Name</th>
                <th>Badges</th>
                <th>pokeType</th>
                <th>Region</th>

            </tr>

            <?php  //gyms  (name, badges, pokeType, r_id, gym_id)
                if(!($stmt = $mysqli->prepare("SELECT gym_id, gyms.name, badges, pokeType, regions.name FROM gyms INNER JOIN regions ON regions.region_id = gyms.r_id GROUP BY gyms.name"))){
                    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($gymid, $gyname, $gybadges, $gyType, $region)){
                    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                while($stmt->fetch()){
                    echo "<tr>\n<td>\n" . $gyname . "\n</td>\n<td>\n" . $gybadges . "\n</td>\n<td>\n" . $gyType . "\n</td><td>\n".$region."\n</td></tr>";
                }
                $stmt->close();
            ?>
    </table>
    </div>

    </body>
    </html>

<?php $mysqli->close(); ?>