<?php

    session_start();

    $database_host = "dbhost.cs.man.ac.uk";
    $database_user = "u95206ma";
    $database_pass = "deeznuts123";
    $database_name = "u95206ma";

    function createSearchTable($database_name)
    {
        $sql = "CREATE TABLE search (
        searchId int NOT NULL,
        searchName VARCHAR(30) NOT NULL,
        PRIMARY KEY (searchID),
        FOREIGN KEY (searchName) REFERENCES search(searchName)"
        );

        $pdo = new pdo('mysql:host=localhost;dbname=' . $database_name . '',
        'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function createUserTable($database_name)
    {
        $sql = "CREATE TABLE user (
        username VARCHAR(30) NOT NULL,
        password VARCHAR(30) NOT NULL,
        nickname VARCHAR(10) NOT NULL,
        friendname VARCHAR(30) NOT NULL,
        playlistID int NOT NULL,
        songID int NOT NULL,
        searchID int NOT NULL,
        PRIMARY KEY (username),
        FOREIGN KEY (password) REFERENCES user(password),
        FOREIGN KEY (friendname) REFERENCES friend(friendname),
        FOREIGN KEY (playlistID) REFERENCES playlist(playlistID),
        FOREIGN KEY (songID) REFERENCES song(songID),
        FOREIGN KEY (searchID) REFERENCES search(searchID),
        FOREIGN KEY (searchName) REFERENCES search(searchName)"
        );

        $pdo = new pdo('mysql:host=localhost;dbname=' . $database_name . '',
        'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function createFriendTable($database_name)
    {
        $sql = "CREATE TABLE friend (
        friendname VARCHAR(30) NOT NULL,
        chat VARCHAR(30) NOT NULL,
        nickname VARCHAR(10) NOT NULL,  
        PRIMARY KEY (friendname)",

        $pdo = new pdo('mysql:host=localhost;dbname=' . $database_name . '',
        'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function createPlaylistTable($database_name)
    {
        $sql = "CREATE TABLE playlist (
        playlistID int NOT NULL AUTO_INCREMENT,
        songID VARCHAR(30) NOT NULL,
        playlistname VARCHAR(30) NOT NULL,
        searchName VARCHAR(30) NOT NULL,
        PRIMARY KEY (playlistID),
        FOREIGN KEY (songID) REFERENCES user(songID)",

        $pdo = new pdo('mysql:host=localhost;dbname=' . $database_name . '',
        'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function createSongTable($database_name)
    {
        $sql = "CREATE TABLE song (
        songID int NOT NULL AUTO_INCREMENT,
        songName VARCHAR(30) NOT NULL,
        artist VARCHAR(30) NOT NULL,
        liked BOOL NOT NULL,
        album VARCHAR(30) NOT NULL,
        weblink VARCHAR(100) NOT NULL,
        PRIMARY KEY (songID)",

        $pdo = new pdo('mysql:host=localhost;dbname=' . $database_name . '',
        'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function createHighScoresTable($database_name)
    {
        $sql = "CREATE TABLE highscores (
        highscoreID int NOT NULL AUTO_INCREMENT,
        gameID int NOT NULL,
        score int NOT NULL,
        username VARCHAR(30) NOT NULL,
        PRIMARY KEY (highscoreID),
        FOREIGN KEY (username) REFERENCES user(username)",

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