<?php
include_once "_polyfill.php";

const CLIENT_ID = "66220fc47eb94cf7ac431646dc4c43cb";
const CLIENT_SECRET = "8685a359e1a244cda6a1c1486b7b7abb";

/**
 * Don't spend more than CURL_TIMEOUT seconds on a request.
 */
const API_TIMEOUT = 5;


if (!isset($_SESSION["auth_code"])) {
	// todo: use Client Credentials Flow to get an access token
	// https://developer.spotify.com/documentation/general/guides/authorization/client-credentials/
}

/**
 * Use curl to request an api endpoint
 * @param string $endpoint The URL of the API endpoint request.
 * @param array $data A dictionary of data, for either get or post.
 * @param bool $isPost The request is POST if true, GET if false.
 * @return string The string returned from the Spotify server.
 */
function callAPI(string $endpoint, array $data, bool $isPost): string {
	// This lets us just use e.g. "/token" instead of "https://accounts.spotify.com/api/token"
	if (!str_starts_with($endpoint, "https://"))
		$endpoint = "https://accounts.spotify.com/api" . $endpoint;

	$curl = curl_init();

	curl_setopt($curl, CURLOPT_TIMEOUT, API_TIMEOUT);

	curl_setopt($curl, CURLOPT_POST, $isPost);
	$dataString = urlEncodeDict($data);
	if ($isPost) {
		curl_setopt($curl, CURLOPT_URL, $endpoint);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);   // POST request
	} else {
		curl_setopt($curl, CURLOPT_URL, $endpoint . "?" . $dataString);  // GET request
	}

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);
	curl_close($curl);

	return $response;
}

/**
 * Encode a dictionary (associative array) into a URL string.
 * @param array $dict
 * @return string URL string: e.g. "username=admin&password=password1"
 */
function urlEncodeDict(array $dict): string {
	$urlStrings = [];
	foreach ($dict as $key => $value) {
		$urlStrings[] = urlencode($key) . "=" . urlencode($value);
	}
	return implode("&", $urlStrings);
}
