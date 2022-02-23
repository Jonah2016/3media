<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    $page_title = 'Videos: Videos related to news, shows and events.';
    $videos_active = 'active';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php"); 
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    $page_name = 'videos-page';

?>
<link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/vendors/swiper/swiper-bundle.min.css"  media="all">
<style>
    <?php include_once("./videos.css"); ?>
</style>

<div class="page_content">
    <!-- Hero section -->
    <section class="hero_section">
        <div class="swiper-container hero_swiper_container">
            <div class="swiper-wrapper">
                <?php 
                    $videos_displayed_array = [];

                    $v_id       = 0;
                    $v_hashed   = "";
                    $v_category = "";
                    // Retrieve main video details
                    $video_posts = $VIDEO_DATA;
                    if(count($video_posts) > 0) {
                        $sliced_video_post = array_slice($video_posts, 0, 5, true);
                        foreach ($sliced_video_post as $key => $video_data) {
                            $v_id          = $video_data['vid_id'];
                            $v_hashed      = $video_data['vid_hashed'];
                            $v_category    = $video_data['vid_category'];
                            $v_title       = $video_data['vid_title'];
                            $v_author      = $video_data['vid_author'];
                            $v_date        = $video_data['formated_vid_date'];
                            $v_thumbnail   = $video_data['vid_thumbnail'];
                            $v_youtube_url = $video_data['vid_youtube_url'];

                            array_push($videos_displayed_array, $v_id);
                            $new_thumbnail = (!empty($v_thumbnail)) ? UPLOAD_PATH."videos_thumbnails/".$v_thumbnail : "https://img.youtube.com/vi/".$v_youtube_url."/default.jpg";
                            $video_page_url = SECTION_PATH."videos/video?vid=".$v_hashed;

                 ?>
                <div class="swiper-slide noselect">
                    <div class="video_frame image-hover">
                        <a href="<?php echo $video_page_url; ?>" style="z-index: 1;" class="play_button"><i class="bi bi-play-circle"></i></a>
                        <div class="hero_video_detail" style="z-index: 0.9;">
                            <div class="hero_video_brand"><?php echo $v_category; ?></div>
                            <a href="<?php echo $video_page_url; ?>">
                                <h2 class="hero_video_title"><?php echo $v_title; ?></h2>
                            </a>
                        </div>
                        <div class="img-gradient"></div>
                        <img src="<?php echo $new_thumbnail; ?>" alt="<?php echo $v_title; ?>">
                    </div>
                </div>
                <?php } 
                    } else{
                ?>
                <div class="col-12">
                    <div class="show_exhausted"><span class="bg-secondary px-5 py-3 d-block w-100"><strong>Nothing to display under this section at the moment. Explore other sections.</strong></span></div>
                </div>
                <?php } ?>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Add Scrollbar -->
            <div class="hero_btn_next swiper-button-next">
                <i class="fas fa-chevron-circle-right arrow-icon"></i>
            </div>
            <div class="hero_btn_prev swiper-button-prev">
                <i class="fas fa-chevron-circle-left arrow-icon"></i>
            </div>
        </div>
    </section>

    <!-- Explore More videos -->
    <section class="more_videos">
        <div class="row">
            <div class="container bg_light cat_title_container no_paddding_x">
                <div class="col-lg-12 page_heading"><h2>Explore More Videos</h2></div>
            </div>
        </div>
        <div class="row"> 
            <div class="container bg_light video_grid_container">
                <div class="row">
                    <?php 
                        $videos_displayed_array7 = [];
                        $search_string6          = (!empty($videos_displayed_array)) ? implode(" , ", $videos_displayed_array) : 0;
                        
                        $v7_id       = 0;
                        $v7_hashed   = "";
                        $v7_category = "";
                        // Retrieve main video details
                        $video_class = new VideoController([
                            'vid_category'          => null,
                            'already_displayed_ids' => $search_string6
                        ]);
                        $video_posts7 = $video_class->getAllVideosByCategory();
                        if(count($video_posts7) > 0) {
                            $sliced_video_post7 = array_slice($video_posts7, 0, 32, true);
                            foreach ($sliced_video_post7 as $key => $video_data7) {
                                $v7_id          = $video_data7['vid_id'];
                                $v7_hashed      = $video_data7['vid_hashed'];
                                $v7_category    = $video_data7['vid_category'];
                                $v7_title       = $video_data7['vid_title'];
                                $v7_author      = $video_data7['vid_author'];
                                $v7_date        = $video_data7['formated_vid_date'];
                                $v7_thumbnail   = $video_data7['vid_thumbnail'];
                                $v7_youtube_url = $video_data7['vid_youtube_url'];

                                array_push($videos_displayed_array7, $v7_id);
                                $new_thumbnail7 = (!empty($v7_thumbnail)) ? UPLOAD_PATH."videos_thumbnails/".$v7_thumbnail : "https://img.youtube.com/vi/".$v7_youtube_url."/default.jpg";
                                $video_page_url7 = SECTION_PATH."videos/video?vid=".$v7_hashed;

                    ?>
                    <div class="col-6 col-lg-3 col-md-3 col-sm-6 video_card_md px-1">
                        <div class="video_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1 h-100">
                            <div class="card h-100">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="vid_thumb_container_md image-hover">
                                            <a href="<?php echo $video_page_url7; ?>" class="video_play_button"><i class="bi bi-play-circle"></i></a>
                                            <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_thumbnail7; ?>" alt="<?php echo $v7_title; ?>">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card-block py-2 px-4">
                                            <h6 class="post_category py-2"><span><a href="#"><?php echo $v7_category; ?></a></span> | By <?php echo $v7_author; ?> | <?php echo $v7_date; ?></h6>
                                            <p class="post_title pb-3"><a href="<?php echo $video_page_url7; ?>"><?php echo $v7_title; ?></a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php   } 
                        } 
                        else { 
                    ?>
                    <div class="col-12">
                        <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>Nothing to display under this section at the moment. Explore other sections.</strong></span></div>
                    </div>
                    <?php } ?>

                    <!-- subscription with no add -->
                    <section class="subscribe_section">
                        <!-- Suscriptions -->
                        <?php require_once(COMPONENT_PATH.'/SubscriptionHorizontalNoAd.php') ?>
                    </section>

                    <div class="row" id="more_videos_data">
                        <!-- More videos from db is hidden loaded here -->
                    </div>

                    <!-- Load more -->
                    <div id="loadMore" class="col-12 px-0 mt-4">
                        <button title="Load More" class="btn btn-lg btn-block btn-dark load_more py-3"> LOAD MORE </button>
                    </div>
                    <div class="col-12">
                        <div class="show_exhausted" id="showExhausted">
                            <span class="bg-secondary px-4 py-3  w-100 d-block"><strong>This page's content has been exhausted. Reload the page or navigate to another section.</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="gototop js-top"> <a href="#" class="js-gotop"><i class="fa fa-arrow-up"></i></a></div>
</div>


<?php require_once(LAYOUTS_PATH . "/main_footer.php"); ?>


<script src='<?php echo ASSETS_PATH; ?>/vendors/swiper/swiper-bundle.min.js'></script> 
<!-- // Load More Script-->
<script>
    // Fetch videos and hide
    $(document).ready(function() {
        var all_displayed_videos_arr = '<?php echo $qry = (!empty($videos_displayed_array7)) ? implode(" , ", $videos_displayed_array7)." , ".$search_string6 : $search_string6;   ?>';
        function load_videos_data() {
            $.ajax({
                url: "./fetch_more_videos.php",
                method: "POST",
                cache: false,
                data: { 'action': 'fetch_videos', 'displayed_array': all_displayed_videos_arr },
                success: function(data) {
                    $("#more_videos_data").html(data);
                }
            });
        }
        load_videos_data();
    });

    $("#showExhausted").hide();
    $( document ).ready(function () {
        $(".moreBox").slice(0, 16).show();

        if ($(".newsBox:hidden").length != 0) {
            $("#loadMore").show();
            $("#showExhausted").hide();
        }       
        $("#loadMore").on('click', function (e) {
            e.preventDefault();
            $(".moreBox:hidden").slice(0, 8).slideDown();
            if ($(".moreBox:hidden").length == 0) {
                $("#loadMore").fadeOut('slow');
                $("#showExhausted").fadeIn('slow');
            }
        });
    });

    // Swiper Configuration -- Hero
    var swiper = new Swiper(".hero_swiper_container", {
        slidesPerView: 1.8,
        spaceBetween: 40,
        centeredSlides: true,
        freeMode: true,
        grabCursor: true,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false
        },
        navigation: {
            nextEl: ".hero_btn_next",
            prevEl: ".hero_btn_prev"
        },
        breakpoints: {
            500: {
                slidesPerView: 1
            },
            700: {
                slidesPerView: 1.8
            }
        }
    });
    // Swiper Configuration -- Latest video section
    var swiper2 = new Swiper('.latest_video_swiper', {
            slidesPerView: 6,
            spaceBetween: 15,
            loop: true,
            freeMode: true,
            slidesPerGroup: 2,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
        navigation: {
            nextEl: '.latest_videos_btn_next',
            prevEl: '.latest_videos_btn_prev',
        }
    });
</script>
<!-- // Load More Script-->

<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>