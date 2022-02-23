<?php 
	// load up system core files (config and authentication)
	require_once("../../resources/config.inc.php");
	require_once("../../resources/auth.inc.php");

	// Set page title
	$title = 'Manage Events';
	$events_mgt_active = "active";
	$event_active = "active";

	// Include template files from resources (header and Navigations)
	require_once(LAYOUT_PATH . "/header.php");
    require_once(LAYOUT_PATH . "/sideBar.php");
    require_once(LAYOUT_PATH . "/topBar.php");

?>

	<div class="page-heading noselect">
	    <div class="page-title">
	        <div class="row">
	            <div class="col-12 col-md-6 order-md-1 order-first">
	                <h3>Manage Events</h3>
	                <p class="text-subtitle text-muted">Manage (add, edit, delete) events on this page.</p>
	            </div>
	            <div class="col-12 col-md-6 order-md-2 order-last">
	            	<div class="float-start float-lg-end">  
	            		<?php if ($neo_eve_add == 1): ?>
	            		<a class="btn btn-md btn-primary mr-1 mb-1" data-bs-toggle="modal" data-bs-target="#addEventModal" href="#addEventModal" id="modellink"><span class="bi bi-plus-square bi-center"> </span> Add New Event</a>
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
                		<div id="add_events_container">
                			<!-- resources/add_modals/add_event.php -->
                		</div>
                		<div id="edit_events_container">
                			<!-- resources/edit_modals/edit_event.php -->
                		</div>
                		<div id="events_data">
                			<!-- classes/events_cl/FetchEvents.php -->
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
	var event_url = "./Events.js";
	$.getScript(event_url);
</script>

<?php 
	// Include header
	require_once(LAYOUT_PATH . "/footer.php");  
?>