<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    $page_title = '3Music Awards: About the award.';
    $award_active = 'active';
    $award_abt_active = 'active';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php"); 
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    // Retrieve about details
    $award_cover_image = "";
    $award_photo_one   = "";
    $award_photo_two   = "";
    $award_photo_three = "";
    $stmt01 = $db_connect->prepare("SELECT award_cover_image, award_photo_one, award_photo_two, award_photo_three, award_description FROM about_award ");
    $stmt01->execute();
    if ($stmt01->rowCount() > 0) {
        while ($row01=$stmt01->fetch(PDO::FETCH_ASSOC)) {
            $award_cover_image = $row01['award_cover_image'];
            $award_photo_one   = $row01['award_photo_one'];
            $award_photo_two   = $row01['award_photo_two'];
            $award_photo_three = $row01['award_photo_three'];
            $award_description = $row01['award_description'];

            (!empty($award_cover_image)) ? $award_cover_image = UPLOAD_PATH."awards/".$award_cover_image : "";
            (!empty($award_photo_one)) ? $award_photo_one = UPLOAD_PATH."awards/".$award_photo_one : "";
            (!empty($award_photo_two)) ? $award_photo_two = UPLOAD_PATH."awards/".$award_photo_two : "";
            (!empty($award_photo_three)) ? $award_photo_three = UPLOAD_PATH."awards/".$award_photo_three : "";
        }
    }
?>

<style>
    <?php include_once("./award.css");  ?>
</style>

<div class="page_content">

    <section class="award_sub_hero_section">
        <div class="bg_black container award_sub_section_container no_paddding_x">
            <img src="<?php echo $award_cover_image; ?>" alt="" class="fluid_img">
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

    <section class="abt_award_body_section">
        <div class="container bg_light">
            <div class="row about_award_body noselect">
                <div class="col-md-4 mb-2 abt_image">
                    <img src="<?php echo $award_photo_one; ?>" alt="" class="fluid_img">
                </div>
                <div class="col-md-4 mb-2 abt_image">
                    <img src="<?php echo $award_photo_two; ?>" alt="" class="fluid_img">
                </div>
                <div class="col-md-4 mb-2 abt_image">
                    <img src="<?php echo $award_photo_three; ?>" alt="" class="fluid_img">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 about_award_body">
                    <div class="container bg-light p-4">
                        <?php if($award_description != ""): ?>
                        <p><?php echo $award_description; ?></p>
                        <?php else: ?>
                        <div class="col-12 boder_all_grey">
                            <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>Nothing to show under this section. Explore other sections.</strong></span></div>
                        </div>
                        <?php endif ?>
                    </div>
                    <!-- Award Categories -->
                    <div class="page_heading"><h2>Award Categories</h2></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                        <div class="row">
                            <?php  
                                $awc_year = date('Y');
                                // Retrieve all award categories data by year and AwardCategories class
                                $award_categories_class = new AwardCategoryController([
                                    'awc_year' => $awc_year,
                                ]);
                                $award_categories = $award_categories_class->getAllAwardCategoriesByYear();
                                $count = 0;
                                if(count($award_categories) > 0) {
                                    foreach ($award_categories as $key => $awd_cat_data) {
                                        $awc_title       = $awd_cat_data['awc_title']; 
                                        $awc_description = $awd_cat_data['awc_description']; 
                                        $counter = $count++;

                            ?>
                            <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                <div class="accordion" id="accordionPar<?php echo $counter; ?>">
                                    <div class="accordion-item" >
                                        <h2 class="accordion-header" id="heading<?php echo $counter; ?>">
                                            <button class="accordion-button p-4 h-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $counter; ?>" aria-expanded="true" aria-controls="collapse<?php echo $counter; ?>"><?php echo $awc_title; ?></button>
                                        </h2>
                                        <div id="collapse<?php echo $counter; ?>" class="accordion-collapse collapse " aria-labelledby="heading<?php echo $counter; ?>" data-bs-parent="#accordionPar<?php echo $counter; ?>">
                                            <div class="accordion-body overflow-hidden">
                                                <article style="overflow-x: hidden; overflow-y: scroll; max-height: 400px; min-height: 400px;"><?php echo $awc_description; ?></article>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php  }  } else { ?>
                            <div class="col-12 boder_all_grey">
                                <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>Nothing to show now, please try again later.</strong></span></div>
                            </div>
                            <?php  }  ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <div class="gototop js-top"> <a href="#" class="js-gotop"><i class="fa fa-arrow-up"></i></a></div>

</div>

<!-- Footer section -->
<?php require_once(LAYOUTS_PATH . "/main_footer.php"); ?>


<script>
    const abtAwrdUrl = "./Award.js";
    $.getScript(abtAwrdUrl);
</script>

<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>