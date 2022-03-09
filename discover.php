<?php
include_once(__DIR__ . "/spotify-api/doSearch.php");
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
                                <?=implode("; ", SearchComponent::getArtists($result))?>
                            <?php } ?>
                        </div>

                        <div class="contentIcons">

                            <img src="assets/images/heart_unfilled.pdf" alt="" style="width: 2em; height: 3em;">
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>
        </div>

    </body>
</html>