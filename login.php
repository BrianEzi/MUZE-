<?php require_once(__DIR__ . "/loginFunctions.php"); ?>

<?php

try {
    $conn = new pdo('mysql:host=localhost:8889;', 'root', 'root');
    // echo "connected to localhost:8889 successfully";
}
catch(PDOException $pe) {
    die("could not connect to host " . $pe->getMessage());
}

createDatabase();
createTable();
?>

<?php
    session_start();
    if (isset($_SESSION['background'])) {
        $background = $_SESSION['background'];
    } else {
        $background = "https://images.unsplash.com/photo-1542401886-65d6c61db217?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/styles/myStyles.css">
    <link rel="stylesheet" href="assets/styles/loginStyleSheet.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUZE# - Log In</title>
</head>
<body style="background-image: url(<?php echo $background ?>);">
    <div class="topnav">
        <a href="home.php">HOME</a>
        <a href="discover.php">DISCOVER</a>
        <a href="chat.php">CHAT</a>
        <a href="games.php">GAMES</a>
        <a href="myMusic.php">MY MUSIC</a>
        <a class = "active" style="float: right;" href="login.php">LOGIN</a>
    </div>

    <div class="loginForm">

        <form method="post" action="login.php">
            
            <div class="formTitle">
                Log In
            </div> <br>

            <input type="text" name="username" id="username" required placeholder="Username"> <br>

            <input type="text" name="password" id="password" required placeholder="Password"> <br>

            <input type="hidden" name="action" value="login">
            <input type="submit" name="filled" value="Log in"> <br> <br>
            <?php 
                if (isset($_SESSION['loginError'])) {
                    echo "<div class='error'>Incorrect Username or Password</div>";
                } else {
                    echo "<br>";
                }
            ?>
        </form> <br> <br> <br>
    
        <form method="post" action="login.php">

            <div class="formTitle">
                Sign Up
            </div> <br>
            
            <input type="text" name="username" id="username" required placeholder="Username"> <br>

            <input type="text" name="password" id="password" required placeholder="Password"> <br>

            <input type="hidden" name="action" value="register">
            <input type="submit" name="filled" value="Register"> <br> <br>
            <?php 
                if (isset($_SESSION['registerError'])) {
                    echo "<div class='error'>Sorry, Username already in use</div>";
                } else {
                    echo "<br>";
                }
            ?>
        </form>
    </div>

    <?php
        if(isset($_POST['filled'])) {
            switch($_POST['action']) {
                case 'login':
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $_SESSION['loginError'] = 1;
                    unset($_SESSION['registerError']);
                    authenticateUser($username, $password);
                    header("Refresh:0");
                break;
                case 'register':
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    addUser($username, $password);
                    $_SESSION['registerError'] = 1;
                    unset($_SESSION['loginError']);
                    header("Refresh:0");
                break;
            }    
        }
    ?>

</body>
</html>