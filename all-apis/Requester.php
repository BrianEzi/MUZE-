<?php


abstract class BaseRequester {
	#region Overwrite these when inheriting from the BaseRequester class
	/**
	 * We know all Web API URLs begin with $URL_PREFIX, so make URL prefix optional.
	 */
	protected static string $URL_PREFIX = "https://example.com/api";

	/**
	 * Function used to apply API-specific headers.
	 * @return void
	 */
	protected abstract static function pre_curl_request($curl, &$data);
	#endregion


	#region Other parameters
	/**
	 * Don't spend more than $API_TIMEOUT seconds on a request.
	 */
	private static int $API_TIMEOUT = 5;
	#endregion


	/**
	 * Use curl to request an api endpoint, and return the response.
	 * @param string $endpoint The URL of the API endpoint request.
	 * @param array $data A dictionary of data, for either get or post.
	 * @param bool $isPost The request is POST if true, GET if false.
	 * @return stdClass The response from the Spotify server.
	 * @throws RequestError
	 */
	public static function request(string $endpoint, array $data, bool $isPost): stdClass {
		if (!str_starts_with($endpoint, "https://")) {
			if (!str_starts_with($endpoint, "/")) {
				// make leading slash optional
				$endpoint = "/" . $endpoint;
			}

			// We know all Web API URLs begin with $URL_PREFIX, so make URL prefix optional
			$endpoint = static::$URL_PREFIX . $endpoint;
		}

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_TIMEOUT, static::$API_TIMEOUT);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		static::pre_curl_request($curl, $data);

		curl_setopt($curl, CURLOPT_POST, $isPost);
		$dataString = static::urlEncodeDict($data);
		if ($isPost) {
			curl_setopt($curl, CURLOPT_URL, $endpoint);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);   // POST request
		} else {
			curl_setopt($curl, CURLOPT_URL, $endpoint . "?" . $dataString);  // GET request
		}

		$response = curl_exec($curl);
		try {
			if (curl_errno($curl)) throw new RequestError(curl_error($curl));
		} finally {
			curl_close($curl);
		}

		return json_decode($response);
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
