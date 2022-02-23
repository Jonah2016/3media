<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' ); 

    $page_title = "3Music Awards: All winners according to year";
    $award_active = 'active';
    $award_win_active = 'active';

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
            <div class="page_heading"><h2>Winners</h2></div>
            <img src="<?php echo BASE_URL.'assets/img/winners_bg.webp'; ?>" alt="nominees background" class="fluid_img">
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
        <div class="row">
            <div class="container bg_black win_title_container no_paddding_x">
                <div class="row page_header">
                    <div class="col-md-4 col-sm-12 body_heading"><h2>Winners</h2></div>
                    <div class="col-sm-12 col-md-3 searchForm"> 
                        <div class="form-group m-2">
                            <label for="multi_search_winners_by_art" class="control-label">Search By Artiste</label> 
                            <?php   
                                // search artiste  
                                $in_sql01 = $db_connect->prepare("SELECT DISTINCT(awn_fullname) FROM award_nominees WHERE awn_active_status=1 AND awn_win_status=1 ORDER BY awn_fullname ASC "); 
                                $in_sql01->execute();
                            ?>
                            <select name="multi_search_winners_by_art" data-live-search="true" class="selectpicker02 form-control" id="multi_search_winners_by_art" data-placeholder="Select artiste" multiple>
                                <option value=""> Select artiste</option>
                                <?php
                                    $i=0;
                                    while($in_row01=$in_sql01->fetch(PDO::FETCH_ASSOC)) 
                                    {
                                        extract($in_row01); 
                                        $awn_fullname = strtoupper($in_row01['awn_fullname']);   
                                ?>
                                <option value="<?=$awn_fullname.'%';?>" ><?=$awn_fullname; ?></option>
                                <?php
                                        $i++;
                                    }
                                ?>
                            </select>
                            <input type="hidden" name="hid_search_by_winners_art" id="hid_search_by_winners_art" />
                            <div style="clear:both"></div>
                        </div> 
                    </div>
                    <div class="col-sm-12 col-md-3 searchForm"> 
                        <div class="form-group m-2">
                            <label for="multi_search_winners_by_cat" class="control-label">Search By Category</label> 
                            <?php   
                                // search category  
                                $in_sql02 = $db_connect->prepare("SELECT DISTINCT(awn_category) FROM award_nominees WHERE awn_active_status=1 ORDER BY awn_category ASC"); 
                                $in_sql02->execute();
                            ?>
                            <select name="multi_search_winners_by_cat" data-live-search="true" class="selectpicker02 form-control" id="multi_search_winners_by_cat" data-placeholder="Select category" multiple>
                                <option value=""> Select category</option>
                                <?php
                                    $i=0;
                                    while($in_row02=$in_sql02->fetch(PDO::FETCH_ASSOC)) 
                                    {
                                        extract($in_row02); 
                                        $awn_category = strtoupper($in_row02['awn_category']);   
                                ?>
                                <option value="<?=$awn_category;?>" ><?=$awn_category; ?></option>
                                <?php
                                        $i++;
                                    }
                                ?>
                            </select>
                            <input type="hidden" name="hid_search_by_winners_cat" id="hid_search_by_winners_cat" />
                            <div style="clear:both"></div>
                        </div> 
                    </div>
                    <div class="col-sm-12 col-md-2 searchForm"> 
                        <div class="form-group m-2">
                            <label for="multi_search_winners_by_year" class="control-label">Search By Year</label> 
                            <?php   
                                // search years  
                                $in_sql03 = $db_connect->prepare("SELECT awn_year FROM award_nominees WHERE awn_active_status=1 GROUP BY awn_year DESC"); 
                                $in_sql03->execute();
                            ?>
                            <select name="multi_search_winners_by_year" data-live-search="true" class="selectpicker02 form-control" id="multi_search_winners_by_year" data-placeholder="<?php echo date('Y') ?>">
                                <option value=""> Select year</option>
                                <?php
                                    $i=0;
                                    while($in_row03=$in_sql03->fetch(PDO::FETCH_ASSOC)) 
                                    {
                                        extract($in_row03); 
                                        $awn_year = $in_row03['awn_year'];   
                                ?>
                                <option value="<?=$awn_year;?>" ><?=$awn_year; ?></option>
                                <?php
                                        $i++;
                                    }
                                ?>
                            </select>
                            <input type="hidden" name="hid_search_by_winners_year" value="<?php echo date('Y'); ?>" id="hid_search_by_winners_year" />
                            <div style="clear:both"></div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <div class="container bg_black">
            <div class="row" id="winners_data">
                <!-- winners data is loaded here -->
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
            url: "./fetch_winners.php",
            method: "POST",
            cache: false,
            data: { query: query, query_type: query_type },
            success: function(data) {
                $("#winners_data").html(data);
            }
        });
    }
    load_data($('#hid_search_by_winners_year').val(),"by_winner_year");
</script>
 
<script>
    const awrdWinUrl = "./Award.js";
    $.getScript(awrdWinUrl);
</script>

<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>