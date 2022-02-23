<?php 
	// load up system core files (config and authentication)
	require_once("../../resources/config.inc.php");
	require_once("../../resources/auth.inc.php");
	// Set page title
	$title = 'News Posts';
	$news_active = "active";
	// Include template files from resources (header and Navigations)
	require_once(LAYOUT_PATH . "/header.php");

    require_once(LAYOUT_PATH . "/sideBar.php");
    require_once(LAYOUT_PATH . "/topBar.php");

?>

	<div class="page-heading noselect">
	    <div class="page-title">
	        <div class="row">
	            <div class="col-12 col-md-6 order-md-1 order-first">
	                <h3>Manage News Posts</h3>
	                <p class="text-subtitle text-muted">Manage (add, edit, delete) news posts from the website on this page.</p>
	            </div>
	            <div class="col-12 col-md-6 order-md-2 order-last">
	            	<div class="float-start float-lg-end">  
	            		<?php if ($neo_news_add == 1): ?>
	            		<a class="btn btn-md btn-primary mr-1 mb-1" data-bs-toggle="modal" data-bs-target="#addNewsModal" href="#addNewsModal" id="modellink"><span class="bi bi-plus-square bi-center"> </span> Add New Post</a>
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
                		<div id="add_news_container">
                			<!-- resources/add_modals/add_news.php -->
                		</div>
                		<div id="edit_news_container">
                			<!-- resources/edit_modals/edit_news.php -->
                		</div>
                		<div id="news_data">
                			<!-- classes/news_cl/FetchNews.php -->
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
	var news_url = "./News.js";
	$.getScript(news_url);
</script>

<?php 
	// Include header
	require_once(LAYOUT_PATH . "/footer.php");  
?>