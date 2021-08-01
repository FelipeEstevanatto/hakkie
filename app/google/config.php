<?php

session_start();

require_once('../php/composer/vendor/autoload.php');
require_once('google.php');

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.1 Client ID
$google_client->setClientId(GOOGLE['clientId']);
//Set the OAuth 2.1 Client Secret key
$google_client->setClientSecret(GOOGLE['clientSecret']);
//Set the OAuth 2.1 Redirect URI
$google_client->setRedirectUri(GOOGLE['redirectUri']);

$google_client->addScope('email');
$google_client->addScope('profile');
