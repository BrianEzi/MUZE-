<?php
include_once "_polyfill.php";

const CLIENT_ID = "66220fc47eb94cf7ac431646dc4c43cb";
const CLIENT_SECRET = "8685a359e1a244cda6a1c1486b7b7abb";

/**
 * Don't spend more than CURL_TIMEOUT seconds on a request.
 */
const API_TIMEOUT = 5;


if (!isset($_SESSION["auth_code"])) {
	// Use Client Credentials Flow to get an access token
	// https://developer.spotify.com/documentation/general/guides/authorization/client-credentials/

	try {
		$json = callAPI("/token", array(
			"grant_type" => "client_credentials"
		), true);
	} catch (RequestError $e) {
		// todo: display error page to user rather than raw text
		echo $e->getMessage();
		die;
	}
	$response = json_decode($json);
	$_SESSION["auth_code"] = $response["access_token"];
}

/**
 * Use curl to request an api endpoint
 * @param string $endpoint The URL of the API endpoint request.
 * @param array $data A dictionary of data, for either get or post.
 * @param bool $isPost The request is POST if true, GET if false.
 * @return string The string returned from the Spotify server.
 * @throws RequestError
 */
function callAPI(string $endpoint, array $data, bool $isPost): string {
	if (!str_starts_with($endpoint, "https://")) {
		// This lets us just use e.g. "/token" instead of "https://accounts.spotify.com/api/token"
		$endpoint = "https://accounts.spotify.com/api" . $endpoint;
	}

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

	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		getAuthorizationHeader()
	));

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($curl);
	try {
		if (curl_errno($curl)) throw new RequestError(curl_error($curl));
	} finally {
		curl_close($curl);
	}

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

/**
 * Valid access token following the format: Bearer <Access Token> if we have an access token.
 * Otherwise, use Basic validation (to request an access token).
 * @return string Header string beginning with "Authorization: "
 */
function getAuthorizationHeader(): string {
	if (isset($_SESSION["auth_code"])) {
		return "Authorization: Bearer " . $_SESSION["auth_code"];
	} else {
		return "Authorization: Basic " . base64_encode(CLIENT_ID . ':' . CLIENT_SECRET);
	}
}

class RequestError extends Exception { }
