<?php 
	// load up system core files (config and authentication)
	require_once("./resources/config.inc.php");
	require_once( LIBRARY_PATH . "/login.lib.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Admin Dashboard - 3Music Network Limited">
	<meta name="author" content="Hashcom Ghana Limited">

	<title>Sign In | 3Music Dashboard</title>

	<!-- Bootstrap core -->
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
	<link href="<?php echo ASSETS_PATH; ?>/vendors/bootstrap/css/bootstrap.css" rel="stylesheet">

	<link href="<?php echo ASSETS_PATH; ?>/css/app.css" rel="stylesheet">
	<link href="<?php echo ASSETS_PATH; ?>/css/auth.css" rel="stylesheet">

	<!-- Custom icons & fonts -->
	<link href="<?php echo ASSETS_PATH; ?>/vendors/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<div id="auth">

	    <div class="row h-100">
	        <div class="col-lg-5 col-12">
	            <div id="auth-left">
	                <div class="auth-logo">
	                    <a href="<?php echo ADMIN_BASE_PATH; ?>"><img src="<?php echo ASSETS_PATH; ?>/img/logo/logo.jpg" alt="Logo"></a>
	                </div>
	                <h3 class="auth-title">Admin Log in.</h3>
	                <p class="auth-subtitle mb-3">Log in with your data that you entered during registration.</p>

	                <?php if(isset($errMSG)) { ?>
	                	<div class="alert alert-danger text-white bg-danger error_msg" align="center">
	                		<span class="text-lowercase"><i class="fas fa-exclamation-triangle"> </i> <strong><?php echo $errMSG; ?></strong></span>
	                		<?php echo '<meta http-equiv="refresh" content="60;" />'; ?>
	                	</div>
	                <?php }  else if(isset($successMSG)) { ?>
	                	<div class="alert alert-success text-white bg-success success_msg" align="center">
	                		<span class="text-lowercase"><i class="fas fa-check"> </i> <strong><?php echo $successMSG; ?></strong></span> 
	                	</div>
	                <?php } ?>

	                <form role="form" method="post" action="<?php echo ADMIN_BASE_PATH; ?>" autocomplete="off" enctype="multipart/form-data">
	                    <div class="form-group position-relative has-icon-left mb-4">
	                        <input type="text" name="user_code_email" class="form-control form-control-xl" placeholder="Enter your User-ID or Email" value="<?php if(isset($errMSG)){ echo htmlspecialchars($_POST['user_code_email'], ENT_QUOTES); } ?>" tabindex="1">
	                        <div class="form-control-icon"> <i class="bi bi-person"></i> </div>
	                    </div>
	                    <div class="form-group position-relative has-icon-left mb-4">
	                        <input type="password" name="password" class="form-control form-control-xl" placeholder="Password" autocomplete="off" tabindex="2">
	                        <div class="form-control-icon"> <i class="bi bi-shield-lock"></i> </div>
	                    </div>
	                    <div class="form-check form-check-lg d-flex align-items-end">
	                        <input class="form-check-input me-2" type="checkbox"  value="remember-me" id="flexCheckDefault" checked tabindex="3">
	                        <label class="form-check-label text-gray-600" for="flexCheckDefault"> Keep me logged in </label>
	                    </div>
	                    <button name="login" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign in</button>
	                </form>
	                <div class="text-center text-muted mt-5 text-lg fs-5"> 
	                    ©2021 All Rights Reserved. Property of 3Music Network Limited created with <i class="fa fa-heart text-danger"></i> by <a target="__blank" href="https://hashcomsoftware.com" tabindex="-1">Hashcom Ghana Limited</a> 
	                </div>
	            </div>
	        </div>
	        <div class="col-lg-7 d-none d-lg-block">
	            <div id="auth-right">

	            </div>
	        </div>
	    </div>

	</div>

 
</body>
</html>