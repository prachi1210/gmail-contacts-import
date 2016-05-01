<?php
	session_start();
	require_once("src/Google_Client.php");
	require_once("src/contrib/Google_Oauth2Service.php");

	$clientId = '119277506516-v38e10q0f8t2dum8d12pfhplb3c5sl9f.apps.googleusercontent.com'; 
	$clientSecret = 'XVoByYX4BdUOXhEf4A6yS94v'; 
	$redirectUrl = 'http://localhost/login-with-google-using-php';  //return url (url to script)
	$homeUrl = 'http://localhost/login-with-google-using-php';  //return to home


	$gClient = new Google_Client();
	$gClient->setApplicationName('GMailOAuthLogin');
	$gClient->setClientId($clientId);
	$gClient->setClientSecret($clientSecret);
	$gClient->setRedirectUri($redirectUrl);

	$google_oauthV2 = new Google_Oauth2Service($gClient);
?>