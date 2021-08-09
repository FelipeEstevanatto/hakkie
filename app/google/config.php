<?php

use Google\Auth\OAuth2;

require_once('../../vendor/autoload.php');

if ( file_exists($_SERVER['DOCUMENT_ROOT'].'/hakkie/app/google/google.php')) {

    require_once('google.php');
  
} else {

    DEFINE("GOOGLE", [
        'clientId'        =>  getenv('GOOGLE_CLIENTID'),
        'clientSecret'    =>  getenv('GOOGLE_CLIENTSECRET'),
        'redirectUri'     =>  getenv('GOOGLE_REDIRECT')
    ]);

}

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
