<?php
session_start();
if(isset($_POST['loginOne'])){
    $allCorrect = true;
    if(strlen($_POST['loginOne']) < 3 or strlen($_POST['loginOne']) > 18){
        $allCorrect = false;
        $_SESSION['errorMessageSettings'] = "Login: Item must have 3 - 18 chars!";
    }  if(!ctype_alnum($_POST['loginOne'])){
        $allCorrect = false;
        $_SESSION['errorMessageSettings'] = "Login: Illegal characters!";
    } if($_POST['loginOne'] != $_POST['loginTwo']){
        $allCorrect = false;
        $_SESSION['errorMessageSettings'] = "Logins are not the same!";
    }

    require_once "../../connectToSQL.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    try{
        $connect = new mysqli(
            HOST,
            DATABASE_USERNAME,
            DATABASE_PASSWORD,
            DATABASE_NAME);
        if($connect->connect_errno != 0){
            throw new Exception(mysqli_connect_errno());
        } else {
            $login = $_POST['loginOne'];
            // Does login exist?
            $sql = "SELECT * FROM user WHERE login='$login'";
            $result = $connect->query($sql);
            if(!$result) throw new Exception($connect->error);
            $howMuche = $result->num_rows;
            if($howMuche > 0){
                $allCorrect = false;
                $_SESSION['errorMessageSettings'] = "Login: User with this login exists!";
            }
            if($allCorrect){
                $id = $_SESSION['userId'];
                $sql = "UPDATE user SET login='$login' WHERE idUser='$id'";
                if($connect->query($sql)){
                    $_SESSION['login'] = $login;
                    $_SESSION['errorMessageSettings'] = '<span style="color: green;">You have changed your login!</span>';
                } else{
                    throw new Exception($connect->error);
                }
            }
            $connect->close();
        }
    } catch(Exception $a){
        echo("Server error: ");
        echo($a);
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Change Login</title>
    <!--Here is a my css will be changed in the future-->
    <link rel="stylesheet" href="styleMenu.css">
    <link rel="shortcut icon" href="../../../icon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!--Change font-->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="mainContainer">
        <div class="mainTitle">
            Change Login
        </div>
        <div class="buttonContainer">
            <div class="buttons">
                <form method="post" action="">
                    <label>
                        <input type="text" name="loginOne" placeholder="New login">
                        <input type="text" name="loginTwo" placeholder="Confirm login">
                        <input type="submit" value="Change" id="animate">
                    </label>
                    <input type="button" onClick="window.location.href='settings.php'" value="Back" id="animate">
                    <div class="error">
                        <?php
                        if(isset($_SESSION['errorMessageSettings']))
                            echo($_SESSION['errorMessageSettings']);
                        $_SESSION['errorMessageSettings'] = "";
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>