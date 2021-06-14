<?php
session_start();
require_once "../../connectToSQL.php";

// Arrays
$id = array();
$costArray = array();
$imageLocationArray = array();
$nameArray = array();
$damageHead[] = array();
$damageBody[] = array();
$damageHeadChance[] = array();
$damageBodyChance[] = array();

if(isset($_POST['chose'])){
    $_SESSION['choseItem'] = $_POST['chose'];
}

// Load from database
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
        $sql = "SELECT * FROM weapon";
        if($result = $connect->query($sql)){
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $id[] = $row['id'];
                $nameArray[] = $row['name'];
                $imageLocationArray[] = $row['imagelocation'];
                $costArray[] = $row['cost'];
                $damageHead[] = $row['damageHead'];
                $damageBody[] = $row['damageBody'];
                $damageHeadChance[] = $row['damageHeadChance'];
                $damageBodyChance[] = $row['damageBodyChance'];
            }
        }$connect->close();
    }
} catch (Exception $exception){
    echo("Server error");
    echo($exception);
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Shop</title>
        <!--Here is a my css will be changed in the future-->
        <link rel="stylesheet" href="../css/shopStyleWeapon.css">
        <link rel="shortcut icon" href="../../../icon.png">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <!--Change font-->
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="mainContainer">
            <div class="mainTitle">
                <div class="title">
                    Weapon
                </div>
                <div class="exit">
                    <div class="window" id="animate">
                        <input type="image" src="../../../textures/usable/exitDoor.png" width="150" height="150" onClick="window.location.href='../shop.php'">
                        <div class="bottomInfo">
                            EXIT
                        </div>
                    </div>
                </div>
                <div class="userBox">
                    <div class="text">
                            <?php
                            if(isset($_POST['chose'])){
                                if($costArray[$_POST['chose']] > $_SESSION['money']){
                                    echo("You dont have enough money!");
                                } else {
                                    echo('<form method="post" action="">');
                                    echo('<input type="hidden" name="yesNo" value="2"/>');
                                    echo('<input type="image" src="../../../textures/usable/checkMarkGreen.png" width="120" height="120" id="okButton" alt="submit">');
                                    echo("</form>");
                                    echo('<form method="post" action="">');
                                    echo('<input type="hidden" name="yesNo" value="1"/>');
                                    echo('<input type="image" src="../../../textures/usable/cancelRed.png" width="120" height="120" id="okButton" alt="submit">');
                                    echo("</form>");
                                }
                            } elseif (isset($_POST['chose']) and $_SESSION['weapon'] >= $_POST['chose']){
                                echo("You have better weapon!");
                            } elseif (isset($_POST['yesNo']) and $_POST['yesNo'] == 2){
                                $_SESSION['money'] = $_SESSION['money'] - $costArray[$_SESSION['choseItem']];
                                $_SESSION['weapon'] = $id[$_SESSION['choseItem']];
                                $_SESSION['weaponName'] = $nameArray[$_SESSION['choseItem']];
                                $_SESSION['damageBody'] = $damageBody[$_SESSION['choseItem']+1];
                                $_SESSION['damageHead'] = $damageHead[$_SESSION['choseItem']+1];
                                $_SESSION['damageBodyChance'] = $damageBodyChance[$_SESSION['choseItem']+1];
                                $_SESSION['damageHeadChance'] = $damageHeadChance[$_SESSION['choseItem']+1];
                                include "saveProgress.php";
                            }
                            else {
                                echo("Current weapon:<br>");
                                echo ($_SESSION['weaponName']) . "<br>";
                                echo("Gold: " . $_SESSION['money']);
                            }
                            ?>
                    </div>
                </div>
            </div>
            <div class="userGui">
                <div class="windows">
                        <div class="window" id="animate">
                            <form method="POST" action="">
                                <input type="hidden" name="chose" value="1"/>
                                <?php
                                echo('<input type="image" src="'.$imageLocationArray[1].'" width="150" height="150" alt="submit">');
                                ?>
                                <div class="bottomInfo">
                                    <?php
                                        echo($costArray[1]."$");
                                    ?>
                                </div>
                            </form>
                        </div>
                        <div class="window" id="animate">
                            <form method="POST" action="">
                                <input type="hidden" name="chose" value="2"/>
                                <?php
                                echo('<input type="image" src="'.$imageLocationArray[2].'" width="150" height="150" alt="submit">');
                                ?>
                                <div class="bottomInfo">
                                    <?php
                                    echo($costArray[2]."$");
                                    ?>
                                </div>
                            </form>
                        </div>
                        <div class="window" id="animate">
                            <form method="POST" action="">
                                <input type="hidden" name="chose" value="3"/>
                                <?php
                                echo('<input type="image" src="'.$imageLocationArray[3].'" width="150" height="150" alt="submit">');
                                ?>
                                <div class="bottomInfo">
                                    <?php
                                    echo($costArray[3]."$");
                                    ?>
                                </div>
                            </form>
                        </div>
                        <div class="window" id="animate">
                            <form method="POST" action="">
                                <input type="hidden" name="chose" value="4"/>
                                <?php
                                echo('<input type="image" src="'.$imageLocationArray[4].'" width="150" height="150" alt="submit">');
                                ?>
                                <div class="bottomInfo">
                                    <?php
                                    echo($costArray[4]."$");
                                    ?>
                                </div>
                            </form>
                        </div>
                        <div class="window" id="animate">
                            <form method="POST" action="">
                                <input type="hidden" name="chose" value="5"/>
                                <?php
                                echo('<input type="image" src="'.$imageLocationArray[5].'" width="150" height="150" alt="submit">');
                                ?>
                                <div class="bottomInfo">
                                    <?php
                                    echo($costArray[5]."$");
                                    ?>
                                </div>
                            </form>
                        </div>
                        <div class="window" id="animate">
                            <form method="POST" action="">
                                <input type="hidden" name="chose" value="6"/>
                                <?php
                                echo('<input type="image" src="'.$imageLocationArray[6].'" width="150" height="150" alt="submit">');
                                ?>
                                <div class="bottomInfo">
                                    <?php
                                    echo($costArray[6]."$");
                                    ?>
                                </div>
                            </form>
                        </div>
                </div>
                <div class="shopPanel">
                    <div class="shopTitle">
                        <?php
                            if(!isset($_POST['chose']) and !isset($_POST['yesNo'])){
                                echo("Welcome!");
                            } elseif(!isset($_POST['chose']) and isset($_POST['yesNo'])){
                                echo("Thanks for purchase!");
                            }else{
                                echo ($nameArray[$_POST['chose']]);
                            }
                        ?>
                    </div>
                    <div class="shopInfo">
                        <?php
                            if(isset($_POST['chose'])){
                                echo("Head:<br>");
                                echo("-  Damage Head: ".$damageHead[$_POST['chose']]."<br>");
                                echo("-  Hit chance: ".$damageHeadChance[$_POST['chose']]."%<br>");
                                echo("Body: <br>");
                                echo("- Damage: ".$damageBody[$_POST['chose']]."<br>");
                                echo("- Hit chance: ".$damageBodyChance[$_POST['chose']]."%<br>");
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

