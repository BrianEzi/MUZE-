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
	public const SHOW = "show";
	public const EPISODE = "episode";

	public static array $ALL = array(
		self::ALBUM, self::ARTIST, self::PLAYLIST,
		self::TRACK, self::SHOW, self::EPISODE
	);
}
