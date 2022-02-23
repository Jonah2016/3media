<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
	include_once('directories.inc.php');

    // Retrieving user deatils from session legged in
    if ( isset($_SESSION['user_email']) || isset($_SESSION['user_code']) ){
		$sess_user_email      = $_SESSION['user_email'];
		$sess_user_code = $_SESSION['user_code'];

		// Include database connection file
		include_once("connect.inc.php");
		// Get user account details
		$stmt000 = $db_connect->prepare("SELECT * FROM users WHERE (user_email='$sess_user_email' OR user_code='$sess_user_code') ");
		$stmt000->execute();
		for($i=0; $row000 = $stmt000->fetch(); $i++)
		{
			$user_id             = $row000['user_id'];
			$neo_user_code  	 = $row000['user_code'];
			$user_email          = $row000['user_email'];
			$user_fname          = $row000['user_fname'];
			$user_lname          = $row000['user_lname'];
			$user_profile_pic    = $row000['user_profile_pic'];
			$user_active_status  = $row000['user_active_status'];
			$user_online_status  = $row000['user_online_status'];
			$account             = $row000['user_account'];
			$last_seen_at        = $row000['last_seen_at'];
			$user_created_at     = $row000['created_at'];
			$user_updated_at     = $row000['updated_at'];
			
			$user_full_name      = $row000['user_fname']." ".$row000['user_lname'];

			if ($row000['user_account_type'] == "super") { $account_type = "Super Admin"; }
			else if ($row000['user_account_type'] == "editorial") { $account_type = "General Editor"; }
			else if ($row000['user_account_type'] == "news") { $account_type = "News Editor"; }
			else if ($row000['user_account_type'] == "commercial") { $account_type = "Commercial Manager"; }
			else if ($row000['user_account_type'] == "accountant") { $account_type = "Accountant"; }
			else { $account_type = "Uknown Account"; }

			if (!empty($user_profile_pic)) {
				$user_photo_directory = UPLOADS_PATH."users/".$user_profile_pic;
			} else {
				$user_photo_directory = UPLOADS_PATH."templates/avatar.jpg";
			}

			// Include all global functions that will be accessible everywhere
			include_once("global_functions.inc.php");
			
	    }
	    // Get permissions
    	$stmt0001 = $db_connect->prepare("SELECT * FROM permissions WHERE perm_user_code='$neo_user_code' ");
    	$stmt0001->execute();
    	if($stmt0001->rowCount() > 0)
        {
	    	for($i=0; $row0001 = $stmt0001->fetch(); $i++)
	    	{
		    	if ($row0001['perm_page_permitted'] == "users_page") {
		    		$neo_user_permission = $row0001['perm_action_permitted'];
		    		$neo_user_add = $row0001['perm_add'];
		    		$neo_user_edit = $row0001['perm_edit'];
		    		$neo_user_read = $row0001['perm_read'];
					$neo_user_delete = $row0001['perm_delete'];
		    	}
				if ($row0001['perm_page_permitted'] == "settings_page") {
		    		$neo_set_permission = $row0001['perm_action_permitted'];
		    		$neo_set_add = $row0001['perm_add'];
		    		$neo_set_edit = $row0001['perm_edit'];
		    		$neo_set_read = $row0001['perm_read'];
					$neo_set_delete = $row0001['perm_delete'];
		    	}
		    	if ($row0001['perm_page_permitted'] == "news_page") {
		    		$neo_news_permission = $row0001['perm_action_permitted'];
		    		$neo_news_add = $row0001['perm_add'];
		    		$neo_news_edit = $row0001['perm_edit'];
		    		$neo_news_read = $row0001['perm_read'];
					$neo_news_delete = $row0001['perm_delete'];
		    	}
		    	if ($row0001['perm_page_permitted'] == "blog_page") {
		    		$neo_blog_permission = $row0001['perm_action_permitted'];
		    		$neo_blog_add = $row0001['perm_add'];
		    		$neo_blog_edit = $row0001['perm_edit'];
		    		$neo_blog_read = $row0001['perm_read'];
					$neo_blog_delete = $row0001['perm_delete'];
		    	}
		    	if ($row0001['perm_page_permitted'] == "event_page") {
		    		$neo_eve_permission = $row0001['perm_action_permitted'];
		    		$neo_eve_add = $row0001['perm_add'];
		    		$neo_eve_edit = $row0001['perm_edit'];
		    		$neo_eve_read = $row0001['perm_read'];
					$neo_eve_delete = $row0001['perm_delete'];
		    	}
    	    	if ($row0001['perm_page_permitted'] == "media_page") {
    	    		$neo_med_permission = $row0001['perm_action_permitted'];
    	    		$neo_med_add = $row0001['perm_add'];
    	    		$neo_med_edit = $row0001['perm_edit'];
    	    		$neo_med_read = $row0001['perm_read'];
    				$neo_med_delete = $row0001['perm_delete'];
    	    	}
    	    	if ($row0001['perm_page_permitted'] == "contacts_page") {
    	    		$neo_con_permission = $row0001['perm_action_permitted'];
    	    		$neo_con_add = $row0001['perm_add'];
    	    		$neo_con_edit = $row0001['perm_edit'];
    	    		$neo_con_read = $row0001['perm_read'];
    				$neo_con_delete = $row0001['perm_delete'];
    	    	}
    	    	if ($row0001['perm_page_permitted'] == "advert_page") {
    	    		$neo_adv_permission = $row0001['perm_action_permitted'];
    	    		$neo_adv_add = $row0001['perm_add'];
    	    		$neo_adv_edit = $row0001['perm_edit'];
    	    		$neo_adv_read = $row0001['perm_read'];
    				$neo_adv_delete = $row0001['perm_delete'];
    	    	}
	        }
	    } else {
	    	$neo_user_permission = 0;
	    	$neo_user_add = 0;
	    	$neo_user_edit = 0;
	    	$neo_user_read = 0;
			$neo_user_delete = 0;

			$neo_set_permission = 0;
	    	$neo_set_add = 0;
	    	$neo_set_edit = 0;
	    	$neo_set_read = 0;
			$neo_set_delete = 0;

			$neo_news_permission = 0;
			$neo_news_add = 0;
			$neo_news_edit = 0;
			$neo_news_read = 0;
			$neo_news_delete = 0;

			$neo_blog_permission = 0;
			$neo_blog_add = 0;
			$neo_blog_edit = 0;
			$neo_blog_read = 0;
			$neo_blog_delete = 0;

			$neo_eve_permission = 0;
			$neo_eve_add = 0;
			$neo_eve_edit = 0;
			$neo_eve_read = 0;
			$neo_eve_delete = 0;

			$neo_med_permission = 0;
			$neo_med_add = 0;
			$neo_med_edit = 0;
			$neo_med_read = 0;
			$neo_med_delete = 0;

			$neo_con_permission = 0;
			$neo_con_add = 0;
			$neo_con_edit = 0;
			$neo_con_read = 0;
			$neo_con_delete = 0;

			$neo_adv_permission = 0;
			$neo_adv_add = 0;
			$neo_adv_edit = 0;
			$neo_adv_read = 0;
			$neo_adv_delete = 0;
	    }
	}
	else {
		// Empty variable declared for user session details
		$user_email   = '';
		$neo_user_code = '';
		$sess_user_email      = "";
		$sess_user_code = "";
		$user_full_name     = "";
		$account = "";
		$account_type = "";
		$user_active_status = "";
		$user_online_status = "";
		$user_profile_pic = "";
		$last_seen_at = "";

		$neo_user_permission = 0;
		$neo_user_add = 0;
		$neo_user_edit = 0;
		$neo_user_read = 0;
		$neo_user_delete = 0;

		$neo_set_permission = 0;
		$neo_set_add = 0;
		$neo_set_edit = 0;
		$neo_set_read = 0;
		$neo_set_delete = 0;

		$neo_news_permission = 0;
		$neo_news_add = 0;
		$neo_news_edit = 0;
		$neo_news_read = 0;
		$neo_news_delete = 0;

		$neo_blog_permission = 0;
		$neo_blog_add = 0;
		$neo_blog_edit = 0;
		$neo_blog_read = 0;
		$neo_blog_delete = 0;

		$neo_eve_permission = 0;
		$neo_eve_add = 0;
		$neo_eve_edit = 0;
		$neo_eve_read = 0;
		$neo_eve_delete = 0;

		$neo_med_permission = 0;
		$neo_med_add = 0;
		$neo_med_edit = 0;
		$neo_med_read = 0;
		$neo_med_delete = 0;

		$neo_con_permission = 0;
		$neo_con_add = 0;
		$neo_con_edit = 0;
		$neo_con_read = 0;
		$neo_con_delete = 0;

		$neo_adv_permission = 0;
		$neo_adv_add = 0;
		$neo_adv_edit = 0;
		$neo_adv_read = 0;
		$neo_adv_delete = 0;
	}


	// If empty parameters the logout
	if(empty($sess_user_email) && empty($sess_user_code)){
		$errMSG = "You have unregistered credentials";
	    echo '<meta http-equiv="refresh" content="0;'.ADMIN_BASE_PATH.'?msg='.$errMSG.'" />';
	}
	else if(!$sess_user_email && !$sess_user_code){
		$errMSG = "You have unregistered credentials";
	    echo '<meta http-equiv="refresh" content="0;'.ADMIN_BASE_PATH.'?msg='.$errMSG.'" />';
	}
	


?>