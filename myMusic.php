<?php
    session_start();
    if (isset($_SESSION['background'])) {
        $background = $_SESSION['background'];
    } else {
        $background = "assets/images/desert.jpg";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="assets/styles/myStyles.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/myMusicStyleSheet.css">
    <!---<link rel="stylesheet" type="text/css" href="assets/styles/discoverStyleSheet.css"--->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUZE# - My Music</title>
</head>
<body style="background-image: url(<?php echo $background ?>);">

    <div class="topnav">
        <a href="home.php">HOME</a>
        <a href="discover.php">DISCOVER</a>
        <a href="chat.php">CHAT</a>
        <a href="games.php">GAMES</a>

        <a class = "active" href="myMusic.php">MY MUSIC</a>
        <?php

            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo'<a style="float: right;" href="myAccount.php">MY ACCOUNT</a>';
            } else {
                echo'<a style="float: right;" href="login.php">LOGIN</a>';
            }
        ?>
    </div>

    <div class="musicHeading">
        <h1>My Tracks</h1> <br>
            <div class="contentWrapper">
                <?php
                    if (isset($_SESSION['tracks'])) {

                        $tracks = $_SESSION['tracks'];
                        // print_r($tracks); 
                        // echo "<br> <br>";

                        foreach($tracks as $row) {
                            echo "<div class='tempContent'>" . $row[0] . "<br>" . "<img src='" . $row[1] . "'alt='' style='width: 10em; height: 10em;'>" . "</div>";

                            echo "<br>";
                            
                            echo "<br>";
                            echo "<br>";
                        }
                    }
                ?>
            </div>
            
        <h1>My Albums</h1> <br>

        <h1>My Artists</h1> <br>
    </div>


</body>
</html>