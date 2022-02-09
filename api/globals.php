<?php
include_once "_polyfill.php";
include_once "_data_structures.php";

const CLIENT_ID = "66220fc47eb94cf7ac431646dc4c43cb";
const CLIENT_SECRET = "8685a359e1a244cda6a1c1486b7b7abb";

/**
 * Don't spend more than CURL_TIMEOUT seconds on a request.
 */
const API_TIMEOUT = 5;





class Network {
	public static Closure $PARSE_FUNCTION_JSON;

	/**
	 * A static constructor to initialise the Spotify API access token.
	 */
	public static function __staticConstructor() {
		self::$PARSE_FUNCTION_JSON = function(string $json): stdClass {
			return json_decode($json);
		};

		if (!isset($_SESSION["auth_code"])) {
			// Use Client Credentials Flow to get an access token
			// https://developer.spotify.com/documentation/general/guides/authorization/client-credentials/

			try {
				$response = self::request("https://accounts.spotify.com/api/token", array(
					"grant_type" => "client_credentials"
				), true, self::$PARSE_FUNCTION_JSON);
			} catch (RequestError $e) {
				// todo: display error page to user rather than raw text
				echo $e->getMessage();
				die;
			}
			$_SESSION["auth_code"] = $response->access_token;
		}
	}

	/**
	 * Use curl to request an api endpoint, and return the response.
	 * @param string $endpoint The URL of the API endpoint request.
	 * @param array $data A dictionary of data, for either get or post.
	 * @param bool $isPost The request is POST if true, GET if false.
	 * @param callable $parseFunction A function that's applied to the string response before returning it.
	 * @return mixed The response from the Spotify server.
	 * @throws RequestError
	 */
	public static function request(string $endpoint, array $data, bool $isPost, callable $parseFunction=null) {
		if (!str_starts_with($endpoint, "https://")) {
			if (!str_starts_with($endpoint, "/")) {
				// make leading slash optional
				$endpoint = "/" . $endpoint;
			}

			// We know all Web API URLs begin with "https://api.spotify.com/v1", so make URL prefix optional
			$endpoint = "https://api.spotify.com/v1" . $endpoint;
		}

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_TIMEOUT, API_TIMEOUT);

		curl_setopt($curl, CURLOPT_POST, $isPost);
		$dataString = self::urlEncodeDict($data);
		if ($isPost) {
			curl_setopt($curl, CURLOPT_URL, $endpoint);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);   // POST request
		} else {
			curl_setopt($curl, CURLOPT_URL, $endpoint . "?" . $dataString);  // GET request
		}

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			self::getAuthorizationHeader()
		));

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($curl);
		try {
			if (curl_errno($curl)) throw new RequestError(curl_error($curl));
		} finally {
			curl_close($curl);
		}

		return $parseFunction == null ? $response : $parseFunction($response);
	}

	/**
	 * Valid access token following the format: Bearer <Access Token> if we have an access token.
	 * Otherwise, use Basic validation (to request an access token).
	 * @return string Header string beginning with "Authorization: "
	 */
	private static function getAuthorizationHeader(): string {
		if (isset($_SESSION["auth_code"])) {
			return "Authorization: Bearer " . $_SESSION["auth_code"];
		} else {
			return "Authorization: Basic " . base64_encode(CLIENT_ID . ':' . CLIENT_SECRET);
		}
	}

	/**
	 * Encode a dictionary (associative array) into a URL string.
	 * @param array $dict
	 * @return string URL string: e.g. "username=admin&password=password1"
	 */
	private static function urlEncodeDict(array $dict): string {
		$urlStrings = [];
		foreach ($dict as $key => $value) {
			$urlStrings[] = urlencode($key) . "=" . urlencode($value);
		}
		return implode("&", $urlStrings);
	}
}

class RequestError extends Exception { }

Network::__staticConstructor();
