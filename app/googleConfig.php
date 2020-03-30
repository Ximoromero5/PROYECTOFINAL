<?php
require_once 'google-api-php-client/vendor/autoload.php';

$googleClient = new Google_Client();

$googleClient->setClientId(Config::$googleClientID);
$googleClient->setClientSecret(Config::$googleClientSecretKey);
$googleClient->setRedirectUri(Config::$googleRedirect);
$googleClient->addScope("email");
$googleClient->addScope("profile");
