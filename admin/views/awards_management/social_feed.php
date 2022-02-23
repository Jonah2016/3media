<?php 
    // load up system core files (config and authentication)
    require_once("../../resources/config.inc.php");
    require_once("../../resources/auth.inc.php");
    // Set page title
    $title = 'Social Media Feedback';
    $awards_active = "active";
    $social_feed_active = "active";
    // Include template files from resources (header and Navigations)
    require_once(LAYOUT_PATH . "/header.php");

    require_once(LAYOUT_PATH . "/sideBar.php");
    require_once(LAYOUT_PATH . "/topBar.php");

?>

    <div class="page-heading noselect">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-5 order-md-1 order-first">
                    <h3>Manage Social Media Feedback</h3>
                    <p class="text-subtitle text-muted">Manage (add, edit, delete) social media feedback</p>
                </div>
                <div class="col-12 col-md-7 order-md-2 order-last">
                    <div class="float-start float-lg-end">  
                        <?php if ($neo_eve_permission == 1): ?>
                        <a class="btn btn-md btn-primary mr-1 mb-1" data-bs-toggle="modal" data-bs-target="#addSocialFeedbackModal" href="#addSocialFeedbackModal" id="modellink"><span class="bi bi-plus-square bi-center"> </span> Add Social Feedback</a>
                        <a class="btn btn-md btn-primary mr-1 mb-1" href="<?php echo ADMIN_BASE_PATH.'views/awards_management/nominees'; ?>" ><span class="bi bi-check2-circle bi-center"> </span> Manage Nominees </a>
                        <a class="btn btn-md btn-primary mr-1 mb-1" href="<?php echo ADMIN_BASE_PATH.'views/awards_management/performers'; ?>" ><span class="bi bi-person-bounding-box bi-center"> </span> Manage Performers </a>
                        <a class="btn btn-md btn-primary mr-1 mb-1" href="<?php echo ADMIN_BASE_PATH.'views/awards_management/'; ?>" ><span class="bi bi-award bi-center"> </span> Manage Awards </a>
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
                        <div id="add_social_feed_container">
                            <!-- resources/add_modals/add_social_feed.php -->
                        </div>
                        <div id="edit_social_feed_container">
                            <!-- resources/edit_modals/edit_social_feed.php -->
                        </div>
                        <div id="social_feed_data">
                            <!-- classes/awards_cl/FetchSocialFeed.php -->
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
    var soc_url = "./SocialFeed.js";
    $.getScript(soc_url);
</script>

<?php 
    // Include header
    require_once(LAYOUT_PATH . "/footer.php");  
?>