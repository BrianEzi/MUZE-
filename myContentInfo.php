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
    <link rel="stylesheet" type="text/css" href="assets/styles/contentInfoStyleSheet.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUZE# - Discover</title>

</head>
<body style="background-image: url(<?php echo $background ?>);">
    <div class="topnav">
        <a href="home.php">HOME</a>
        <a href="discover.php">DISCOVER</a>
        
        <?php
            if (isset($_SESSION['username'])) {
                echo '<a href="chat.php">CHAT</a>';
            }
        ?>
        
        <a href="games.php">GAMES</a>

        <?php

            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo'<a style="float: right;" href="myAccount.php">MY ACCOUNT</a>';
            } else {
                echo'<a style="float: right;" href="login.php">LOGIN</a>';
            }

            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo'<a class = "active" style="float: right;" href="myMusic.php">MY MUSIC</a>';
            }
        ?>
    </div>

    <?php
        $title = $_SESSION['title'];
        $image = $_SESSION['image'];
        $type = $_SESSION['type'];

        if (isset($_SESSION['artist'])) {
            $artist = $_SESSION['artist'];
        }

        if (isset($_SESSION['tracklist'])) {
            $tracklist = $_SESSION['tracklist'];
        }
    ?>

        <?php
        if ($type=="TRACK") {   
        ?>

        <div class="contentWrapper">
            <div class="imageWrapper">
                <img src="<?=$image?>" alt="">
            </div>
            <div class="textWrapper">
                <div class="type"><?=$type?></div>
                <div class="title"><b><?=$title?></b></div>
                <div class="artist"><?=$artist?></div>
            </div>
        </div>

        <?php
        }
        if ($type=="ALBUM") {
        ?>
            
        <div class="contentWrapper">
            <div class="imageWrapper">
                <img src="<?=$image?>" alt="">
            </div>
            <div class="textWrapper">
                <div class="type"><?=$type?></div>
                <div class="title"><b><?=$title?></b></div>
                <div class="artist"><?=$artist?></div>
            </div>
        </div>

        <?php
        }
        if ($type=="ARTIST") {
        ?>
        

        <div class="contentWrapper">
            <div class="imageWrapper">
                <img src="<?=$image?>" alt="">
            </div>
            <div class="textWrapper">
                <div class="type"><?=$type?></div>
                <div class="title"><b><?=$title?></b></div>
            </div>
        </div>

        <?php
        }

        if ($type=="PLAYLIST") {
        ?>
                
        <div class="contentWrapper">
            <div class="imageWrapper">
                <img src="<?=$image?>" alt="">
            </div>
            <div class="textWrapper">
                <div class="type"><?=$type?></div>
                <div class="title"><b><?=$title?></b></div>
            </div>
        </div>

        <br><br><br><br>

        <?php

            foreach(array_slice($tracklist, 1) as $t) {
                ?>
                <div class="trackWrapper">

                    <img src="<?=$t[2]?>" alt="" class="trackImage">

                    <div class="trackTextWrapper">

                        <div class="trackTitle">
                            <?=$t[0]?>
                        </div>
    
                        <div class="trackArtist">
                            <?=$t[1]?>
                        </div>

                    </div>


                </div>

                <br><br>

                <?php
            }
        }

        ?>
       
    


    
</body>
</html>