<?php
session_start();
include 'sessionCheck.php';
// To change
// Armour body
$bodyName = $_SESSION['bodyName'];
$armourBody = $_SESSION['armourId'];
$armourBodyProtection = $_SESSION['armourBodyProtection'];
// Armour head
$headName = $_SESSION['headName'];
$armourHead = $_SESSION['headId'];
echo($armourHead);
$armourHeadProtection = $_SESSION['armourHeadProtection'];
// Weapon
$weaponName = $_SESSION['weaponName'];
$weapon = $_SESSION['weapon'];
$damageBody = $_SESSION['damageBody'];
$damageHead = $_SESSION['damageHead'];
$damageBodyChance = $_SESSION['damageBodyChance'];
$damageHeadChance = $_SESSION['damageHeadChance'];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Inventory</title>
    <!--Here is a my css will be changed in the future-->
    <link rel="stylesheet" href="css/inventory.css">
    <link rel="shortcut icon" href="../../icon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!--Change font-->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
</head>
<body>
<div class="mainContainer">
    <div class="mainTitle">
        <div class="title">
            Inventory:
        </div>
        <div class="userBox">
            All your inventory storage
        </div>
    </div>
    <div class="userGui">
        <div class="windows">
            <div class="window">
                <?php
                    switch ($armourBody){
                        case 1:{
                            echo('<input type="image" src="../../textures/armour/body/none.png" width="225" height="225" id="animate">');
                            break;
                        }
                        case 2:{
                            echo('<input type="image" src="../../textures/armour/body/armourTier1.png" width="225" height="225" id="animate">');
                            break;
                        }
                        case 3:{
                            echo('<input type="image" src="../../textures/armour/body/armourTier2.png" width="225" height="225" id="animate">');
                            break;
                        }
                        case 4:{
                            echo('<input type="image" src="../../textures/armour/body/armourTier3.png" width="225" height="225" id="animate">');
                            break;
                        }
                    }
                ?>
                <div class="bottomInfo">
                    <?php
                        echo($bodyName."<br>");
                        echo("Protection: ".$armourBodyProtection);
                    ?>
                </div>
            </div>
            <div class="window">
                <?php
                switch ($armourHead){
                    case 1:{
                        echo('<input type="image" src="../../textures/armour/head/none.png" width="225" height="225" id="animate">');
                        break;
                    }
                    case 2:{
                        echo('<input type="image" src="../../textures/armour/head/armourTier1.png" width="225" height="225" id="animate">');
                        break;
                    }
                    case 3:{
                        echo('<input type="image" src="../../textures/armour/head/armourTier2.png" width="225" height="225" id="animate">');
                        break;
                    }
                    case 4:{
                        echo('<input type="image" src="../../textures/armour/head/armourTier3.png" width="225" height="225" id="animate">');
                        break;
                    }
                }
                ?>
                <div class="bottomInfo">
                    <?php
                    echo($headName."<br>");
                    echo("Protection: ".$armourHeadProtection);
                    ?>
                </div>
            </div>
            <div class="window">
                <?php
                switch ($weapon){
                    case 1:{
                        echo('<input type="image" src="../../textures/weapon/knife.png" width="225" height="225" id="animate">');
                        break;
                    }
                    case 2:{
                        echo('<input type="image" src="../../textures/weapon/glock.png" width="225" height="225" id="animate">');
                        break;
                    }
                    case 3:{
                        echo('<input type="image" src="../../textures/weapon/enfield.png" width="225" height="225" id="animate">');
                        break;
                    }
                    case 4:{
                        echo('<input type="image" src="../../textures/weapon/mp5.png" width="225" height="225" id="animate">');
                        break;
                    }
                    case 5:{
                        echo('<input type="image" src="../../textures/weapon/falafel.png" width="225" height="225" id="animate">');
                        break;
                    }
                    case 6:{
                        echo('<input type="image" src="../../textures/weapon/ak47.png" width="225" height="225" id="animate">');
                        break;
                    }
                    case 7:{
                        echo('<input type="image" src="../../textures/weapon/flamethrower.png" width="225" height="225" id="animate">');
                        break;
                    }
                }
                ?>
                <div class="bottomInfo">
                    <?php
                    echo($weaponName."<br>");
                    echo("Damage Body: ".$damageBody."<br>");
                    echo("Damage Head: ".$damageHead."<br>");
                    echo("Body Chance: ".$damageBodyChance."% <br>");
                    echo("Head Chance: ".$damageHeadChance."% <br>");
                    ?>
                </div>
            </div>
            <div class="window" id="animate">
                <input type="image" src="../../textures/usable/exitDoorRed.png" width="225" height="225" onClick="window.location.href='mainGame.php'">
                <div class="bottomInfo">
                    EXIT
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
