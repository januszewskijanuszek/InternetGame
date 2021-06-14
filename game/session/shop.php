<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
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
            Shop
        </div>
        <div class="userBox">
            <?php
                echo("Select Shop");
            ?>
        </div>
    </div>
    <div class="userGui">
        <div class="windows">
            <div class="window" id="animate">
                <input type="image" src="../../textures/shop/headArmourShop.png" width="225" height="225" onClick="window.location.href='shops/shopHead.php'">
                <div class="bottomInfo">
                    Head Armour
                </div>
            </div>
            <div class="window" id="animate">
                <input type="image" src="../../textures/shop/bodyArmourShop.png" width="225" height="225" onClick="window.location.href='shops/shopBody.php'">
                <div class="bottomInfo">
                    Body Armour
                </div>
            </div>
            <div class="window" id="animate">
                <input type="image" src="../../textures/shop/weaponShop.png" width="225" height="225" onClick="window.location.href='shops/shopWeapon.php'">
                <div class="bottomInfo">
                    Weapon
                </div>
            </div>
            <div class="window" id="animate">
                <input type="image" src="../../textures/usable/exitDoor.png" width="225" height="225" onClick="window.location.href='mainGame.php'">
                <div class="bottomInfo">
                    EXIT
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
