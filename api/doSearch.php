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

	function __construct(stdClass $responseComponent) {
		$this->href = $responseComponent->href;
		$this->items = $responseComponent->items;
		$this->limit = $responseComponent->limit;
		$this->next = $responseComponent->next;
		$this->offset = $responseComponent->offset;
		$this->previous = $responseComponent->previous ?? "";
		$this->total = $responseComponent->total;
	}

	/**
	 * Returns an array detailing the available images of different sizes.
	 * @param stdClass $item This may be an album, artist, playlist, track, or episode.
	 * @return array of stdClass objects { "height": ___, "url": ___, "width": ___ }, sorted by size descending
	 */
	private static function extractAllImages(stdClass $item): array {
		return $item->images ?? $item->album->images;
	}

	/**
	 * Returns the URL of the biggest image Spotify provides.
	 * @param stdClass $item This may be an album, artist, playlist, track, or episode.
	 */
	public static function extractBiggestImageUrl(stdClass $item): string {
		$images = self::extractAllImages($item);
		return $images[0]->url ?? "";
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
	$response = Network::request("/search", array(
		"q" => $searchTerm,
		"type" => implode(",", $contentTypes),
		// "limit" => 20,
		// "offset" => 0,  // todo: implement pagination via the offset property
	), false, Network::$PARSE_FUNCTION_JSON);
	
	$searchComponents = array();
	foreach (SPOTIFY_CONTENT_TYPE::$ALL as $type_singular) {
		$type_plural = $type_singular . "s"; // response keys are plural
		
		if (!property_exists($response, $type_plural)) continue;

		$searchComponents[$type_singular] = new SearchComponent($response->{$type_plural});
	}
	return $searchComponents;
}
