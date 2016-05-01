<?php
	require_once("config.php");
	require_once("inc/connection.inc.php");
	require_once("inc/functions.inc.php");


	if(isset($_REQUEST['code'])){
		$gClient->authenticate();
		$_SESSION['token'] = $gClient->getAccessToken();
		header('Location: ' . filter_var($redirectUrl, FILTER_SANITIZE_URL));
	}

	if (isset($_SESSION['token'])) {
		$gClient->setAccessToken($_SESSION['token']);
	}

	if ($gClient->getAccessToken()) {
		$userProfile = $google_oauthV2->userinfo->get();
		
		$gUser = checkUser('google',$userProfile['id'],$userProfile['given_name'],$userProfile['family_name'],$userProfile['email'],$userProfile['gender'],$userProfile['locale'],$userProfile['link'],$userProfile['picture']);
		$_SESSION['google_data'] = $userProfile;
		header("location: account.php");
		$_SESSION['token'] = $gClient->getAccessToken();
	} else {
		$authUrl = $gClient->createAuthUrl();
	}

	if(isset($authUrl)) {
		echo '<a href="'.$authUrl.'"><img src="images/glogin.png" alt=""/></a>';
	} else {
		echo '<a href="logout.php?logout">Logout</a>';
	}
?>