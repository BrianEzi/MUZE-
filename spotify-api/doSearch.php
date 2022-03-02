<?php
require_once(__DIR__ . "/spotify-api.php");

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
	public string|null $next;

	/** The offset of the items returned (as set in the query or by default) */
	public int $offset;

	/** URL to the previous page of items. (null if none) */
	public string|null $previous;

	/** The total number of items available to return. */
	public int $total;

	function __construct(stdClass $responseComponent) {
		try {

			$this->href = $responseComponent->href;
			$this->items = $responseComponent->items;
			$this->limit = $responseComponent->limit;
			$this->next = $responseComponent->next;
			$this->offset = $responseComponent->offset;
			$this->previous = $responseComponent->previous ?? "";
			$this->total = $responseComponent->total;
		} catch (TypeError $e) {
			print_r($responseComponent);
			die;
		}
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
	 * Returns the URL of the biggest image Spotify provides. This should only be used
	 * when you can't use a responsive image (when you'd use the extractImageTag method).
	 * @param stdClass $item This may be an album, artist, playlist, track, or episode.
	 */
	public static function extractBiggestImageUrl(stdClass $item): string {
		$images = self::extractAllImages($item);
		return $images[0]->url ?? "";
	}

	/**
	 * Returns the image HTML tag with responsive image sources. This minimises
	 * bandwidth by reducing the size of images on lower-resolution screens.
	 * https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images
	 * @param stdClass $item This may be an album, artist, playlist, track, or episode.
	 * @param string $sizes Defines a set of media conditions and indicates what image size would be best to choose
	 */
	public static function extractImageTag(stdClass $item, string $sizes="25vw"): string {
		$images = self::extractAllImages($item);

		// collect an array of images and their sizes in the form of "elva-fairy-480w.jpg 480w"
		$srcset = [];
		foreach ($images as $image) {
			$srcset[] = "$image->url $image->width";
		}

		// default to the biggest image
		$defaultImageUrl = $images[0]->url ?? "";

		// alt text for if the image doesn't load / for screen readers / for search engines / etc
		$alt = $item->name;

		return '
		<img srcset="'.implode(", ", $srcset).'"
			sizes="'.$sizes.'"
			src="'.$defaultImageUrl.'"
			alt="'.$alt.'" >
		';
	}

	/**
	 * Returns an array of the artists' names.
	 * @param stdClass $item This may be an album, playlist, track, or episode, but not an artist.
	 */
	public static function getArtists(stdClass $item): array {
		// (the @ suppresses warnings if these properties don't exist)
		@$artistsObject = $item->artists ?? $item->album->artists;

		if (empty($artistsObject)) {
			// playlists have an owner property
			if (!empty($item->owner)) return [$item->owner->display_name];

			// otherwise, return an empty array if we've failed to find any artists
			return [];
		}

		// loop through artistsObject and extract the artist's name from each object
		return array_map(function($artist) {
			return $artist->name;
		}, $artistsObject);
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
	$response = SpotifyRequester::request("/search", array(
		"q" => $searchTerm,
		"type" => implode(",", $contentTypes),
		// "limit" => 20,
		// "offset" => 0,  // todo: implement pagination via the offset property
	), false);
	
	$searchComponents = array();
	foreach (SPOTIFY_CONTENT_TYPE::$ALL as $type_singular) {
		$type_plural = $type_singular . "s"; // response keys are plural
		
		if (!property_exists($response, $type_plural)) continue;

		$searchComponents[$type_singular] = new SearchComponent($response->{$type_plural});
	}
	return $searchComponents;
}
