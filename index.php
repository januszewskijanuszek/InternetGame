<?php
    session_start();
    if(isset($_SESSION['loggedIn']) and $_SESSION['loggedIn']){
        header('Location:game/session/mainGame.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Main menu</title>
        <!--Here is a my css will be changed in the future-->
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="icon.png">
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
            </div>
            <div class="buttonContainer">
                <!--All menu buttons-->
                <p class="buttons">
                    <input type="button" onClick="window.location.href='game/login.php'" value="Start" id="buttonMenu1">
                    <input type="button" onClick="window.location.href='howToPlay/tutorial1.html'" value="How to play" id="buttonMenu2">
                </p>
                <div class="imageBox">
                    <img src="icon.png" width="225" height="225">
                </div>
            </div>
        </div>
    </body>
</html>