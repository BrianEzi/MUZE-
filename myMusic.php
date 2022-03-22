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

        
        <?php

            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo'<a style="float: right;" href="myAccount.php">MY ACCOUNT</a>';
            } else {
                echo'<a style="float: right;" href="login.php">LOGIN</a>';
            }
        ?>
        <a style="float: right;" class = "active" href="myMusic.php">MY MUSIC</a>
        
    </div>

    <div class="musicHeading">
        <div class="emptySpace"></div>

        <div class="heading">
            <b>My Tracks</b>
        </div>
        <div class="seeAll"><a href="myMusic/myTracks.php">SEE ALL</a></div>
    </div>
            <div class="content">
                <?php
                    if (isset($_SESSION['tracks'])) {

                        $tracks = $_SESSION['tracks'];
                        // print_r($tracks); 
                        // echo "<br> <br>";

                        if (count($tracks) > 0) {

                            if (count($tracks) < 10) {

                                foreach($tracks as $row) {
                                    ?>
        
                                    <div class="contentItem">
                                        <div class="contentItem-image">
                                            <img src="<?php echo $row[2]; ?>" alt="">
                                            
                                        </div>
                                        <div class="contentItem-mainText">
                                            <div class="contentLabel">TRACK</div>
                                            <div class="title"><b><?php echo $row[0]; ?></b></div>
                                            <?php echo $row[1]; ?>
                                        </div>
        
                                    </div>
        
                                    <?php
                                }

                            } else {
                                for ($i = 0; $i < 10; $i++) {
                                    $row = $tracks[$i];

                                    ?>
            
                                    <div class="contentItem">
                                        <div class="contentItem-image">
                                            <img src="<?php echo $row[2]; ?>" alt="">
                                            
                                        </div>
                                        <div class="contentItem-mainText">
                                            <div class="contentLabel">TRACK</div>
                                            <div class="title"><b><?php echo $row[0]; ?></b></div>
                                            <?php echo $row[1]; ?>
                                        </div>
        
                                    </div>
        
                                    <?php
                                    
                                }
                            
                            }
                        } else {
                            echo "<h2>You Currently Have No Tracks Saved</h2>";
                        }

                    } else {
                        echo "<h2>You Currently Have No Tracks Saved</h2>";
                    }

                ?>
            </div>
            
    <div class="musicHeading">
        <div class="emptySpace"></div>

        <div class="heading">
            <b>My Albums</b>
        </div>
        <div class="seeAll"><a href="myMusic/myAlbums.php">SEE ALL</a></div>
    </div>

            <div class="content">
                <?php
                    if (isset($_SESSION['albums'])) {

                        $albums = $_SESSION['albums'];
                        // print_r($tracks); 
                        // echo "<br> <br>";

                        if (count($albums) > 0) {

                            if (count($albums) < 10) {

                                foreach($albums as $row) {
                                    ?>

                                    <div class="contentItem">
                                        <div class="contentItem-image">
                                            <img src="<?php echo $row[3]; ?>" alt="">
                                            
                                        </div>
                                        <div class="contentItem-mainText">
                                            <div class="contentLabel">ALBUM</div>
                                            <div class="title"><b><?php echo $row[0]; ?></b></div>
                                            <?php echo $row[2]; ?>
                                        </div>

                                    </div>

                                    <?php
                                }

                            } else {
                                for ($i = 0; $i < 10; $i++) {
                                    $row = $albums[$i];

                                    ?>
            
                                    <div class="contentItem">
                                        <div class="contentItem-image">
                                            <img src="<?php echo $row[3]; ?>" alt="">
                                            
                                        </div>
                                        <div class="contentItem-mainText">
                                            <div class="contentLabel">ALBUM</div>
                                            <div class="title"><b><?php echo $row[0]; ?></b></div>
                                            <?php echo $row[2]; ?>
                                        </div>

                                    </div>

                                    <?php
                                    
                                }
                            
                            }
                        } else {
                            echo "<h2>You Currently Have No Albums Saved</h2>";
                        }
                    } else {
                        echo "<h2>You Currently Have No Albums Saved</h2>";
                    }
                ?>
            </div>

    <div class="musicHeading">
        <div class="emptySpace"></div>
        <div class="heading">
            <b>My Artists</b>
        </div>
        <div class="seeAll"><a href="myMusic/myArtists.php">SEE ALL</a></div>
    </div>

            <div class="content">
                <?php
                    if (isset($_SESSION['artists'])) {

                        $artists = $_SESSION['artists'];
                        // print_r($tracks); 
                        // echo "<br> <br>";

                        if (count($artists) > 0) {

                            if (count($artists) < 10) {

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
                                for ($i = 0; $i < 10; $i++) {
                                    $row = $artists[$i];

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
                            }

                        } else {
                            echo "<h2>You Currently Have No Artists Saved</h2>";
                        }
                    
                    } else {
                        echo "<h2>You Currently Have No Artists Saved</h2>";
                    }
                ?>
            </div>

    <div class="musicHeading">
        <div class="emptySpace"></div>
        <div class="heading">
            <b>My Playlists</b>
        </div>
        <div class="seeAll"><a href="myMusic/myPlaylists.php">SEE ALL</a></div>
    </div>

            <div class="content">
                <?php
                    if (isset($_SESSION['playlists'])) {

                        $playlists = $_SESSION['playlists'];
                        // print_r($tracks); 
                        // echo "<br> <br>";

                        if (count($playlists) > 0) {

                            if (count($playlists) < 10) {

                                foreach($playlists as $row) {
                                    ?>

                                    <div class="contentItem">
                                        <div class="contentItem-image">
                                            <img src="<?php echo $row[3]; ?>" alt="">
                                            
                                        </div>
                                        <div class="contentItem-mainText">
                                            <div class="contentLabel">ALBUM</div>
                                            <div class="title"><b><?php echo $row[0]; ?></b></div>
                                            <?php echo $row[2]; ?>
                                        </div>

                                    </div>

                                    <?php
                                }

                            } else {
                                for ($i = 0; $i < 10; $i++) {
                                    $row = $playlists[$i];

                                    ?>
            
                                    <div class="contentItem">
                                        <div class="contentItem-image">
                                            <img src="<?php echo $row[3]; ?>" alt="">
                                            
                                        </div>
                                        <div class="contentItem-mainText">
                                            <div class="contentLabel">ALBUM</div>
                                            <div class="title"><b><?php echo $row[0]; ?></b></div>
                                            <?php echo $row[2]; ?>
                                        </div>

                                    </div>

                                    <?php
                                    
                                }
                            
                            }
                        } else {
                            echo "<h2>You Currently Have No Playlists Saved</h2>";
                        }
                    } else {
                        echo "<h2>You Currently Have No Playlists Saved</h2>";
                    }
                ?>
            </div>

            <br><br><br><br>

</body>
</html>