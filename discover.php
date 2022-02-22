<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="assets/styles/myStyles.css">
        <link rel="stylesheet" type="text/css" href="assets/styles/ContentDisplayStyleSheet.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Discover</title>
    </head>
    <body>
        <div class="topnav">
            <a href="home.php">HOME</a>
            <a class = "active" href="discover.php">DISCOVER</a>
            <a href="chat.php">CHAT</a>
            <a href="games.php">GAMES</a>
            <a href="yourMusic.php">YOUR MUSIC</a>
            <?php

            session_start();
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo'<a style="float: right;" href="myAccount.php">MY ACCOUNT</a>';
            } else {
                echo'<a style="float: right;" href="login.php">LOGIN</a>';
            }
            ?>
        </div>

        <div class="searchbar">
            <form action="">
                <input type="text" id="mySearch" onkeyup="myFunction()" placeholder="Search..." title="Type in a category">
            </form>
        </div>

        <!-- Example songs -->
        <div class="content">

            <div class="contentItem">

                <div class="image">
                    <img src="https://i.scdn.co/image/ab67616d0000b273d8082097058d4c44739b17dd" alt="" style="width: 5em; height: 5em">
                </div>

                <div class="mainText">
                    <div class="contentLabel">SONG</div>
                    <div class="title"><b>THE NEWS</b></div>
                    PARTYNEXTDOOR
                </div>
            
            </div>

            <div class="contentItem">

                <div class="image">
                    <img src="https://images.genius.com/2512fb4d26b27387d45221f328b83246.1000x1000x1.jpg" alt="" style="width: 5em; height: 5em">
                </div>

                <div class="mainText">
                    <div class="contentLabel">ALBUM</div>
                    <div class="title"><b>Nothing Was The Same</b></div>
                    Drake
                </div>
            
            </div>
            
            <div class="contentItem">

                <div class="image">
                    <img src="https://i.scdn.co/image/ab6761610000e5eb876faa285687786c3d314ae0" alt="" style="width: 5em; height: 5em">
                </div>

                <div class="mainText">
                    <div class="contentLabel">ARTIST</div>
                    <div class="title"><b>Kid Cudi</b></div>
                </div>
            </div>

        </div>
    </body>
</html>