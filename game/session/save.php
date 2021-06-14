<?php
session_start();
include "saveProgress.php";

$_SESSION['save'] = true;
header('Location:mainGame.php');