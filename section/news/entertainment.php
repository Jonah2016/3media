<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    $page_title = 'News: Entertainment';
    $news_active = 'active';
    $news_ent_active = 'active';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php");
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    $src_news_category = 'entertainment';
    $page_name         = 'entertainment';
?>

<style>
    <?php include_once("./category.css");  ?>
</style>

<div class="page_content">
    <!-- Hero section -->
    <section class="hero_section">
        <div class="container no_paddding_x">
            <!-- Nes category navbar section -->
            <div><?php require_once(COMPONENT_PATH.'/NewsCategoryNavbar.php'); ?></div>
        </div>
    </section>

    <section class="cat_news_grid_section">
        <div class="row">
            <div class="container bg_light cat_title_container no_paddding_x">
                <div class="col-lg-12 page_heading"><h2>Entertainment</h2></div>
            </div>
        </div>
        <div class="row">
            <!-- News posts -->
            <div class="container bg_light cat_news_grid_container">
                <!-- Entertainment news posts -->
                <div class="row">
                    <?php
                        $n1_id = 0;
                        $n1_hashed = "";
                        // Retrieve all news data by cateory and ids from News class
                        $news_class = new NewsController([
                            'news_category'         => $src_news_category,
                            'already_displayed_ids' => null
                        ]);
                        $news_posts1 = $news_class->getAllNewsByCategory();
                        if(count($news_posts1) > 0) {
                            $sliced_news_post1 = array_slice($news_posts1, 0, 15, true);
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
                    <div class="col-6 col-lg-4 col-md-4 col-sm-6 post_card_md p-0">
                        <div class="post_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1 h-100">
                            <div class="card h-100">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="img_container_md">
                                            <img class="noselect d-block w-100 fluid_img" src="<?php echo $new_cover_image1; ?>" alt="<?php echo $n1_title; ?>">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card-block py-5 px-4">
                                            <h6 class="post_category py-2">By <?php echo $n1_author; ?> | <?php echo $n1_date; ?></h6>
                                            <p class="post_title pb-3"><a href="<?php echo $news_page_url1; ?>"><?php echo $n1_title; ?></a></p>
                                            <p class="post_short_desc_md"><?php echo $n1_briefing; ?></p>
                                        </div>
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
                        <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>Nothing to show under entertainment category. Explore other news categories.</strong></span></div>
                    </div>
                    <?php } ?>
                </div>
                <!-- Similar Video posts -->
                <div class="row">
                    <?php
                       // Retrieve main video details
                       $video_class = new VideoController([
                           'vid_category'          => $src_news_category,
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
                                        <div class="vid_thumb_container_md">
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

                <div class="row" id="entertainment_news_data">
                    <!-- Category news data is loaded here -->
                </div>
             
                <!-- Load more -->
                <div id="loadMore" class="col-12 px-0 mt-4">
                    <button title="Load More" class="btn btn-lg btn-block btn-dark load_more py-3"> LOAD MORE </button>
                </div>
                <div class="col-12">
                    <div class="show_exhausted" id="showExhausted" style="display:none;">
                        <span class="bg-secondary px-4 py-3 w-100 d-block"><strong>This page's content has been exhausted. Reload the page or navigate to another section.</strong></span>
                    </div>
                </div>             
            </div>
        </div>
    </section>


    <div class="gototop js-top"> <a href="#" class="js-gotop"><i class="fa fa-arrow-up"></i></a></div>

</div>

<?php require_once(LAYOUTS_PATH . "/main_footer.php"); ?>



<script>
    // Fetch news and hide
    $(document).ready(function() {
        var category = 'entertainment';
        var action = 'fetch_news_category';
        var all_displayed_news_arr = '<?php echo $qry = (!empty($news_displayed_array1)) ? implode(" , ", $news_displayed_array1): ""; ?>';
        function load_ent_data() {
            $.ajax({
                url: "./fetch_news_category.php",
                method: "POST",
                cache: false,
                data: { 'action': action, 'category': category, 'displayed_array': all_displayed_news_arr },
                success: function(data) {
                    $("#entertainment_news_data").html(data);
                }
            });
        }
        load_ent_data();
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

<script>
    var news_url = "./News.js";
    $.getScript(news_url);
</script>

<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>
