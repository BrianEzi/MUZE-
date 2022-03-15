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
    </head>
    <body style="background-image: url(<?php echo $background ?>);">
        <div class="topnav">
            <a href="home.php">HOME</a>
            <a class = "active" href="discover.php">DISCOVER</a>
            <a href="chat.php">CHAT</a>
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
        if (!empty($searchTerm)) {
	        foreach ($types as $type) {
                // if the search results don't have any of this type, skip this type
		        if (!array_key_exists($type, $results)) continue;
                
                $resultIndex = 0;
		        foreach ($results[$type]->items as $result) {
                    ?>
                    <div class="contentItem">
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
                        
                        <?php

                            $saved = false;

                            if ($type == SPOTIFY_CONTENT_TYPE::TRACK) {
                                foreach($tracks as $t) {
                                    if ($t[0] == $result->name && $t[1] == implode(", ", SearchComponent::getArtists($result))) {
                                        $saved = true;
                                    }
                                }
                            }

                            if ($type == SPOTIFY_CONTENT_TYPE::ALBUM) {
                                foreach($albums as $a) {
                                    if ($a[0] == $result->name && $a[2] == implode(", ", SearchComponent::getArtists($result))) {
                                        $saved = true;
                                    }
                                }
                            }

                            if ($type == SPOTIFY_CONTENT_TYPE::ARTIST) {
                                foreach($artists as $t) {
                                    if ($t[0] == $result->name) {
                                        $saved = true;
                                    }
                                }
                            }


                        ?>

                        <div class="contentIcons">

                            <?php
                                if ($saved && isset($username)) {
                            ?>

                                    <form method="post">
                                        <input type="hidden" name="toUnsave">
                                        <input type="hidden" name="index" value=<?=$resultIndex?>>
                                        <input type="hidden" name="type" value=<?=$type?>>
                                        <input type="image" src="assets/images/heart_filled.pdf" style="width: 3em; height: 5em;" alt="submit">
                                    </form>

                                    

                            <?php
                                } else if (isset($username)) {
                            ?>

                                    <form method="post">
                                        <input type="hidden" name="toSave">
                                        <input type="hidden" name="index" value=<?=$resultIndex?>>
                                        <input type="hidden" name="type" value=<?=$type?>>
                                        <input type="image" src="assets/images/heart_unfilled.pdf" style="width: 3em; height: 5em;" alt="submit">
                                    </form>

                            <?php
                                }
                            ?>

                        </div>
                    </div>

                    <?php
                    
                    $resultIndex += 1;



                    
                }
            }
            
            if (isset($_POST["toSave"])) {
                $postIndex = $_POST["index"];
                $postType = $_POST["type"];
                
                $resultToSave = ($results[$postType]->items)[$postIndex];

                if ($postType == SPOTIFY_CONTENT_TYPE::TRACK) {
                    addTrack($username, $resultToSave->name, implode(", ",SearchComponent::getArtists($resultToSave)), SearchComponent::extractBiggestImageUrl($resultToSave));
                    getTracks($username);
                }

                if ($postType == SPOTIFY_CONTENT_TYPE::ALBUM) {
                    addAlbum($username, $resultToSave->name, implode(", ",SearchComponent::getArtists($resultToSave)), ["",""], SearchComponent::extractBiggestImageUrl($resultToSave));
                    getAlbums($username);
                }

                if ($postType == SPOTIFY_CONTENT_TYPE::ARTIST) {
                    addArtist($username, $resultToSave->name, SearchComponent::extractBiggestImageUrl($resultToSave));
                    getArtists($username);
                }

                unset($_POST["toSave"]);
                unset($_POST["index"]);
                unset($_POST["type"]);

                $_SESSION['reloadThePage'] = true;
                echo "<meta http-equiv='refresh' content='0'>";
            }

            if (isset($_POST["toUnsave"])) {
                $postIndex = $_POST["index"];
                $postType = $_POST["type"];

                $resultToUnsave = ($results[$postType]->items)[$postIndex];

                // print_r($resultToUnsave);

                if ($postType == SPOTIFY_CONTENT_TYPE::TRACK) {
                    removeTrack($username, $resultToUnsave->name, implode(", ",SearchComponent::getArtists($resultToUnsave)));
                    getTracks($username);
                }

                if ($postType == SPOTIFY_CONTENT_TYPE::ALBUM) {
                    removeAlbum($username, $resultToUnsave->name, implode(", ",SearchComponent::getArtists($resultToUnsave)));
                    getAlbums($username);
                }

                if ($postType == SPOTIFY_CONTENT_TYPE::ARTIST) {
                    removeArtist($username, $resultToUnsave->name);
                    getArtists($username);
                }

                unset($_POST["toUnsave"]);
                unset($_POST["index"]);
                unset($_POST["type"]);

                $_SESSION['reloadThePage'] = true;
                echo "<meta http-equiv='refresh' content='0'>";
            }

        }
        ?>
        </div>

    </body>
</html>