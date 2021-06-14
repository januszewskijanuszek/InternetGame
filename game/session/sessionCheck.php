<?php
if (!isset($_SESSION['loggedIn']) and !$_SESSION['loggedIn']) {
    header('Location:../game/session/mainGame.php');
    exit();
}