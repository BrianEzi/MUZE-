<?php
require_once "globals.php";

/**
 * Each SPOTIFY_CONTENT_TYPE in the search response has its own SearchComponent data structure.
 */
class SearchComponent {
	/** A link to the Web API endpoint returning the full result of the request */
	public string $href;

	/** The requested content */
	public array $items;

	/** The maximum number of items in the response (as set in the query or by default). */
	public int $limit;

	/** URL to the next page of items. */
	public string $next;

	/** The offset of the items returned (as set in the query or by default) */
	public int $offset;

	/** URL to the previous page of items. (null if none) */
	public string $previous;

	/** The total number of items available to return. */
	public int $total;

	function __construct(array $responseComponent) {
		$this->href = $responseComponent["href"];
		$this->items = $responseComponent["items"];
		$this->limit = $responseComponent["limit"];
		$this->next = $responseComponent["next"];
		$this->offset = $responseComponent["offset"];
		$this->previous = $responseComponent["previous"];
		$this->total = $responseComponent["total"];
	}
}

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
	$searchComponents = array();
	foreach (SPOTIFY_CONTENT_TYPE::$ALL as $type) {
		$searchComponents[$type] = new SearchComponent($response[$type]);
	}
	return $searchComponents;
}
