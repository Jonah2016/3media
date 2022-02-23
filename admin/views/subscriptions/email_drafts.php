<?php 
	// load up system core files (config and authentication)
	require_once("../../resources/config.inc.php");
	require_once("../../resources/auth.inc.php");
	// Set page title
	$title = 'Email Drafts';
	$drafts_active = "active";
	// Include template files from resources (header and Navigations)
	require_once(LAYOUT_PATH . "/header.php");

    require_once(LAYOUT_PATH . "/sideBar.php");
    require_once(LAYOUT_PATH . "/topBar.php");

?>

	<div class="page-heading noselect">
	    <div class="page-title">
	        <div class="row">
	            <div class="col-12 col-md-6 order-md-1 order-first">
	                <h3>Manage Email Drafts</h3>
	                <p class="text-subtitle text-muted">Manage (suspend/activate, email, delete drafts) all drafts from the website on this page.</p>
	            </div>
	            <div class="col-12 col-md-6 order-md-2 order-last">
	            	<div class="float-start float-lg-end"> 
	            		<?php if ($neo_con_add == 1): ?>
	            		<a class="btn btn-md btn-primary mr-1 mb-1" data-bs-toggle="modal" data-bs-target="#sendEmailModal" href="#sendEmailModal" id="modellink"><span class="bi bi-envelope bi-center"> </span> Send Bulk Email</a>
	            		<?php endif ?>
	            		<?php if ($neo_con_permission == 1): ?>
	            		<a class="btn btn-md btn-primary mr-1 mb-1" href="<?php echo ADMIN_BASE_PATH.'views/subscriptions/email_drafts'; ?>" ><span class="bi bi-person-badge bi-center"> </span> Subscribers </a>
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
                	<div class="card-body">
                		<div id="send_bulk_email_container">
                			<!-- resources/other_modals/send_bulk_email.php -->
                		</div>
                		<div id="email_draft_data">
                			<!-- classes/subscriptions_cl/FetchEmailDrafts.php -->
                		</div>
                	</div>
                </div>
	        </div>
	    </div>

	</section>

	<!-- Logout modaly is loaded here -->
	<div id="signOut">
		
	</div>


<script>
	var con_url = "./Subscriptions.js";
	$.getScript(con_url);
</script>

<?php 
	// Include header
	require_once(LAYOUT_PATH . "/footer.php");  
?>