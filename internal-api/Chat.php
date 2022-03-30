<?php

class Chat {
	/**
	 * @return array An associative array of recent chats, indexed by the userId of the other user.
	 */
	public static function ListChats(): array {
		// todo: use real data
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
		return array(
			"1000" => array(
				"userName" => "John Doe",
				"lastMessage" => "Example message"
			),
			"1001" => array(
				"userName" => "Juan Pérez",
				"lastMessage" => "I don't like Italian olive oil as well as the French kind. It has too much flavour for me."
			),
			"1002" => array(
				"userName" => "Hans Meier",
				"lastMessage" => "Example message"
			),
			"1003" => array(
				"userName" => "Jan Modaal",
				"lastMessage" => "Example message"
			)
		);
	}

	/**
	 * @return array[] An array of message objects, indexed by their message id.
	 */
	public static function GetChatMessages(int $otherUserId): array {
		$userId = $_SESSION["userId"];
		// todo: use real data
		$dbname = "2021_comp10120_m8";
		$dbhost = "dbhost.cs.man.ac.uk";
		$dbuser = "u68780be";
		$dbpass = "Ezinwoke3-2022";
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
		return array(
			1000 => array(
				"author" => $otherUserId,
				"text" => "Yeah sure!"
			),
			1001 => array(
				"author" => $otherUserId,
				"text" => "Bye"
			),
			1002 => array(
				"author" => $otherUserId,
				"text" => "I don't like Italian olive oil as well as the French kind. It has too much flavour for me."
			),
			1003 => array(
				"author" => $userId,
				"text" => "Okay 👍"
			),
		);
	}

	public static function SendMessage(string $selectedChat, string $newMessage) {
		// todo: add $newMessage to the database
		echo "Something something send message:";
		echo $newMessage;
	}
}
