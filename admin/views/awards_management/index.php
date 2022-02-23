<?php 
	// load up system core files (config and authentication)
	require_once("../../resources/config.inc.php");
	require_once("../../resources/auth.inc.php");
	// Set page title
	$title = '3Music Awards';
	$awards_active = "active";
	$about_awards_active = "active";
	// Include template files from resources (header and Navigations)
	require_once(LAYOUT_PATH . "/header.php");

    require_once(LAYOUT_PATH . "/sideBar.php");
    require_once(LAYOUT_PATH . "/topBar.php");

?>

	<div class="page-heading noselect">
	    <div class="page-title">
	        <div class="row">
	            <div class="col-12 col-md-5 order-md-1 order-first">
	                <h3>Manage 3Music Awards</h3>
	                <p class="text-subtitle text-muted">Manage (add, edit, delete) 3music awards</p>
	            </div>
	            <div class="col-12 col-md-7 order-md-2 order-last">
	            	<div class="float-start float-lg-end">  
	            		<?php if ($neo_eve_permission == 1): ?>
	            			<a class="btn btn-md btn-primary mr-1 mb-1" data-bs-toggle="modal" data-bs-target="#addAwardCategoryModal" href="#addAwardCategoryModal" id="modellink"><span class="bi bi-plus-square bi-center"> </span> Add Award Category</a>
	            			<a class="btn btn-md btn-primary mr-1 mb-1" href="<?php echo ADMIN_BASE_PATH.'views/awards_management/social_feed'; ?>" ><span class="bi bi-rss bi-center"> </span> Manage Social Feedback </a>
	            			<a class="btn btn-md btn-primary mr-1 mb-1" href="<?php echo ADMIN_BASE_PATH.'views/awards_management/performers'; ?>" ><span class="bi bi-person-bounding-box bi-center"> </span> Manage Performers</a>
	            			<a class="btn btn-md btn-primary mr-1 mb-1" href="<?php echo ADMIN_BASE_PATH.'views/awards_management/nominees'; ?>" ><span class="bi bi-check2-circle bi-center"> </span> Manage Nominees </a>
	            		<?php endif ?>
		                <a href="javascript:history.go(-1)" title="return to the previous page" class="btn btn-md btn-dark mb-1"><i class="bi bi-arrow-left-square bi-center "></i> <span class="d-none d-sm-inline-block">Back</span> </a>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<section class="section">
	
	    <div class="row">
	        <div class="col-md-12">
                <div class="card">
                	<div class="card-header bg-light">
                	    <h4>About The Award</h4>
                	</div>
                	<div class="card-body">
                		<div id="about_awards_form">
                			<!-- ./about_awards_form.php -->
                		</div>
                	</div>
                </div>
	        </div>
	    </div>

	    <div class="row mt-2">
	        <div class="col-md-12">
                <div class="card">
                	<div class="card-header bg-light">
                	    <h4>Award Categories</h4>
                	</div>
            		<div id="add_awards_category_container">
            			<!-- resources/add_modals/add_awards_category.php -->
            		</div>
            		<div id="edit_awards_category_container">
            			<!-- resources/edit_modals/edit_awards_category.php -->
            		</div>
                </div>
                <div id="awards_category_data">
                	<!-- classes/awards_cl/FetchAwardsCategory.php -->
                </div>
	        </div>
	    </div>

	</section>

	<!-- Logout modaly is loaded here -->
	<div id="signOut">
		
	</div>


<script>
	var awards_url = "./Awards.js";
	$.getScript(awards_url);
</script>

<?php 
	// Include header
	require_once(LAYOUT_PATH . "/footer.php");  
?>