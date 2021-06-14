<?php
session_start();

$_SESSION['infoMenu'] = true;
header('Location:mainGame.php');
