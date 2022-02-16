<?php

function createDatabase(){
    $sql = "CREATE DATABASE IF NOT EXISTS loginInfo";
    $pdo = new pdo('mysql:host=localhost:8889;', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $pdo->query($sql);
}

function createTable(){
    $sql = "CREATE TABLE IF NOT EXISTS users (
        userID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        password VARCHAR(128) NOT NULL,
        email VARCHAR(30) NOT NULL UNIQUE)";

    $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $pdo->query($sql);
}

function dropTable(){
    $sql = "DROP TABLE users";
    $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $pdo->query($sql);
}


function addUser($username, $password, $email){
    $sql = "SELECT * FROM users WHERE email=?";
    $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $emailExists = $stmt->fetch();
    if ($emailExists) {
        echo "<div class='error'>Sorry, email already in use</div>";

    } else {
        $sql = "INSERT INTO users (username, password, email)
                VALUES (:username, :password, :email)";
        $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
        $stmt = $pdo->prepare($sql);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([
            'username' => $username,
            'password' => $password,
            'email' => $email
        ]);
        session_start();
            $_SESSION['username'] = $username;
            header("location: home.php");
    }

}

function POSTUser($id){
    $sql = "SELECT username, password, email
            FROM users
            WHERE userID=:id";
    $pdo = new pdo("mysql:host=localhost:8889; dbname=loginInfo", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id' => $id
    ]);
}

function authenticateUser($email, $password) {
    $sql = "SELECT password, username
            FROM users
            WHERE email = :email";
    $pdo = new pdo("mysql:host=localhost:8889; dbname=loginInfo", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'email' => $email
    ]);

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $row = $stmt->fetch();

    echo "<br>";

    if ($stmt->rowCount() > 0) {
        if (password_verify($password, $row['password'])) {
            session_start();
            $username = $row['username'];
            $_SESSION['username'] = $username;
            $_SESSION['signedIn'] = FALSE;
            header("location: home.php");
        } else {
            echo "<div class='error'>Incorrect email or password</div>";
        }
    } else {
        echo "<div class='error'>Incorrect email or password</div>";
    }
    
    
}


try {
    $conn = new pdo('mysql:host=localhost:8889;', 'root', 'root');
    //echo "connected to localhost:8889 successfully";
}
catch(PDOException $pe) {
    die("could not connect to host " . $pe->POSTMessage());
}

createDatabase();
createTable();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="myStyles.css">
    <link rel="stylesheet" href="loginStyleSheet.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <h2>Log In</h2>
        <form method="post" action="login.php">
            <p>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" required> 
            </p>
            <p>
                <label for="password">Password</label>
                <input type="text" name="password" id="password" required>
            </p>
            <br>
            <input type="hidden" name="action" value="login">
            <input type="submit" name="filled" value="Log in">
        </form>
    
        <h2>Sign Up</h2>
        <form method="post" action="login.php">
            <p>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" required>
            </p>

            <p>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </p>
            <p>
                <label for="password">Password</label>
                <input type="text" name="password" id="password" required> 
            </p>
            <br>
            <input type="hidden" name="action" value="register">
            <input type="submit" name="filled" value="Register">
        </form>
    </div>

    <?php

        if(isset($_POST['filled'])) {
            switch($_POST['action']) {
                case 'login':
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    authenticateUser($email, $password);
                break;
                case 'register':
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $email = $_POST['email'];
                    addUser($username, $password, $email);
            }    
        }
    ?>

</body>
</html>