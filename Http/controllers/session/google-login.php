<?php

use Core\Authenticator;

use Google\Auth\OAuth2;
use Google\Client;

//Make object of Google API Client for call Google API
$client = new Google_Client();

// Set the OAuth 2.0 Client ID, Client Secret, and Redirect URI
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);

$google_oauthV2 = new Google_Oauth2Service($client);

// Add the required scopes to the client object
$client->addScope('https://www.googleapis.com/auth/userinfo.profile');
$client->addScope('https://www.googleapis.com/auth/userinfo.email');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Use the access token to create a Google API client object
    $people_service = new PeopleService($client);

    // Retrieve the user's profile information
    $person = $people_service->people->get('people/me', ['personFields' => 'names,emailAddresses']);
    $name = $person->getNames()[0]->getDisplayName();
    $email = $person->getEmailAddresses()[0]->getValue();

    dd($people_service->people);

    // Do something with the user's profile information
    // ...
}

