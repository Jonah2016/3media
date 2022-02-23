<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    if ($sett_data['sett_voting_opened'] == 0) {
        header("location:javascript://history.go(-1)");
        exit;
    }

    $page_title = "3Music Awards: Voting";
    $award_active = 'active';
    $award_vot_active = 'active';
    
    // Include header
    require_once(LAYOUTS_PATH . "/header.php"); 
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");
?>

<style>
    <?php include_once("./award.css");  ?>
</style>

<div class="page_content">

    <section id="award_nav">
        <div class="row">
            <div class="container bg-light p-3">
                <!-- Awards navbar -->
                <?php require_once(COMPONENT_PATH.'/AwardsNavbar.php') ?>
            </div>
        </div>
    </section>

    <section class="award_sub_cards_container">
        <div class="row no_paddding_x">
            <div class="container bg_black nom_title_container ">
                <div class="row page_header">
                    <div class="col-md-10 col-sm-12 body_heading"><h2>Nominees</h2></div>
                    <div class="col-sm-12 col-md-2 searchForm"> 

                    </div>
                </div>
            </div>
        </div>

        <div class="container bg_black">
            <div id="voting_data">
                <!-- voting data is loaded here -->
            </div>
        </div>
    </section>


    <div class="gototop js-top"> <a href="#" class="js-gotop"><i class="fa fa-arrow-up"></i></a></div>

</div>

<!-- Footer section -->
<?php require_once(LAYOUTS_PATH . "/main_footer.php"); ?>

<script>
    const voteUrl = "./Voting.js";
    $.getScript(voteUrl);
</script>

<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>