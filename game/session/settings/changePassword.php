<?php
session_start();
if(isset($_POST['passwordOne'])){
    $allCorrect = true;
    if(strlen($_POST['passwordOne']) < 6 or strlen($_POST['passwordOne']) > 18){
        $allCorrect = false;
        $_SESSION['errorMessageSettings'] = "Password: Item must have 6 - 18 chars!";
    }  if(!ctype_alnum($_POST['passwordOne'])){
        $allCorrect = false;
        $_SESSION['errorMessageSettings'] = "Password: Illegal characters!";
    } if($_POST['passwordOne'] != $_POST['passwordTwo']){
        $allCorrect = false;
        $_SESSION['errorMessageSettings'] = "Passwords are not the same!";
    }

    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    echo(password_hash("admin", PASSWORD_DEFAULT). "<br>");
    $hashedNewPassword = password_hash($_POST['passwordOne'], PASSWORD_DEFAULT);

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
            $id = $_SESSION['userId'];
            $sql = "SELECT * FROM user WHERE idUser='$id'";
            $actualPassword = $connect->query($sql)->fetch_assoc()['password'];
            echo($actualPassword);
            if(password_verify($_POST['password'], $actualPassword)){
                $allCorrect = false;
                $_SESSION['errorMessageSettings'] = "Wrong password";
            }
            if($allCorrect){
                $sql = "UPDATE user SET password='$hashedNewPassword' WHERE idUser='$id'";
                if($connect->query($sql)){
                    $_SESSION['errorMessageSettings'] = '<span style="color: green;">You have changed your password!</span>';
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
        Change Password
    </div>
    <div class="buttonContainer">
        <div class="buttons">
            <form method="post" action="">
                <label>
                    <input type="password" name="password" placeholder="Current password">
                    <input type="password" name="passwordOne" placeholder="New password">
                    <input type="password" name="passwordTwo" placeholder="Confirm password">
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
