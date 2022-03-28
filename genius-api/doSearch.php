<?php
require_once(__DIR__ . "/genius-api.php");
require_once(__DIR__ . "/../all-apis/Set.php");


/**
 * https://docs.genius.com/#search-h2
 * @param string $searchTerm Your search query.
 * @return array Search response (contains songs only, no album/artist results)
 * @throws RequestError
 */
function doSearch(string $searchTerm, string $imageSize="25vw"): array {
	$response = GeniusRequester::request("/search", array(
		"q" => $searchTerm,
	), false);

	$songs = [];
	$artists = new Set();
	foreach ($response->response->hits as $hit) {
		$result = $hit->result;
		$srcset = [
			$result->song_art_image_thumbnail_url . " 300w",
			$result->song_art_image_url . " 1000w",
		];
		$songs[] = array(
			"id" => $result->id,
			"type" => GENIUS_CONTENT_TYPE::SONG,
			"title" => $result->title,
			"artist" => $result->primary_artist->name,
			"image_tag" => '<img class="genius-song-art"
								srcset="'.implode(", ", $srcset).'"
								src="'.$result->song_art_image_thumbnail_url.'"
								sizes="'.$imageSize.'"
								width="300" height="300"
								alt="'.$result->full_title.'"
								>'
		);
		$artists->add(array(
			"id" => $result->primary_artist->id,
			"type" => GENIUS_CONTENT_TYPE::ARTIST,
			"title" => $result->primary_artist->name,
			"artist" => "Artist",
			"image_tag" => '<img class="genius-song-art"
								src="'.$result->primary_artist->image_url.'"
								sizes="'.$imageSize.'"
								width="300" height="300"
								alt="'.$result->primary_artist->name.'"
								>'
		));
	}
	return array_merge($songs, $artists->toArray());
}
