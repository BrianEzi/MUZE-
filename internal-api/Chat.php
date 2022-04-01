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
		global $dbhost, $dbuser, $dbpass, $dbname, $username;
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT friendshipID, lastmessage, user1, user2 FROM Friendship WHERE user1 ='" . $username. "' OR user2 ='". $username ."'";
		if ($result = mysqli_query($conn, $sql)){
			$fullresults = array();
			while($row = mysqli_fetch_assoc($result)) {
				$fullresults[$row['friendshipID']] = array(
					"userName" => ($row['user1'] == $username) ? $row['user2'] : $row['user1'],
					"lastMessage" => $row['lastmessage']
				);
			}
			return $fullresults;
		} else{
			return [];
		}
		$conn->close();
	}

	/**
	 * @return array[] An array of message objects, indexed by their message id.
	 */
	public static function GetChatMessages(string $chatID): array {
		global $dbhost, $dbuser, $dbpass, $dbname, $username;
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT * FROM ChatMessages WHERE friendshipID =" . $chatID;
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result)>0){
			$fullresults=[];
			while($row = mysqli_fetch_assoc($result)){
				$fullresults[] = array(
					"author"=>$row['sender'],
					"text"=>$row['messagetext']
				);
			}
			return $fullresults;
		} else{
			return [];
		}
	}

	public static function SendMessage(string $selectedChat, string $newMessage) {
		global $dbhost, $dbuser, $dbpass, $dbname, $username;
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		if($conn->connect_error){	
			die("Connection failed ". mysqli_connect_error());
		}
		$sql = "INSERT INTO ChatMessages (friendshipID, messagetext, sender, timesent) VALUES (".$selectedChat.",'" . stripslashes(htmlspecialchars($newMessage)) . "','" . $username ."',NOW())";

		mysqli_query($conn, $sql);

		$sql2 = "Update Friendship 
				Set lastmessage = '" . $newMessage . "', lastsender ='". $username . "' 
				Where friendshipID =" . $selectedChat . "";

		mysqli_query($conn, $sql2);

		$conn->close();
	}

}
// Chat::SendMessage('3','yo');
// Chat::GetChatMessages('3');
// Chat::ListChats()

?>