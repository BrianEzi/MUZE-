<?php

    session_start();

    $database_host = "dbhost.cs.man.ac.uk";
    $database_user = "u95206ma";
    $database_pass = "deeznuts123";
    $database_name = "u95206ma";

    function createSearchTable($database_name)
    {
        $sql = "CREATE TABLE user (
        searchId INT,
        searchName VARCHAR(30) NOT NULL";

        $pdo = new pdo('mysql:host=localhost;dbname=' . $database_name . '',
        'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    } 

    function authenticateUser($username, $password)
    {
        $sql = "SELECT password
        FROM user
        WHERE username = :username";

        $pdo = new pdo('mysql:host=localhost;dbname=mydb',
        'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
                'username' => $username
                ]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();
        if (password_verify($password, $row['password']))
            echo("authentication successful");
        else
            echo("incorrect email or password");
    }

?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="myStyles.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MUZE#</title>
    </head>
    <body>
        <div class="topnav">
            <a class = "active" href="home.php">HOME</a>
            <a href="discover.php">DISCOVER</a>
            <a href="chat.php">CHAT</a>
            <a href="games.php">GAMES</a>
            <a href="yourMusic.php">YOUR MUSIC</a>
            <?php

            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo'<a style="float: right;" href="myAccount.php">MY ACCOUNT</a>';
            } else {
                echo'<a style="float: right;" href="login.php">LOGIN</a>';
            }
            ?>

        </div>

        <div class="logo">
            <img src="muze_image.png" alt="" class="center">
        </div>

        <div class="box">
            <input type="text" id="mySearch" onkeyup="myFunction()" placeholder="Search..." title="Type in a category">
        </div>

        
    </body>
</html>