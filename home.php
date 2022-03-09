
<?php
    session_start();
    if (isset($_SESSION['background'])) {
        $background = $_SESSION['background'];
    } else {
        $background = "https://images.unsplash.com/photo-1542401886-65d6c61db217?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80";
    }
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="assets/styles/myStyles.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MUZE# - Home</title>
    </head>
    <body style="background-image: url(<?php echo $background ?>);">
        <div class="topnav">
            <a class="active" href="home.php">HOME</a>
            <a href="discover.php">DISCOVER</a>
            <a href="chat.php">CHAT</a>
            <a href="games.php">GAMES</a>
            <?php

            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo'<a href="myMusic.php">MY MUSIC</a>';
            }
            ?>

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
            <img src="assets/images/muze_image.png" alt="" class="center">
        </div>

        <div class="box">
            <form class="searchForm" method="get" action="discover.php">
                <input id="searchInput" name="searchInput"
                       placeholder="Find Music..." title="Type in a category">
            </form>
        </div>

        
    </body>
</html>