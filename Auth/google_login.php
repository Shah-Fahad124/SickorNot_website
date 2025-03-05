<?php

//start session on web page
session_start();


//Include Google Client Library for PHP autoload file
require_once '../libraray/vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('699186405953-uao013i5lk59bbu520bi8jrkkro2kvug.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('secret=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');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/SickorNot/index.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

?> 