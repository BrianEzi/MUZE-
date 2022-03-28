<?php require_once(__DIR__ . "/DBFunctions.php"); ?>

<?php
	session_start();
	if (isset($_SESSION['background'])) {
        $background = $_SESSION['background'];
    } else {
        $background = "assets/images/desert.jpg";
    }

    // $username = $_SESSION['username'];
    // $profilePicture = $_SESSION['profilePicture'];
?>

<?php 
	

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="assets/styles/myAccountStyleSheet.css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUZE# - Friends</title>

</head>
	
	<body style="background-image: url(<?php echo $background ?>);">
	    <div class="topnav">
	        <a href="home.php">HOME</a>
	        <a href="discover.php">DISCOVER</a>
	        <a href="chat.php">CHAT</a>
	        <a href="games.php">GAMES</a>
	        <a class = "active" style="float: right;" href="myAccount.php">MY ACCOUNT</a>
	        <a style="float: right;" href="myMusic.php">MY MUSIC</a>
	    </div>

	    <?php
		if (isset($_POST['logout'])) {
            session_destroy();
            header("location: login.php");
        }        
    	?>

    	<div class="accountHeading">
        	<h1>Add Friends</h1>
    	</div>

    	<input type="text" id="slugmanuts" placeholder="Find Friends you sado" style="width: 100%;">
    	<input type="submit" name="submit">
	<body>

</body>
</html>