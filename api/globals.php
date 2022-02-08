<?php

const CLIENT_ID = "66220fc47eb94cf7ac431646dc4c43cb";
const CLIENT_SECRET = "8685a359e1a244cda6a1c1486b7b7abb";

if (!isset($_SESSION["auth_code"])) {
	// todo: use Client Credentials Flow to get an access token
	// https://developer.spotify.com/documentation/general/guides/authorization/client-credentials/
}

function callAPI($endpoint) {
	// todo: use curl to call api
}
