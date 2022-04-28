<?php
    require 'google-api/vendor/autoload.php';
    // Creating new google client instance
    $client = new Google_Client();
    /** for disable ssl verify** */
    $guzzle = new GuzzleHttp\Client([
        'verify' => false
    ]);
    $client->setHttpClient($guzzle);
    /** for disable ssl verify** */
    
    // Enter your Client ID
    $client->setClientId('77034325127-mai3i5pssmtbudrobh0ucb12qdtcr8s2.apps.googleusercontent.com');
    // Enter your Client Secrect
    $client->setClientSecret('vMr8aT-qcnPn2tDZBqfxXPP1');
    // Enter the Redirect URL
    $client->setRedirectUri('http://timberexecute.com/login.php');
    // Adding those scopes which we want to get (email & profile Information)
    $client->addScope("email");
    $client->addScope("profile");    
?>