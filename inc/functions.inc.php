<?php
	require_once('connection.inc.php');

	function checkUser($oauth_provider,$oauth_uid,$fname,$lname,$email,$gender,$locale,$link,$picture){
		$q1= "SELECT * FROM $tbl_name WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'";
						
		$q1_run = mysqli_query($connection,$q1);
		if(mysqli_num_rows($q1_run) == 1){
			$update = "UPDATE $tbl_name SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', fname = '".$fname."', lname = '".$lname."', email = '".$email."', gender = '".$gender."', locale = '".$locale."', picture = '".$picture."', gpluslink = '".$link."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'";
			mysqli_query($connection,$update);
		}else{
			$insert = "INSERT INTO $tbl_name SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', fname = '".$fname."', lname = '".$lname."', email = '".$email."', gender = '".$gender."', locale = '".$locale."', picture = '".$picture."', gpluslink = '".$link."', created = '".date("Y-m-d H:i:s")."', modified = '".date("Y-m-d H:i:s")."'";
			mysqli_query($connection,$insert);
		}
		$query = "SELECT * FROM $tbl_name WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'";
		$query_run = mysqli_query($connection,$query);
		$result = mysqli_fetch_assoc($query_run);
		return $result;
	}
?>