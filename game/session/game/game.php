<?php
session_start();

if(isset($_POST['action'])){
    switch($_POST['action']){
        case 0:{
            header('Location:../mainGame.php');
            break;
        }
        case 1:{
            // Head
            $randomNumber = rand(1, 100);
            if($randomNumber > $_SESSION['damageHeadChance']){
                $_SESSION['myInfo'] = "You Missed!";
            } else {
                $_SESSION['enemyHealth'] = $_SESSION['enemyHealth'] - ($_SESSION['damageHead'] - (($_SESSION['enemyArmourHeadProtection']/100) * $_SESSION['damageHead']));
                $_SESSION['myInfo'] = "You took ".($_SESSION['damageHead'] - (($_SESSION['enemyArmourHeadProtection']/100) * $_SESSION['damageHead']))." hp";
            }
            break;
        }
        case 2:{
            // Body
            $randomNumber = rand(1, 100);
            if($randomNumber > $_SESSION['damageBodyChance']){
                $_SESSION['myInfo'] = "You Missed!";
            } else {
                $_SESSION['enemyHealth'] = $_SESSION['enemyHealth'] - ($_SESSION['damageBody'] - (($_SESSION['enemyArmourBodyProtection']/100) * $_SESSION['damageBody']));
                $_SESSION['myInfo'] = "You took ".($_SESSION['damageBody'] - (($_SESSION['enemyArmourBodyProtection']/100) * $_SESSION['damageBody']))." hp";
            }
            break;
        }
    }
    $attackChose = rand(1, 2);
    switch($attackChose){
        case 1:{
            $randomNumber = rand(1, 100);
            if($randomNumber > $_SESSION['enemyDamageHeadChance']){
                $_SESSION['enemyInfo'] = "Enemy Missed!";
            } else {
                $_SESSION['health'] = $_SESSION['health'] - ($_SESSION['enemyDamageHead'] - (($_SESSION['armourHeadProtection']/100) * $_SESSION['enemyDamageHead']));
                $_SESSION['enemyInfo'] = "Enemy took ".($_SESSION['enemyDamageHead'] - (($_SESSION['armourHeadProtection']/100) * $_SESSION['enemyDamageHead']))." hp";
            }
            break;
        }
        case 2:{
            $randomNumber = rand(1, 100);
            if($randomNumber > $_SESSION['enemyDamageBodyChance']){
                $_SESSION['enemyInfo'] = "Enemy Missed!";
            } else {
                $_SESSION['health'] = $_SESSION['health'] - ($_SESSION['enemyDamageBody'] - (($_SESSION['armourBodyProtection']/100) * $_SESSION['enemyDamageBody']));
                $_SESSION['enemyInfo'] = "Enemy took ".($_SESSION['enemyDamageBody'] - (($_SESSION['armourBodyProtection']/100) * $_SESSION['enemyDamageBody']))." hp";
            }
            break;
        }
    }
}

if($_SESSION['health'] <= 0){
    require_once "../../connectToSQL.php";
    try{
        $connect = @new mysqli(
            HOST,
            DATABASE_USERNAME,
            DATABASE_PASSWORD,
            DATABASE_NAME);
        if($connect -> connect_errno != 0){
            throw new Exception(mysqli_connect_errno());
        } else {
            mysqli_report(MYSQLI_REPORT_STRICT);
            $id = $_SESSION['userId'];
            $score = $_SESSION['killCount'];
            $money = $_SESSION['money'];
            $sql = "INSERT INTO grave VALUES (NULL,'$id', '$score', '$money', '2020-10-06')";
            $connect->query($sql);
        }
    } catch (Exception $exception){
        echo("Server Error");
    }
    $_SESSION['money'] = 0;
    $_SESSION['killCount'] = 0;

    $_SESSION['weapon'] = 1;
    $_SESSION['weaponName'] = "Knife";
    $_SESSION['damageBody'] = 3;
    $_SESSION['damageHead'] = 5;
    $_SESSION['damageBodyChance'] = 80;
    $_SESSION['damageHeadChance'] = 60;

    $_SESSION['armourId'] = 1;
    $_SESSION['bodyName'] = "None";
    $_SESSION['armourBodyProtection'] = 0;

    $_SESSION['headId'] = 1;
    $_SESSION['headName'] = "none";
    $_SESSION['armourHeadProtection'] = 0;
    include "saveProgress.php";
    header('Location:../mainGame.php');
}
if($_SESSION['enemyHealth'] <= 0){
    $_SESSION['money'] = $_SESSION['money'] + 40;
    $_SESSION['killCount'] = $_SESSION['killCount'] + 1;
    header('Location:../mainGame.php');
}


if(!isset($_SESSION['random']) or $_SESSION['random']){
    $randomTierWeapon = 0;
    $randomTierArmour = 0;
    // Enemy Weapon
    if($_SESSION['killCount'] < 10){
        $randomTierWeapon = 1;
        $randomTierArmour = 1;
    } else if($_SESSION['killCount'] < 20) {
        $randomTierWeapon = 4;
        $randomTierArmour = 2;
    } else if ($_SESSION['killCount'] < 30){
        $randomTierWeapon = 4;
        $randomTierArmour = 3;
    } else if ($_SESSION['killCount'] < 40){
        $randomTierWeapon = 5;
        $randomTierArmour = 4;
    } else{
        $randomTierWeapon = 6;
        $randomTierArmour = 4;
    }
    $_SESSION['enemyWeaponId'] = rand(1, $randomTierWeapon);
    $weaponId = $_SESSION['enemyWeaponId'];
    require_once "../../connectToSQL.php";
    try{
        $connect = @new mysqli(
            HOST,
            DATABASE_USERNAME,
            DATABASE_PASSWORD,
            DATABASE_NAME);
        if($connect -> connect_errno != 0){
            throw new Exception(mysqli_connect_errno());
        } else {
            mysqli_report(MYSQLI_REPORT_STRICT);
            $sql = "SELECT * FROM weapon WHERE id='$weaponId'";
            $record2 = $connect->query($sql)->fetch_assoc();

            $_SESSION['enemyWeaponName'] = $record2['name'];
            $_SESSION['enemyDamageBody'] = $record2['damageBody'];
            $_SESSION['enemyDamageHead'] = $record2['damageHead'];
            $_SESSION['enemyDamageBodyChance'] = $record2['damageBodyChance'];
            $_SESSION['enemyDamageHeadChance'] = $record2['damageHeadChance'];


            // Enemy Body armour
            $_SESSION['enemyArmourId'] = rand(1, $randomTierArmour);
            $armourId = $_SESSION['enemyArmourId'];
            $sql = "SELECT * FROM armourbody WHERE id='$armourId'";
            if($result = $connect->query($sql)){
                $record = $result->fetch_assoc();
                $_SESSION['enemyBodyName'] = $record['name'];
                $_SESSION['enemyArmourBodyProtection'] = $record['protection'];
            }
            // Enemy Head armour
            $_SESSION['enemyHeadId'] = rand(1, $randomTierArmour);
            $armourId = $_SESSION['enemyHeadId'];
            $sql = "SELECT * FROM armourhead WHERE id='$armourId'";
            $record2 = $connect->query($sql)->fetch_assoc();

            $_SESSION['enemyHeadName'] = $record2['name'];
            $_SESSION['enemyArmourHeadProtection'] = $record2['protection'];
            $connect->close();

            $_SESSION['random'] = false;
        }
    } catch (Exception $exception){
        echo("Server Error");
    }

}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>GAME</title>
    <!--Here is a my css will be changed in the future-->
    <link rel="stylesheet" href="game.css">
    <link rel="shortcut icon" href="../../../icon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!--Change font-->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
</head>
<body>
 <div class="mainContainer">
    <div class="logPanel">
        <div class="logBox">
            <?php
            if(!isset($_SESSION['myInfo'])){
                echo ("");
            } else {
                echo($_SESSION['myInfo']);
            }
            ?>
        </div>
        <div class="logBox">
            <?php
            if(!isset($_SESSION['enemyInfo'])){
                echo ("");
            } else {
                echo($_SESSION['enemyInfo']);
            }
            ?>
        </div>
        <div class="playerBox">
            <div class="windows">
                <div class="window" id="animate">
                    <div class="windowImage">
                        <?php
                            switch($_SESSION['armourId']){
                                case 1:{
                                    echo('<input type="image" src="../../../textures/armour/body/none.png" width="130" height="130" alt="">');
                                    break;
                                }
                                case 2:{
                                    echo('<input type="image" src="../../../textures/armour/body/armourTier1.png" width="130" height="130" alt="">');
                                    break;
                                }
                                case 3:{
                                    echo('<input type="image" src="../../../textures/armour/body/armourTier2.png" width="130" height="130" alt="">');
                                    break;
                                }
                                case 4:{
                                    echo('<input type="image" src="../../../textures/armour/body/armourTier3.png" width="130" height="130" alt="">');
                                    break;
                                }
                            }
                        ?>
                    </div>
                    <div class="windowDisc">
                        <?php
                        echo("Protection: ".$_SESSION['armourBodyProtection']."%");
                        ?>
                    </div>
                </div>
                <div class="window" id="animate">
                    <div class="windowImage">
                        <?php
                            switch ($_SESSION['headId']){
                                case 1:{
                                    echo('<input type="image" src="../../../textures/armour/head/none.png" width="130" height="130">');
                                    break;
                                }
                                case 2:{
                                    echo('<input type="image" src="../../../textures/armour/head/armourTier1.png" width="130" height="130" alt="">');
                                    break;
                                }
                                case 3:{
                                    echo('<input type="image" src="../../../textures/armour/head/armourTier2.png" width="130" height="130">');
                                    break;
                                }
                                case 4:{
                                    echo('<input type="image" src="../../../textures/armour/head/armourTier3.png" width="130" height="130">');
                                    break;
                                }
                            }
                        ?>
                    </div>
                    <div class="windowDisc">
                        <?php
                        echo("Protection: ".$_SESSION['armourHeadProtection']."%");
                        ?>
                    </div>
                </div>
                <div class="window" id="animate">
                    <div class="windowImage">
                        <?php
                        switch ($_SESSION['weapon']){
                            case 1:{
                                echo('<input type="image" src="../../../textures/weapon/knife.png" width="130" height="130">');
                                break;
                            }
                            case 2:{
                                echo('<input type="image" src="../../../textures/weapon/glock.png" width="130" height="130">');
                                break;
                            }
                            case 3:{
                                echo('<input type="image" src="../../../textures/weapon/enfield.png" width="130" height="130">');
                                break;
                            }
                            case 4:{
                                echo('<input type="image" src="../../../textures/weapon/mp5.png" width="130" height="130">');
                                break;
                            }
                            case 5:{
                                echo('<input type="image" src="../../../textures/weapon/falafel.png" width="130" height="130">');
                                break;
                            }
                            case 6:{
                                echo('<input type="image" src="../../../textures/weapon/ak47.png" width="130" height="130">');
                                break;
                            }
                            case 7:{
                                echo('<input type="image" src="../../../textures/weapon/flamethrower.png" width="130" height="130">');
                                break;
                            }
                        }
                        ?>
                    </div>
                    <div class="windowDisc">
                        <?php
                        echo($_SESSION['weaponName']);
                        ?>
                    </div>
                </div>
            </div>
            <div class="windows">
                <div class="window" id="animate">
                    <div class="windowImage">
                        <form method="post" action="">
                            <input type="hidden" name="action" value="0">
                            <input type="image" src="../../../textures/gameGui/surrender.png" width="130" height="130">
                        </form>
                    </div>
                    <div class="windowDisc">
                        Surrender
                    </div>
                </div>
                <div class="window" id="animate">
                    <div class="windowImage">
                        <form method="post" action="">
                            <input type="hidden" name="action" value="1">
                            <input type="image" src="../../../textures/gameGui/headShot.png" width="130" height="130">
                        </form>
                    </div>
                    <div class="windowDisc">
                        <?php
                        echo("Head ".$_SESSION['damageHeadChance']."%")
                        ?>
                    </div>
                </div>
                <div class="window" id="animate">
                    <div class="windowImage">
                        <form method="post" action="">
                            <input type="hidden" name="action" value="2">
                            <input type="image" src="../../../textures/gameGui/bodyShot.png" width="130" height="130">
                        </form>
                    </div>
                    <div class="windowDisc">
                        <?php
                        echo("Body ".$_SESSION['damageBodyChance']."%")
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="playerBox">
            <div class="windows">
                <div class="window" id="animate">
                    <div class="windowImage">
                        <?php
                        switch($_SESSION['enemyArmourId']){
                            case 1:{
                                echo('<input type="image" src="../../../textures/armour/body/none.png" width="130" height="130"">');
                                break;
                            }
                            case 2:{
                                echo('<input type="image" src="../../../textures/armour/body/armourTier1.png" width="130" height="130">');
                                break;
                            }
                            case 3:{
                                echo('<input type="image" src="../../../textures/armour/body/armourTier2.png" width="130" height="130">');
                                break;
                            }
                            case 4:{
                                echo('<input type="image" src="../../../textures/armour/body/armourTier3.png" width="130" height="130">');
                                break;
                            }
                        }
                        ?>
                    </div>
                    <div class="windowDisc">
                        <?php
                        echo("Protection: ".$_SESSION['enemyArmourBodyProtection']."%");
                        ?>
                    </div>
                </div>
                <div class="window" id="animate">
                    <div class="windowImage">
                        <?php
                        switch ($_SESSION['enemyHeadId']){
                            case 1:{
                                echo('<input type="image" src="../../../textures/armour/head/none.png" width="130" height="130">');
                                break;
                            }
                            case 2:{
                                echo('<input type="image" src="../../../textures/armour/head/armourTier1.png" width="130" height="130">');
                                break;
                            }
                            case 3:{
                                echo('<input type="image" src="../../../textures/armour/head/armourTier2.png" width="130" height="130">');
                                break;
                            }
                            case 4:{
                                echo('<input type="image" src="../../../textures/armour/head/armourTier3.png" width="130" height="130">');
                                break;
                            }
                        }
                        ?>
                    </div>
                    <div class="windowDisc">
                        <?php
                        echo("Protection: ".$_SESSION['enemyArmourHeadProtection']."%");
                        ?>
                    </div>
                </div>
                <div class="window" id="animate">
                    <div class="windowImage">
                        <?php
                        switch ($_SESSION['enemyHeadId']){
                            case 1:{
                                echo('<input type="image" src="../../../textures/weapon/knife.png" width="130" height="130">');
                                break;
                            }
                            case 2:{
                                echo('<input type="image" src="../../../textures/weapon/glock.png" width="130" height="130">');
                                break;
                            }
                            case 3:{
                                echo('<input type="image" src="../../../textures/weapon/enfield.png" width="130" height="130">');
                                break;
                            }
                            case 4:{
                                echo('<input type="image" src="../../../textures/weapon/mp5.png" width="130" height="130">');
                                break;
                            }
                            case 5:{
                                echo('<input type="image" src="../../../textures/weapon/falafel.png" width="130" height="130">');
                                break;
                            }
                            case 6:{
                                echo('<input type="image" src="../../../textures/weapon/ak47.png" width="130" height="130">');
                                break;
                            }
                            case 7:{
                                echo('<input type="image" src="../../../textures/weapon/flamethrower.png" width="130" height="130">');
                                break;
                            }
                        }
                        ?>
                    </div>
                    <div class="windowDisc">
                        <?php
                        echo($_SESSION['enemyWeaponName']);
                        ?>
                    </div>
                </div>
            </div>
            <div class="infoBar">
                <div class="hpBar">
                    Your hp:
                    <?php
                    echo($_SESSION['health']."%");
                    ?>
                </div>
                <div class="hpBar">
                    Enemy hp:
                    <?php
                    echo($_SESSION['enemyHealth']."%");
                    ?>
                </div>
            </div>
        </div>
    </div>
 </div>
</body>
</html>