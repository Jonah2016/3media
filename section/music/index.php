<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );
    
    $page_title = 'Music: News and blogs related to the music industry';
    $music_active = 'active';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php");
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    $src_category = 'music';
    $page_name    = 'music-page';
?>
<style>
    <?php include_once("./music.css");  ?>
</style>

<div class="page_content">
    <!-- Hero section -->
    <section class="hero_section">
        <div class="container boder_top_grey bg_black">
            <div class="row">
                <div class="row noselect py-3">
                    <div class="news_header"><h2>Music</h2></div>          
                </div>
            </div>
        </div>
        <div class="container boder_all_grey bg_black">
            <div class="row">
                <?php
                    $n_id = 0;
                    $n_hashed = "";
                    // Retrieve all news data by cateory and ids from News class
                    $news_class = new NewsController([
                        'news_category'         => $src_category,
                        'already_displayed_ids' => null
                    ]);
                    $news_posts = $news_class->getFeaturedNewsByCategory();
                    if(count($news_posts) > 0) {
                        $sliced_news_post = array_slice($news_posts, 0, 1, true);
                        foreach ($sliced_news_post as $key => $news_data1) {
                            $n_id = $news_data1['news_id'];
                            $n_hashed = $news_data1['news_hashed'];
                            $n_title = $news_data1['news_title'];
                            $n_briefing = htmlspecialchars_decode($news_data1['news_briefing']);
                            $n_author = $news_data1['news_author'];
                            $n_date = $news_data1['formated_date'];
                            $n_cover_image = $news_data1['news_cover_image'];

                            $news_page_url   = SECTION_PATH."news/article?nid=".$n_hashed;
                            $new_cover_image = (!empty($n_cover_image)) ? UPLOAD_PATH."news/".$n_cover_image : UPLOAD_PATH."templates/no_photo.png";

                ?>
                <div class="col-md-4 order-2 boder_right_grey no_paddding_x ">
                    <div class="hero_news_latest_content">
                        <div class="hero_news_latest_title"><h3><a href="<?php echo $news_page_url; ?>"><?php echo $n_title; ?></a></h3></div>
                        <div class="hero_news_latest_desc"><h5><?php echo $n_briefing; ?></h5></div>
                        <div class="hero_news_latest_tags"><h5>By <?php echo $n_author; ?> | <span><?php echo $n_date; ?></span></h5></div>
                    </div>
                </div>
                <div class="col-md-8 col-12 order-1 no_paddding_x boder_left_grey animate-box fadeIn animated-fast noselect" data-animate-effect="fadeIn">
                    <div class="hero_news_post_container image-hover">
                        <img src="<?php echo $new_cover_image; ?>" class="fluid_img noselect" alt="<?php echo $n_title; ?>"> 
                    </div>
                </div>
                <?php 
                        }
                    } 
                ?>
            </div>
            <div class="row">
                <?php
                    $news_displayed_array1 = [];
                    $n1_id = 0;
                    $n1_hashed = "";
                    // Retrieve all news data by cateory and ids from News class
                    $news_class = new NewsController([
                        'news_category'         => $src_category,
                        'already_displayed_ids' => $n_id
                    ]);
                    $news_posts1 = $news_class->getAllNewsByCategory();
                    if(count($news_posts1) > 0) {
                        $sliced_news_post1 = array_slice($news_posts1, 0, 3, true);
                        foreach ($sliced_news_post1 as $key => $news_data1) {
                            $n1_id            = $news_data1['news_id'];
                            $n1_hashed        = $news_data1['news_hashed'];
                            $n1_category      = (!empty($news_data1['news_category'])) ? explode(",", $news_data1['news_category']) : [];
                            $n1_category_str  = $n1_category[0];
                            $n1_title         = $news_data1['news_title'];
                            $n1_author        = $news_data1['news_author'];
                            $n1_date          = $news_data1['formated_date'];
                            $n1_cover_image   = $news_data1['news_cover_image'];
                            $n1_briefing      = $news_data1['news_briefing'];

                            array_push($news_displayed_array1, $n1_id);
                            $news_page_url1   = SECTION_PATH."news/article?nid=".$n1_hashed;
                            $new_cover_image1 = (!empty($n1_cover_image)) ? UPLOAD_PATH."news/".$n1_cover_image : UPLOAD_PATH."templates/no_photo.png";

                ?>
                <div class="col-md-4 col-sm-12 post_card_container boder_right_grey boder_top_grey">
                    <div class="post_card_sm p-3">
                        <div class="card float-right">
                            <div class="row bg_black py-3">
                                <div class="col-sm-5 bg_black">
                                    <div class="img_container_sm">
                                        <img class="d-block w-100 fluid_img noselect" src="<?php echo $new_cover_image1; ?>" alt="<?php echo $n1_title; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-7 bg_black">
                                    <div class="card-block">
                                        <p class="post_short_desc_sm text_white py-3 pr-3 mb-3"><a class="text_white " href="<?php echo $news_page_url1; ?>"><?php echo $n1_title; ?></a></p>
                                        <div class="news_txt_container text_white pr-3"><a class="hero_news_date text_white"> <i class="bi bi-calendar-event bi-center pr-2 text_white"></i> <?php echo $n1_date; ?> | <span class="text_white hero_author">By <?php echo $n1_author; ?></span> </a></div>
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
    </section>
    <!-- More music news -->
    <section class="cat_news_grid_section">
        <div class="row">
            <div class="container bg_light cat_title_container no_paddding_x">
                <div class="col-lg-12 page_heading text-uppercase"><h2>The Latest in Music</h2></div>
            </div>
        </div>

        <div class="row">
            <!-- medium posts -->
            <div class="container bg_light cat_news_grid_container">
                <div class="row">
                    <?php
                        $news_displayed_array2 = [];
                        $search_string1 = (!empty($news_displayed_array1)) ? implode(" , ", $news_displayed_array1)." , ".$n_id : $n_id;
                        $n1_id = 0;
                        $n1_hashed = "";
                        // Retrieve all news data by cateory and ids from News class
                        $news_class = new NewsController([
                            'news_category'         => $src_category,
                            'already_displayed_ids' => $search_string1
                        ]);
                        $news_posts2 = $news_class->getAllNewsByCategory();
                        if(count($news_posts2) > 0) {
                            $sliced_news_post2 = array_slice($news_posts2, 0, 15, true);
                            foreach ($sliced_news_post2 as $key => $news_data2) {
                                $n2_id            = $news_data2['news_id'];
                                $n2_hashed        = $news_data2['news_hashed'];
                                $n2_category      = (!empty($news_data2['news_category'])) ? explode(",", $news_data2['news_category']) : [];
                                $n2_category_str  = $n2_category[0];
                                $n2_title         = $news_data2['news_title'];
                                $n2_author        = $news_data2['news_author'];
                                $n2_date          = $news_data2['formated_date'];
                                $n2_cover_image   = $news_data2['news_cover_image'];
                                $n2_briefing      = $news_data2['news_briefing'];

                                array_push($news_displayed_array2, $n2_id);
                                $news_page_url2   = SECTION_PATH."news/article?nid=".$n2_hashed;
                                $new_cover_image2 = (!empty($n2_cover_image)) ? UPLOAD_PATH."news/".$n2_cover_image : UPLOAD_PATH."templates/no_photo.png";

                    ?>
                    <div class="col-6 col-lg-4 col-md-4 col-sm-6 post_card_md p-0">
                        <div class="post_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1 h-100">
                            <div class="card h-100">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="img_container_md">
                                            <img class="d-block w-100 fluid_img noselect" src="<?php echo $new_cover_image2; ?>" alt="<?php echo $n2_title; ?>">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card-block py-5 px-4">
                                            <h6 class="post_category py-2">By <?php echo $n2_author; ?> | <?php echo $n2_date; ?></h6>
                                            <p class="post_title pb-3"><a href="<?php echo $news_page_url2; ?>"><?php echo $n2_title; ?></a></p>
                                            <p class="post_short_desc_md"><?php echo $n2_briefing; ?></p>
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

                <!-- Similar Video posts -->
                <div class="row mt-2 mb-2">
                    <?php
                       // Retrieve main video details
                       $video_class = new VideoController([
                           'vid_category'          => $src_category,
                           'already_displayed_ids' => null
                       ]);
                       $video_posts1 = $video_class->getAllVideosByCategory();
                       if(count($video_posts1) > 0) {
                           $sliced_video_post1 = array_slice($video_posts1, 0, 9, true);
                           foreach ($sliced_video_post1 as $key => $video_data1) {
                               $v1_hashed       = $video_data1['vid_hashed'];
                               $v1_category     = $video_data1['vid_category'];
                               $v1_title        = $video_data1['vid_title'];
                               $v1_author       = $video_data1['vid_author'];
                               $v1_date         = $video_data1['formated_vid_date'];
                               $v1_thumbnail    = $video_data1['vid_thumbnail'];
                               $v1_youtube_url  = $video_data1['vid_youtube_url'];
                               $new_thumbnail1  = (!empty($v1_thumbnail)) ? UPLOAD_PATH."videos_thumbnails/".$v1_thumbnail : "https://img.youtube.com/vi/".$v1_youtube_url."/default.jpg";
                               $video_page_url1 = SECTION_PATH."videos/video?vid=".$v1_hashed;
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 video_card_md">
                        <div class="video_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1 h-100">
                            <div class="card h-100">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="vid_thumb_container_md image-hover">
                                            <a href="<?php echo $new_video_url1; ?>" class="video_play_button"><i class="bi bi-play-circle"></i></a>
                                            <img class="d-block w-100 fluid_img noselect" src="<?php echo $new_thumbnail1; ?>" alt=" <?php echo $v1_title; ?> ">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card-block py-2 px-4">
                                            <h6 class="post_category py-2"><span><a href="#"><?php echo $v1_category; ?></a></span> | <?php echo $v1_author; ?> | <?php echo $v1_date; ?></h6>
                                            <p class="post_title pb-3"><a href="<?php echo $new_video_url1; ?>"><?php echo $v1_title; ?></a></p>
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

                <!-- Subscription section -->
                <div><?php require_once(COMPONENT_PATH.'/Subscription.php'); ?></div>

                <!-- More music news -->
                <div class="row">
                    <?php
                        $news_displayed_array3 = [];
                        $search_string2 = (!empty($news_displayed_array2)) ? implode(" , ", $news_displayed_array2)." , ".$search_string1 : $search_string1;

                        $n3_id = 0;
                        $n3_hashed = "";
                        // Retrieve all news data by cateory and ids from News class
                        $news_class = new NewsController([
                            'news_category'         => $src_category,
                            'already_displayed_ids' => $search_string2
                        ]);
                        $news_posts3 = $news_class->getAllNewsByCategory();
                        if(count($news_posts3) > 0) {
                            $sliced_news_post3 = array_slice($news_posts3, 0, 15, true);
                            foreach ($sliced_news_post3 as $key => $news_data3) {
                                $n3_id            = $news_data3['news_id'];
                                $n3_hashed        = $news_data3['news_hashed'];
                                $n3_category      = (!empty($news_data3['news_category'])) ? explode(",", $news_data3['news_category']) : [];
                                $n3_category_str  = $n3_category[0];
                                $n3_title         = $news_data3['news_title'];
                                $n3_author        = $news_data3['news_author'];
                                $n3_date          = $news_data3['formated_date'];
                                $n3_cover_image   = $news_data3['news_cover_image'];
                                $n3_briefing      = $news_data3['news_briefing'];

                                array_push($news_displayed_array3, $n3_id);
                                $news_page_url3   = SECTION_PATH."news/article?nid=".$n3_hashed;
                                $new_cover_image3 = (!empty($n3_cover_image)) ? UPLOAD_PATH."news/".$n3_cover_image : UPLOAD_PATH."templates/no_photo.png";
                    ?>
                    <div class="col-6 col-lg-4 col-md-4 col-sm-6 post_card_md p-0">
                        <div class="post_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1 h-100">
                            <div class="card h-100">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="img_container_md">
                                            <img class="d-block w-100 fluid_img noselect" src="<?php echo $new_cover_image3; ?>" alt="<?php echo $n3_title; ?>">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card-block py-5 px-4">
                                            <h6 class="post_category py-2">By <?php echo $n3_author; ?> | <?php echo $n3_date; ?></h6>
                                            <p class="post_title pb-3"><a href="<?php echo $news_page_url3; ?>"><?php echo $n3_title; ?></a></p>
                                            <p class="post_short_desc_md"><?php echo $n3_briefing; ?></p>
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

                    <div class="row" id="music_news_data">
                        <!-- Music category news data is loaded here -->
                    </div>

                    <!-- Load more -->
                    <div id="loadMore" class="col-12 px-0 mt-4">
                        <button title="Load More" class="btn btn-lg btn-block btn-dark load_more py-3"> LOAD MORE </button>
                    </div>
                    <div class="col-12">
                        <div class="show_exhausted" id="showExhausted" style="display:none;">
                            <span class="bg-secondary px-4 py-3 w-100 d-block"><strong>You have exhausted the content on this page. Reload the page or explore other categories.</strong></span>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </section>


    <div class="gototop js-top"> <a href="#" class="js-gotop"><i class="fa fa-arrow-up"></i></a></div>
</div>
<?php require_once(LAYOUTS_PATH . "/main_footer.php"); ?>



<!-- // Load More Script-->
<script>
    // Fetch news and hide
    $(document).ready(function() {
        var category = 'music';
        var action = 'fetch_news_category';
        var all_displayed_news_arr = '<?php echo $qry = (!empty($news_displayed_array3)) ? implode(" , ", $news_displayed_array3)." , ".$search_string2 : $search_string2; ?>';
        function load_music_data() {
            $.ajax({
                url: "../news/fetch_news_category.php",
                method: "POST",
                cache: false,
                data: { 'action': action, 'category': category, 'displayed_array': all_displayed_news_arr },
                success: function(data) {
                    $("#music_news_data").html(data);
                }
            });
        }
        load_music_data();
    });

    $( document ).ready(function () {
        $(".moreBox").slice(0, 15).show();
        $("#showExhausted").hide();

        if ($(".newsBox:hidden").length != 0) {
            $("#loadMore").show();
            $("#showExhausted").hide();
        }       
        $("#loadMore").on('click', function (e) {
            e.preventDefault();
            $(".moreBox:hidden").slice(0, 9).slideDown();
            if ($(".moreBox:hidden").length == 0) {
                $("#loadMore").fadeOut('slow');
                $("#showExhausted").fadeIn('slow');
            }
        });
    });
</script>
<!-- // Load More Script-->


<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>
