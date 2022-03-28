<?php
include_once(__DIR__ . "/spotify-api/doSearch.php");
require_once(__DIR__ . "/DBFunctions.php");
@$searchTerm = $_GET["searchInput"];
if (!empty($searchTerm)) {
	// get all types selected with the checkboxes
	$types = array_filter(SPOTIFY_CONTENT_TYPE::$ALL, function($type) { return array_key_exists($type, $_GET); });
	// use all types if none are specified
	if (empty($types)) $types = SPOTIFY_CONTENT_TYPE::$ALL;

    // call spotify api
	$results = doSearch($searchTerm, $types);
}
?>

<?php
    session_start();
    if (isset($_SESSION['background'])) {
        $background = $_SESSION['background'];
    } else {
        $background = "assets/images/desert.jpg";
    }

    if (isset($_SESSION['tracks'])) {
        $tracks = $_SESSION['tracks'];
    } else {
        $tracks = [];
    }


    if (isset($_SESSION['albums'])) {
        $albums = $_SESSION['albums'];
    } else {
        $albums = [];
    }

    if (isset($_SESSION['artists'])) {
        $artists = $_SESSION['artists'];
    } else {
        $artists = [];
    }


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="assets/styles/myStyles.css">
        <link rel="stylesheet" type="text/css" href="assets/styles/discoverStyleSheet.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MUZE# - Discover</title>

        <script>
            
            document.addEventListener("DOMContentLoaded", function (event) {
                var scrollPosition = localStorage.getItem("scrollPosition");
                if (scrollPosition) {
                    window.scrollTo(0, scrollPosition);
                }
            });

            window.onscroll = function (e) {
                localStorage.setItem("scrollPosition", window.scrollY);
            };

        </script>

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

        <div class="searchbar">
            <form class="searchForm" method="get" action="discover.php">
                <input id="searchInput" name="searchInput"
                       placeholder="Find Music..." title="Type in a category"
                       value="<?=$searchTerm?>">
            </form>
        </div>






        <div class="content">
        <?php
        $resultIndex = 0;
        if (!empty($searchTerm)) {
            $tempIndex = 5;
	        foreach ($types as $type) {
                // if the search results don't have any of this type, skip this type
		        if (!array_key_exists($type, $results)) continue;
                
		        foreach ($results[$type]->items as $result) {

                    $_SESSION['searchResults'] = $results[$type]->items;

                    ?>



                    <form method="post">
                            <?php

                                if ($type == SPOTIFY_CONTENT_TYPE::TRACK) {
                                    echo '<input type="hidden" name="artist" value="' . implode(", ", SearchComponent::getArtists($result)) . '">';
                                    
                                }
                                
                                if ($type == SPOTIFY_CONTENT_TYPE::ALBUM) {
                                    echo '<input type="hidden" name="artist" value="' . implode(", ", SearchComponent::getArtists($result)) . '">';
                                }
                                
                                if ($type == SPOTIFY_CONTENT_TYPE::ARTIST) {
                                    
                                }
                                ?>

                            <input type="hidden" name="contentType" value="<?=strtoupper($result->type)?>">
                            <input type="hidden" name="title" value="<?=$result->name?>">
                            <input type="hidden" name="image" value="<?=SearchComponent::extractBiggestImageUrl($result)?>">

                            <button type="submit" class="contentItem" name="expand">
                            <!-- <div class="contentItem"> -->
                                <div class="contentItem-image">
                                    <?=SearchComponent::extractImageTag($result, "5em")?>
                                </div>
                                <div class="contentItem-mainText">
                                    <div class="contentLabel"><?=strtoupper($type)?></div>
                                    <div class="title"><b><?=$result->name?></b></div>
                                    <?php if ($type != SPOTIFY_CONTENT_TYPE::ARTIST) { ?>
                                        <?=implode(", ", SearchComponent::getArtists($result))?>
                                    <?php } ?>
                                </div>
                                
        
                                <div class="contentIcons">
        
                                    <?php
                                        if (isset($username)) {
                                        echo $resultIndex;

                                    ?>

                                    <form method="post" id="form">

                                        <a type="submit" class="addButton" href="javascript:void(0)" onclick="document.getElementsByClassName('light')[<?=$resultIndex?>].style.display='block';document.getElementById('fade').style.display='block'">
                                            +
                                        </a>

                                    </form>

                                    <?php
                                        }
                                    ?>
        
                                </div>
                            <!-- </div> -->
        
                        </button>
                    </form>


                    <div class="light" class="white_content">

                        <form class="playlistMenu" method="post">
                        <input type="hidden" name="index" value="<?=strval($resultIndex)?>">
                        <?php
                            if (isset($_SESSION['playlists'])) {
                                $playlists = $_SESSION['playlists'];
                                foreach($playlists as $p) {
                                    ?>
                                        <button type="submit" name="playlistSubmitted" value="<?=$p[0]?>">
                                            <?=$p[0]?>
                                        </button>
                                        <br>
                                    <?php
                                }
                                echo $result->name;
                            }
                        ?>
                        </form>
                        <a href="javascript:void(0)" onclick="document.getElementsByClassName('light')[<?=$resultIndex?>].style.display='none';document.getElementById('fade').style.display='none'">Close</a>
                    </div>
                        


                    <?php
                    $resultIndex += 1;
                }
        
                    
            }
        }
            
            if (isset($_POST["playlistSubmitted"])) {
                
                $playlistName = $_POST['playlistSubmitted'];
                $postIndex = intval($_POST["index"]);
                
                if ($postIndex < 19) {
                    $postType = "TRACK";
                    $spotifyType = SPOTIFY_CONTENT_TYPE::TRACK;
                } else if ($postIndex < 39) {
                    $postIndex -= 20;
                    $postType = "ALBUM";
                    $spotifyType = SPOTIFY_CONTENT_TYPE::ALBUM;
                } else {
                    $postIndex -= 40;
                    $postType = "ARTIST";
                    $spotifyType = SPOTIFY_CONTENT_TYPE::ARTIST;
                }
                echo $_POST['index'];
                
                // $resultToSave = ($results[$postType]->items)[$postIndex];

                $name = ($results[$spotifyType]->items)[$postIndex]->name;
                
                
                if ($postType == "TRACK") {

                    if ($playlistName == "My Tracks") {
                        addTrack($username, $resultToSave->name, implode(", ",SearchComponent::getArtists($resultToSave)), SearchComponent::extractBiggestImageUrl($resultToSave));
                        getTracks($username);
                    } else {
                        
                        addToPlaylist($username, $playlistName, $name, "me", "");
                        getPlaylists($username);
                    }

                }

                if ($postType == SPOTIFY_CONTENT_TYPE::ALBUM) {
                    addAlbum($username, $resultToSave->name, implode(", ",SearchComponent::getArtists($resultToSave)), ["",""], SearchComponent::extractBiggestImageUrl($resultToSave));
                    getAlbums($username);
                }

                if ($postType == SPOTIFY_CONTENT_TYPE::ARTIST) {
                    addArtist($username, $resultToSave->name, SearchComponent::extractBiggestImageUrl($resultToSave));
                    getArtists($username);
                }

                unset($_POST["playlistSubmitted"]);
                unset($_POST["index"]);
                unset($_POST["type"]);



                $_SESSION['reloadThePage'] = true;
                echo "<meta http-equiv='refresh' content='0'>";
            }

            if (isset($_POST['expand'])) {
                $_SESSION['title'] = $_POST['title'];
                $_SESSION['image'] = $_POST['image'];
                $_SESSION['type'] = $_POST['contentType'];
                // $_SESSION['type'] = "TRACK";
                if (isset($_POST['artist'])) {
                    $_SESSION['artist'] = $_POST['artist'];
                }
                if ($_POST['contentType'] == "PLAYLIST") {
                    foreach($_SESSION['playlists'] as $p) {
                        if ($p[0] == $_POST['title']) {
                            $_SESSION['tracklist'] = $p[1];
                        }
                    }
                }
                echo "<meta http-equiv='refresh' content='0;URL=contentInfo.php'>";
            }

        ?>
        </div>

        <div id="fade" class="black_overlay"></div>

    </body>
</html>