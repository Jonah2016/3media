<?php
    // Require config file
    require_once('./backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    $page_title = '3Music: Here for the music';
    $home_active = 'active';
    $page_name = 'home-page';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php"); 
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    $news_categories = $NEWS_CATEGORIES_DATA;
    shuffle($news_categories);
    $random_categories = [];
    if(count($news_categories) > 0) {
        $sliced_cat_array = array_slice($news_categories, 0, 3, true);
        foreach ($sliced_cat_array as $key => $categories) {
            array_push($random_categories, $categories['category_name']);
        }
    }

?>

<style>
    <?php include_once("./home.css");  ?>
</style>

<div class="page_content">

    <!-- Top Section -->
    <section class="head_section">
        <div class="container bg_black">
            <!-- Ad banner -->
            <div class="row">
                <?php
                    $date_now          = date('Y-m-d');
                    $adverts_category  = "home-page";
                    $adverts_dimension = "horizontal-rectangle";
                    $adverts_type      = "image";
                    // Retrieve all ads by parameters data from Ads class
                    $home_ad_class = new AdsController([
                        'date_now'          => $date_now,
                        'adverts_category'  => $adverts_category,
                        'adverts_dimension' => $adverts_dimension,
                        'adverts_type'      => $adverts_type
                    ]);
                    $home_ads_data   = $home_ad_class->getAdByParams();
                    $sliced_ad_array = array_slice($home_ads_data, 0, 1, true);

                    if(count($sliced_ad_array) > 0) {
                        foreach ($sliced_ad_array as $key => $home_ad) {
                                $advs1_url            = $home_ad['adverts_url'];
                                $advs1_title          = $home_ad['adverts_title'];
                                $advs1_cover_image    = $home_ad['adverts_cover_image'];
                                $neo_advs1_cover_img1 = (!empty($advs1_cover_image)) ? UPLOAD_PATH."advsImages/".$advs1_cover_image : ASSETS_PATH."/img/placeholders/ad_placeholder.png"; 
                ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 ad_banner_fw">
                        <img class="noselect fluid_img" src="<?php echo $neo_advs1_cover_img1; ?>" alt="<?php echo $advs1_title; ?>">
                    </div>
                <?php 
                        } 
                    }
                    else {
                ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 ad_banner_fw">
                        <img class="noselect fluid_img" src="<?php echo ASSETS_PATH."/img/placeholders/ad_placeholder.png"; ?>" alt="ad banner">
                    </div>
                <?php  
                        }
                ?>
            </div>
            <!-- Nominees Slider -->
            <div class="row bg_light">
                <h3 class="header_h3 text_black pt-4 px-2 mx-lg-1 mx-sm-0"><a href="<?php echo SECTION_PATH.'award/nominees'; ?>">3 Music Award Nominees [ <?php echo date('Y'); ?> ]</a></h3>   
                <?php require_once(COMPONENT_PATH.'/NomineesSlider.php') ?>
            </div>
            <!-- hero & top stories -->
            <div class="row hero bg_white">
                <!-- 1 major Post -->
                <div class="col-12 col-lg-9 col-md-9 col-sm-12 hero_post_lg mb-3 mb-lg-0 mb-md-0 mb-sm-3">
                    <?php
                        $n1_id = 0;
                        $n1_hashed = "";
                        $n1_category = "";

                        $news_posts1 = $FEATURED_NEWS_DATA;
                        if(count($news_posts1) > 0) {
                            $sliced_news_post1 = array_slice($news_posts1, 0, 1, true);
                            foreach ($sliced_news_post1 as $key => $news_data1) {
                                $n1_id            = $news_data1['news_id'];
                                $n1_hashed        = $news_data1['news_hashed'];
                                $n1_category      = (!empty($news_data1['news_category'])) ? explode(",", $news_data1['news_category']) : [];
                                $n1_category_str  = $n1_category[0];
                                $n1_title         = $news_data1['news_title'];
                                $n1_author        = $news_data1['news_author'];
                                $n1_date          = $news_data1['formated_date'];
                                $n1_cover_image   = $news_data1['news_cover_image'];
                                $news_page_url1   = SECTION_PATH."news/article?nid=".$n1_hashed;
                                $new_cover_image1 = (!empty($n1_cover_image)) ? UPLOAD_PATH."news/".$n1_cover_image : UPLOAD_PATH."templates/no_photo.png";            
                    ?>
                    <h2><a href="<?php echo $news_page_url1; ?>"><?php echo $n1_title; ?></a></h2>
                    <h6 class="post_category">
                        <?php if(sizeof($n1_category) > 1): ?>
                            <?php 
                                foreach ($n1_category as $key1 => $n1_cat_name) { 
                                    $categoy_url1 = $global_class->getCategoryUrl($n1_cat_name);
                            ?>
                            <span><a href="<?php echo $categoy_url1; ?>"><?php echo $n1_cat_name; ?></a></span> |
                            <?php } ?>
                        <?php else: ?>
                            <span><a href="<?php echo $global_class->getCategoryUrl($n1_category_str); ?>"><?php echo $n1_category_str; ?></a></span> 
                        <?php endif ?>
                        | BY <?php echo $n1_author; ?>
                    </h6>
                    <div class="hero_img_container_lg image-hover">
                        <img src="<?php echo $new_cover_image1; ?>" alt="<?php echo $n1_title; ?>" class="noselect fluid_img">
                    </div>
                    <?php       
                            }
                        }
                    ?>
                </div>
                <!-- Top stories carousel-->
                <div class="col-12 col-lg-3 col-md-3 col-sm-12 hero_top_stories">
                    <h3>TOP STORIES</h3>
                    <div class="hero_top_stories_slide">
                        <!-- Carousel start -->
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <!-- 3 Carousel Items -->
                                <?php 
                                    $news_displayed_array1 = [];
                                    $rand_cats2            = array_unique($DIST_NEWS_CATEGORIES_DATA);
                                    $sliced_categories2    = array_slice($rand_cats2, 0, 3, true);
                                    if (!empty($sliced_categories2)) {
                                        // iterate categories array
                                        $count_one = 1;
                                        foreach ($sliced_categories2 as $key => $val) {
                                            // if($count_one < 4) {
                                                $ck_category2 = $val; 
                                ?>
                                <div class="carousel-item <?php if($count_one <= 1){echo " active "; }else{ echo ""; } ?> hero_top_stories_items">
                                    <div class="row">
                                        <!-- 1 Post -->
                                        <?php 
                                            $n2_id       = 0;
                                            $n2_hashed   = "";
                                            $n2_category = "";

                                            // Retrieve all news data by cateory and ids from News class
                                            $home_news_class = new NewsController([
                                                'news_category'         => $ck_category2,
                                                'already_displayed_ids' => $n1_id
                                            ]);
                                            $news_posts2 = $home_news_class->getAllNewsByCategory();
                                            if(count($news_posts2) > 0) {
                                                $sliced_news_posts2 = array_slice($news_posts2, 0, 3, true);
                                                $count_two = 1;
                                                foreach ($sliced_news_posts2 as $key => $news_data2) {
                                                    $n2_id     = $news_data2['news_id'];
                                                    $n2_hashed = $news_data2['news_hashed'];
                                                    $n2_title  = $news_data2['news_title'];

                                                    // Get category name from the comma separated string
                                                    $n2_cat_name = (!empty($news_data2['news_category'])) ? array_filter(explode(",", $news_data2['news_category'])) : $news_data2['news_category'];
                                                    foreach ($n2_cat_name as $key2 => $n2_val) {
                                                        $n2_category = ($n2_val == $ck_category2) ? $n2_val : $news_data2['news_category'];
                                                    }
                                                    
                                                    $n2_author      = $news_data2['news_author'];
                                                    $n2_date        = $news_data2['formated_date'];
                                                    $n2_cover_image = $news_data2['news_cover_image'];
                                                    $news_page_url2 = SECTION_PATH."news/article?nid=".$n2_hashed;

                                                    array_push($news_displayed_array1, $n2_id);
                                                    $new_cover_image2 = (!empty($n2_cover_image)) ? UPLOAD_PATH."news/".$n2_cover_image : UPLOAD_PATH."templates/no_photo.png";
                                        ?>
                                        <?php if($count_two <= 1): ?>
                                        <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="card border-0">
                                                <div class="row">
                                                    <div class="img_container_md">
                                                        <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_cover_image2; ?>" alt="<?php echo $n2_title; ?>">
                                                    </div>
                                                    <div class="card-body">
                                                        <h6 class="post_category"><span><a href="<?php echo $global_class->getCategoryUrl($n2_category); ?>"><?php echo $ck_category2; ?></a></span> | BY <?php echo $n2_author; ?></h6>
                                                        <h2><a href="<?php echo $news_page_url2; ?>"><?php echo $n2_title; ?></a></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif ?>
                                        <?php if($count_two >= 2): ?>
                                        <!-- small post card -->
                                        <div class="post_card_sm mb-3">
                                            <div class="card float-right">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <div class="img_container_sm">
                                                            <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_cover_image2; ?>" alt="<?php echo $n2_title; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <div class="card-block"> 
                                                            <h6 class="post_category"><span><a href="<?php echo $global_class->getCategoryUrl($n2_category); ?>"><?php echo $n2_category; ?></a></span></h6>
                                                            <p class="post_short_desc_sm"><a href="<?php echo $news_page_url2; ?>"><?php echo $n2_title; ?></a></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif ?>
                                        <?php $count_two++; } ?>
                                    </div>
                                </div>
                                <?php  
                                    $count_one++; 
                                                // }
                                            }  
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- End of carousel -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- // Top Section -->

    <!-- Small Grid Posts 1 Section-->
    <section class="container bg_light">
        <h3 class="header_h3 text_black pt-4 px-1 mx-lg-1 mx-sm-0">LATEST NEWS</h3> 
        <div class="banner-top-thumb-wrap row small_post px-1 mx-lg-1 mx-sm-0">
            <?php 
                $news_displayed_array3 = [];
                $search_string2 = (!empty($news_displayed_array1)) ? implode(" , ", $news_displayed_array1)." , ".$n1_id : $n1_id;

                $n4_id = 0;
                $n4_hashed = "";
                $n4_category = "";

                // Retrieve all news data by cateory and ids from News class
                $home_news_class = new NewsController([
                    'news_category'         => null,
                    'already_displayed_ids' => $search_string2
                ]);
                $news_posts4 = $home_news_class->getAllNewsByCategory();
                if(count($news_posts4) > 0) {
                    $sliced_news_posts4 = array_slice($news_posts4, 0, 8, true);
                    foreach ($sliced_news_posts4 as $key => $news_data4) {
                        $n4_id           = $news_data4['news_id'];
                        $n4_hashed       = $news_data4['news_hashed'];
                        $n4_category     = (!empty($news_data4['news_category'])) ? explode(",", $news_data4['news_category']) : [];
                        $n4_category_str = $n4_category[0];
                        $n4_title        = $news_data4['news_title'];
                        $n4_author       = $news_data4['news_author'];
                        $n4_date         = $news_data4['formated_date'];
                        $n4_cover_image  = $news_data4['news_cover_image'];

                        array_push($news_displayed_array3, $n4_id);
                        $news_page_url4 = SECTION_PATH."news/article?nid=".$n4_hashed;
                        $new_cover_image4 = (!empty($n4_cover_image)) ? UPLOAD_PATH."news/".$n4_cover_image : UPLOAD_PATH."templates/no_photo.png";

            ?>
            <div class="col-6 col-lg-3 col-md-3 col-sm-6 px-1 pb-2">
                <div class="post_section_container">
                    <div class="d-flex justify-content-between align-items-center px-1 px-lg-3 px-sm-1 pt-2 pt-lg-2 pt-sm-2">
                        <div class="d-flex justify-content-between mb-0 mb-lg-0 mb-sm-0">
                            <div><img src="<?php echo $new_cover_image4; ?>" alt="thumb" class="banner-top-thumb fluid_img" /></div>
                            <div class="m-0 px-1 pl-0 pr-2"><a href="<?php echo $news_page_url4; ?>" class="post_short_desc_md fw-bold clamp_3 clamp_4_sm post_title"><?php echo $n4_title; ?></a></div>
                        </div>
                    </div>
                    <h6 class="post_category px-3 py-2">
                        <?php if(sizeof($n1_category) > 1): ?>
                            <?php foreach ($n1_category as $key1 => $n1_cat_name) { ?>
                            <span><a href="<?php echo $global_class->getCategoryUrl($n1_cat_name); ?>"><?php echo $n1_cat_name; ?></a></span> |
                            <?php } ?>
                        <?php else: ?>
                            <span><a href="<?php echo $global_class->getCategoryUrl($n1_category_str); ?>"><?php echo $n1_category_str; ?></a></span> 
                        <?php endif ?>
                        | BY <?php echo $n1_author; ?> | <?php echo $n4_date; ?>
                    </h6>
                  </div>
            </div>
            <?php 
                    }
                }               
            ?>
        </div>
    </section>
    <!-- // Small Grid Posts 1 Section-->

    <!-- 3Music Videos Section -->
    <section class="music_section">
        <div class="music_section_content container bg_black">
            <h3 class="header_h3 text_white">3MUSIC VIDEOS</h3>
            <div class="music_section_show_box text_white">
                <div class="row">
                    <!-- THE YOUTUBE PLAYER -->
                    <div class="col-12 col-lg-9 col-md-9 sol-sm-12">
                        <?php 
                            $v1_hashed = "";
                            // Retrieve main video details
                            $video_posts1 = $VIDEO_DATA;
                            if(count($video_posts1) > 0) {
                                $sliced_video_post1 = array_slice($video_posts1, 0, 1, true);
                                foreach ($sliced_video_post1 as $key => $video_data1) {
                                    $v1_id               = $video_data1['vid_id'];
                                    $v1_hashed           = $video_data1['vid_hashed'];
                                    $v1_title            = $video_data1['vid_title'];
                                    $v1_thumbnail        = $video_data1['vid_thumbnail'];
                                    $v1_youtube_url      = $video_data1['vid_youtube_url'];
                                    $new_video_play_url1 = "https://www.youtube.com/embed/".$v1_youtube_url."?autoplay=0&rel=0&showinfo=0&autohide=1";
                                    $new_thumbnail1      = (!empty($v1_thumbnail)) ? UPLOAD_PATH."videos_thumbnails/".$v1_thumbnail : "https://img.youtube.com/vi/".$v1_youtube_url."/default.jpg";
                        ?>
                            <iframe title="<?php echo $v1_title; ?>" id="vid_frame" src="<?php echo $new_video_play_url1; ?>" frameborder="0" ></iframe>
                        <?php  } 
                            }
                        ?>
                    </div>
                    <!-- THE PLAYLIST -->
                    <div class="col-12 col-lg-3 col-md-3 sol-sm-12">
                        <div class="row vid_list_container">
                            <?php 
                                $v2_hashed2 = "";
                                $v2_category2 = "";

                                // Retrieve all news data by cateory and ids from News class
                                $home_vid_class = new VideoController([
                                    'vid_category'         => null,
                                    'already_displayed_ids' => $v1_id
                                ]);
                                $video_posts2 = $home_vid_class->getAllVideosByCategory();
                                if(count($video_posts2) > 0) {
                                    $sliced_video_posts2 = array_slice($video_posts2, 0, 30, true);
                                    foreach ($sliced_video_posts2 as $key => $video_data2) {
                                        $v2_hashed2 = $video_data2['vid_hashed'];
                                        $v2_category2 = $video_data2['vid_category'];
                                        $v2_title2 = $video_data2['vid_title'];
                                        $v2_thumbnail2 = $video_data2['vid_thumbnail'];
                                        $v2_youtube_url2 = $video_data2['vid_youtube_url'];

                                        $new_video_play_url2 = ($v2_youtube_url2 != "") ? "https://www.youtube.com/embed/".$v2_youtube_url2."?autoplay=1&rel=0&showinfo=0&autohide=1" : "";
                                        $new_thumbnail2 = (!empty($v2_thumbnail2)) ? UPLOAD_PATH."videos_thumbnails/".$v2_thumbnail2 : "https://img.youtube.com/vi/".$v2_youtube_url2."/default.jpg";
                                        $page_url2 = SECTION_PATH."videos/video?vid=".$v2_hashed2;
                            ?>
                            <div class="col-12 vid_container_sm active">
                                <div class="vid_inner_container">
                                    <a href="javascript:void(0);" class="vid_item" onClick="document.getElementById('vid_frame').src='<?php echo $new_video_play_url2; ?>'">
                                        <span class="vid_thumb"><img class="noselect fluid_img" width="100%" height="100%" src="<?php echo $new_thumbnail2; ?>" alt="<?php echo $v2_title2; ?>" /></span>
                                        <h6 class="vid_category"><?php echo $v2_category2; ?></h6>
                                        <div class="desc"><?php echo $v2_title2; ?></div>
                                    </a>
                                </div>
                            </div>
                            <?php 
                                    } 
                                } 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- // 3Music Videos Section -->

    <!-- Grid Posts 1 Section-->
    <section class="post_section">
        <div class="post_section_container container py-4 bg_white">
            <div class="row boder_bottom_dark">
                <?php 
                    $news_displayed_array4 = [];
                    $search_string3 = (!empty($news_displayed_array3)) ? implode(" , ", $news_displayed_array3)." , ".$search_string2 : $search_string2;

                    $n5_id = 0;
                    $n5_hashed = "";
                    $n5_category = "";

                    // Retrieve all news data by cateory and ids from News class
                    $home_news_class = new NewsController([
                        'news_category'         => null,
                        'already_displayed_ids' => $search_string3
                    ]);
                    $news_posts5 = $home_news_class->getAllNewsByCategory();
                    if(count($news_posts5) > 0) {
                        $sliced_news_posts5 = array_slice($news_posts5, 0, 9, true);
                        foreach ($sliced_news_posts5 as $key => $news_data5) {
                            $n5_id           = $news_data5['news_id'];
                            $n5_hashed       = $news_data5['news_hashed'];
                            $n5_category     = (!empty($news_data5['news_category'])) ? explode(",", $news_data5['news_category']) : [];
                            $n5_category_str = $n5_category[0];
                            $n5_title        = $news_data5['news_title'];
                            $n5_author       = $news_data5['news_author'];
                            $n5_date         = $news_data5['formated_date'];
                            $n5_cover_image  = $news_data5['news_cover_image'];

                            array_push($news_displayed_array4, $n5_id);
                            $news_page_url5 = SECTION_PATH."news/article?nid=".$n5_hashed;
                            $new_cover_image5 = (!empty($n5_cover_image)) ? UPLOAD_PATH."news/".$n5_cover_image : UPLOAD_PATH."templates/no_photo.png";

                ?>
                <div class="col-6 col-lg-4 col-md-4 col-sm-6 post_card_md boder_right_dark boder_top_dark">
                    <div class="post_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1 h-100">
                        <div class="card h-100">
                            <div class="row">
                                <div class="col-12">
                                    <div class="img_container_md image-hover">
                                        <div class="post_label_container"> 
                                            <?php if(sizeof($n5_category) > 1): ?>
                                                <?php 
                                                    foreach ($n5_category as $key5 => $n5_cat_name) { 
                                                        $n5_neo_cat_name = $n5_cat_name;
                                                ?>
                                                    <span class="post_label text-uppercase"> <?php echo $n5_neo_cat_name; ?> </span>
                                                <?php
                                                    } 
                                                ?>
                                            <?php else: ?>
                                                <span class="post_label text-uppercase"> <?php echo $n5_category_str; ?> </span>
                                            <?php endif ?> 
                                        </div>
                                        <img class="noselect d-block w-100 fluid_img lazy" data-src="<?php echo $new_cover_image5; ?>" alt="<?php echo $n5_title; ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card-block"> 
                                        <h6 class="post_category py-2">
                                            <?php if(sizeof($n5_category) > 1): ?>
                                                <?php foreach ($n5_category as $key5 => $n5_cat_name) { ?>
                                                <span><a href="<?php echo $global_class->getCategoryUrl($n5_cat_name); ?>"><?php echo $n5_cat_name; ?></a></span> |
                                                <?php } ?>
                                            <?php else: ?>
                                                <span><a href="<?php echo $global_class->getCategoryUrl($n5_category_str); ?>"><?php echo $n5_category_str; ?></a></span> | 
                                            <?php endif ?>
                                            By <?php echo $n5_author; ?> | <?php echo $n5_date; ?>
                                        </h6>
                                        <p class="post_short_desc_md"><a href="<?php echo $news_page_url5; ?>"><?php echo $n5_title; ?></a></p>
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
    <!-- // Grid Posts 1 Section-->

    <!-- Suscription Section -->
    <section>    
        <?php require_once(COMPONENT_PATH.'/Subscription.php') ?>
    </section>
    <!-- // Suscription Section -->

    <!-- Grid Posts 2 Section -->
    <section class="post_section mt-0">
        <div class="post_section_container container py-4 bg_light"> 
            <div class="row boder_bottom_dark">
                <?php 
                    $news_displayed_array6 = [];
                    $search_string5 = (!empty($news_displayed_array4)) ? implode(" , ", $news_displayed_array4)." , ".$search_string3 : $search_string3;
                    $n7_id = 0;
                    $n7_hashed = "";
                    $n7_category = "";

                    // Retrieve all news data by cateory and ids from News class
                    $home_news_class = new NewsController([
                        'news_category'         => null,
                        'already_displayed_ids' => $search_string5
                    ]);
                    $news_posts7 = $home_news_class->getAllNewsByCategory();
                    if(count($news_posts7) > 0) {
                        $sliced_news_posts7 = array_slice($news_posts7, 0, 6, true);
                        foreach ($sliced_news_posts7 as $key => $news_data7) {
                            $n7_id           = $news_data7['news_id'];
                            $n7_hashed       = $news_data7['news_hashed'];
                            $n7_category     = (!empty($news_data7['news_category'])) ? explode(",", $news_data7['news_category']) : [];
                            $n7_category_str = $n7_category[0];
                            $n7_title        = $news_data7['news_title'];
                            $n7_author       = $news_data7['news_author'];
                            $n7_date         = $news_data7['formated_date'];
                            $n7_cover_image  = $news_data7['news_cover_image'];

                            array_push($news_displayed_array6, $n7_id);
                            $news_page_url7 = SECTION_PATH."news/article?nid=".$n7_hashed;
                            $new_cover_image7 = (!empty($n7_cover_image)) ? UPLOAD_PATH."news/".$n7_cover_image : UPLOAD_PATH."templates/no_photo.png";
                ?>
                <div class="col-6 col-lg-4 col-md-4 col-sm-6 post_card_md boder_right_dark boder_top_dark">
                    <div class="post_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1">
                        <div class="card">
                            <div class="row">
                                <div class="col-12">
                                    <div class="img_container_md noselect">
                                        <div class="post_label_container">
                                            <?php if(sizeof($n7_category) > 1): ?>
                                                <?php 
                                                    foreach ($n7_category as $key7 => $n7_cat_name) { 
                                                        $n7_neo_cat_name = $n7_cat_name;
                                                ?>
                                                    <a href="<?php echo $global_class->getCategoryUrl($n7_cat_name); ?>"><span class="post_label text-uppercase"> <?php echo  $n7_neo_cat_name; ?> </span></a>
                                                <?php
                                                    } 
                                                ?>                                        
                                            <?php else: ?>
                                                <a href="<?php echo $global_class->getCategoryUrl($n7_category_str); ?>"><span class="post_label text-uppercase"> <?php echo  $n7_category_str; ?> </span></a>
                                            <?php endif ?> 
                                        </div>
                                        <img class="noselect d-block w-100 fluid_img lazy" data-src="<?php echo $new_cover_image7; ?>" alt="<?php echo $n7_title; ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card-block"> 
                                        <h6 class="post_category py-2 noselect"><span>BY <?php echo $n7_author; ?></span> | <?php echo $n7_date; ?></h6>
                                        <p class="post_short_desc_md"><a href="<?php echo $news_page_url7; ?>"><?php echo $n7_title; ?></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php  } 
                    }
                ?>
            </div>
        </div>
    </section>
    <!-- // Grid Posts 2 Section -->

    <!-- Horizontal Posts Section -->
    <section class="horizontal_post_section mt-0">
        <div class="hor_post_container container bg_light pt-2">
            <div class="container bg_white">
                <h3 class="header_h3 text_black pt-3 pb-3">MORE STORIES</h3>
            </div>
            <div class="row boder_top_dark">
                <?php
                    $news_displayed_array7 = [];
                    $search_string6 = (!empty($news_displayed_array6)) ? implode(" , ", $news_displayed_array6)." , ".$search_string5 : $search_string5;

                    $n8_id = 0;
                    $n8_hashed = "";
                    $n8_category = "";
                    // Retrieve all news data by cateory and ids from News class
                    $home_news_class = new NewsController([
                        'news_category'         => null,
                        'already_displayed_ids' => $search_string6
                    ]);
                    $news_posts8 = $home_news_class->getAllNewsByCategory();
                    if(count($news_posts8) > 0) {
                        $ck8_count_one = 1;
                        $sliced_news_posts8 = array_slice($news_posts8, 0, 15, true);
                        foreach ($sliced_news_posts8 as $key => $news_data8) {
                            $n8_id = $news_data8['news_id'];
                            $n8_hashed = $news_data8['news_hashed'];
                            $n8_category = (!empty($news_data8['news_category'])) ? explode(",", $news_data8['news_category']) : [];
                            $n8_category_str = $n8_category[0];
                            $n8_title = $news_data8['news_title'];
                            $n8_briefing = $news_data8['news_briefing'];
                            $n8_author = $news_data8['news_author'];
                            $n8_date = $news_data8['formated_date'];
                            $n8_cover_image = $news_data8['news_cover_image'];

                            array_push($news_displayed_array7, $n8_id);
                            $news_page_url8 = SECTION_PATH."news/article?nid=".$n8_hashed;
                            $new_cover_image8 = (!empty($n8_cover_image)) ? UPLOAD_PATH."news/".$n8_cover_image : UPLOAD_PATH."templates/no_photo.png";

                ?>
                <div class="col-lg-8" >
                    <div class="card float-right hor_post_content_hsmd">
                        <div class="row">
                            <?php if($ck8_count_one % 5 == 0): ?>
                                <div class="col-5 col-lg-5 col-md-5 col-sm-5">
                                    <div class="img_container_hmd noselect">
                                        <div class="post_label_container">
                                            <?php if(sizeof($n8_category) > 1): ?>
                                                <?php 
                                                    foreach ($n8_category as $key8 => $n8_cat_name) { 
                                                        $n8_neo_cat_name = $n8_cat_name;
                                                ?>
                                                    <span class="post_label text-uppercase"> <?php echo  $n8_neo_cat_name; ?> </span>
                                                <?php
                                                    } 
                                                ?>                                        
                                            <?php else: ?>
                                                <span class="post_label text-uppercase"> <?php echo $n8_category_str; ?> </span>
                                            <?php endif ?> 
                                        </div>
                                        <img class="noselect d-block w-100 fluid_img lazy" data-src="<?php echo $new_cover_image8; ?>" alt=" <?php echo $n8_title; ?> ">
                                    </div>
                                </div>
                                <div class="col-7 col-lg-7 col-md-7 col-sm-7">
                                    <div class="card-block hor_post_captions">
                                        <h6 class="post_category py-2 noselect"><span>By <?php echo $n8_author; ?></span> | <?php echo $n8_date; ?></h6>
                                        <h4 class="hor_post_card_title"><a href="<?php echo $news_page_url8; ?>"><?php echo $n8_title; ?></a></h4>
                                        <p class="hor_post_card_desc"><?php echo $n8_briefing; ?></p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="col-5 col-lg-5 col-md-5 col-sm-5">
                                    <div class="img_container_hsmd noselect">
                                        <img class="noselect d-block w-100 fluid_img lazy" data-src="<?php echo $new_cover_image8; ?>" alt=" <?php echo $n8_title; ?> ">
                                    </div>
                                </div>
                                <div class="col-7 col-lg-7 col-md-7 col-sm-7">
                                    <div class="card-block hor_post_captions">
                                        <h6 class="post_category py-2 px-2 pl-0 pr-2 noselect">
                                            <?php if(sizeof($n8_category) > 1): ?>
                                                <?php foreach ($n8_category as $key8 => $n8_cat_name) { ?>
                                                <span><a href="<?php echo $global_class->getCategoryUrl($n8_cat_name); ?>"><?php echo $n8_cat_name; ?></a></span> |
                                                <?php } ?>
                                            <?php else: ?>
                                                <span><a href="<?php echo $global_class->getCategoryUrl($n8_category_str); ?>"><?php echo $n8_category_str; ?></a></span> | 
                                            <?php endif ?>
                                            BY <?php echo $n8_author; ?> | <?php echo $n8_date; ?>
                                        </h6>
                                        <h4 class="hor_post_card_title px-2 pl-0 pr-2"><a href="<?php echo $news_page_url8; ?>"><?php echo $n8_title; ?></a></h4>
                                        <p class="hor_post_card_desc px-2 pl-0 pr-2"><?php echo $n8_briefing; ?></p>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <?php  
                    $ck8_count_one++; 
                        } 
                    } 
                ?>
            </div>

            <div id="more_hor_news_data">
                <!-- More news post from db is hidden loaded here -->
            </div>

            <!-- Load more btn   -->
            <div id="loadMore" class="col-12 col-lg-8 col-md-8 col-sm-12">
                <button title="Load More" class="btn btn-lg btn-block btn-dark load_more py-3"> LOAD MORE </button>
            </div>
            <div class="col-12 col-lg-8 col-md-8 col-sm-12">
                <div class="show_exhausted" id="showExhausted" style="display:none;">
                    <span class="bg-secondary px-4 py-3 w-100 d-block"><strong>This page's content has been exhausted. Reload the page or navigate to another section.</strong></span>
                </div>
            </div>
        </div>    
    </section>
    <!-- // Horizontal Posts Section -->

    <div class="gototop js-top"> <a href="#" class="js-gotop"><i class="fa fa-arrow-up"></i></a></div>
</div>

<?php require_once(LAYOUTS_PATH . "/main_footer.php"); ?>


<script>
    $(document).ready(function () {
        var e = '<?php echo $qry = (!empty($news_displayed_array7)) ? implode(" , ", $news_displayed_array7)." , ".$search_string6 : $search_string6;   ?>';
        $.ajax({
            url: "./section/news/fetch_more_news.php",
            method: "POST",
            cache: true,
            data: { action: "fetch_news", displayed_array: e },
            success: function (e) {
                $("#more_hor_news_data").html(e);
            },
        });
    });
    // Load more
    $( document ).ready(function () {
        $(".moreBox").slice(0, 15).show();
        $("#showExhausted").hide();

        if ($(".newsBox:hidden").length != 0) {
            $("#loadMore").show();
            $("#showExhausted").hide();
        }       
        $("#loadMore").on('click', function (e) {
            e.preventDefault();
            $(".moreBox:hidden").slice(0, 10).slideDown();
            if ($(".moreBox:hidden").length == 0) {
                $("#loadMore").fadeOut('slow');
                $("#showExhausted").fadeIn('slow');
            }
        });
    });
    $(document).ready(function () {
        $(".vid_item").each(function (e) {
            $(this).on("click", function () {
                var a = e + 1;
                $(".vid_container_sm").removeClass("active"),
                    $(".vid_container_sm:nth-child(" + a + ")").addClass("active");
            });
        });
    });
</script>


<script>
    const homeUrl = "./home.js";
    $.getScript(homeUrl);
</script>

<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>
