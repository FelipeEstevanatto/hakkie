<?php

require('../database/connect.php');
require_once('../php/composer/vendor/autoload.php');
require_once('../php/composer/vendor/google/auth/src/');


$google_client = new Google_Client(['client_id' => GOOGLE['clientId']]);

$google_client->setClientId('aaa');