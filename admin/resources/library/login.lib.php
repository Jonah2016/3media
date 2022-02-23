<?php 

session_start();

//If user has already logged in, redirect to dashboard page.
if (isset($_SESSION['user_logged_in'])) 
{
    header('Location: views/');
}

// If user clicks login button
if (isset($_POST['login']))
{
	
	// Checking various authentifications
	if (!isset($_POST['user_code_email'])) $errMSG = "Please fill out all fields";
	if (!isset($_POST['password'])) $errMSG = "Please fill out all fields";

	$post_user_code_email = htmlspecialchars(strip_tags($_POST['user_code_email']), ENT_QUOTES);
	// verifying if what user entered was email if yes the verify
	$verified_email = filter_var($post_user_code_email, FILTER_VALIDATE_EMAIL);

	// If what user entered is an email and verified then set user-email value as email and set user-code to null
	if ($verified_email) {
		$user_email     = $verified_email;
		$user_code = "";
	}
	// else if what user entered is not email then set user-email value as empty and set user-code to post value
	else if ($verified_email == FALSE){
		$user_email     = "";
		$user_code = $post_user_code_email;
	}

	$password = strip_tags($_POST['password']);

	// Verification Procedures
	if(empty($post_user_code_email)  && empty($password)){
		$errMSG = "Please fill out all fields.";
	}
	else if(empty($post_user_code_email)){
		$errMSG = "Please enter your user code or email.";
	}
	else if(empty($password)){
		$errMSG = "Please enter your password.";
	}
	else if (!empty($user_email) && strlen($user_email) < 6) {
		$errMSG = "Please enter an email with more than 6 characters.";
	}
	else if (!empty($user_code) && strlen($user_code) < 4) {
		$errMSG = "Please enter a user code with more than 4 characters.";
	}
	else if (!empty($user_email) && strlen($user_email) > 60) {
		$errMSG = "Please enter a email with not more than 60 characters.";
	}
	else if (!empty($user_code) && strlen($user_code) > 24) {
		$errMSG = "Please enter a user code with not more than 24 characters.";
	}
	else if (strlen($password) < 8) {
		$errMSG = "Please enter a password less than 8 characters.";
	}
	else if (strlen($password) > 25) {
		$errMSG = "Please enter a password not more than 25 characters.";
	}
	if (!isset($errMSG)) 
	{ 
		try
		{
			// selecting user from users table
			$select_stmt=$db_connect->prepare("SELECT * FROM users WHERE user_email=:usemail OR user_code=:usproid");
			$select_stmt->execute(array(':usemail'=>$user_email, ':usproid'=>$user_code));
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);

			if($select_stmt->rowCount() > 0)
			{
				if ( $row['user_active_status'] == 1) {

					if($user_email == $row["user_email"] OR $user_code == $row["user_code"]) //check condition user table "user_email or user_code" are both match from database "user_email or user_code", after continue
					{
						//check condition user table "password" are match from database "password" using password_verify() after continue
						if(password_verify($password, $row["user_password"])) 
						{
							// Check activated status
							if ($row['user_active_status'] == 0) {
								$errMSG = "Sorry <b>".$row['user_fname']."</b>, your account is temporarily disabled.";
							}
							else if ($row['user_active_status'] == 1) {

								//Allow user to login.
								$_SESSION['user_logged_in']    = $row["user_id"];//session name is "user_logged_in"
								$_SESSION['user_id']           = $row['user_id'];
								$_SESSION['user_code']         = $row['user_code'];
								$_SESSION['user_account']      = $row['user_account'];
								$_SESSION['user_account_type'] = $row['user_account_type'];
								$_SESSION['user_email']        = $row['user_email'];
								$_SESSION['user_fname']        = $row['user_fname'];
								$_SESSION['user_lname']        = $row['user_lname'];		    
								$user_id                       = $_SESSION['user_id'];

							    $successMSG = "Welcome back ".$row['user_fname'].", redirecting...";  //user login success message
							    // Update online session
							    $new_online_status = 1;
							    $new_last_seen_at = date("Y-m-d H:i:s");
							    $stmt01 =  $db_connect->prepare("  
							    UPDATE users SET user_online_status =:upuser_online_status, last_seen_at=:uplast_seen_at, updated_at=:upupdated_at WHERE user_code=:upuser_code ");
							    $result01 = $stmt01->execute(
							        array(
							            ':upuser_code'     => $_SESSION['user_code'],
							            ':upuser_online_status' => $new_online_status,
							            ':uplast_seen_at' => $new_last_seen_at,
							            ':upupdated_at' => date('Y-m-d H:i:s')
							        )
							    );


							    // Record activity history
							    include("./resources/global_functions.inc.php");
							    $action = $row['user_fname']." ".$row['user_lname']." logged in at ".date('d F Y H:i:s');
							    $status = "signin";
							    log_history($row['user_code'], $action, $status);

							    //redirect after 2 second to "dashboard" page
							    header("refresh:2; views/");
						    }
						}
						else
						{
							$errMSG = "Please enter a valid password";
						}
					}
					else
					{
						$errMSG = "Please enter a valid user code or email.";
					}

				}else {
					$errMSG = "This account has been deactivated. Verify with the system administrator";
				}
			}
			else //user_code, email Or password might be changed. Unset cookie
			{

				unset($_COOKIE['user_email']);
				unset($_COOKIE['user_code']);
				unset($_COOKIE['user_password']);
				setcookie('user_email', null, -1, '/');
				setcookie('user_code', null, -1, '/');
				setcookie('user_password', null, -1, '/');
				setcookie('same-site-cookie', 'foo', ['samesite' => 'Lax']);
				setcookie('cross-site-cookie', 'bar', ['samesite' => 'None', 'secure' => true]);
				$errMSG = "Please enter a valid code or email";

			}
		}
		catch(PDOException $e)
		{
			echo 'ERRCON002: Login to this application failed, please contact technical support team. ';
			//. $e->getMessage()
		}  

	}
} 


?>