<?php
    session_start();
    if (isset($_SESSION['background'])) {
        $background = $_SESSION['background'];
    } else {
        $background = "assets/images/desert.jpg";
    }

    function changeBackground() {
        $background = $_SESSION['background'];
        $username = $_SESSION['username'];
        $sql = "UPDATE users
                SET background = :background
                WHERE username = :username";
        $pdo = new pdo("mysql:host=localhost:8889; dbname=loginInfo", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'background' => $background
        ]);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="assets/styles/myStyles.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/myAccountStyleSheet.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Games</title>

    <style>
        <?php
            if (isset($_SESSION["background"])) {
                
                switch ($_SESSION['background']) {
                    case "assets/images/mountain.jpg":
                        echo "button[name='mountain'] {background-color: rgba(10, 10, 10, 0.7);}";
                        break;
                
                    case "assets/images/desert.jpg":
                        echo "button[name='desert'] {background-color: rgba(10, 10, 10, 0.7);}";
                        break;
                    
                    case "assets/images/forest.jpg":
                        echo "button[name='forest'] {background-color: rgba(10, 10, 10, 0.7);}";
                        break;

                    case "assets/images/ocean.jpg":
                        echo "button[name='ocean'] {background-color: rgba(10, 10, 10, 0.7);}";
                        break;

                    case "assets/images/aurora.jpg":
                        echo "button[name='aurora'] {background-color: rgba(10, 10, 10, 0.7);}";
                        break;

                    case "assets/images/city.jpg":
                        echo "button[name='city'] {background-color: rgba(10, 10, 10, 0.7);}";
                        break;

                    case "assets/images/stars.jpg":
                        echo "button[name='stars'] {background-color: rgba(10, 10, 10, 0.7);}";
                        break;

                    case "assets/images/sunset.jpg":
                        echo "button[name='sunset'] {background-color: rgba(10, 10, 10, 0.7);}";
                        break;
                }
            }        
        ?>
        
    </style>

</head>
<body style="background-image: url(<?php echo $background ?>);">
    <div class="topnav">
        <a href="home.php">HOME</a>
        <a href="discover.php">DISCOVER</a>
        <a href="chat.php">CHAT</a>
        <a href="games.php">GAMES</a>
        <a href="yourMusic.php">YOUR MUSIC</a>
        <a class = "active" style="float: right;" href="myAccount.php">MY ACCOUNT</a>
    </div>

    <?php

        if (isset($_POST['logout'])) {
            session_destroy();
            header("location: login.php");
        }        
    ?>


    <form method="post">

        <div class="accountHeading">
            <h1>Background Image</h1>      
        </div> <br>

        <div class="buttonContainer">

            <button type="submit" name="desert" class="backgroundButton">
                <img class="backgroundPreview" src="assets/images/desert.jpg"> <br>
                <div class="imageLabel">Desert</div>
            </button>
    
            <button type="submit" name="ocean" class="backgroundButton">
                <img class="backgroundPreview" src="assets/images/ocean.jpg"> <br>
                <div class="imageLabel">Ocean</div>
            </button>
    
            <button type="submit" name="mountain" class="backgroundButton">
                <img class="backgroundPreview" src="assets/images/mountain.jpg"> <br>
                <div class="imageLabel">Mountains</div>
            </button>
            
            <button type="submit" name="forest" class="backgroundButton">
                <img class="backgroundPreview" src="assets/images/forest.jpg"> <br>
                <div class="imageLabel">Forest</div>
            </button>

            <button type="submit" name="aurora" class="backgroundButton">
                <img class="backgroundPreview" src="assets/images/aurora.jpg"> <br>
                <div class="imageLabel">Northern Lights</div>
            </button>
    
            <button type="submit" name="city" class="backgroundButton">
                <img class="backgroundPreview" src="assets/images/city.jpg"> <br>
                <div class="imageLabel">City</div>
            </button>
    
            <button type="submit" name="stars" class="backgroundButton">
                <img class="backgroundPreview" src="assets/images/stars.jpg"> <br>
                <div class="imageLabel">Starry Sky</div>
            </button>

            <button type="submit" name="sunset" class="backgroundButton">
                <img class="backgroundPreview" src="assets/images/sunset.jpg"> <br>
                <div class="imageLabel">Sunset</div>
            </button>

        </div>
    </form>

    <?php
        if (isset($_POST['mountain'])) {
            $_SESSION['background'] = "assets/images/mountain.jpg";
            header("Refresh: 0");
            changeBackground();
            
        } else if (isset($_POST['desert'])) {
            $_SESSION['background'] = "assets/images/desert.jpg";
            header("Refresh: 0");
            changeBackground();

        } else if (isset($_POST['ocean'])) {
            $_SESSION['background'] = "assets/images/ocean.jpg";
            header("Refresh: 0");
            changeBackground();

        } else if (isset($_POST['city'])) {
            $_SESSION['background'] = "assets/images/city.jpg";
            header("Refresh: 0");
            changeBackground();

        } else if (isset($_POST['forest'])) {
            $_SESSION['background'] = "assets/images/forest.jpg";
            header("Refresh: 0");
            changeBackground();

        } else if (isset($_POST['aurora'])) {
            $_SESSION['background'] = "assets/images/aurora.jpg";
            header("Refresh: 0");
            changeBackground();

        } else if (isset($_POST['stars'])) {
            $_SESSION['background'] = "assets/images/stars.jpg";
            header("Refresh: 0");
            changeBackground();

        } else if (isset($_POST['sunset'])) {
            $_SESSION['background'] = "assets/images/sunset.jpg";
            header("Refresh: 0");
            changeBackground();
        }

        
    ?>

    <form method="post" class="logoutForm">
        <input type="submit" name="logout" value="Log Out" class="logout">
    </form>


</body>
</html>