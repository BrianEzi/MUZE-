<?php require_once(__DIR__ . "/DBFunctions.php");
		require "lib-relation.php"; ?>

<?php
	session_start();
	if (isset($_SESSION['background'])) {
        $background = $_SESSION['background'];
    } else {
        $background = "assets/images/desert.jpg";
    }
    $username = $_SESSION['username'];
    $con = new mysqli("dbhost.cs.man.ac.uk","n80569fh","balls1235","2021_comp10120_m8");
    if ($con->connect_error){
    	die("Connection failed:" . $mysqli_connect_error());
    }
    $sql = "SELECT userID FROM users WHERE username ='".$username . "'";
    $result= mysqli_query($con, $sql);
    if(mysqli_num_rows($result)>0){
    	while($row=mysqli_fetch_assoc($result)){
    		$uid = $row["userID"];
    	}
    }
    mysqli_close($con);
		// (B) PROCESS RELATIONSHIP REQUEST
		if (isset($_POST['req'])) {
		  $pass = true;
		  switch ($_POST['req']) {
		    // (B0) INVALID
		    default: $pass = false; $REL->error = "Invalid request"; break;
		    // (B1) ADD FRIEND
		    case "add": $pass = $REL->request($uid, $_POST['id']); break;
		    // (B2) ACCEPT FRIEND
		    case "accept": $pass = $REL->acceptReq($_POST['id'], $uid); break;
		    // (B3) CANCEL ADD
		    case "cancel": $pass = $REL->cancelReq($uid, $_POST['id']); break;
		    // (B4) UNFRIEND
		    case "unfriend": $pass = $REL->unfriend($uid, $_POST['id'], false); break;
		    // (B5) BLOCK
		    // case "block": $pass = $REL->block($uid, $_POST['id']); break;
		    // // (B6) UNBLOCK
		    // case "unblock": $pass = $REL->block($uid, $_POST['id'], false); break;
		  }
		  // echo $pass ? "<div class='ok'>OK</div>" : "<div class='nok'>{$REL->error}</div>";
		}
		 
		// (C) GET + SHOW ALL USERS
		$users = $REL->getUsers(); 
?>

</div>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="assets/styles/myAccountStyleSheet.css">
	<link rel="stylesheet" type="text/css" href="assets/styles/myStyles.css">
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

		<script type="text/javascript">
		  function relate (req, uid) {
		  document.getElementById("ninreq").value = req;
		  document.getElementById("ninid").value = uid;
		  document.getElementById("ninform").submit();
		}
		</script>

    	<div class="accountHeading">
        	<h1>Add Friends</h1>
    	</div>

    	<!-- (D) NINJA RELATIONSHIP FORM -->
		
		<form id="ninform" method="post" target="_self">
		  <input type="hidden" name="req" id="ninreq"/>
		  <input type="hidden" name="id" id="ninid"/>
		</form>
		<div>
		  <form method="post">
		  <label>Search</label>
		  <input type="text" name="search" style="width: 85%;" style="align-content: center;">

		  <input type="submit" name="submit">
		  </form>
		</div>
		<div id="userNow">You are now <?=$users[$uid]?>.</div>
		<div id="userList">

		<?php

		$con = new PDO("mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_m8",'n80569fh','balls1235');

		if (isset($_POST["submit"])) {
		  $str = $_POST["search"];
		  $sth = $con->prepare("SELECT * FROM `users` WHERE username = '$str'");

		  $sth -> setFetchMode(PDO:: FETCH_OBJ);
		  $sth -> execute();

		  if($row = $sth->fetch())
		  {
		    ?>
		    <br><br><br>
		    <table>
		      <tr>
		        <th>Name</th>
		      </tr>
		      <tr>
		        <td><?php echo $row->username;
						  $requests = $REL->getReq($uid);
						  $friends = $REL->getFriends($uid);
						  $id = $row->userID;
						  echo "<div></div>";

						    // // (C2) BLOCK/UNBLOCK
						    // if (isset($friends['b'][$id])) {
						    //   echo "<button onclick=\"relate('unblock', $id)\">Unblock</button>";
						    // } else {
						    //   echo "<button onclick=\"relate('block', $id)\">Block</button>";
						    // }
						 
						    // (C3) FRIEND STATUS
						    // FRIENDS
						    if (isset($friends['f'][$id])) { 
						      echo "<button onclick=\"relate('unfriend', $id)\">Unfriend</button>";
						    }
						    // INCOMING FRIEND REQUEST
						    else if (isset($requests['in'][$id])) { 
						      echo "<button onclick=\"relate('accept', $id)\">Accept Friend</button>";
						    }
						    // OUTGOING FRIEND REQUEST
						    else if (isset($requests['out'][$id])) { 
						      echo "<button onclick=\"relate('cancel', $id)\">Cancel Add</button>";
						    }
						    //STRANGERS
						    else { 
						      echo "<button onclick=\"relate('add', $id)\">Add Friend</button>";
						    }
						    echo "</div>";
						  }
						?>
		        	</td>
		      </tr>

		    </table>
		<?php 
		  }
		    
		    
		    else{
		      echo "Name Does not exist";
		    }


		
		?>

		<!-- <input type="text" id="slugmanuts" placeholder="Find Friends you sado" style="width: 100%;">
		<input type="submit" name="submit"> -->

	<body>

</body>
</html>