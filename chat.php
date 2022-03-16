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
    <link rel="stylesheet" type="text/css" href="assets/styles/chatStyleSheet.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUZE# - Chat</title>
</head>
<body style="background-image: url(<?php echo $background ?>);">
    <div class="topnav">
        <a href="home.php">HOME</a>
        <a href="discover.php">DISCOVER</a>
        <a class = "active" href="chat.php">CHAT</a>
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

    <div class="chatArea">
        <ul class="chatSidebar">
            <li class="chatOption">
                <img src="assets/images/aurora.jpg" alt="Someone's profile picture">
                <div>
                    <h5>Someone</h5>
                    <p>Hey!</p>
                </div>
            </li>
            <li class="chatOption selected">
                <img src="assets/images/aurora.jpg" alt="Someone else's profile picture">
                <div>
                    <h5>Someone else</h5>
                    <p>Hello!</p>
                </div>
            </li>
            <li class="chatOption">
                <img src="assets/images/aurora.jpg" alt="A friend's profile picture">
                <div>
                    <h5>A friend</h5>
                    <p>Hi!</p>
                </div>
            </li>
            <li class="chatOption">
                <img src="assets/images/aurora.jpg" alt="Another person's profile picture">
                <div>
                    <h5>Another person</h5>
                    <p>Hola!</p>
                </div>
            </li>
        </ul>
        <div class="chatMain">
            <ul class="chatMessages">
		        <?php for ($i = 0; $i < 10; ++$i) { ?>
                    <li class="chatMessage">
                        Lorem ipsum dolor sit amet
                    </li>
                    <li class="chatMessage">
                        consectetur adipiscing elit
                    </li>
                    <li class="chatMessage chatMessage-ownMessage">
                        Ut enim ad minim veniam
                    </li>
                    <li class="chatMessage">
                        Ut enim ad minim veniam
                    </li>
		        <?php } ?>
            </ul>
            <input class="chatInput" placeholder="Send a message...">
        </div>
    </div>

</body>
</html>