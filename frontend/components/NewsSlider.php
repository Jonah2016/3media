<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );
?>
<link href="<?php echo ASSETS_PATH; ?>/vendors/swiper/swiper-bundle.min.css" rel="stylesheet">
<style>
    .newsSlider.swiper-container-horizontal>.swiper-pagination-bullets .swiper-pagination-bullet {
        margin: 0 4px;
        padding: 0.5rem;
    }
    .newsSlider{
        height: 31.5rem;
    }

    @media screen and (max-width: 768px){
        .newsSlider {
            height: 49.5rem;
        }
        .newsSlider.swiper-container-horizontal>.swiper-pagination-bullets .swiper-pagination-bullet {
            margin: 0 4px;
            padding: 0.5rem;
        }
    }
</style>


<div class="newsSlider swiper-container swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
    <div class="swiper-wrapper" id="swiper-wrapper-87bcfccc76e4510ac" aria-live="off" style="transform: translate3d(-2672px, 0px, 0px); transition-duration: 0ms;">
        <!-- News swiper item -->
        <?php
            $news_categories = $DIST_NEWS_CATEGORIES_DATA;
            shuffle($news_categories);
            if(count($news_categories) > 0) {
                $q00_counter = 0;
                $sliced_cat_array = array_slice($news_categories, 0, 5, true);
                foreach ($sliced_cat_array as $key => $category) {
                    $ind_category = $category;

        ?>
        <div class="swiper-slide" role="group"  style="margin-right: 10px;" data-swiper-slide-index="<?php echo $q00_counter++; ?>">
            <div class="row">
                <!-- 3 cards -->
                <?php
                    // Retrieve all news data by cateory and ids from News class
                    $news_class = new NewsController([
                        'news_category'         => $ind_category,
                        'already_displayed_ids' => null
                    ]);
                    $news_posts01 = $news_class->getAllNewsByCategory();
                    if(count($news_posts01) > 0) {
                        shuffle($news_posts01);
                        $sliced_news_post1 = array_slice($news_posts01, 0, 3, true);
                        foreach ($sliced_news_post1 as $key => $news_data01) {
                            $q01_id           = $news_data01['news_id'];
                            $q01_hashed       = $news_data01['news_hashed'];
                            $q01_category     = (!empty($news_data01['news_category'])) ? explode(",", $news_data01['news_category']) : [];
                            $q01_category_str = $q01_category[0];
                            $q01_title        = $news_data01['news_title'];
                            $q01_author       = $news_data01['news_author'];
                            $q01_date         = $news_data01['formated_date'];
                            $q01_cover_image  = $news_data01['news_cover_image'];
                            $q01_briefing     = $news_data01['news_briefing'];

                            $news_page_url01   = SECTION_PATH."news/article?nid=".$q01_hashed;
                            $new_cover_image01 = (!empty($q01_cover_image)) ? UPLOAD_PATH."news/".$q01_cover_image : UPLOAD_PATH."templates/no_photo.png";
                ?>
                <div class="col-12 col-lg-4 col-md-4 col-sm-12 post_card_md">
                  <div class="post_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1 h-100">
                      <div class="card border_radius_sm h-100">
                          <div class="row">
                              <div class="col-12">
                                  <div class="img_container_md noselect border_radius_top_sm">
                                      <img class="noselect d-block w-100 fluid_img border_radius_top_sm" src="<?php echo $new_cover_image01; ?>" alt="<?php echo $q01_title; ?>">
                                  </div>
                              </div>
                              <div class="col-12 ">
                                  <div class="card-block px-4">
                                    <h6 class="post_category py-2 noselect">
                                        <?php if(sizeof($q01_category) > 1): ?>
                                            <?php foreach ($q01_category as $key01 => $q01_cat_name) { ?>
                                            <span><a href="<?php echo $global_class->getCategoryUrl($q01_cat_name); ?>"><?php echo $q01_cat_name; ?></a></span> |
                                            <?php } ?>
                                        <?php else: ?>
                                            <span><a href="<?php echo $global_class->getCategoryUrl($q01_category_str); ?>"><?php echo $q01_category_str; ?></a></span> | 
                                        <?php endif ?>
                                        BY <?php echo $q01_author; ?> | <?php echo $q01_date; ?>
                                    </h6>
                                      <p class="post_short_desc_md "><a href="<?php echo $news_page_url01; ?>"><?php echo $q01_title; ?></a></p>
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
        <span class="swiper-pagination-bullet" tabindex="4" role="button" aria-label="Go to slide 5"></span>
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
  new Swiper('.newsSlider', {
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