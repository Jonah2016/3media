<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    // Get URL
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $cur_page_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Retrieve aritcle details
    $a_key    = strip_tags($_GET['nid']);
    $b_key    = stripslashes($a_key);
    $c_key    = htmlspecialchars($b_key, ENT_QUOTES);
    $hash_key = strip_tags($c_key);
    if (empty($hash_key)) {
        header("location:javascript://history.go(-1)");
        exit;
    } else {
            $n1_id = 0;
            $n1_hashed = "";
            // Retrieve all news data by hashced key from News class
            $news_class = new NewsController(['news_hashed' => $hash_key]);
            $news_posts = $news_class->getNews();
            if(count($news_posts) > 0) {
                foreach ($news_posts as $key => $news_data) {
                    $n1_id           = $news_data['news_id'];
                    $n1_hashed       = $news_data['news_hashed'];
                    $n1_category     = (!empty($news_data['news_category'])) ? explode(",", $news_data['news_category']) : "";
                    $n1_neo_category = (sizeof($n1_category) > 1) ? $n1_category[0] : implode("", $n1_category);
                    $n1_title        = $news_data['news_title'];
                    $n1_briefing     = htmlspecialchars_decode($news_data['news_briefing']);
                    $n1_body         = htmlspecialchars_decode($news_data["news_body"]);
                    $n1_author       = $news_data['news_author'];
                    $n1_date         = $news_data['formated_date'];
                    $n1_cover_image  = $news_data['news_cover_image'];
                    $n1_img_caption  = $news_data['news_img_caption'];
                    $n1_author_img   = $news_data['user_profile_pic'];
                    $n1_poster_name  = $news_data['user_fname'].' '.$news_data['user_lname'];
                        
                    $new_cover_image1 = (!empty($n1_cover_image)) ? UPLOAD_PATH."news/".$n1_cover_image : UPLOAD_PATH."templates/no_photo.png";
                    $new_author_img1 = (!empty($n1_author_img)) ? UPLOAD_PATH."users/".$n1_author_img : UPLOAD_PATH."templates/avatar.png";
                }

            // Update and retrieve view count
            $search_type = "news";
            $news_view_count = $global_class->post_view_count($n1_hashed, $search_type, "UPDATE news_posts SET news_views_count=news_views_count+1 WHERE news_hashed LIKE '%$n1_hashed%' ");
        } else {
            header("location:javascript://history.go(-1)");
            exit;
        }
    }

    $og_title        = "3Music News: ".$n1_title;
    $og_image        = $new_cover_image1;
    $og_url          = $cur_page_url;
    $og_description  = $n1_briefing;
    $page_title      = "3Music News: ".$n1_title;
    $news_active     = 'active';
    $news_per_active = 'active';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php");
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    $page_name = 'news-page';
?>

<style>
    <?php include("./article.css");  ?>
</style>

<div class="page_content">


    <div class="article_wrap bg_white">
        <div class="container">
            <header class="article_header">
                <h1 class="article_title"><?php echo $n1_title; ?></h1>
                <div class="info_row">
                    <div class="info_row_credits">
                        <div class="info_row_author">
                            <div class="mini_author">
                                <div class="mini_author_img"><img class="noselect fluid_img" src="<?php echo$new_author_img1; ?>" alt="<?php echo $n1_author; ?>" /></div>
                                <div class="mini_author_name_bio">
                                    <div class="mini_author_name" itemprop="name">
                                        <span class="type">Posted By </span><a rel="author" class="attribution" href="#"> <?php echo $n1_author; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <time class="info_row_datetime" itemprop="datePublished"><?php echo $n1_date; ?></time>
                </div>
                <div class="social_follow_buttons">
                    <p class="share_this">Share This Story</p>
                    <ul class="social_follow_buttons_list">
                        <li>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo str_replace(' ', '%20', $cur_page_url); ?>" title="Facebook" target="__blank" rel="noopener noreferrer" class="social_follow_buttons_button mb-1">
                                <i class="bi bi-facebook bi-center text-primary share_icon"> </i>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/share?url=<?php echo str_replace(' ', '%20', $cur_page_url); ?>" title="Twitter" target="__blank" rel="noopener noreferrer" class="social_follow_buttons_button mb-1">
                                <i class="bi bi-twitter bi-center text-info share_icon"> </i>
                            </a>
                        </li>
                        <li>
                            <a href="mailto:?Subject=<?php echo str_replace(' ', '%20', '3Music News: '.$n1_title); ?>&Body=<?php echo str_replace(' ', '%20', 'Here is the link to the article: '.$cur_page_url); ?>" target="__blank" rel="noopener noreferrer" title="Email" class="social_follow_buttons_button mb-1"><i class="bi bi-envelope-fill bi-center text-secondary share_icon"> </i></a>
                        </li>
                        <li>
                            <div id="page_props" style="display:none" data-xpgkey="<?php echo $n1_hashed; ?>" data-xpkey="" data-xtype="" ></div>
                            <a href="javascript:void(0);" data-cpgkey="<?php echo $n1_hashed; ?>" data-cpkey="" data-ctype="<?php echo 'main'; ?>" id="commentBtn" class="comment_button_container mb-1"><button class="comment_button btn btn-md btn-dark"><i class="bi bi-chat-dots bi-center"> </i><span class="comm_txt bg-dark pl-2">COMMENT</span></button></a>
                        </li>
                    </ul>
                </div>
            </header>
            
            <section class="article_section">
                <!-- Cover Image -->
                <div class="article_cover_img_container">
                    <img src="<?php echo $new_cover_image1; ?>" class="fluid_img" alt="<?php echo $n1_title; ?>">
                    <figcaption class="article_img_caption"><?php echo $n1_img_caption; ?></figcaption>
                </div>
                <div class="container article_section_container">
                    <div class="row">
                        <div class="col-12 col-lg-9 col-md-9 col-sm-12 pb-4">
                            <div class="article_body_section">
                                <!-- News body -->
                                <div class="overflow_wrap"><?php echo $n1_body; ?></div>
                                <p class="pt-3"><?php echo 'Author: '.$n1_poster_name; ?></p>
                                <!-- Subscription section -->
                                <div class="mt-5 bg-dark subscribe_section">
                                    <div><?php require_once(COMPONENT_PATH.'/SubscriptionHorizontalNoAd.php'); ?></div>
                                </div>
                            </div>

                            <div class="mt-4 article_comment_container noselect">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h2 class="page_heading">Comments</h2>
                                    <a href="javascript:void(0);" data-cpgkey="<?php echo $n1_hashed; ?>" data-cpkey="<?php echo $n1_hashed; ?>" data-ctype="<?php echo $ctype = 'main'; ?>" id="commentBtn" class="comment_button_container"><button class="comment_button btn btn-md btn-dark"><i class="bi bi-chat-dots bi-center"> </i><span class="comm_txt bg-dark pl-2">COMMENT</span></button></a>
                                </div>
                                <div id="comments_data">
                                    <!-- loaded from classes/FetchComments.php -->
                                </div>
                                <div id="comment_form_container">
                                    <!-- loaded from components/CommentForm.php -->
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-3 col-sm-12">
                            <div class="article_right_side_panel">
                                <div class="article_right_side_panel_wrapper">
                                    <div class="article_right_side_panel_title ">
                                        <h3 class="text-uppercase">MORE FROM <br><?php echo $n1_neo_category; ?></h3>
                                    </div>
                                    <div class="article_right_side_panel_items_wrapper">
                                        <ul class="article_right_side_panel_items">
                                            <?php
                                                $news_displayed_array1 = [];
                                                $n2_id       = 0;
                                                $n2_hashed   = "";
                                                $n2_category = "";

                                                // Retrieve all news data by cateory and ids from News class
                                                $news_class = new NewsController([
                                                    'news_category'         => null,
                                                    'already_displayed_ids' => $n1_id
                                                ]);
                                                $news_posts2 = $news_class->getAllNewsByCategory();
                                                if(count($news_posts2) > 0) {
                                                    $sliced_news_posts2 = array_slice($news_posts2, 0, 5, true);
                                                    foreach ($sliced_news_posts2 as $key => $news_data2) {
                                                        $n2_id           = $news_data2['news_id'];
                                                        $n2_hashed       = $news_data2['news_hashed'];
                                                        $n2_category     = (!empty($news_data2['news_category'])) ? explode(",", $news_data2['news_category']) : [];
                                                        $n2_category_str = $n2_category[0];
                                                        $n2_title        = $news_data2['news_title'];
                                                        $n2_author       = $news_data2['news_author'];
                                                        $n2_date         = $news_data2['formated_date'];
                                                        $n2_cover_image  = $news_data2['news_cover_image'];

                                                        array_push($news_displayed_array1, $n2_id);
                                                        $news_page_url2   = SECTION_PATH."news/article?nid=".$n2_hashed;
                                                        $new_cover_image2 = (!empty($n2_cover_image)) ? UPLOAD_PATH."news/".$n2_cover_image : UPLOAD_PATH."templates/no_photo.png";
                                            ?>
                                            <li>
                                                <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                                                    <div class="post_card_sm mb-3 border_bottom pb-3">
                                                        <div class="card float-right">
                                                            <div class="row">
                                                                <div class="col-5 col-sm-5">
                                                                    <div class="img_container_sm">
                                                                        <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_cover_image2; ?>" alt="<?php echo $n2_title; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-7 col-sm-7">
                                                                    <div class="card-block"> 
                                                                        <h6 class="article_right_side_post_category">
                                                                        <?php if (sizeof($n2_category) > 1) : ?>
                                                                                <?php foreach ($n2_category as $key2 => $n2_cat_name) { ?>
                                                                                <span><a href="<?php echo $global_class->getCategoryUrl($n2_cat_name); ?>"><?php echo $n2_cat_name; ?></a></span> 
                                                                                <?php } ?>
                                                                        <?php else : ?>
                                                                                <span><a href="<?php echo $global_class->getCategoryUrl($n2_category_str); ?>"><?php echo $n2_category_str; ?></a></span> 
                                                                        <?php endif ?>
                                                                        </h6>
                                                                        <h4 class="article_right_side_post_title"><a href="<?php echo $news_page_url2; ?>"><?php echo $n2_title; ?></a></h4>
                                                                        <h6 class="article_right_side_post_author">By <?php echo $n2_author; ?></h6>
                                                                        <h6 class="article_right_side_post_date"><?php echo $n2_date; ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li> 
                                            <?php 
                                                    }
                                                } 
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> 
        </div>
    </div>

    <!-- more news posts -->
    <section class="more_news_grid_section">
        <div class="row">
            <div class="container bg_black cat_title_container no_paddding_x">
                <div class="col-lg-12 page_heading text-uppercase"><h2 class="p-2">More From 3Music News</h2></div>
            </div>
        </div>
        <div class="row">
            <!-- more news posts -->
            <div class="container bg_black cat_news_grid_container">
                <div class="row">
                    <?php
                        $search_string = (!empty($news_displayed_array1)) ? implode(" , ", $news_displayed_array1)." , ".$n1_id : $n1_id;

                        $n3_id = 0;
                        $n3_hashed = "";
                        // Retrieve all news data by cateory and ids from News class
                        $news_class = new NewsController([
                            'news_category'         => null,
                            'already_displayed_ids' => $search_string
                        ]);
                        $news_posts3 = $news_class->getAllNewsByCategory();
                        if(count($news_posts3) > 0) {
                            $sliced_news_posts3 = array_slice($news_posts3, 0, 12, true);
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

                                $news_page_url3   = SECTION_PATH."news/article?nid=".$n3_hashed;
                                $new_cover_image3 = (!empty($n3_cover_image)) ? UPLOAD_PATH."news/".$n3_cover_image : UPLOAD_PATH."templates/no_photo.png";

                            ?>
                    <div class="col-6 col-lg-4 col-md-4 col-sm-6 post_card_md p-0 bg_black">
                        <div class="post_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1">
                            <div class="card">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="img_container_md">
                                            <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_cover_image3; ?>" alt="<?php echo $n3_title; ?>">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card-block py-5 px-4 bg_black">
                                            <h6 class="post_category py-2 text-white">
                                            <?php if (sizeof($n3_category) > 1) : ?>
                                                    <?php foreach ($n3_category as $key3 => $n3_cat_name) { ?>
                                                    <span><a class="text_white fs_7" href="<?php echo $global_class->getCategoryUrl($n3_cat_name); ?>"><?php echo $n3_cat_name; ?></a></span> |
                                                    <?php } ?>
                                            <?php else : ?>
                                                    <span><a class="text_white fs_7" href="<?php echo $global_class->getCategoryUrl($n3_category_str); ?>"><?php echo $n3_category_str; ?></a></span> | 
                                            <?php endif ?>
                                                BY <?php echo $n3_author; ?> | <?php echo $n3_date; ?>
                                            </h6>

                                            <h3 class="post_title pb-3 text-white"><a class="text_white fs-5" href="<?php echo $news_page_url3; ?>"><?php echo $n3_title; ?></a></h3>
                                            <p class="post_short_desc_md text-white"><?php echo $n3_briefing; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php }
                    } else { ?>
                    <div class="col-12 boder_all_grey">
                        <div class="show_exhausted">
                            <span class="bg-secondary px-4 py-3 d-block w-100"><strong>Nothing to display under this section at the moment.</strong></span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Similar Video posts -->
    <section class="">
        <div class="row">
            <div class="container bg_black cat_title_container no_paddding_x more_news_grid_section boder_left_grey boder_right_grey boder_bottom_grey">
                <div class="col-lg-12 page_heading text-uppercase"><h2 class="p-2">More Similar Videos</h2></div>
            </div>
        </div>
        <div class="container bg_black">
            <div class="row boder_right_grey">
                <?php
                    // Retrieve main video details
                    $video_class = new VideoController([
                        'vid_category'          => $n1_neo_category,
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
                <div class="col-lg-4 col-md-4 col-sm-6 video_card_md pt-1 boder_left_grey boder_bottom_grey">
                    <div class="video_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1 h-100">
                        <div class="card h-100">
                            <div class="row">
                                <div class="col-12">
                                    <div class="vid_thumb_container_md">
                                        <a href="<?php echo $new_video_url1; ?>" class="video_play_button"><i class="bi bi-play-circle"></i></a>
                                        <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_thumbnail1; ?>" alt=" <?php echo $v1_title; ?> ">
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
                <?php }
                    } else { 
                ?>
                <div class="col-12 boder_all_grey">
                    <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>No similar videos to show related to this post. Explore other sections.</strong></span></div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <div class="gototop js-top"> <a href="#" class="js-gotop"><i class="fa fa-arrow-up"></i></a></div>

</div>

<!-- Footer section -->
<?php require_once(LAYOUTS_PATH . "/main_footer.php"); ?>


<div id="signup_modal">
    <!-- loaded from frontend/components/SignUpModal.php -->
</div>

<script>
    const article_url = "./Article.js";
    $.getScript(article_url);
</script>

<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>
