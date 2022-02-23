<?php 
	// load up system core files (config and authentication)
	require_once("../../resources/config.inc.php");
	require_once("../../resources/auth.inc.php");
	// Set page title
	$title = 'Settings';
	$settings_active = "active";
	$general_active = "active";
	// Include template files from resources (header and Navigations)
	require_once(LAYOUT_PATH . "/header.php");

    require_once(LAYOUT_PATH . "/sideBar.php");
    require_once(LAYOUT_PATH . "/topBar.php");

?>

	<div class="page-heading noselect">
	    <div class="page-title">
	        <div class="row">
	            <div class="col-12 col-md-6 order-md-1 order-first">
	                <h3>General Settings</h3>
	                <p class="text-subtitle text-muted">Set default site parameters on this page.</p>
	            </div>
	            <div class="col-12 col-md-6 order-md-2 order-last">
	            	<div class="float-start float-lg-end">            	
		                <?php if ($neo_set_permission == "1"): ?>
		                <a class="btn btn-md btn-primary mr-1 mb-1" href="<?php echo ADMIN_BASE_PATH.'views/user_management/users'; ?>" ><span class="bi bi-people bi-center"> </span> Manage Users</a>
		                <?php endif ?>
		                <a href="javascript:history.go(-1)" title="return to the previous page" class="btn btn-md btn-dark mb-1"><i class="bi bi-arrow-left-square bi-center"></i> <span class="d-none d-sm-inline-block">Back</span> </a>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<section class="section">
		<?php if ($neo_set_permission == "1"): ?>
	    <div class="row">
	        <div class="col-md-12">
	        	<div class="settings_container">
					<!-- Load settings form here -->
	        	</div>
	        </div>
	    </div>
	    <?php endif ?>
	</section>

	<!-- Logout modaly is loaded here -->
	<div id="signOut">
		
	</div>




<script>
	var gen_url = "./Settings.js";
	$.getScript(gen_url);
</script>

<?php 
	// Include header
	require_once(LAYOUT_PATH . "/footer.php");  
?>