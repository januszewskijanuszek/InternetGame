<?php
// Table infos
$statusTableId = $_SESSION['tableId'];
$userTableId = $_SESSION['userId'];

$level = $_SESSION['killCount'];
$money = $_SESSION['money'];

$weapon = $_SESSION['weapon'];
$armour = $_SESSION['armourId'];
$head = $_SESSION['headId'];

require_once "../../connectToSQL.php";
try{
$connect = @new mysqli(
HOST,
DATABASE_USERNAME,
DATABASE_PASSWORD,
DATABASE_NAME);
if($connect->connect_errno != 0){
throw new Exception(mysqli_connect_errno());
} else {
$sql = "UPDATE status SET money='$money', armourid='$armour', headid='$head', weaponid='$weapon' WHERE userid='$userTableId'";
$connect->query($sql);
}
$connect->close();
}catch (Exception $exception){
echo("Something went wrong: ");
echo($exception);
exit();
}