<?php
	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];
	}
	else{
		$username='Jasveer';
	}
	$dbname = "2021_comp10120_m8";
	$dbhost = "dbhost.cs.man.ac.uk";
	$dbuser = "u68780be";
	$dbpass = "Ezinwoke3-2022";
class Chat {
	/**
	 * @return array An associative array of recent chats, indexed by the userId of the other user.
	 */
	

	public static function ListChats(): array {
		// todo: use real dat
		global $dbhost, $dbuser, $dbpass, $dbname, $username;
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT friendshipID, lastsender, lastmessage  FROM Friendship WHERE user1 ='" . $username. "' OR user2 ='". $username ."'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result)>0){
			$fullresults = array();
			while($row = mysqli_fetch_assoc($result)) {
				$data = array("userName" => $row['lastsender'], "lastMessage" => $row['lastmessage']);
				$fullresults+=array($row['friendshipID']=>$data);
			}
			return array($fullresults);
		} else{
			die("No messages found");
		}
		$conn->close();
	}

	/**
	 * @return array[] An array of message objects, indexed by their message id.
	 */
	public static function GetChatMessages(string $chatID): array {
		// todo: use real data
		global $dbhost, $dbuser, $dbpass, $dbname, $username;
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
;		$sql = "SELECT * FROM ChatMessages WHERE friendshipID =" . $chatID;
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result)>0){
			echo 'Got messages';
			$fullresults=array();
			while($row = mysqli_fetch_assoc($result)){
				// $data =
				array_push($fullresults, array("author"=>$row['sender'], "text"=>$row['messagetext']));
			}
			return array($fullresults);
		} else{
			die("No messages found");
		}
	}

	public static function SendMessage(string $selectedChat, string $newMessage) {
		// todo: add $newMessage to the database
		global $dbhost, $dbuser, $dbpass, $dbname, $username;
			$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		if($conn->connect_error){	
			die("Connection failed ". mysqli_connect_error());
		}
		$sql = "INSERT INTO ChatMessages (friendshipID, messagetext, sender, timesent) VALUES (".$selectedChat.",'" . stripslashes(htmlspecialchars($newMessage)) . "','" . $username ."',NOW())";

		if (mysqli_query($conn, $sql)) {
		  echo $newMessage;
		} else {
		  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

		$sql2 = "Update Friendship 
				Set lastmessage = '" . $newMessage . "', lastsender ='". $username . "' 
				Where friendshipID =" . $selectedChat . "";

		if (mysqli_query($conn, $sql2)) {
		  echo $newMessage;
		} else {
		  echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
		}
		$conn->close();
	}

}
// Chat::SendMessage('3','yo');
// Chat::GetChatMessages('3');
// Chat::ListChats()

?>