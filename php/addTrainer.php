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



if(!($stmt = $mysqli->prepare("INSERT INTO trainers (fname,badges,pokedex,region_id) VALUES (?,?,?,?)"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("siii",$_POST['Name'],$_POST['Badge'],$_POST['Pokedex'],$_POST['Region']))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
    echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
    echo $stmt->affected_rows . " trainer has been added";
}
$strainer = $mysqli->insert_id;

if(!($stmt = $mysqli->prepare("INSERT INTO gym_trainer (gym_id,trainer_id) VALUES (?,?)"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ii",$_POST['Gym'],$strainer))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
    echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
    echo " and " . $stmt->affected_rows . " added to gym.";
}
?>
<!-------Form to add new Pokemon------->
<form method="post" action="addPokemon.php">
    <fieldset>
        <legend>You caught a wild Pokemon? </legend>
        <p>Name: <input type="text" name="Name" /></p>
        <p>Species: <input type="text" name="Species" /></p>
        <p>Evolution: <input type="text" name="Evolution" /></p>
        <p>Types: <input type="text" name="Types" /></p>
        <p>Experience: <input type="number" min="0" name="Exp" /></p>
        <input type="hidden" name="Trainer" value= "<?php echo $strainer; ?>"/>
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
<!-------Link a previously added Pokemon------->
<form method="post" action="linkPoke.php">
    <fieldset>
        <legend>The pokemon is already in the system. </legend>
        <input type="hidden" name="Trainer" value= "<?php echo $strainer; ?>"/>
        <select name="Pokemon">
            <?php
            if(!($stmt = $mysqli->prepare("SELECT poke_id, name FROM pokemons"))){
                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }

            if(!$stmt->execute()){
                echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            if(!$stmt->bind_result($id, $pname)){
                echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            while($stmt->fetch()){
                echo '<option value=" '. $id . ' "> ' . $pname . '</option>\n';
            }
            $stmt->close();
            ?>
        </select>
    </fieldset>
    <!--Should take us to the Trainer info page-->
    <input type="submit" value="Select" />
</form>
</body>
</html>