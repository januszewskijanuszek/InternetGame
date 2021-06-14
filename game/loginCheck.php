<?php
session_start();
require_once "connectToSQL.php";

if(!isset($_POST['login']) or !isset($_POST['password'])){
    header('Location:../index.php');
    exit();
}

// Import Data
$connect = @new mysqli(
    HOST,
    DATABASE_USERNAME,
    DATABASE_PASSWORD,
    DATABASE_NAME);
// Validation system

if($connect -> connect_errno != false){
    echo("Error: ").$connect->connect_errno."Desc: ".$connect -> connect_error;
} else{
    // Setting variable to login and password
    $login = $_POST['login'];
    $password = $_POST['password'];

    $login = htmlentities($login,ENT_QUOTES, 'UTF-8');
    $password = htmlentities($password,ENT_QUOTES, 'UTF-8');
    // Query to database
    $sql = "SELECT * FROM user WHERE login='$login'";
    // Sending query to database
    // $result is connection to database
    if($result = @$connect ->query(sprintf(
        "SELECT * FROM user WHERE login='%s'",
        mysqli_real_escape_string($connect, $login)))){
        if($result -> num_rows > 0){
            $record = $result->fetch_assoc();
            if(password_verify($password, $record['password'])) {

                $userId = $record['idUser'];
                $sql = "SELECT * FROM status WHERE userid='$userId'";
                $result2 = $connect->query($sql);
                $record2 = $result2->fetch_assoc();

                $_SESSION['loggedIn'] = true;
                $_SESSION['userId'] = $record['idUser'];
                $_SESSION['userLogin'] = $record['login'];
                $_SESSION['userPassword'] = $record['password'];

                // User data
                $_SESSION['tableId'] = $record2['id'];
                $_SESSION['money'] = $record2['money'];
                $_SESSION['killCount'] = $record2['level'];

                $weapon = $record2['weaponid'];
                $armour = $record2['armourid'];
                $head = $record2['headid'];

                // Weapon info
                $sql = "SELECT * FROM weapon WHERE id='$weapon'";
                $result2 = $connect->query($sql);
                $record2 = $result2->fetch_assoc();
                $_SESSION['weapon'] = $weapon;
                $_SESSION['weaponName'] = $record2['name'];
                $_SESSION['damageBody'] = $record2['damageBody'];
                $_SESSION['damageHead'] = $record2['damageHead'];
                $_SESSION['damageBodyChance'] = $record2['damageBodyChance'];
                $_SESSION['damageHeadChance'] = $record2['damageHeadChance'];

                // Body armour
                $sql = "SELECT * FROM armourhead WHERE id='$armour'";
                $result2 = $connect->query($sql);
                $record2 = $result2->fetch_assoc();
                $_SESSION['armourId'] = $armour;
                $_SESSION['bodyName'] = $record2['name'];
                $_SESSION['armourBodyProtection'] = $record2['protection'];

                // Head armour
                $sql = "SELECT * FROM armourbody WHERE id='$head'";
                $result2 = $connect->query($sql);
                $record2 = $result2->fetch_assoc();
                $_SESSION['headId'] = $head;
                $_SESSION['headName'] = $record2['name'];
                $_SESSION['armourHeadProtection'] = $record2['protection'];
                unset($_SESSION['error']);

                // Close result
                $result->close();
                header('Location:session/mainGame.php');
            } else {
                $_SESSION['error'] = "Wrong login or password";
                header('Location:login.php');
            }
        } else{
            $_SESSION['error'] = "Wrong login or password";
            header('Location:login.php');
        }
            }
    }
$connect -> close();