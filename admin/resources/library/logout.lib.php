<?php

	session_start(); 

	include_once('../auth.inc.php');

	$new_user_online_status = 0;
	$new_last_seen_at = date("Y-m-d H:i:s");
	$stmt01 =  $db_connect->prepare("  
	UPDATE users SET user_online_status =:upuser_online_status, last_seen_at=:uplast_seen_at, updated_at=:upupdated_at WHERE user_code=:upuser_code ");
	$result01 = $stmt01->execute(
	    array(
	        ':upuser_code' => $neo_user_code,
	        ':upuser_online_status' => $new_user_online_status,
	        ':uplast_seen_at' => $new_last_seen_at,
	        ':upupdated_at' => date('Y-m-d H:i:s')
	    )
	);

	// Record activity history
	$action = $user_fname." ".$user_lname." logged out at ".date('d F Y H:i:s');
	$status = "signin";
	log_history($neo_user_code, $action, $status);
	
	session_unset();
	session_destroy();
	if(isset($_COOKIE['user_email']) && isset($_COOKIE['user_password'])){
		unset($_COOKIE['user_email']);
	    unset($_COOKIE['user_password']);
	    setcookie('user_email', null, -1, '/');
	    setcookie('user_password', null, -1, '/');
	}

	$successMSG = "You have logged out successfully";

	header("Location: ". ADMIN_BASE_PATH ."/?user=logout"); 

?>