<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="myStyles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Games</title>
</head>
<body>
    <div class="topnav">
        <a href="home.php">HOME</a>
        <a href="discover.php">DISCOVER</a>
        <a href="chat.php">CHAT</a>
        <a href="games.php">GAMES</a>
        <a href="yourMusic.php">YOUR MUSIC</a>
        <a class = "active" style="float: right;" href="myAccount.php">MY ACCOUNT</a>
    </div>

    <?php

        session_start();
        $username = $_SESSION['username'];
        echo("<h1 style='color: white'>Welcome, ". $username ."</h1>");

        if (isset($_POST['logout'])) {
            session_destroy();
            header("location: home.php");
        }

    ?>
    <form method="POST">
        <input type="submit" name="logout" value="logout">
    </form>
        
</body>
</html>