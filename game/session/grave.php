<?php
session_start();

$bgColor = false;

$counter = 0;
$score = array();
$money = array();
$date = array();
$show = true;

try{
    require_once "../connectToSQL.php";
    $connect = @new mysqli(
        HOST,
        DATABASE_USERNAME,
        DATABASE_PASSWORD,
        DATABASE_NAME);
    if($connect->connect_errno != 0){
        throw new Exception(mysqli_connect_errno());
    } else {
        $id = $_SESSION['userId'];
        $sql = "SELECT * FROM grave WHERE userId='$id'";
        if($result = $connect->query($sql)){
            $counter = $result->num_rows - 1;
            if($counter > 4) $counter = 4;
            if($result->num_rows <= 0){
                $show = false;
            } else {
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    $rowId[] = $row['id'];
                    $score[] = $row['score'];
                    $money[] = $row['money'];
                    $date[] = $row['date'];
                }
            }
            $result->close();
        }
    }
    $connect->close();
}catch (Exception $exception){
    echo ($exception);
}
?>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
    <!--Here is a my css will be changed in the future-->
    <link rel="stylesheet" href="css/grave.css">
    <link rel="shortcut icon" href="../../../icon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!--Change font-->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="mainContainer">
        <div class="mainTitle">
            <div class="title">
                Grave yard
            </div>
            <div class="userBox">
                <?php
                    if($show){
                        echo("Your last 4 fails!");
                    } else {
                        echo("You have never died!");
                    }
                ?>
            </div>
        </div>
        <div class="userGui">
            <div class="gravePanel">
                <div class="graveCell">
                    <?php
                    if($show){
                        if($bgColor){
                            echo ('<div class="graveInfo" style="background-color: #333333">');
                        } else{
                            echo ('<div class="graveInfo" style="background-color: #222222">');
                        }
                        echo ("Score: ". $score[$counter]. " Money: ". $money[$counter]. "  Date: ". $date[$counter]);
                        echo ('</div>');
                        $bgColor = !$bgColor;
                        $counter = $counter - 1;
                    } else {
                        echo ("");
                    }
                    ?>
                </div>
                <div class="graveCell">
                    <?php
                    if($counter >= 0){
                        if($bgColor){
                            echo ('<div class="graveInfo" style="background-color: #333333">');
                        } else{
                            echo ('<div class="graveInfo" style="background-color: #222222">');
                        }
                        echo ("Score: ". $score[$counter]. " Money: ". $money[$counter]. "  Date: ". $date[$counter]);
                        echo ('</div>');
                        $bgColor = !$bgColor;
                        $counter = $counter - 1;
                    } else {
                        echo ("");
                    }
                    ?>
                </div>
                <div class="graveCell">
                    <?php
                    if($counter >= 0){
                        if($bgColor){
                            echo ('<div class="graveInfo" style="background-color: #333333">');
                        } else{
                            echo ('<div class="graveInfo" style="background-color: #222222">');
                        }
                        echo ("Score: ". $score[$counter]. " Money: ". $money[$counter]. "  Date: ". $date[$counter]);
                        echo ('</div>');
                        $bgColor = !$bgColor;
                        $counter = $counter - 1;
                    } else {
                        echo ("");
                    }
                    ?>
                </div>
                <div class="graveCell">
                    <?php
                    if($counter >= 0){
                        if($bgColor){
                            echo ('<div class="graveInfo" style="background-color: #333333">');
                        } else{
                            echo ('<div class="graveInfo" style="background-color: #222222">');
                        }
                        echo ("Score: ". $score[$counter]. " Money: ". $money[$counter]. "  Date: ". $date[$counter]);
                        echo ('</div>');
                        $bgColor = !$bgColor;
                        $counter = $counter - 1;
                    } else {
                        echo ("");
                    }
                    ?>
                </div>
            </div>
            <div class="exit" id="animate">
                <input type="image" src="../../textures/usable/exitDoor.png" width="200" height="200" onClick="window.location.href='mainGame.php'">
                <div class="bottomInfo">
                    EXIT
                </div>
            </div>
        </div>
    </div>
</body>
</html>
