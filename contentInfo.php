<?php
    session_start();
    include_once(__DIR__ . "/spotify-api/getAlbumTracks.php");
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
        <a class = "active" href="discover.php">DISCOVER</a>
        
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
                echo'<a style="float: right;" href="myMusic.php">MY MUSIC</a>';
            }
        ?>
    </div>

    <?php
        $itemId = $_SESSION['id'];
        $title = $_SESSION['title'];
        $image = $_SESSION['image'];
        $type = $_SESSION['type'];

        if (isset($_SESSION['artist'])) {
            $artist = $_SESSION['artist'];
        }
        if (isset($_SESSION['url'])) {
            $url = $_SESSION['url'];
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
                <br>
                <a target="_blank"  class="link" href="<?=$url?>">Listen on Spotify</a>
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
                <br>
                <a target="_blank"  class="link" href="<?=$url?>">Listen on Spotify</a>
            </div>
        </div>

        <div class="content">

            <?php foreach (getAlbumTracks($itemId) as $result) { ?>
            <form method="post">
		        <?php

		        if ($type == SPOTIFY_CONTENT_TYPE::TRACK) {
			        echo '<input type="hidden" name="artist" value="' . $result["artist"] . '">';
			        echo '<input type="hidden" name="url" value="' . $result["url"] . '"?>';

		        }

		        if ($type == SPOTIFY_CONTENT_TYPE::ALBUM) {
			        echo '<input type="hidden" name="artist" value="' . $result["artist"] . '">';
			        echo '<input type="hidden" name="url" value="' . $result["url"] . '"?>';
		        }

		        if ($type == SPOTIFY_CONTENT_TYPE::ARTIST) {
			        echo '<input type="hidden" name="url" value="' . $result["url"] . '"?>';
		        }
		        ?>

                <input type="hidden" name="contentType" value="<?=strtoupper($type)?>">
                <input type="hidden" name="title" value="<?=$result["name"]?>">
                <input type="hidden" name="image" value="<?=$image?>">
                <input type="hidden" name="id" value="<?=$result["id"]?>">

                <button type="submit" class="contentItem" name="expand">
                    <!-- <div class="contentItem"> -->
                    <div class="contentItem-mainText">
                        <div class="contentLabel"><?=strtoupper($type)?></div>
                        <div class="title"><b><?=$result["name"]?></b></div>
                        <div class="artist">
					        <?php if ($type != SPOTIFY_CONTENT_TYPE::ARTIST) { ?>
						        <?=$result["artist"]?>
					        <?php } ?>

                        </div>
                    </div>


                    <div class="contentIcons">

				        <?php
				        if (isset($username) AND $type==SPOTIFY_CONTENT_TYPE::TRACK) {

				        ?>

                        <form method="post" id="form" class="addForm">

                            <a type="submit" class="addButton" href="javascript:void(0)" onclick="document.getElementsByClassName('light')[<?=$resultIndex?>].style.display='flex';document.getElementById('fade').style.display='block'">
                                +
                            </a>



					        <?php
					        } else if (isset($username)) {
						        ?>

                                <input type="hidden" name="index" value="<?=strval($resultIndex)?>">
                                <input type="hidden" name="type" value="<?=strtoupper($type)?>">
                                <input type="hidden" name="submitted">
                                <input type="submit" class="inputSubmit" value="+">


						        <?php
					        }
					        ?>

                        </form>

                    </div>
                    <!-- </div> -->

                </button>
            </form>
            <?php } ?>
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
                <br>
                <a target="_blank"  class="link" href="<?=$url?>">Listen on Spotify</a>
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
    
        <?php
        }
        ?>
    


    
</body>
</html>