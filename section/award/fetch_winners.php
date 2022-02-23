<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    if(!empty($_POST["query"]) && !empty($_POST["query_type"]))
    {
        $query_type  = strip_tags(htmlspecialchars($_POST["query_type"], ENT_QUOTES));
        $query_param = strip_tags(htmlspecialchars($_POST["query"], ENT_QUOTES));
        $awc_year    =  ($query_type == "by_winner_year") ? $query_param : date('Y');

        // Retrieve all award categories data by year and AwardCategories class
        $award_categories_class = new AwardCategoryController([
            'awc_year' => $awc_year,
        ]);
        $award_categories = $award_categories_class->getAllAwardCategoriesByYear();
        if(count($award_categories) > 0) {
            foreach ($award_categories as $key => $awd_cat_data) {
                $awc_title = $awd_cat_data['awc_title']; 
?>
<div class="row mt-3 mx-auto">    
    <div class="col-12">
        <div class="category_row row bg-secondary p-3">
            <h3 class="py-2 px-0 fs-5"><?php echo $awc_title; ?></h3>
            <?php 
                // Retrieve all nominees data by cateory and ids from AwardNominees class
                $winner_class = new WinnerController([
                    'param'        => $query_param,
                    'awn_category' => $awc_title,
                    'query_type'   => $query_type
                ]);
                $winners = $winner_class->getAllWinnersByCatYear();
                if(count($winners) > 0) {
                    foreach ($winners as $key => $winner_data) {
                        $awn_year        = $winner_data['awn_year'];
                        $awn_type        = $winner_data['awn_type'];
                        $awn_category    = $winner_data['awn_category'];
                        $awn_fullname    = $winner_data['awn_fullname'];
                        $awn_biography   = htmlspecialchars_decode($winner_data['awn_biography']);
                        $awn_hashed      = $winner_data['awn_hashed'];
                        $awn_win_status  = $winner_data['awn_win_status'];
                        $awn_cover_image = $winner_data['awn_cover_image'];
                        $photo_directory = (!empty($awn_cover_image)) ? UPLOAD_PATH."awards/".$awn_cover_image : UPLOAD_PATH."templates/no_photo.png";
            ?>
            <div class="col-md-3 bg_light p-3 boder_all_dark">
                <div class="flip">
                    <div class="overlay"></div> 
                    <div class="flip_card_text_container" style="background-image: url(<?php echo $photo_directory; ?>)">
                        <?php if ($awn_win_status == 1): ?>
                            <span class="badge bg-success p-3 mt-1 mb-1 fs-4" title="Winner"><i class="bi bi-trophy bi-center"></i></span>
                        <?php endif ?>
                       <h1 class="flip_card_text mx-2"><?php echo $awn_fullname; ?></h1>
                       <span class="badge bg_black p-2 mt-1 mb-1 fs-6"><?php echo $awn_year; ?></span>
                    </div>
                    <div class="back">
                       <h2><?php echo $awn_fullname; ?></h2>
                       <?php if ($awn_win_status == 1): ?>
                           <p class="badge bg-success py-2 px-3 mt-1 mb-1 fs-6" title="Winner"><i class="bi bi-trophy bi-center"></i></p>
                       <?php endif ?>
                       <p class="badge bg_light py-2 px-3 mt-1 mb-1 fs-6 text-dark"><?php echo $awn_year; ?></p>
                       <p><?php echo $awn_biography; ?></p>
                    </div>
                </div>
            </div>
            <?php
                    }
                } else {
            ?>
            <div class="col-12 boder_all_grey">
                <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>No winner(s) to display now. Try other search parameters.</strong></span></div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php       
            }
        }
    }
    else {
?>
<div class="col-12 boder_all_grey">
    <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>No winner(s) to display now. Try other search parameters.</strong></span></div>
</div>
<?php } ?>