<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    $page_title = "3Music Awards: Nominees for this year's event.";
    $award_active = 'active';
    $award_nom_active = 'active';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php"); 
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");
?>

<style>
    <?php include_once("./award.css");  ?>
</style>

<div class="page_content">

    <section class="award_sub_hero_section">
        <div class="bg_black container award_sub_section_container no_paddding_x">
            <div class="page_heading"><h2>Nominees</h2></div>
            <img src="<?php echo ASSETS_PATH.'/img/nominees_bg.webp'; ?>" alt="nominees background" class="fluid_img">
        </div>
    </section>

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
                        <div class="form-group m-2">
                            <label for="multi_search_nominees_by_year" class="control-label">Search By Year</label> 
                            <select name="multi_search_nominees_by_year" data-live-search="true" class="selectpicker02 form-control" id="multi_search_nominees_by_year" data-placeholder="<?php echo date('Y') ?>" >
                                <option value=""> Select year</option>
                                <?php 
                                    $init_year = 2015;
                                    $end_year = 2050;

                                    for($year=$init_year; $year <= $end_year; $year++) {
                                ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="hid_search_by_nominees_year" value="<?php echo date('Y'); ?>" id="hid_search_by_nominees_year" />
                            <div style="clear:both"></div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <div class="container bg_black">
            <div class="row " id="nominees_data">
                <!-- nominees data is loaded here -->
            </div>
        </div>
    </section>


    <div class="gototop js-top"> <a href="#" class="js-gotop"><i class="fa fa-arrow-up"></i></a></div>

</div>

<!-- Footer section -->
<?php require_once(LAYOUTS_PATH . "/main_footer.php"); ?>


<script>
    function load_data(query = '', query_type = '') {
        $.ajax({
            url: "./fetch_nominees.php",
            method: "POST",
            cache: false,
            data: { query: query, query_type: query_type },
            success: function(data) {
                $("#nominees_data").html(data);
            }
        });
    }
    load_data($('#hid_search_by_nominees_year').val(),"by_nomination_year");
</script>
 
<script>
    const nomURl = "./Award.js";
    $.getScript(nomURl);
</script>

<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>