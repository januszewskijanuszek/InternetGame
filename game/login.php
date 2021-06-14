<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!--Here is a my css will be changed in the future-->
    <link rel="stylesheet" href="styleMenu.css">
    <link rel="shortcut icon" href="../icon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!--Change font-->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
</head>
<body>
<div class="mainContainer">
    <div class="mainTitle">
        <div class="title">
            Login
        </div>
    </div>
    <div class="buttonContainer">
        <!--All menu buttons-->
        <form method="post" action="loginCheck.php">
        <p class="buttons">
                <input type="text" minlength="3" maxlength="25" placeholder="Login" id="login" name="login"/>
                <input type="password" minlength="3" maxlength="25" placeholder="Password" id="password1" name="password"/>
                <input type="submit" value="Login" id="login"/>
                <input type="button" onClick="window.location.href='../index.php'" value="Back" id="login"/>
            <div class="hyperlink">
                <a href="register.php">I don't have an account</a>
            </div>
        </p>
        </form>
        <div class="error">
            <?php
                if(isset($_SESSION['error'])) echo($_SESSION['error']."!");
            ?>
        </div>
        <div class="imageBox">
            <!--img src="" width="225" height="225"-->
        </div>
    </div>
</div>
</body>
</html>
