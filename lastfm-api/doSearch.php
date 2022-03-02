<?php
require_once(__DIR__ . "/lastfm-api.php");


/**
 * last.fm only tells us e.g. "small", and not the actual pixel size of an image.
 * This array maps the descriptor to the pixel size.
 */
$mapRelativeSizeToPixels = array(
	"small" => 34,
	"medium" => 64,
	"large" => 174,
	"extralarge" => 300
);


/**
 * https://www.last.fm/api/show/track.search
 * @param string $searchTerm Your search query.
 * @return array Search response (contains songs only, no album/artist results)
 * @throws RequestError
 */
function doSearch(string $searchTerm, string $imageSize="25vw"): array {
	global $mapRelativeSizeToPixels;

	$response = LastfmRequester::request("/", array(
		"method" => "track.search",
		"track" => $searchTerm
	), false);

	$hits = [];
	foreach ($response->results->trackmatches->track as $track) {
		$srcset = [];
		foreach ($track->image as $image) {
			$srcset[] = $image->{"#text"} . " " . $mapRelativeSizeToPixels[$image->size] . "w";
		}
		$hits[] = array(
			"name" => $track->name,
			"artist" => $track->artist,
			"image_tag" => '<img class="lastfm-image"
								srcset="'.implode(", ", $srcset).'"
								src="'.($track->image[0]->{"#text"} ?? "").'"
								sizes="'.$imageSize.'"
								width="300" height="300"
								alt="'.$track->name.' by '.$track->artist.'"
								>'
		);
	}
	return $hits;
}
