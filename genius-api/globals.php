<?php
include_once "../_polyfill.php";
require_once "../all-apis/Requester.php";

const CLIENT_ID = "93qLZ131ftv7HAbc4IVYCFRqTbH7HW8xnVwAqi0BoDBA-tRV-QCEbkBuD9BvLlf5";
const CLIENT_SECRET = "TUe3yVUyDqHbNUIWEd7z6V-yMeCD0CnPRV1t8x7MNdeCenBs35-dtnCBfVbxcynP3WD5ybb0zDxFPTnyby3Cww";
const CLIENT_ACCESS_TOKEN = "XHuE1__CmDhW__MnQdCES6_UdsPtH0ypuvyeylqQiQiuq_NTeEhiISpBdDFWw6cw";

class GeniusRequester extends BaseRequester {
	public static string $URL_PREFIX = "https://api.genius.com";

	protected static function apply_custom_curl_opts($curl) {
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			"Authorization: Bearer " . CLIENT_ACCESS_TOKEN
		));
	}
}
