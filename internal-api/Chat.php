<?php

class Chat {
	/**
	 * @return array An associative array of recent chats, indexed by the userId of the other user.
	 */
	public static function ListChats(): array {
		// todo: use real data
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
}
