<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    $page_title = 'News: Latest Sports, Entertainment, Shows, Culture, Fashion, etc.';
    $news_active = 'active';
    $news_lts_active = 'active';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php");
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    $page_name = 'news-page';
?>

<style>
    <?php include_once("./news.css");  ?>
</style>

<div class="page_content">
    <!-- Hero section -->
    <section class="hero_section">
        <div class="container no_paddding_x">
            <!-- News category nav section -->
            <div><?php require_once(COMPONENT_PATH.'/NewsCategoryNavbar.php'); ?></div>
            <!-- Top news posts -->
            <div class="row">
                <div class="col-md-6 col-12 no_paddding_x animate-box fadeIn animated-fast" data-animate-effect="fadeIn">
                    <?php
                        $n1_id = 0;
                        $n1_hashed = "";
                        $news_posts1 = $FEATURED_NEWS_DATA;
                        if(count($news_posts1) > 0) {
                            $sliced_news_post1 = array_slice($news_posts1, 0, 1, true);
                            foreach ($sliced_news_post1 as $key => $news_data1) {
                                $n1_id           = $news_data1['news_id'];
                                $n1_hashed       = $news_data1['news_hashed'];
                                $n1_category     = (!empty($news_data1['news_category'])) ? explode(",", $news_data1['news_category']) : [];
                                $n1_category_str = $n1_category[0];
                                $n1_title        = $news_data1['news_title'];
                                $n1_author       = $news_data1['news_author'];
                                $n1_date         = $news_data1['formated_date'];
                                $n1_cover_image  = $news_data1['news_cover_image'];
                                $n1_briefing     = $news_data1['news_briefing'];

                                $news_page_url1   = SECTION_PATH."news/article?nid=".$n1_hashed;
                                $new_cover_image1 = (!empty($n1_cover_image)) ? UPLOAD_PATH."news/".$n1_cover_image : UPLOAD_PATH."templates/no_photo.png";
                    ?>
                    <div class="hero_news_post_container image-hover">
                        <img class="noselect fluid_img" src="<?php echo $new_cover_image1; ?>" alt="<?php echo $n1_title; ?>">
                        <div class="hero_news_post_container_position_absolute"></div>
                        <div class="hero_news_post_container_position_absolute_font">
                            <div class="">
                                <a href="#" class="hero_news_date"> <i class="bi bi-calendar-event bi-center pr-2"></i> <?php echo $n1_date; ?> | <span class="hero_author">By <?php echo $n1_author; ?></span></a>
                            </div>
                            <div class="news_txt_container"><a href="<?php echo $news_page_url1; ?>" class="hero_txt"> <?php echo $n1_title; ?> </a></div>
                            <div class="news_txt_container"><p class="hero_txt_2"> <?php echo $n1_briefing; ?> </p></div>
                        </div>
                    </div>
                    <?php 
                            }
                        } 
                    ?>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <?php
                            $news_displayed_array1 = [];
                            $n2_id       = 0;
                            $n2_hashed   = "";
                            $n2_category = "";

                            // Retrieve all news data by cateory and ids from News class
                            $home_news_class = new NewsController([
                                'news_category'         => null,
                                'already_displayed_ids' => $n1_id
                            ]);
                            $news_posts2 = $home_news_class->getAllNewsByCategory();
                            if(count($news_posts2) > 0) {
                                $sliced_news_posts2 = array_slice($news_posts2, 0, 4, true);
                                $count_two = 1;
                                foreach ($sliced_news_posts2 as $key => $news_data2) {
                                    $n2_id          = $news_data2['news_id'];
                                    $n2_hashed      = $news_data2['news_hashed'];
                                    $n2_title       = $news_data2['news_title'];
                                    $n2_author      = $news_data2['news_author'];
                                    $n2_date        = $news_data2['formated_date'];
                                    $n2_cover_image = $news_data2['news_cover_image'];

                                    array_push($news_displayed_array1, $n2_id);
                                    $news_page_url2   = SECTION_PATH."news/article?nid=".$n2_hashed;
                                    $new_cover_image2 = (!empty($n2_cover_image)) ? UPLOAD_PATH."news/".$n2_cover_image : UPLOAD_PATH."templates/no_photo.png";
                        ?>
                        <div class="col-md-6 col-6 no_paddding_x animate-box fadeIn animated-fast" data-animate-effect="fadeIn">
                            <div class="hero_news_post_container_2 image-hover">
                                <img class="noselect fluid_img" src="<?php echo $new_cover_image2; ?>" alt=" <?php echo $n2_title; ?> ">
                                <div class="hero_news_post_container_position_absolute"></div>
                                <div class="hero_news_post_container_position_absolute_font_2">
                                    <div class="news_txt_container"><a href="#" class="hero_news_date"> <i class="bi bi-calendar-event bi-center pr-2"></i> <?php echo $n2_date; ?> | <span class="hero_author"><?php echo 'By '.$n2_author; ?></span> </a></div>
                                    <div class="news_txt_container"><a href="<?php echo $news_page_url2; ?>" class="hero_txt_2"> <?php echo $n2_title; ?> </a></div>
                                </div>
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
    </section>
    
    <section class="latest_news_section">
        <section class="horizontal_post_section mt-0">
            <div class="hor_post_container container bg_light pt-3">
                <!-- More news posts -->
                <div class="row ml-0">
                    <?php
                        $news_displayed_array2 = [];
                        $search_string1 = (!empty($news_displayed_array1)) ? implode(" , ", $news_displayed_array1)." , ".$n1_id : $n1_id;

                        $n3_id = 0;
                        $n3_hashed = "";
                        // Retrieve all news data by cateory and ids from News class
                        $home_news_class = new NewsController([
                            'news_category'         => null,
                            'already_displayed_ids' => $search_string1
                        ]);
                        $news_posts3 = $home_news_class->getAllNewsByCategory();
                        if(count($news_posts3) > 0) {
                            $sliced_news_posts3 = array_slice($news_posts3, 0, 10, true);
                            foreach ($sliced_news_posts3 as $key => $news_data3) {
                                $n3_id           = $news_data3['news_id'];
                                $n3_hashed       = $news_data3['news_hashed'];
                                $n3_category     = (!empty($news_data3['news_category'])) ? explode(",", $news_data3['news_category']) : "";
                                $n3_category_str = $n3_category[0];
                                $n3_title        = $news_data3['news_title'];
                                $n3_briefing     = htmlspecialchars_decode($news_data3['news_briefing']);
                                $n3_author       = $news_data3['news_author'];
                                $n3_date         = $news_data3['formated_date'];
                                $n3_cover_image  = $news_data3['news_cover_image'];

                                array_push($news_displayed_array2, $n3_id);
                                $news_page_url3   = SECTION_PATH."news/article?nid=".$n3_hashed;
                                $new_cover_image3 = (!empty($n3_cover_image)) ? UPLOAD_PATH."news/".$n3_cover_image : UPLOAD_PATH."templates/no_photo.png";

                    ?>
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <div class="card float-right hor_post_content_hsmd">
                            <div class="row">
                                <div class="col-5 col-lg-5 col-md-5 col-sm-5">
                                    <div class="img_container_hsmd noselect">
                                        <div class="post_label_container">
                                        <?php if (sizeof($n3_category) > 1) : ?>
                                                <?php
                                                foreach ($n3_category as $key3 => $n3_cat_name) {
                                                    $n3_neo_cat_name = $n3_cat_name;
                                                    ?>
                                                    <a href="<?php echo $global_class->getCategoryUrl($n3_neo_cat_name); ?>"><span class="post_label text-uppercase"> <?php echo  $n3_neo_cat_name; ?> </span></a>
                                                    <?php
                                                }
                                                ?>                                        
                                        <?php else : ?>
                                                <a href="<?php echo $global_class->getCategoryUrl($n3_category_str); ?>"><span class="post_label text-uppercase"> <?php echo $n3_category_str; ?> </span></a>
                                        <?php endif ?> 
                                        </div>
                                        <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_cover_image3; ?>" alt=" <?php echo $n3_title; ?> ">
                                    </div>
                                </div>
                                <div class="col-7 col-lg-7 col-md-7 col-sm-7">
                                    <div class="card-block hor_post_captions">
                                        <h6 class="post_category py-2 noselect"><span><?php echo $n3_author; ?></span> | <?php echo $n3_date; ?></h6>
                                        <h4 class="hor_post_card_title"><a href="<?php echo $news_page_url3; ?>"><?php echo $n3_title; ?></a></h4>
                                        <p class="hor_post_card_desc"><?php echo $n3_briefing; ?></p>
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
                <!-- video section -->
                <div class="row mt-4 px-2">
                    <?php
                        // Retrieve main video details
                        $video_posts1 = $VIDEO_DATA;
                        if(count($video_posts1) > 0) {
                            $sliced_video_post1 = array_slice($video_posts1, 0, 9, true);
                            foreach ($sliced_video_post1 as $key => $video_data1) {
                                $v1_hashed      = $video_data1['vid_hashed'];
                                $v1_category    = $video_data1['vid_category'];
                                $v1_title       = $video_data1['vid_title'];
                                $v1_author      = $video_data1['vid_author'];
                                $v1_date        = $video_data1['formated_vid_date'];
                                $v1_thumbnail   = $video_data1['vid_thumbnail'];
                                $v1_youtube_url = $video_data1['vid_youtube_url'];

                                $new_thumbnail1 = (!empty($v1_thumbnail)) ? UPLOAD_PATH."videos_thumbnails/".$v1_thumbnail : "https://img.youtube.com/vi/".$v1_youtube_url."/default.jpg";
                                $video_page_url1 = SECTION_PATH."videos/video?vid=".$v1_hashed;

                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 video_card_md">
                        <div class="video_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1">
                            <div class="card">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="vid_thumb_container_md image-hover">
                                            <a href="<?php echo $video_page_url1; ?>" class="video_play_button"><i class="bi bi-play-circle"></i></a>
                                            <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_thumbnail1; ?>" alt=" <?php echo $v1_title; ?> ">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card-block py-2 px-4">
                                            <h6 class="post_category py-2"><span><a href="#"><?php echo $v1_category; ?></a></span> | <?php echo $v1_author; ?> | <?php echo $v1_date; ?></h6>
                                            <p class="post_title pb-3"><a href="<?php echo $video_page_url1; ?>"><?php echo $v1_title; ?></a></p>
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
                <div><?php include(COMPONENT_PATH.'/Subscription.php'); ?></div>
                <!-- More news posts -->
                <div class="row">
                    <?php
                        $news_displayed_array3 = [];
                        $search_string2 = (!empty($news_displayed_array2)) ? implode(" , ", $news_displayed_array2)." , ".$search_string1 : $search_string1;

                        $n4_id = 0;
                        $n4_hashed = "";
                        $n4_category = "";

                        // Retrieve all news data by cateory and ids from News class
                        $home_news_class = new NewsController([
                            'news_category'         => null,
                            'already_displayed_ids' => $search_string2
                        ]);
                        $news_posts4 = $home_news_class->getAllNewsByCategory();
                        $ck4_count_one = 0;
                        if(count($news_posts4) > 0) {
                            $sliced_news_posts4 = array_slice($news_posts4, 0, 8, true);
                            foreach ($sliced_news_posts4 as $key => $news_data4) {
                                $n4_id           = $news_data4['news_id'];
                                $n4_hashed       = $news_data4['news_hashed'];
                                $n4_category     = (!empty($news_data4['news_category'])) ? explode(",", $news_data4['news_category']) : [];
                                $n4_category_str = $n4_category[0];
                                $n4_title        = $news_data4['news_title'];
                                $n4_briefing     = $news_data4['news_briefing'];
                                $n4_author       = $news_data4['news_author'];
                                $n4_date         = $news_data4['formated_date'];
                                $n4_cover_image  = $news_data4['news_cover_image'];

                                array_push($news_displayed_array3, $n4_id);
                                $news_page_url4 = SECTION_PATH."news/article?nid=".$n4_hashed;
                                $new_cover_image4 = (!empty($n4_cover_image)) ? UPLOAD_PATH."news/".$n4_cover_image : UPLOAD_PATH."templates/no_photo.png";

                    ?>
                    <div class="col-lg-8" >
                        <div class="card float-right hor_post_content_hsmd">
                            <div class="row">
                                <?php if ($ck4_count_one % 5 == 0) : ?>
                                <div class="col-5 col-lg-5 col-md-5 col-sm-5">
                                    <div class="img_container_hmd noselect">
                                        <div class="post_label_container">
                                            <?php if (sizeof($n4_category) > 1) : ?>
                                                <?php
                                                foreach ($n4_category as $key4 => $n4_cat_name) {
                                                    $n4_neo_cat_name = $n4_cat_name;
                                                    ?>
                                                    <a href="<?php echo $global_class->getCategoryUrl($n4_category_str); ?>"><span class="post_label text-uppercase"> <?php echo $n4_category_str; ?> </span></a>
                                                    <?php
                                                }
                                                ?>                                        
                                            <?php else : ?>
                                                <a href="<?php echo $global_class->getCategoryUrl($n4_category_str); ?>"><span class="post_label text-uppercase"> <?php echo $n4_category_str; ?> </span></a>
                                            <?php endif ?> 
                                        </div>
                                        <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_cover_image4; ?>" alt=" <?php echo $n4_title; ?> ">
                                    </div>
                                </div>
                                <div class="col-7 col-lg-7 col-md-7 col-sm-7">
                                    <div class="card-block hor_post_captions">
                                        <h6 class="post_category py-2 noselect"><span><?php echo $n4_author; ?></span> | <?php echo $n4_date; ?></h6>
                                        <h4 class="hor_post_card_title"><a href="<?php echo $news_page_url4; ?>"><?php echo $n4_title; ?></a></h4>
                                        <p class="hor_post_card_desc"><?php echo $n4_briefing; ?></p>
                                    </div>
                                </div>
                                <?php else : ?>
                                <div class="col-5 col-lg-5 col-md-5 col-sm-5">
                                    <div class="img_container_hsmd noselect">
                                        <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_cover_image4; ?>" alt=" <?php echo $n4_title; ?> ">
                                    </div>
                                </div>
                                <div class="col-7 col-lg-7 col-md-7 col-sm-7">
                                    <div class="card-block hor_post_captions">
                                        <h6 class="post_category py-2 noselect">
                                            <?php if (sizeof($n4_category) > 1) : ?>
                                                <?php foreach ($n4_category as $key4 => $n4_cat_name) { ?>
                                                <span><a href="<?php echo $global_class->getCategoryUrl($n4_cat_name); ?>"><?php echo $n4_cat_name; ?></a></span> |
                                                <?php } ?>
                                            <?php else : ?>
                                                <span><a href="<?php echo $global_class->getCategoryUrl($n4_category_str); ?>"><?php echo $n4_category_str; ?></a></span> | 
                                            <?php endif ?>
                                            BY <?php echo $n4_author; ?> | <?php echo $n4_date; ?>
                                        </h6>
                                        <h4 class="hor_post_card_title"><a href="<?php echo $news_page_url4; ?>"><?php echo $n4_title; ?></a></h4>
                                        <p class="hor_post_card_desc"><?php echo $n4_briefing; ?></p>
                                    </div>
                                </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                            <?php $ck4_count_one++;
                        }
                    } else {
                        $n4_id = 0;
                        $n4_hashed = "";
                    }
                    ?>
                </div>

                <div id="news_data">
                    <!-- More news post from db is hidden loaded here -->
                </div>

                <!-- Load more btn -->
                <div id="loadMore" class="col-12 col-lg-8 col-md-8 col-sm-12">
                    <button title="Load More" class="btn btn-lg btn-block btn-dark load_more py-3"> LOAD MORE </button>
                </div>
                <div class="col-12 col-lg-8 col-md-8 col-sm-12">
                    <div class="show_exhausted" id="showExhausted" style="display:none;">
                        <span class="bg-secondary px-4 py-3 w-100 d-block"><strong>This page's content has been exhausted. Reload the page or navigate to another section or cateory.</strong></span>
                    </div>
                </div>
                
            </div>   
        </section>
    </section>


    <div class="gototop js-top"> <a href="#" title="Scroll to Top" class="js-gotop"><i class="fa fa-arrow-up"></i></a></div>

</div>

<?php require_once(LAYOUTS_PATH . "/main_footer.php"); ?>


<script>
    // Fetch news and hide
    $(document).ready(function() {
        var all_displayed_news_arr = '<?php echo $qry = (!empty($news_displayed_array3)) ? implode(" , ", $news_displayed_array3)." , ".$search_string2 : $search_string2;   ?>';
        function load_news_data() {
            $.ajax({
                url: "./fetch_more_news.php",
                method: "POST",
                cache: true,
                data: { 'action': 'fetch_news', 'displayed_array': all_displayed_news_arr },
                success: function(data) {
                    $("#news_data").html(data);
                }
            });
        }
        load_news_data();
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
</script>

<script>
    var news_url = "./News.js";
    $.getScript(news_url);
</script>

<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>
