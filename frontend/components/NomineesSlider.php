<?php
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );
?>
<link href="<?php echo ASSETS_PATH; ?>/vendors/swiper/swiper-bundle.min.css" rel="stylesheet">
<style>
    .nomineesSlider.swiper-container-horizontal>.swiper-pagination-bullets .swiper-pagination-bullet {
        margin: 0 4px;
        padding: 0.5rem;
    }
    .nomineesSlider{
        min-height: 25.5rem;
        max-height: 25.5rem;
    }
    .swiper-container-horizontal>.swiper-pagination-bullets, .swiper-pagination-custom, .swiper-pagination-fraction {
        bottom: 25px;
        left: 0;
        width: 100%;
    }
    .swiper-slide {
        margin-right: 10px;
    }
    .slider_img_container .img_container_md{
        height: 12rem !important;
    }
    .slider_title h3{
        font-style: italic;
    }

    @media screen and (max-width: 768px){
        .nomineesSlider{
            min-height: 100%;
            max-height: 100%;
        }
        .nomineesSlider.swiper-container-horizontal>.swiper-pagination-bullets .swiper-pagination-bullet {
            margin: 0 4px;
            padding: 0.5rem;
        }
        .swiper-container-horizontal>.swiper-pagination-bullets, .swiper-pagination-custom, .swiper-pagination-fraction {
            bottom: 0px;
            left: 0;
            width: 100%;
        }
        .swiper-slide {
            margin-left: 1rem;
            padding-right: 2rem;
            width: 100%;
        }
        .post_card_md .img_container_md{
            height: 15rem !important;
        }
    }
</style>


<div class="nomineesSlider swiper-container swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
    <div class="swiper-wrapper" id="swiper-wrapper-87bcfccc76e4510ac" aria-live="off" style="transform: translate3d(-2672px, 0px, 0px); transition-duration: 0ms;">
        <!-- News swiper item -->
        <?php
            $awc_year    =  date('Y');
            // Retrieve all award categories data by year and AwardCategories class
            $award_categories_class = new AwardCategoryController([
                'awc_year' => $awc_year,
            ]);
            $award_categories = $award_categories_class->getAllAwardCategoriesByYear();
            shuffle($award_categories);
            $sliced_award_categories = array_slice($award_categories, 0, 4, true);
            if(count($sliced_award_categories) > 0) {
                $counter = 0;
                foreach ($sliced_award_categories as $key => $awd_cat_data) {
                    $awc_title = $awd_cat_data['awc_title']; 
                    $awc_id    = $awd_cat_data['awc_id']; 
        ?>
        <div class="swiper-slide py-1 h-100" role="group" data-swiper-slide-index="<?php echo $counter++; ?>">
            <div class="slider_title pt-3 pb-1 px-3 fs-4 fw-bold"><h3><?php echo $awc_title; ?></h3></div>
            <div class="row px-2">
                <!-- 3 cards -->
                <?php
                    // Retrieve all nominees data by cateory and ids from AwardNominees class
                    $nomineee_class = new NomineeController([
                        'param'        => $awc_year,
                        'awn_category' => $awc_title,
                        'query_type'   => 'by_nomination_year'
                    ]);
                    $nominees = $nomineee_class->getAllNomineesByCatYear();
                    shuffle($nominees);
                    $sliced_nominees = array_slice($nominees, 0, 6, true);
                    if(count($sliced_nominees) > 0) {
                        foreach ($sliced_nominees as $key => $winner_data) {
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
                <div class="col-6 col-lg-2 col-md-2 col-sm-6 post_card_md">
                  <div class="post_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1 h-100">
                      <div class="card border_radius_sm h-100">
                          <div class="row">
                              <div class="col-12 slider_img_container">
                                  <div class="img_container_md noselect border_radius_top_sm">
                                      <img class="noselect d-block w-100 fluid_img border_radius_top_sm" src="<?php echo $photo_directory; ?>" alt="<?php echo $awn_fullname; ?>">
                                  </div>
                              </div>
                              <div class="col-12 ">
                                  <div class="card-block px-2 py-2">
                                      <p class="post_short_desc_md clamp_4 text-center"><a href="#"><?php echo $awn_fullname; ?></a></p>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
                <?php 
                        } 
                    } 
                ?>
            </div>
        </div>
        <?php 
                } 
            } 
        ?>
        <!-- End news swiper item -->
    </div>
    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
        <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 1"></span>
        <span class="swiper-pagination-bullet" tabindex="1" role="button" aria-label="Go to slide 2"></span>
        <span class="swiper-pagination-bullet" tabindex="2" role="button" aria-label="Go to slide 3"></span>
        <span class="swiper-pagination-bullet" tabindex="3" role="button" aria-label="Go to slide 4"></span>
    </div>
    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
</div>


<script src="<?php echo ASSETS_PATH; ?>/vendors/swiper/swiper-bundle.min.js"></script>

<script>
  (function() {
  "use strict";

  /**
   * Testimonials slider
   */
  new Swiper('.nomineesSlider', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    }
  });
})()
</script>