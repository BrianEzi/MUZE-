<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="myStyles.css">
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
        </div>

        <div class="searchbar">
            <input type="text" id="mySearch" onkeyup="myFunction()" placeholder="Search..." title="Type in a category">
        </div>

        <!-- Example songs -->
        <div class="content">

            <div class="song">
                Sacrifice - The Weeknd
            </div>

            <div class="song">
                Out Of Time - The Weeknd
            </div>

            <div class="song">
                Just Testing What A Really Long Song Would Look Like - Not That Good Apparently
            </div>


            <div class="album">

                <div class="albumcover">
                    <img src="https://images.genius.com/2512fb4d26b27387d45221f328b83246.1000x1000x1.jpg" alt="" style="width: 5em; height: 5em">
                </div>

                <div class="albumText">
                    <div class="contentLabel">ALBUM</div>
                    <div class="albumTitle"><b>Nothing Was The Same</b></div>
                    Drake
                </div>
            
            </div>
            
            <div class="artist">

                <div class="ProfilePicture">
                    <img src="https://i.scdn.co/image/ab6761610000e5eb876faa285687786c3d314ae0" alt="" style="width: 5em; height: 5em">
                </div>

                <div class="artistText">
                    <div class="contentLabel">ARTIST</div>
                    <div class="artistTitle"><b>Kid Cudi</b></div>
                </div>
            </div>

        </div>
    </body>
</html>