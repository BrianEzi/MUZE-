<?php

/**
* An enum of possible content types with the Spotify API.
* Source: https://developer.spotify.com/documentation/web-api/reference/#/operations/search.
*/
class SPOTIFY_CONTENT_TYPE {
	public const ALBUM = "album";
	public const ARTIST = "artist";
	public const PLAYLIST = "playlist";
	public const TRACK = "track";
	public const EPISODE = "episode";

	// "show" is removed as Spotify was returning non-empty arrays with blank contents
	// public const SHOW = "show";

	public static array $ALL = array(
		self::ALBUM, self::ARTIST, self::PLAYLIST,
		self::TRACK, self::EPISODE //, self::SHOW
	);
}
