<?php
    require_once("inc/functions.inc.php");
    require_once("inc/constants.inc.php");
    

    if(isset($_SESSION['google_code'])) {
         $auth_code = $_SESSION['google_code'];
         $max_results = 200;
            $fields=array(
                'code'=>  urlencode($auth_code),
                'client_id'=>  urlencode($google_client_id),
                'client_secret'=>  urlencode($google_client_secret),
                'redirect_uri'=>  urlencode($google_redirect_uri),
                'grant_type'=>  urlencode('authorization_code'),
            );

            $post = '';
            foreach($fields as $key=>$value){
                $post .= $key.'='.$value.'&';
            }

            $post = rtrim($post,'&');
            $result = get_curl('https://accounts.google.com/o/oauth2/token',$post);
            $response =  json_decode($result);
            $accesstoken = $response->access_token;
            $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results.'&alt=json&v=3.0&oauth_token='.$accesstoken;
            $xmlresponse =  get_curl($url);
            $contacts = json_decode($xmlresponse,true);
         
         $return = array();
         if (!empty($contacts['feed']['entry'])){
            foreach($contacts['feed']['entry'] as $contact) {
                $return[] = array (
                    'name'=> $contact['title']['$t'],
                    'email' => $contact['gd$email'][0]['address'],
                );
            } 
         }
         
        $google_contacts = $return;
         
        unset($_SESSION['google_code']);
    }
?>