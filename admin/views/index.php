<?php 
	// load up system core files (config and authentication)
	require_once("../resources/config.inc.php");
	require_once("../resources/auth.inc.php");
	// Set page title
	$title = 'Dashboard';
	$home_active = "active";
	// Include template files from resources (header and Navigations)
	require_once(LAYOUT_PATH . "/header.php");

   require_once(LAYOUT_PATH . "/sideBar.php");
   require_once(LAYOUT_PATH . "/topBar.php");

?>

	<div class="page-heading">
	    <div class="page-title">
	        <div class="row">
	            <div class="col-12 col-md-6 order-md-1 order-last">
	                <h3>Dashboard</h3>
	                <p class="text-subtitle text-muted">Refresh dashboard to see current updates</p>
	            </div> 
	        </div>
	    </div>
	</div>

    <section class="section">
       <!-- Dashboard contents goes here -->
       <div id="dashboard_container">
        
       </div>
    </section>
	


	<!-- Logout modaly is loaded here -->
	<div id="signOut">
		
	</div>


<script>
	var dash_url = "./App.js";
	$.getScript(dash_url);
</script>

<?php 
	// Include header
	require_once(LAYOUT_PATH . "/footer.php");  
?>