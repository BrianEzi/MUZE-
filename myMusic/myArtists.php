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
    <link rel="stylesheet" type="text/css" href="../assets/styles/myStyles.css">
    <link rel="stylesheet" type="text/css" href="../assets/styles/myMusicAllStyleSheet.css">
    <!---<link rel="stylesheet" type="text/css" href="assets/styles/discoverStyleSheet.css"--->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUZE# - My Music</title>
</head>
<body style="background-image: url(../<?php echo $background ?>);">

    <div class="topnav">
        <a href="../home.php">HOME</a>
        <a href="../discover.php">DISCOVER</a>
        <a href="../chat.php">CHAT</a>
        <a href="g../ames.php">GAMES</a>

        <a class = "active" href="../myMusic.php">MY MUSIC</a>
        <?php

            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo'<a style="float: right;" href="../myAccount.php">MY ACCOUNT</a>';
            } else {
                echo'<a style="float: right;" href="../login.php">LOGIN</a>';
            }
        ?>
    </div>


    <div class="musicHeading">
        <div class="back"><a href="../myMusic.php">BACK</a></div>
        <h1>My Artists</h1>
    </div>

            <div class="content">
                <?php
                    if (isset($_SESSION['artists'])) {

                        $artists = $_SESSION['artists'];
                        // print_r($tracks); 
                        // echo "<br> <br>";

                        if (count($artists) > 0) {

                            foreach($artists as $row) {
                                ?>

                                <div class="contentItem">
                                    <div class="contentItem-image">
                                        <img src="<?php echo $row[1]; ?>" alt="">
                                        
                                    </div>
                                    <div class="contentItem-mainText">
                                        <div class="contentLabel">ARTIST</div>
                                        <div class="title"><b><?php echo $row[0]; ?></b></div>
                                    </div>

                                </div>

                                <?php
                            }

                        } else {
                            echo "<h2>You Currently Have No Artists Saved</h2>";
                        }
                    } else {
                        echo "<h2>You Currently Have No Artists Saved</h2>";
                    }
                ?>
            </div>

</body>
</html>