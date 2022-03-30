<?php 
	// $_SESSION['username'] = 'Jasveer';

	$dbname = "2021_comp10120_m8";
	$dbhost = "dbhost.cs.man.ac.uk";
	$dbuser = "u68780be";
	$dbpass = "Ezinwoke3-2022";

	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];
	}else{
		die ("No username given");
	}

	function getChats($chatID){
		global $dbname, $dbhost, $dbuser, $dbpass ;
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
;		$sql = "SELECT * FROM ChatMessages WHERE friendshipID =" . $chatID;
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result)>0){
			return $result;
		} else{
			die("No messages found");
		}
		$conn->close();
	}


	function inputChats($chatID, $msg){
		global $dbname, $dbhost, $dbuser, $dbpass, $username ;
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		if($conn->connect_error){	
			die("Connection failed ". mysqli_connect_error());
		}
		$sql = "INSERT INTO ChatMessages (friendshipID, messagetext, sender, timesent) VALUES (".$chatID.",'" . stripslashes(htmlspecialchars($msg)) . "','" . $username ."',NOW())";
		if (mysqli_query($conn, $sql)) {
		  echo "New record created successfully";
		} else {
		  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
	}


	// inputChats('3','\h<ow> you doing?');
	// $result=getChats(3);
	// while($row = mysqli_fetch_assoc($result)) {
 //    	echo "id: " . $row["friendshipID"]. " , Sender: " . $row["sender"]. " ,Message: " . $row["messagetext"]. " ,Time sent: " . $row["timesent"].  "<br>";
	// }
?>