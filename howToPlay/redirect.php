<?php
session_start();
if (isset($_SESSION['loggedIn']) and $_SESSION['loggedIn']) {
    header('Location:../game/session/mainGame.php');
    exit();
} else{
    header('Location:../index.php');
}