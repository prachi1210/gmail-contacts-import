<?php
	session_start();
	require_once("src/Google_Client.php");
	require_once("src/contrib/Google_Oauth2Service.php");
	require_once("inc/constants.inc.php");	


	$gClient = new Google_Client();
	$gClient->setApplicationName('GMailOAuthLogin');
	$gClient->setClientId($clientId);
	$gClient->setClientSecret($clientSecret);
	$gClient->setRedirectUri($redirectUrl);

	$google_oauthV2 = new Google_Oauth2Service($gClient);
?>