<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    // Retrieve search param
    If(isset($_POST['search_param'])) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $a_src        = strip_tags($_POST['search_param']);
            $b_src        = stripslashes($a_src);
            $c_src        = htmlspecialchars($b_src, ENT_QUOTES);
            $search_param = strip_tags($c_src);
        }
    }

    if (empty($search_param)) { 
        header("location:javascript://history.go(-1)"); 
        exit;
    } 
    else {
        // News query
        $stmt02 = $db_connect->prepare("SELECT news_id, news_hashed, news_category, news_title, news_author, news_briefing, DATE_FORMAT(`news_date`, '%M %D, %Y') AS formated_date, news_cover_image FROM news_posts WHERE news_active_status=1 AND (news_briefing LIKE '%$search_param%' OR news_title LIKE '%$search_param%' OR news_author LIKE '%$search_param%' OR FIND_IN_SET('%$search_param%', news_category)) AND news_category NOT LIKE '%music%' ORDER BY news_id DESC LIMIT 200 ");
        $stmt02->execute();
        // Video query
        $stmt03 = $db_connect->prepare("SELECT vid_hashed, vid_category, vid_title, vid_author, vid_date, vid_thumbnail, vid_youtube_url FROM videos WHERE vid_active_status=1 AND vid_active_status=1 AND (vid_title LIKE '%$search_param%' OR vid_author LIKE '%$search_param%' OR vid_category LIKE '%$search_param%') ORDER BY vid_id DESC LIMIT 200 ");           
        $stmt03->execute();
        // Music query
        $stmt04 = $db_connect->prepare("SELECT news_id, news_hashed, news_category, news_title, news_author, news_briefing, DATE_FORMAT(`news_date`, '%M %D, %Y') AS formated_date, news_cover_image FROM news_posts WHERE news_active_status=1 AND (news_briefing LIKE '%$search_param%' OR news_title LIKE '%$search_param%' OR news_author LIKE '%$search_param%' OR FIND_IN_SET('%$search_param%', news_category)) AND FIND_IN_SET('music', news_category) ORDER BY news_id DESC LIMIT 200 ");           
        $stmt04->execute();
    }

    // Meta data params
    $og_title   = "Search Result: ".$search_param;
    $page_title = "Search Result: ".$search_param;

    // Include header
    require_once(LAYOUTS_PATH . "/header.php"); 
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");
?>

<style>
    <?php include_once("./search.css");  ?>
</style>

<div class="page_content">

    <section class="hero_section bg_light">
        <div class="container bg_white">
            <div class="searchbar_wrapper">
              <div class="search_bar">
                <form method="POST" action="<?php echo SECTION_PATH.'search/'; ?>" novalidate enctype="multipart/form-data" accept-charset="utf-8">
                    <input type="text" value="<?php echo (isset($search_param) && !empty($search_param)) ? $search_param : ''; ?>" name="search_param" placeholder="Search news and blog articles, videos..." required="">
                    <button type="submit" name="search" class="nav_bar_search_bar_button"><i class="bi bi-search"></i></button>
                </form>
              </div>
            </div>
        </div>
    </section>

    <section class="search_nav bg_light">
        <div class="search_results bg_white container">
            <div class="model_selection ">
                <button data-model="news" class="search_nav_btn active">
                    News Articles 
                    <span>
                        <?php echo "[".$global_class->query_total("SELECT COUNT(news_id) AS total FROM news_posts WHERE news_active_status=1 AND (news_briefing LIKE '%$search_param%' OR news_title LIKE '%$search_param%' OR news_author LIKE '%$search_param%' OR FIND_IN_SET('%$search_param%', news_category)) AND news_category NOT LIKE '%music%' LIMIT 200 ")."]"; ?>
                    </span>
                </button>
                <button data-model="videos" class="search_nav_btn">
                    Videos 
                    <span>
                        <?php echo "[".$global_class->query_total("SELECT COUNT(vid_id) AS total FROM videos WHERE vid_active_status=1 AND (vid_title LIKE '%$search_param%' OR vid_author LIKE '%$search_param%' OR vid_category LIKE '%$search_param%') LIMIT 200 ")."]"; ?>
                    </span>
                </button>
                <button data-model="music" class="search_nav_btn">
                    Music Articles 
                    <span>
                        <?php echo "[".$global_class->query_total("SELECT COUNT(news_id) AS total FROM news_posts WHERE news_active_status=1 AND (news_briefing LIKE '%$search_param%' OR news_title LIKE '%$search_param%' OR news_author LIKE '%$search_param%' OR FIND_IN_SET('%$search_param%', news_category)) AND FIND_IN_SET('music', news_category) LIMIT 200 ")."]"; ?>
                    </span>
                </button>
            </div>
        </div>
    </section>

    <section class="result_section bg_light">
        <div class="bg_white container">
            <div class="row">
                <div class="col-12 col-lg-8 col-md-8 col-sm-12 boder_right_dark">
                    <div class="result_feed">
                        <!-- News results -->
                        <div class="row news_results">
                            <?php
                                if($stmt02->rowCount() > 0)
                                {
                                    while($row02=$stmt02->fetch(PDO::FETCH_ASSOC))
                                    {
                                        $n1_hashed       = $row02['news_hashed'];
                                        $n1_category     = (!empty($row02['news_category'])) ? explode(",", $row02['news_category']) : [];
                                        $n1_category_str = $n1_category[0];
                                        $n1_title        = $row02['news_title'];
                                        $n1_briefing     = $row02['news_briefing'];
                                        $n1_author       = $row02['news_author'];
                                        $n1_date         = $row02['formated_date'];
                                        $n1_cover_image  = $row02['news_cover_image'];

                                        $news_page_url1 = SECTION_PATH."news/article?nid=".$n1_hashed;
                                        $new_n1_cover_image1 = (!empty($n1_cover_image)) ? UPLOAD_PATH."news/".$n1_cover_image : UPLOAD_PATH."templates/no_photo.png";

                            ?>
                            <div class="col-lg-12">
                                <div class="card float-right hor_post_content_hsmd boder_left_no boder_top_no boder_right_no boder_bottom_dark">
                                    <div class="row">
                                        <div class="col-5 col-lg-5 col-md-5 col-sm-5">
                                            <div class="img_container_hsm noselect">
                                                <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_n1_cover_image1; ?>" alt=" <?php echo $n1_title; ?> ">
                                            </div>
                                        </div>
                                        <div class="col-7 col-lg-7 col-md-7 col-sm-7">
                                            <div class="card-block hor_post_captions">
                                                <h6 class="post_category py-2 noselect">
                                                    <?php if(sizeof($n1_category) > 1): ?>
                                                        <?php foreach ($n1_category as $key1 => $n1_cat_name) { ?>
                                                        <span><a href="<?php echo $global_class->getCategoryUrl($n1_cat_name); ?>"><?php echo $n1_cat_name; ?></a></span> |
                                                        <?php } ?>
                                                    <?php else: ?>
                                                        <span><a href="<?php echo $global_class->getCategoryUrl($n1_category_str); ?>"><?php echo $n1_category_str; ?></a></span> | 
                                                    <?php endif ?>
                                                    BY <?php echo $n1_author; ?> | <?php echo $n1_date; ?>
                                                </h6>
                                                <h4 class="hor_post_card_title"><a href="<?php echo $news_page_url1; ?>"><?php echo $n1_title; ?></a></h4>
                                                <p class="hor_post_card_desc d-md-block d-sm-none"><?php echo $n1_briefing; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    }
                                } else {
                            ?>
                            <div class="col-12 boder_all_grey">
                                <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>No news article found related to this search. Try other parameters.</strong></span></div>
                            </div>
                            <?php    
                                }
                            ?>
                        </div>
                        <!-- Videos result -->
                        <div class="row videos_results" style="display:none;">
                            <?php
                                if($stmt03->rowCount() > 0)
                                {
                                    while($row03=$stmt03->fetch(PDO::FETCH_ASSOC))
                                    {
                                        $v1_hashed       = $row03['vid_hashed'];
                                        $v1_category     = $row03['vid_category'];
                                        $v1_title        = $row03['vid_title'];
                                        $v1_author       = $row03['vid_author'];
                                        $v1_date         = $row03['vid_date'];
                                        $v1_thumbnail    = $row03['vid_thumbnail'];

                                        $video_page_url1  = SECTION_PATH."videos/video?vid=".$v1_hashed;
                                        $v1_youtube_url   = $row03['vid_youtube_url'];
                                        $new_v1_thumbnail = (!empty($v1_thumbnail)) ? UPLOAD_PATH."videos_thumbnails/".$v1_thumbnail : "https://img.youtube.com/vi/".$v1_youtube_url."/default.jpg";

                            ?>
                            <div class="col-lg-12">
                                <div class="card float-right hor_post_content_hsmd boder_left_no boder_top_no boder_right_no boder_bottom_dark">
                                    <div class="row">
                                        <div class="col-5 col-lg-5 col-md-5 col-sm-5">
                                            <div class="img_container_hsmd noselect"> 
                                                <a href="<?php echo $video_page_url1; ?>" class="video_play_button"><i class="bi bi-play-circle"></i></a>
                                                <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_v1_thumbnail; ?>" alt=" <?php echo $v1_title; ?> ">
                                            </div>
                                        </div>
                                        <div class="col-7 col-lg-7 col-md-7 col-sm-7">
                                            <div class="card-block hor_post_captions">
                                                <h6 class="post_category py-2 noselect"><span><a href="#"><?php echo $v1_category; ?></a></span> | <?php echo $v1_author; ?> | <?php echo $v1_date; ?></h6>
                                                <h4 class="hor_post_card_title"><a href="<?php echo $video_page_url1; ?>"><?php echo $v1_title; ?></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    }
                                } else {
                            ?>
                            <div class="col-12 boder_all_grey">
                                <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>No video found related to this search. Try other parameters.</strong></span></div>
                            </div>
                            <?php    
                                }
                            ?>
                        </div>
                        <!-- Music news results -->
                        <div class="row music_results" style="display:none;">
                            <?php
                                if($stmt04->rowCount() > 0)
                                {
                                    while($row04=$stmt04->fetch(PDO::FETCH_ASSOC))
                                    {
                                        $m1_hashed      = $row04['news_hashed'];
                                        $m1_category    = $row04['news_category'];
                                        $m1_title       = $row04['news_title'];
                                        $m1_briefing    = $row04['news_briefing'];
                                        $m1_author      = $row04['news_author'];
                                        $m1_date        = $row04['formated_date'];
                                        $m1_cover_image = $row04['news_cover_image'];

                                        $music_page_url1 = SECTION_PATH."news/article?nid=".$m1_hashed;
                                        $new_m1_cover_image1 = (!empty($m1_cover_image)) ? UPLOAD_PATH."news/".$m1_cover_image : UPLOAD_PATH."templates/no_photo.png";

                            ?>
                            <div class="col-lg-12">
                                <div class="card float-right hor_post_content_hsmd boder_left_no boder_top_no boder_right_no boder_bottom_dark">
                                    <div class="row">
                                        <div class="col-5 col-lg-5 col-md-5 col-sm-5">
                                            <div class="img_container_hsm noselect">
                                                <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_m1_cover_image1; ?>" alt=" <?php echo $m1_title; ?> ">
                                            </div>
                                        </div>
                                        <div class="col-7 col-lg-7 col-md-7 col-sm-7">
                                            <div class="card-block hor_post_captions">
                                                <h6 class="post_category py-2 noselect"><span><a href="<?php echo $global_class->getCategoryUrl($m1_category); ?>"><?php echo $m1_category; ?></a></span> | <?php echo $m1_author; ?> | <?php echo $m1_date; ?></h6>
                                                <h4 class="hor_post_card_title"><a href="<?php echo $music_page_url1; ?>"><?php echo $m1_title; ?></a></h4>
                                                <p class="hor_post_card_desc d-md-block d-sm-none"><?php echo $m1_briefing; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    }
                                } else {
                            ?>
                            <div class="col-12 boder_all_grey">
                                <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>No result found for this search. Try other parameters.</strong></span></div>
                            </div>
                            <?php    
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <div class="article_right_side_panel">
                        <div class="article_right_side_panel_wrapper">
                            <div class="article_right_side_panel_title ">
                                <h3 class="text-uppercase">MOST READ</h3>
                            </div>
                            <div class="article_right_side_panel_items_wrapper">
                                <ul class="article_right_side_panel_items">
                                    <?php 
                                        $stmt00 = $db_connect->prepare(" SELECT news_id, news_hashed, news_category, news_title, news_author, DATE_FORMAT(`news_date`, '%M %D, %Y') AS formated_date, news_cover_image FROM news_posts WHERE news_active_status=1 ORDER BY news_views_count DESC LIMIT 4 ");           
                                        $stmt00->execute();
                                        if($stmt00->rowCount() > 0)
                                        {
                                            while($row00=$stmt00->fetch(PDO::FETCH_ASSOC))
                                            {
                                                $rn2_id          = $row00['news_id'];
                                                $rn2_hashed      = $row00['news_hashed'];
                                                $rn2_category    = $row00['news_category'];
                                                $rn2_title       = $row00['news_title'];
                                                $rn2_author      = $row00['news_author'];
                                                $rn2_date        = $row00['formated_date'];
                                                $rn2_cover_image = $row00['news_cover_image'];

                                                $r_news_page_url2 = SECTION_PATH."news/article?nid=".$rn2_hashed;
                                                $new_rn_cover_image2 =  (!empty($rn2_cover_image)) ? UPLOAD_PATH."news/".$rn2_cover_image : UPLOAD_PATH."templates/no_photo.png"; 

                                    ?>
                                    <li>
                                        <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="post_card_sm mb-3 border_bottom pb-3">
                                                <div class="card float-right">
                                                    <div class="row">
                                                        <div class="col-5 col-sm-5">
                                                            <div class="img_container_sm">
                                                                <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_rn_cover_image2; ?>" alt="<?php echo $rn2_title; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-7 col-sm-7">
                                                            <div class="card-block"> 
                                                                <h6 class="article_right_side_post_category text-uppercase"><span><a href="#"><?php echo $rn2_category; ?></a></span></h6>
                                                                <h4 class="article_right_side_post_title"><a href="<?php echo $r_news_page_url2; ?>"><?php echo $rn2_title; ?></a></h4>
                                                                <h6 class="article_right_side_post_author">By <?php echo $rn2_author; ?></h6>
                                                                <h6 class="article_right_side_post_date"><?php echo $rn2_date; ?></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li> 
                                    <?php } } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-3 bg_white"></div>
        </div>
    </section>


    <div class="gototop js-top"> <a href="#" class="js-gotop"><i class="fa fa-arrow-up"></i></a></div>

</div>

<!-- Footer section -->
<?php require_once(LAYOUTS_PATH . "/main_footer.php"); ?>

<div id="signup_modal">
    <!-- loaded from components/SignUpModal.php -->
</div>

<script>
    $(document).ready(function() {
        // hide and reveal results category 
        $(document).on('click', '.search_nav_btn', function(event) {
            const active_search_nav = $(this).data('model');

            if (active_search_nav === "news") {
                $('.search_nav_btn').removeClass('active');
                $(this).addClass('active');
                $('.news_results').show();
                $('.blogs_results').hide();
                $('.videos_results').hide();
                $('.music_results').hide();
            }
            if (active_search_nav === "videos") {
                $('.search_nav_btn').removeClass('active');
                $(this).addClass('active');
                $('.news_results').hide();
                $('.videos_results').show();
                $('.music_results').hide();
            }
            if (active_search_nav === "music") {
                $('.search_nav_btn').removeClass('active');
                $(this).addClass('active');
                $('.news_results').hide();
                $('.videos_results').hide();
                $('.music_results').show();
            }
        });
    });
</script>

<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>