<?php
	session_start();
 	require_once('inc/constants.inc.php');
 	require_once('inc/functions.inc.php');
	require_once 'google-api-php-client-1.1.7/src/Google/autoload.php';// or wherever autoload.php is located
	require_once("src/Google_Client.php");
	require_once("src/contrib/Google_Oauth2Service.php");
	require_once("inc/constants.inc.php");	

	$client = new Google_Client();
	$client -> setApplicationName('GMailOAuthLogin');
	$client -> setClientId($clientId);
	$client -> setClientSecret($clientSecret);
	$client -> setRedirectUri("http://localhost/login-with-google-using-php/importcontacts.php");
	$client -> setAccessType('online');

	$client -> setScopes('https://www.google.com/m8/feeds');

	$googleImportUrl = $client -> createAuthUrl();
	echo $googleImportUrl;
	if (isset($_GET['code'])) 
	{

		$auth_code = $_GET['code'];
		$_SESSION['google_code'] = $auth_code;
		header('Location: importcontacts.php');
	}

	echo $_SESSION['google_code'];
	if(isset($_SESSION['google_code'])) 
	{
		$auth_code = $_SESSION['google_code'];
		$max_results = 200;
	    $fields=array(
	        'code'=>  urlencode($auth_code),
	        'client_id'=>  urlencode($clientId),
	        'client_secret'=>  urlencode($clientSecret),
	        'redirect_uri'=>  urlencode($redirectUrl),
	        'grant_type'=>  urlencode('authorization_code'),
	    );

	    $post = '';
	    foreach($fields as $key=>$value)
	    {
	        $post .= $key.'='.$value.'&';
	    }
	    
	    $post = rtrim($post,'&');
	    $result = curl('https://accounts.google.com/o/oauth2/token',$post);
	    $response =  json_decode($result);
	    echo $response;
	    $accesstoken = $response->access_token;
	    $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results.'&alt=json&v=3.0&oauth_token='.$accesstoken;
	    $xmlresponse =  curl($url);
	    $contacts = json_decode($xmlresponse,true);
		
		echo $contacts;
		$return = array();
		if (!empty($contacts['feed']['entry'])) {
			foreach($contacts['feed']['entry'] as $contact) {
				$return[] = array (
					'name'=> $contact['title']['$t'],
					'email' => $contact['gd$email'][0]['address'],
				);
			}				
		}
		
		$_SESSION['contactos']=$google_contacts = $return;		
		unset($_SESSION['google_code']);
	}
	if(isset($_SESSION['contactos']))
	{
		print_r($_SESSION['contactos']);
	}
?>


