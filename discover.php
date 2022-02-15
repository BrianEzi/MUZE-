<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="myStyles.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
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
        </div>
    </body>
</html>