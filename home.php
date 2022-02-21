<?php
    session_start();
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