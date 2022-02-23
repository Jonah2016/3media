<?php 
	// load up system core files (config and authentication)
	require_once("../../resources/config.inc.php");
	require_once("../../resources/auth.inc.php");
	// Set page title
	$title = 'Users';
	$users_active = "active";
	// Include template files from resources (header and Navigations)
	require_once(LAYOUT_PATH . "/header.php");

    require_once(LAYOUT_PATH . "/sideBar.php");
    require_once(LAYOUT_PATH . "/topBar.php");

?>

	<div class="page-heading noselect">
	    <div class="page-title">
	        <div class="row">
	            <div class="col-12 col-md-6 order-md-1 order-first">
	                <h3>Manage Users</h3>
	                <p class="text-subtitle text-muted">Add, edit, activate or deactivate user accounts on this page.</p>
	            </div>
	            <div class="col-12 col-md-6 order-md-2 order-last">
	            	<div class="float-start float-lg-end">            	
		                <a class="btn btn-md btn-warning mr-1 mb-1" href="#" id="toggleView" onclick="toggleView()"><span class="bi bi-list bi-center"> </span> <span class="changeTxt">List View</span> </a>
		                <?php if ($neo_user_add == "1"): ?>
		                <a class="btn btn-md btn-primary mr-1 mb-1" data-bs-toggle="modal" data-bs-target="#addNewUserModal" href="#addNewUserModal" id="modellink"><span class="bi bi-person-plus bi-center"> </span> Add New User</a>
		                <?php endif ?>
		                <a href="javascript:history.go(-1)" title="return to the previous page" class="btn btn-md btn-dark mb-1"><i class="bi bi-arrow-left-square bi-center "></i> <span class="d-none d-sm-inline-block">Back</span> </a>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<section class="section">
		<?php if ($neo_user_permission == "1"): ?>
	    <div class="row">
	        <div class="col-md-12">
	        	<div class="add_modal_container">
	        		<!-- form-modals/add-modals/add_user -->
	        	</div>
	        	<div class="edit_modal_container">
	        		<!-- form-modals/edit-modals/edit_user -->
	        	</div>
				
                <div class="mt-4" id="user_data">
                	<!-- classes/users_cl/FetchUser.php -->
                </div>
	        </div>
	    </div>
	    <?php endif ?>
	</section>

	<!-- Logout modaly is loaded here -->
	<div id="signOut">
		
	</div>



<script>
	// Function to toggle data views
	function toggleView(){
	    var txt = $('.changeTxt').html()
	    if (txt == 'List View') {
	      	$('#toggleView').html('<span class="bi bi-grid bi-center"> </span> <span class="changeTxt">Tile View</span> ')
	        $("#user_data").load('../../classes/users_cl/FetchUsersTable.php')  
	    } 
	    else{
	        $('#toggleView').html('<span class="bi bi-list bi-center"> </span> <span class="changeTxt">List View</span> ')
	        $("#user_data").load('../../classes/users_cl/FetchUsers.php')
	    }
	}
</script>

<script>
	var user_url = "./Users.js";
	$.getScript(user_url);
</script>

<?php 
	// Include header
	require_once(LAYOUT_PATH . "/footer.php");  
?>