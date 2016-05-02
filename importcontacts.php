<?php
 	require_once('inc/constants.inc.php');
 	require_once('inc/functions.inc.php');
	$max_results = 25;

	$auth_code = $_SESSION['code'];


	$fields=array(
	    'code'=>  urlencode($auth_code),
	    'client_id'=>  urlencode($clientId),
	    'client_secret'=>  urlencode($clientSecret),
	    'redirect_uri'=>  urlencode($redirectUrl),
	    'grant_type'=>  urlencode('authorization_code')
	);

	$post = '';
	
	foreach($fields as $key=>$value) { $post .= $key.'='.$value.'&'; }
		$post = rtrim($post,'&');

	$result = curl_file_get_contents('https://accounts.google.com/o/oauth2/token', $post);
	
	$response =  json_decode($result);
	$accesstoken = $response->access_token;

	$url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results.'&oauth_token='.$accesstoken;
	$xmlresponse =  curl_file_get_contents($url);
	
	if((strlen(stristr($xmlresponse,'Authorization required'))>0) && (strlen(stristr($xmlresponse,'Error '))>0))
	{
	    echo "<h2>OOPS !! Something went wrong. Please try reloading the page.</h2>";
	    exit();
	}
	
	echo "<h3>Email Addresses:</h3>";
	$xml =  new SimpleXMLElement($xmlresponse);
	$xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
	$result = $xml->xpath('//gd:email');

	foreach ($result as $title) {
	  echo $title->attributes()->address . "<br>";
	}
?>
<a href="<?php echo $googleImportUrl; ?>"> Import google contacts </a>