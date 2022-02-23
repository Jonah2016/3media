<?php  
	// authenticating user type
	require_once("../resources/config.inc.php");
	require_once("../resources/auth.inc.php");
	// End authenticating user type
	$title = "ERROR 404";
	
	// Include header 
	require_once(LAYOUT_PATH . "/header.php");
    // Include Side Bar 
    require_once(LAYOUT_PATH . "/sideBar.php");
?>

	<div class="row pt-5">
		<div class="col-md-6 offset-md-3 mt-5" align="center">
			<div class="row mt-5">
				<p><img src="<?php echo ASSETS_PATH; ?>/images/404.png" alt=""></p>
			</div>
			<div class="row">
				<h3 class="text-center">Ouch!! You are not authorized to access this page!</h3>
			</div>
			<div class="row">
				<form class="form-inline" enctype="multipart/form-data" accept-charset="utf-8"> 
					<input type="text" class="form-control" id="form1Name" name="form1Name">
					<button class="btn btn-info">Search</button>
				</form>
			</div>
			<div class="row"  align="center">
				<h5 class="mt">Hey, maybe you will be interested in these pages:</h5>
				<p><a target="__blank" href="#">Frequently Asked Questions</a> | <a target="__blank" href="#">Contact us</a> </p>
			</div>
		</div>
	</div>

	<!-- js placed at the end of the document so the pages load faster -->
  



<?php require_once(LAYOUT_PATH . "/footer.php"); ?>
