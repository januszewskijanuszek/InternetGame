<?php
session_start();
$_SESSION['health'] = 100;
$_SESSION['enemyHealth'] = 100;
$_SESSION['random'] = true;
include 'sessionCheck.php';
// $_SESSION['userId']
// $_SESSION['userLogin']
// $_SESSION['userPassword']
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Game</title>
    <!--Here is a my css will be changed in the future-->
    <link rel="stylesheet" href="css/mainStyle.css">
    <link rel="shortcut icon" href="../../icon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!--Change font-->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
</head>
<body>
<div class="mainContainer">
    <div class="mainTitle">
        <div class="title">
            War of pHata
        </div>
        <div class="userBox">
            <?php
            if(isset($_SESSION['save']) and $_SESSION['save']){
                echo ("Your progress has been saved!");
                $_SESSION['save'] = false;
            } elseif(isset($_SESSION['infoMenu']) and $_SESSION['infoMenu']){
                echo ("Gold:".$_SESSION['money']."<br>");
                echo ("Kills: ".$_SESSION['killCount']);
                $_SESSION['infoMenu'] = false;
            }
            else{
                echo("Welcome: <br>");
                echo($_SESSION['userLogin']);
            }
            ?>
        </div>
    </div>
    <div class="userGui">
        <div class="windows">
            <div class="window">
                <input type="image" src="../../textures/usable/exitDoor.png" width="180" height="180" onClick="window.location.href='logout.php'" id="animate">
            </div>
            <div class="window">
                <input type="image" src="../../textures/usable/saveBlue.png" width="180" height="180" onClick="window.location.href='save.php'" id="animate">
            </div>
            <div class="window">
                <input type="image" src="../../textures/usable/grave.png" width="180" height="180" onClick="window.location.href='grave.php'" id="animate">
            </div>
            <div class="window">
                <input type="image" src="../../textures/usable/coinYellow.png" width="180" height="180" onClick="window.location.href='shop.php'" id="animate">
            </div>
            <div class="window">
                <input type="image" src="../../textures/usable/war.png" width="180" height="180" onClick="window.location.href='game/game.php'" id="animate">
            </div>
            <div class="window">
                <input type="image" src="../../textures/usable/settings.png" width="180" height="180" onClick="window.location.href='settings/settings.php'" id="animate">
            </div>
            <div class="window">
                <input type="image" src="../../textures/usable/tutorialBlue.png" width="180" height="180" onClick="window.location.href='../../howToPlay/tutorial1.html'" id="animate">
            </div>
            <div class="windowLeft">
                <input type="image" src="../../textures/usable/menu.png" width="180" height="180" onClick="window.location.href='info.php'" id="animate">
            </div>
            <div class="windowLeft">
                <input type="image" src="../../textures/usable/inventory.png" width="180" height="180" onClick="window.location.href='inventory.php'" id="animate">
            </div>
        </div>
    </div>
</div>
</body>
</html>
