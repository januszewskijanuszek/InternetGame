<?php
session_start();
require_once "../../connectToSQL.php";
$connect = @new mysqli(
    HOST,
    DATABASE_USERNAME,
    DATABASE_PASSWORD,
    DATABASE_NAME);
$nameVariable = array();
$imageLocation = array();
if($connect -> connect_errno != false) {
    echo ("Error: ") . $connect->connect_errno . "Desc: " . $connect->connect_error;
}else{
    // Getting info from database
    $sql = "SELECT * FROM armourbody";
    if($result = @$connect->query($sql)){
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $nameVariable[] = $row['cost'];
        }
        $result->close();
    }
    if($result = $connect->query($sql)){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $imageLocation[] = $row['imagelocation'];
        }
        $result->close();
    }
    if($result = $connect->query($sql)){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $nameArray[] = $row['name'];
        }
        $result->close();
    }
}
// Closing connection
$connect -> close();
$_SESSION['productName'] = "nul";
if(isset($_POST['apply']) and $_POST['apply']){
    require_once "../../connectToSQL.php";
    $connect = @new mysqli(
        HOST,
        DATABASE_USERNAME,
        DATABASE_PASSWORD,
        DATABASE_NAME);
    if($connect -> connect_errno != false) {
        echo ("Error: ") . $connect->connect_errno . "Desc: " . $connect->connect_error;
    }else{
        if($_SESSION['transaction']){
            if(isset($_SESSION['choice'])){
                $value = $_SESSION['choice'] + 1;
                $sql = "SELECT * FROM armourhead WHERE id='$value'";
                if($result = @$connect->query($sql)){
                    $record = $result->fetch_assoc();
                    $_SESSION['bodyName'] = $record['name'];
                    $_SESSION['armourBodyProtection'] = $record['protection'];
                    $_SESSION['armourId'] = $_SESSION['choseId'];
                    $_SESSION['money'] = $_SESSION['money'] - $nameVariable[$value - 1];
                    include "saveProgress.php";
                }
            }
        }
    }
}

if(isset($_POST['tier1'])
    or isset($_POST['tier2'])
    or isset($_POST['tier3'])){
    $_SESSION['confirm']=true;
    $name = "";
    if(isset($_POST['tier1'])) $_SESSION['choice'] = 1;
    if(isset($_POST['tier2'])) $_SESSION['choice'] = 2;
    if(isset($_POST['tier3'])) $_SESSION['choice'] = 3;
    switch ($_SESSION['choice']){
        case 1:{
            if($_SESSION['money'] >= $nameVariable[1]){
                $_SESSION['productName']  = "Tier 1";
                $_SESSION['choseId'] = 2;
                $_SESSION['price'] = $nameVariable[1];
                $_SESSION['transaction'] = true;
                break;
            } else{
                $_SESSION['transaction'] = false;
                break;
            }
        }
        case 2:{
            if($_SESSION['money'] >= $nameVariable[2]){
                $_SESSION['productName']  = "Tier 2";
                $_SESSION['choseId'] = 3;
                $_SESSION['price'] = $nameVariable[2];
                break;
            } else {
                $_SESSION['transaction'] = false;
                break;
            }
        }
        case 3:{
            if($_SESSION['money'] >= $nameVariable[3]){
                $_SESSION['productName']  = "Tier 3";
                $_SESSION['choseId'] = 4;
                $_SESSION['price'] = $nameVariable[3];
                break;
            } else {
                $_SESSION['transaction'] = false;
                break;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
    <!--Here is a my css will be changed in the future-->
    <link rel="stylesheet" href="../css/shopStyleArmory.css">
    <link rel="shortcut icon" href="../../../icon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!--Change font-->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
</head>
<body>
<div class="mainContainer">
    <div class="mainTitle">
        <div class="title">
            Body Armour
        </div>
        <div class="userBox">
            <div class="text">
                <?php
                if(isset($_SESSION['confirm']) and $_SESSION['confirm']){
                    if($_SESSION['transaction']){
                        echo("Buy: ".$_SESSION['productName']." : ".$_SESSION['price']."$"."<br>" );
                        echo("Are you siure?");
                    } else {
                        echo("You dont have money!");
                    }
                }else{
                    echo("Current armour:<br>");
                    echo($_SESSION['bodyName']."<br>");
                    echo("Gold: ".$_SESSION['money']."$");
                }
                ?>
            </div>
            <div class="image">
                <?php
                    if(isset($_SESSION['confirm']) and $_SESSION['confirm']){
                        switch ($_SESSION['choice']){
                            case 1:{
                                echo('<input type="image" src="'.$imageLocation[1].'" width="122" height="122">');
                                break;
                            }
                            case 2:{
                                echo('<input type="image" src="'.$imageLocation[2].'" width="122" height="122">');
                                break;
                            }
                            case 3:{
                                echo('<input type="image" src="'.$imageLocation[3].'" width="122" height="122">');
                                break;
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="userGui">
        <div class="windows">
            <div class="window" id="animate">
                <form method="post" action="">
                    <input type="hidden" name="tier1" value=1>
                    <?php
                    echo('<input type="image" src="'.$imageLocation[1].'" width="225" height="225" alt="submit">');
                    ?>
                    <div class="bottomInfo">
                        <?php
                        echo($nameArray[1]."<br>");
                        if(!isset($_SESSION['confirm']) or !$_SESSION['confirm']){
                            echo($nameVariable[1]."$");
                        }
                        ?>
                    </div>
                </form>
            </div>
            <div class="window" id="animate">
                <form method="post" action="">
                    <input type="hidden" name="tier2" value=2>
                    <?php
                    echo('<input type="image" src="'.$imageLocation[2].'" width="225" height="225" alt="submit">');
                    ?>
                    <div class="bottomInfo">
                        <?php
                        echo($nameArray[2]."<br>");
                        if(!isset($_SESSION['confirm']) or !$_SESSION['confirm']){
                            echo($nameVariable[2]."$");
                        }
                        ?>
                    </div>
                </form>
            </div>
            <div class="window" id="animate">
                <form method="post" action="">
                    <input type="hidden" name="tier3" value=3>
                    <?php
                    echo('<input type="image" src="'.$imageLocation[3].'" width="225" height="225" alt="submit">');
                    ?>
                    <div class="bottomInfo">
                        <?php
                        echo($nameArray[3]."<br>");
                        if(!isset($_SESSION['confirm']) or !$_SESSION['confirm']){
                            echo($nameVariable[3]."$");
                        }
                        ?>
                    </div>
                </form>
            </div>
            <div class="window" id="animate">
                <input type="image" src="../../../textures/usable/exitDoor.png" width="225" height="225" onClick="window.location.href='../shop.php'">
                <div class="bottomInfo">
                    EXIT
                </div>
            </div>
        </div>
        <div class="bottomPanel">
            <div class="ok">
                <form action="" method="post">
                    <input type="hidden" name="apply" value=true>
                    <?php
                    if(isset($_SESSION['confirm']) and $_SESSION['confirm']){
                        echo('<input type="image" src="../../../textures/usable/checkMarkGreen.png" width="120" height="120" id="okButton" alt="submit">');
                    }
                    ?>
                </form>
            </div>
            <div class="Ok">
                <form action="" method="post">
                    <input type="hidden" name="deny" value=false>
                    <?php
                    if(isset($_SESSION['confirm']) and $_SESSION['confirm']){
                        echo('<input type="image" src="../../../textures/usable/cancelRed.png" width="120" height="120" id="okButton" alt="submit">');
                    }
                    ?>
                </form>
            </div>
            <?php
            $_SESSION['confirm'] = false;
            ?>
        </div>
    </div>
</div>
</body>
</html>
