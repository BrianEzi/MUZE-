<?php require_once "loginFunctions.php"; ?>

<?php

try {
    $conn = new pdo('mysql:host=localhost:8889;', 'root', 'root');
    //echo "connected to localhost:8889 successfully";
}
catch(PDOException $pe) {
    die("could not connect to host " . $pe->getMessage());
}

createDatabase();
createTable();
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/styles/myStyles.css">
    <link rel="stylesheet" href="assets/styles/loginStyleSheet.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
    <div class="topnav">
        <a href="home.php">HOME</a>
        <a href="discover.php">DISCOVER</a>
        <a href="chat.php">CHAT</a>
        <a href="games.php">GAMES</a>
        <a href="yourMusic.php">YOUR MUSIC</a>
        <a class = "active" style="float: right;" href="login.php">LOGIN</a>
    </div>

    <div class="loginForm">

        <form method="post" action="login.php">
            
            <div class="formTitle">
                Log In
            </div> <br>

            <input type="text" name="email" id="email" required placeholder="Email"> <br>

            <input type="text" name="password" id="password" required placeholder="Password"> <br>

            <input type="hidden" name="action" value="login">
            <input type="submit" name="filled" value="Log in"> <br> <br>
            <?php 
                if (isset($_SESSION['loginError'])) {
                    echo "<div class='error'>Incorrect Email or Password</div>";
                } else {
                    echo "<br>";
                }
            ?>
        </form> <br> <br> <br>
    
        <form method="post" action="login.php">

            <div class="formTitle">
                Sign Up
            </div> <br>
            
            <input type="text" name="email" id="email" placeholder="Email"> <br>

            <input type="text" name="username" id="username" required placeholder="Username"> <br>

            <input type="text" name="password" id="password" required placeholder="Password"> <br>

            <input type="hidden" name="action" value="register">
            <input type="submit" name="filled" value="Register"> <br> <br>
            <?php 
                if (isset($_SESSION['registerError'])) {
                    echo "<div class='error'>Sorry, Email already in use</div>";
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
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $_SESSION['loginError'] = 1;
                    unset($_SESSION['registerError']);
                    header("Refresh:0");
                    authenticateUser($email, $password);
                break;
                case 'register':
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $email = $_POST['email'];
                    $_SESSION['registerError'] = 1;
                    unset($_SESSION['loginError']);
                    header("Refresh:0");
                    addUser($username, $password, $email);
                break;
            }    
        }
    ?>

</body>
</html>