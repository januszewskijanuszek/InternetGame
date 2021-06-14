<?php
session_start();
if(isset($_POST['login'])){
    $allCorrect = true;
    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 18){
        $allCorrect = false;
        $_SESSION['errorMessage'] = "Login: Item must have 3 - 18 chars!";
    } else if(!ctype_alnum($_POST['login'])){
        $allCorrect = false;
        $_SESSION['errorMessage'] = "Login: Illegal characters!";
    } else if(strlen($_POST['password1']) < 6 or strlen($_POST['password1']) > 18){
        $allCorrect = false;
        $_SESSION['errorMessage'] = "Password: Item must have 6 - 18 characters!";
    } else if($_POST['password1'] != $_POST['password2']){
        $allCorrect = false;
        $_SESSION['errorMessage'] = "Password: Items must be the same!";
    } else if(!ctype_alnum($_POST['password1'])){
        $allCorrect = false;
        $_SESSION['errorMessage'] = "Password: Illegal characters!";
    }
    $hashedPassword = password_hash($_POST['password1'], PASSWORD_DEFAULT);

    // Server connect
    require_once "connectToSQL.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    try{
        $connect = @new mysqli(
            HOST,
            DATABASE_USERNAME,
            DATABASE_PASSWORD,
            DATABASE_NAME);
        if($connect->connect_errno != 0){
            throw new Exception(mysqli_connect_errno());
        } else {
            $login = $_POST['login'];
            // Does login exist?
            $sql = "SELECT * FROM user WHERE login='$login'";
            $result = $connect->query($sql);
            if(!$result) throw new Exception($connect->error);
            $howMuche = $result->num_rows;
            if($howMuche > 0){
                $allCorrect = false;
                $_SESSION['errorMessage'] = "Login: User with this login exists!";
            }
            if($allCorrect){
                $login = $_POST['login'];
                $sql = "INSERT INTO user VALUES (NULL, '$login', '$hashedPassword')";
                if($connect->query($sql)){
                    $_SESSION['errorMessage'] = '<span style="color: green;">User has been created!</span>';
                } else{
                    throw new Exception($connect->error);
                }
                // $record = $result->fetch_assoc();
                $records = mysqli_query($connect,"SELECT * FROM user WHERE login='$login'");
                while($data = mysqli_fetch_array($records)){
                    $userId = $data['idUser'];
                }
                $sql = "INSERT INTO status VALUES (NULL, 0, 0, 0,'$userId', 1, 1, 1)";
                $connect->query($sql);
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
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
            Register
        </div>
    </div>
    <div class="buttonContainer">
        <!--All menu buttons-->
        <form method="post">
        <p class="buttons">
            <input type="text"  maxlength="25" placeholder="Login" name="login" id="login"/>
            <input type="password" minlength="3" maxlength="25" placeholder="Password" id="password1" name="password1"/>
            <input type="password" minlength="3" maxlength="25" placeholder="Repeat password" id="password1" name="password2"/>
            <input type="submit" value="Register" name="buttonMenu" id="password1"/>
            <input type="button" onClick="window.location.href='login.php'" value="Back" name="buttonMenu" id="password1"/>
            <br/>
        </p>
        </form>
        <div class="error">
            <?php
                if(isset($_SESSION['errorMessage'])){
                    echo($_SESSION['errorMessage']);
                }
            ?>
        </div>
        <div class="imageBox">
            <!--img src="" width="225" height="225"-->
        </div>
    </div>
</div>
</body>
</html>
