<?php
	require_once('connection.inc.php');
	
	function checkUser($connection, $oauth_provider,$oauth_uid,$fname,$lname,$email,$gender,$locale,$link,$picture){
		$tbl_name='users';
		$q1= "SELECT * FROM $tbl_name WHERE `oauth_provider`= '$oauth_provider' AND `oauth_uid`='$oauth_uid'";
						
		$q1_run = mysqli_query($connection,$q1);
		if(mysqli_num_rows($q1_run) > 0){
			$date=date("Y-m-d H:i:s");
			$update = "UPDATE $tbl_name SET `oauth_provider` = '$oauth_provider', `oauth_uid`='$oauth_uid', `fname` = '$fname', `lname` = '$lname', `email` = '$email', `gender` = '$gender', `locale` = '$locale', `picture` = '$picture', `gpluslink` = '$link', `modified` = '$date' WHERE `oauth_provider` = '$oauth_provider' AND `oauth_uid`='$oauth_uid'";
			mysqli_query($connection,$update);
		}else{
			$date=date("Y-m-d H:i:s");
			$insert = "INSERT INTO $tbl_name (`oauth_provider`,`oauth_uid`,`fname`,`lname`,`email`,`gender`,`locale`,`picture`,`gpluslink`,`created`,`modified`) VALUES ('$oauth_provider', '$oauth_uid', '$fname', '$lname', '$email', '$gender', '$locale', '$picture', '$link','$date','$date')";
			mysqli_query($connection,$insert);
		}
		$query = "SELECT * FROM $tbl_name WHERE `oauth_provider` = '$oauth_provider' AND `oauth_uid`= '$oauth_uid'";
		$query_run = mysqli_query($connection,$query);
		$result = mysqli_fetch_assoc($query_run);
		return $result;
	}

	function curl_file_get_contents($url)
	{
		 $curl = curl_init();
		 
		 curl_setopt($curl,CURLOPT_URL,$url);   
		 curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);    
		 curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5);  
		 curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);  //To follow any "Location: " header that the server sends as part of the HTTP header.
		 curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
		 curl_setopt($curl, CURLOPT_TIMEOUT, 10);   
		 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); 
		 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

		 $contents = curl_exec($curl);
		 curl_close($curl);
		 return $contents;
	}
?>