<?php
require_once "globals.php";

/**
 * https://developer.spotify.com/documentation/web-api/reference/#/operations/search
 * @param string $searchTerm Your search query.
 * @param array $contentTypes An array of SPOTIFY_CONTENT_TYPEs to search across.
 * @return array Search response
 * @throws RequestError
 */
function doSearch(string $searchTerm, array $contentTypes): array {
	$json = callAPI("/search", array(
		"q" => $searchTerm,
		"type" => implode(",", $contentTypes),
		// "limit" => 20,
		// "offset" => 0,  // todo: implement pagination via the offset property
	), false);
	$response = json_decode($json);
	return $response;
}
