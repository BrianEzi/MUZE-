<?php


class BaseRequester {
	#region Overwrite these when inheriting from the BaseRequester class
	/**
	 * We know all Web API URLs begin with $URL_PREFIX, so make URL prefix optional.
	 */
	protected static string $URL_PREFIX = "https://example.com/api";

	/**
	 * Function used to apply API-specific headers.
	 * @return void
	 */
	protected static function apply_custom_curl_opts($curl) {}
	#endregion


	#region Other parameters
	/**
	 * Don't spend more than $API_TIMEOUT seconds on a request.
	 */
	private static int $API_TIMEOUT = 5;
	#endregion


	#region Parsing functions
	/**
	 * Used as a parameter to specify that the API response should be parsed as JSON.
	 */
	public static Closure $PARSE_FUNCTION_JSON;
	#endregion


	/**
	 * A static constructor to do any initialisation
	 * @return void
	 */
	public static function __staticConstructor() {
		self::$PARSE_FUNCTION_JSON = function(string $json): stdClass {
			return json_decode($json);
		};
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

			// We know all Web API URLs begin with $URL_PREFIX, so make URL prefix optional
			$endpoint = self::$URL_PREFIX . $endpoint;
		}

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_TIMEOUT, API_TIMEOUT);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($curl, CURLOPT_POST, $isPost);
		$dataString = self::urlEncodeDict($data);
		if ($isPost) {
			curl_setopt($curl, CURLOPT_URL, $endpoint);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);   // POST request
		} else {
			curl_setopt($curl, CURLOPT_URL, $endpoint . "?" . $dataString);  // GET request
		}

		self::apply_custom_curl_opts($curl);

		$response = curl_exec($curl);
		try {
			if (curl_errno($curl)) throw new RequestError(curl_error($curl));
		} finally {
			curl_close($curl);
		}

		return $parseFunction == null ? $response : $parseFunction($response);
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
