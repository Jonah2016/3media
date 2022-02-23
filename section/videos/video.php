<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    // Get URL
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $cur_page_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Retrieve video details
    $a_key = strip_tags($_GET['vid']);
    $b_key = stripslashes($a_key);
    $c_key = htmlspecialchars($b_key, ENT_QUOTES);
    $hash_key = strip_tags($c_key);
    if (empty($hash_key)) {
        header("location:javascript://history.go(-1)");
        exit;
    } else {

        $v_id = 0;
        $v_hashed = "";
        // Retrieve all video data by hashed key from Video class
        $videos_class = new VideoController(['vid_hashed' => $hash_key]);
        $videos_posts = $videos_class->getVideo();
        if(count($videos_posts) > 0) {
            foreach ($videos_posts as $key => $video_data) {
                $v_id           = $video_data['vid_id'];
                $v_hashed       = $video_data['vid_hashed'];
                $v_category     = $video_data['vid_category'];
                $v_title        = $video_data['vid_title'];
                $v_description  = htmlspecialchars_decode($video_data['vid_description']);
                $v_author       = $video_data['vid_author'];
                $v_date         = $video_data['formated_vid_date'];
                $v_thumbnail    = $video_data['vid_thumbnail'];
                $v1_img_caption = $video_data['vid_img_caption'];
                $v_youtube_url  = $video_data['vid_youtube_url'];

                $video_url = "https://www.youtube.com/embed/".$v_youtube_url."?autoplay=1&rel=0&showinfo=0&autohide=1";
                if (!empty($v_thumbnail)) {
                    $new_thumbnail = UPLOAD_PATH."videos_thumbnails/".$v_thumbnail;
                } else {
                    $new_thumbnail = "https://img.youtube.com/vi/".$v_youtube_url."/default.jpg";
                }
            }

            // Update and retrieve view count
            $search_type = "video";
            $video_view_count = $global_class->post_view_count($v_hashed, $search_type, "UPDATE videos SET vid_views_count=vid_views_count+1 WHERE vid_hashed LIKE '%$v_hashed%' ");
        } else {
            header("location:javascript://history.go(-1)");
            exit;
        }
    }

    $og_title          = "3Music Videos: ".$v_title;
    $og_image          = $v_thumbnail;
    $og_url            = $cur_page_url;
    $og_description    = $v_title;
    $page_title        = "3Music Videos: ".$v_title;
    $videos_active     = 'active';
    $videos_per_active = 'active';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php");
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    // Get current url aand manipulate in js
    function GetCurUrl()
    {
        return sprintf(
            "%s://%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_URI']
        );
    }
    $half_cur_page_url = GetCurUrl().SECTION_PATH.'videos/video?vid=';

    $page_name = 'videos-page';
?>

<link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/vendors/swiper/swiper-bundle.min.css"  media="all">
<style>
    <?php include_once("./videos.css");  ?>
    <?php include_once("./video.css");  ?>
</style>

<div class="page_content">

    <section class="videos_hero_section">
        <div class="bg_black container-fluid videos_section_container no_paddding_x">
            <!-- Music Shows -->
            <div class="video_section_show_box text_white">
                <div class="row">
                    <!-- THE YOUTUBE PLAYER -->
                    <div class="col-12 col-lg-9 col-md-9 sol-sm-12">
                        <iframe title="<?php echo $v_title; ?>" id="vid_frame" src="<?php echo $video_url; ?>" frameborder="0" ></iframe>
                    </div>
                    <!-- THE PLAYLIST -->
                    <div class="col-12 col-lg-3 col-md-3 sol-sm-12">
                        <div class="row vid_list_container"> 
                            <?php
                            // Retrieve main video details
                            $video_class = new VideoController([
                                'vid_category'          => $v_category,
                                'already_displayed_ids' => $v_id
                            ]);
                            $video_posts = $video_class->getAllVideosByCategory();
                            if(count($video_posts) > 0) {
                                $sliced_video_post = array_slice($video_posts, 0, 10, true);
                                foreach ($sliced_video_post as $key => $video_data) {
                                    $v_hashed2      = $video_data['vid_hashed'];
                                    $v_category2    = $video_data['vid_category'];
                                    $v_title2       = $video_data['vid_title'];
                                    $v_description2 = htmlspecialchars_decode($video_data['vid_description']);
                                    $v_author2      = $video_data['vid_author'];
                                    $v_date2        = $video_data['formated_vid_date'];
                                    $v_thumbnail2   = $video_data['vid_thumbnail'];
                                    $v_youtube_url2 = $video_data['vid_youtube_url'];

                                    $video_url2 = ($v_youtube_url2 != "") ? "https://www.youtube.com/embed/".$v_youtube_url2."?autoplay=1&rel=0&showinfo=0&autohide=1" : "";
                                    $new_thumbnail2 = (!empty($v_thumbnail2)) ? UPLOAD_PATH."videos_thumbnails/".$v_thumbnail2 : "https://img.youtube.com/vi/".$v_youtube_url2."/default.jpg";
                                    $page_url2 = SECTION_PATH."videos/video?vid=".$v_hashed2;
                            ?>
                            <div class="col-12 vid_container_sm active">
                                <div class="vid_inner_container">
                                    <a href="javascript:void(0);" 
                                        data-key="<?php echo $v_hashed2; ?>" 
                                        data-title="<?php echo $v_title2; ?>" 
                                        class="vid_item" 
                                        onClick="document.getElementById('vid_frame').src='<?php echo $video_url2; ?>'" >
                                        <span class="vid_thumb"><img width="100%" height="100%" class="noselect fluid_img" src="<?php echo $new_thumbnail2; ?>" alt="thumbnail" /></span>
                                        <h6 class="vid_category"><?php echo $v_category2; ?></h6>
                                        <div class="desc"><?php echo $v_title2; ?></div>
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

    <section class="video_infocard_section bg_light">
        <div class="bg_light container-fluid video_infocard_container no_paddding_x">
            <div class="row">
                <div class="col-12 col-md-2 col-sm-12 d-sm-none d-md-block show_card_thumbnail mb-4">
                    <img src="<?php echo $new_thumbnail; ?>" class="noselect fluid_img" id="vidThumbnail" alt="thumbnail">
                    <figcaption class="video_img_caption"><?php echo $v1_img_caption; ?></figcaption>
                </div>
                <div class="col-12 col-md-8 col-sm-12 video_desc_container mb-3">
                    <div class="video_category">
                        <p>
                            <span id="vidCategory"><?php echo $v_category.' Category'; ?></span>&nbsp; | &nbsp;
                            <span class="pl-3"><i class="bi bi-calendar-event bi-center pr-2"> </i><span id="vidDate"> <?php echo $v_date; ?></span></span>
                        </p>
                    </div>
                    <div class="video_title"><h3 id="vidTitle"><?php echo $v_title; ?></h3></div>
                    <div class="video_full_description">
                        <p id="vidDescription overflow_wrap"> <?php echo $v_description; ?> </p>
                    </div>
                    <div class="video_social_buttons">
                        <!-- fb share btn -->
                        <a id="fbShareBtn" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo str_replace(' ', '%20', $cur_page_url); ?>" title="Facebook" target="__blank" rel="noopener noreferrer"  class="btn btn-labeled btn-primary text-capitalize text_white mb-1"><span class="btn-label"><i class="fab fa-facebook pr-2"></i></span>&nbsp; Share</a>
                        <!-- twitter share btn -->
                        <a id="TwitterShareBtn" href="https://twitter.com/share?url=<?php echo str_replace(' ', '%20', $cur_page_url); ?>" title="Twitter" target="__blank" rel="noopener noreferrer"  class="btn btn-labeled btn-info text-capitalize text_white mb-1"><span class="btn-label"><i class="fab fa-twitter pr-2"></i></span>&nbsp; Twitter</a>
                        <div id="page_props" style="display:none" data-xpgkey="<?php echo $v_hashed; ?>" data-xpkey="" data-xtype="" ></div>

                        <a href="javascript:void(0);" data-cpgkey="<?php echo $v_hashed; ?>" data-cpkey="" data-ctype="<?php echo 'main'; ?>" id="commentBtn" class="comment_button_container"><button class="comment_button btn btn-md btn-dark mb-1"><i class="bi bi-chat-dots bi-center"> </i><span class="comm_txt bg-dark pl-2">COMMENT</span></button></a>
                    </div>
                    
                    <!-- Comment Section -->
                    <div class="mt-2 video_comment_container noselect"> 
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="com_sec_heading">Comments</h2> 
                        </div>
                        <div id="comments_data">
                            <!-- loaded from classes/FetchComments.php -->
                        </div>
                        <div id="comment_form_container">
                            <!-- loaded from components/CommentForm.php -->
                        </div> 
                    </div>
                </div>
            </div> 
        </div>
    </section>

    <!-- more videos -->
    <section class="video_scroll_wrapper">
        <div class="more_category_video_container no_paddding_x">
            <div class="row">
                <div class=" latest_video_title_container no_paddding_x">
                    <div class="col-lg-12 page_heading text-capitalize "><h2>More <?php echo $v_category; ?> Videos</h2></div>
                </div>
            </div>
            <!-- more video section -->
            <div class="latest_video_slider"> 
                <div class="swiper-container latest_video_swiper">
                    <div class="swiper-wrapper">
                        <?php
                            // Retrieve main video details
                            $video_class = new VideoController([
                                'vid_category'          => $v_category,
                                'already_displayed_ids' => $v_id
                            ]);
                            $video_posts = $video_class->getAllVideosByCategory();
                            if(count($video_posts) > 0) {
                                $sliced_video_post = array_slice($video_posts, 0, 50, true);
                                foreach ($sliced_video_post as $key => $video_data) {
                                    $v_id3          = $video_data['vid_id'];
                                    $v_hashed3      = $video_data['vid_hashed'];
                                    $v_category3    = $video_data['vid_category'];
                                    $v_title3       = $video_data['vid_title'];
                                    $v_description3 = htmlspecialchars_decode($video_data['vid_description']);
                                    $v_author3      = $video_data['vid_author'];
                                    $v_date3        = $video_data['formated_vid_date'];
                                    $v_thumbnail3   = $video_data['vid_thumbnail'];
                                    $v_youtube_url3 = $video_data['vid_youtube_url'];

                                    $video_url3 = ($v_youtube_url3 != "") ? "https://www.youtube.com/embed/".$v_youtube_url3."?autoplay=1&rel=0&showinfo=0&autohide=1" : "";
                                    $new_thumbnail3 = (!empty($v_thumbnail3)) ? UPLOAD_PATH."videos_thumbnails/".$v_thumbnail3 : "https://img.youtube.com/vi/".$v_thumbnail3."/default.jpg";
                                    $page_url3 = SECTION_PATH."videos/video?vid=".$v_hashed3;
                        ?> 
                        <div class="swiper-slide slider" > 
                            <div class="latest_video_detail"> 
                                <a href="<?php echo $page_url3; ?>">
                                    <h2 class="latest_video_title"><?php echo $v_title3; ?></h2>
                                </a>
                            </div>

                            <img src="<?php echo $new_thumbnail3; ?>" class= "noselect fluid_img" alt="thumbnail">
                        </div>
                            <?php }
                        } ?>
                    </div>
                    <!-- Add Pagination -->
                    <div class="latest_videos_btn_next swiper-button-next"><i class="fas fa-chevron-right arrow-icon"></i></div>
                    <div class="latest_videos_btn_prev swiper-button-prev"><i class="fas fa-chevron-left arrow-icon"></i></div>
                </div>
            </div>
        </div>
    </section>

    <!-- subscription with no add -->
    <section class="subscribe_section">
        <?php require_once(COMPONENT_PATH.'/SubscriptionHorizontalNoAd.php') ?>
    </section>

    <!-- More videos -->
    <section class="more_videos">
        <div class="row">
            <div class="container bg_light cat_title_container p-lg-0 p-md-0">
                <div class="col-lg-12 page_heading"><h2>Explore More Videos</h2></div>
            </div>
        </div>
        <div class="row">
            <!-- more video posts -->
            <div class="container bg_light video_grid_container">
                <div class="row">
                    <?php
                        // Retrieve main video details
                        $vid_categories = $NEWS_CATEGORIES_DATA;
                        $random_categories = [];
                        if(count($vid_categories) > 0) {
                            foreach ($vid_categories as $key => $categories) {
                                if ($categories['category_name'] != $v_category3 && $categories['category_name'] != $v_category) {
                                    array_push($random_categories, $categories['category_name']);
                                }
                            }
                        }
                        shuffle($random_categories);
                        $random_category = array_slice($random_categories, 0, 1, true);

                        $video_class = new VideoController([
                            'vid_category'          => $random_category[0],
                            'already_displayed_ids' => null
                        ]);
                        $video_posts = $video_class->getAllVideosByCategory();
                        if(count($video_posts) > 0) {
                            $sliced_video_post = array_slice($video_posts, 0, 150, true);
                            foreach ($sliced_video_post as $key => $video_data) {
                                $v_hashed4      = $video_data['vid_hashed'];
                                $v_category4    = $video_data['vid_category'];
                                $v_title4       = $video_data['vid_title'];
                                $v_description4 = htmlspecialchars_decode($video_data['vid_description']);
                                $v_author4      = $video_data['vid_author'];
                                $v_date4        = $video_data['formated_vid_date'];
                                $v_thumbnail4   = $video_data['vid_thumbnail'];
                                $v_youtube_url4 = $video_data['vid_youtube_url'];

                                $video_url4 = ($v_youtube_url4 != "") ? "https://www.youtube.com/embed/".$v_youtube_url4."?autoplay=1&rel=0&showinfo=0&autohide=1" : "";
                                $new_thumbnail4 = (!empty($v_thumbnail4)) ? UPLOAD_PATH."videos_thumbnails/".$v_thumbnail4 : "https://img.youtube.com/vi/".$v_youtube_url4."/default.jpg";
                                $page_url4 = SECTION_PATH."videos/video?vid=".$v_hashed4;

                    ?> 
                    <div class="col-6 col-lg-3 col-md-3 col-sm-6 video_card_md px-1 newsBox moreBox" style="display: none;">
                        <div class="video_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1 h-100">
                            <div class="card h-100">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="vid_thumb_container_md  image-hover">
                                            <a href="<?php echo $page_url4; ?>" class="video_play_button"><i class="bi bi-play-circle"></i></a>
                                            <img class=" noselect d-block w-100 fluid_img" src="<?php echo $new_thumbnail4; ?>" alt="thumbnail">
                                        </div>
                                    </div>
                                    <div class="col-12 ">
                                        <div class="card-block py-2 px-4">
                                            <h6 class="post_category py-2"><span><a href="#"><?php echo $v_category4; ?></a></span> | <?php echo $v_author4; ?> | <?php echo $v_date4; ?> </h6>
                                            <p class="post_title pb-3"><a href="<?php echo $page_url4; ?>"><?php echo $v_title4; ?></a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php }
                    } ?>

                    <!-- Load more -->
                    <div id="loadMore" class="col-12 px-0 mt-4">
                        <button class="btn btn-lg btn-block btn-dark load_more py-3"> LOAD MORE </button>
                    </div>
                    <div class="col-12">
                        <div class="show_exhausted" id="showExhausted"><span class="bg-secondary px-4 py-3 w-100 d-block"><strong>This page's content has been exhausted. Reload the page or navigate to another section.</strong></span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="gototop js-top"> <a href="#" class="js-gotop"><i class="fa fa-arrow-up"></i></a></div>

</div>

<!-- Footer section -->
<?php require_once(LAYOUTS_PATH . "/main_footer.php"); ?>

<div id="signup_modal">
    <!-- loaded from components/SignUpModal.php -->
</div>

<script src='<?php echo ASSETS_PATH; ?>/vendors/swiper/swiper-bundle.min.js'></script> 

<script>
    // Reloads bage when navigating back because of the push states effect
    window.addEventListener("popstate", function(e) {
        window.location.reload();
    });

    $(document).ready(function () {
        // Load modals
        function load_vid_modals() { $("#signup_modal").load('../../frontend/components/SignUpModal.php'); }
        function load_vid_com_data() {
            $("#comment_form_container").load('../../frontend/components/CommentForm.php');
            $('.comment_button_container').show();
            const page_id = $('#page_props').data('xpgkey');;
            // Ajax call
            $.ajax({
                url: "../news/fetch_comments.php",
                method: "POST",
                cache: false,
                data: { 'action': 'fetch_comments', 'page_id': page_id },
                success: function(data) {
                    $("#comments_data").html(data);
                    $(".commentForm").attr("id","comment_form");
                    $('.comment_button_container').show();

                    // Reset prop div
                    $("#page_props").replaceWith('<div id="page_props" style="display:none" data-xpgkey="" data-xpkey="" data-xtype="" ></div>'); 
                }
            });
            return false;
        }
        // Initialize functions
        load_vid_modals();
        load_vid_com_data();

        // hide and reveal comment form component
        $(document).on('click', '.comment_button_container', function(event) {
            event.preventDefault();
            const cpkey = $(this).data('cpkey');
            const ctype = $(this).data('ctype');
            const cpgkey = $(this).data('cpgkey');
            // Fill prop values
            $('#page_props').attr('data-xpgkey', cpgkey);
            $('#page_props').attr('data-xpkey', cpkey);
            $('#page_props').attr('data-xtype', ctype);
            // Ajax call component
            $.ajax({
                url: "../../frontend/components/CommentForm.php",
                method: "POST",
                cache: false,
                success: function(data) {
                    // Add component
                    $("#comment_form_container").html(data);
                    $("#commentFormContainer").show();
                    $('.comment_button_container').hide();
                    $(".commentForm").attr("id","comment_form");
                    scrollToCommentSection();
                }
            })
        });
        // Ajax call onclick reply button 
        $(document).on('click', '.reply_btn', function(event) {
            event.preventDefault();
            const rpkey = $(this).data('rpkey');
            const rtype = $(this).data('rtype');
            const rpgkey = $(this).data('rpgkey');
            // Fill prop values
            $('#page_props').attr('data-xpgkey', rpgkey);
            $('#page_props').attr('data-xpkey', rpkey);
            $('#page_props').attr('data-xtype', rtype);

            const rpname = $(this).data('rpname');
            const id = $(this).data('id');
            const component = $('#reply_'+id);
            // Ajax call component
            $.ajax({
                url: "../../frontend/components/CommentForm.php",
                method: "POST",
                cache: false,
                success: function(data) {
                    // Init remove component
                    $("#commentFormContainer").remove();
                    // Append component
                    $(component).append(data); 
                    $("#commentFormContainer").show();
                    $(".header").html('Replying to '+rpname);
                    $('.comment_button_container').show();
                    $(".commentForm").attr("id","reply_form");
                }
            });
            return false;
        });

        function scrollToCommentSection() {
            // scroll to comment div
            $('html,body').animate({ 
                scrollTop: $("#commentFormContainer").offset().top}, 
                'slow'
            );
        }
        function postComment(formData, vc_name, vc_content, form_id){
            if (vc_content != "" && vc_name != "") {
                $.ajax({
                    url: '../../backend/models/comments.mod.php',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        if (data.code == "200") {
                            const msg = data.msg;
                            success_operation(msg);
                            $("#vc_name").val('');
                            $('.vc_content').summernote('code', '');
                            // close and hide comment form
                            $("#commentFormContainer").hide(); 
                            $(".comm_txt").html('Comment');
                            // load comment
                            load_vid_com_data(); 
                        } else {
                            const msg = data.msg
                            error_operation(msg);
                        }
                    }
                });
                return false;
            } else {
                const msg = "All fields are mandatory.";
                error_operation(msg);
            }
        }
        // save comment when  is submitted
        $(document).on('submit', '.commentForm', function(event) {
            event.preventDefault();
            const form_id = $(this).attr('id');
            const vc_content = $('#vc_content').val()
            const vc_name = $('#vc_name').val()
            const page_key =  $('#page_props').data('xpgkey');
            const parent_key = $('#page_props').data('xpkey');
            const comment_type = $('#page_props').data('xtype'); 
        
            if (vc_name == '') {
                const msg = "It seems you forgot to input your name.";
                error_operation(msg);
                return false;
            }
            if (vc_content == '') {
                const msg = "Comment content is required";
                error_operation(msg);
                return false;
            }

            var formData = new FormData(this);
            formData.append('action', 'post_comment');
            formData.append('vc_page_hashed', page_key);
            formData.append('vc_parent_hashed', parent_key);
            formData.append('vc_type', comment_type);

            postComment(formData, vc_name, vc_content, form_id) 
        });

        // change active status for videos lists
        $('.vid_item').each(function(index){
            $(this).on('click', function(e){
                e.preventDefault();
                var current_index = index+1;
                $('.vid_container_sm').removeClass('active');
                $('.vid_container_sm:nth-child('+current_index+')').addClass('active');

                var vidKey = $(this).data('key');
                var vTitle = $(this).data('title');
                var newTitle="3Music Videos: "+vTitle;
                var curUrl = '<?php echo $half_cur_page_url; ?>';
                var newPageUrl = curUrl+vidKey;
                var newFBShareUrl = 'https://www.facebook.com/sharer/sharer.php?u='+newPageUrl;
                var newTWShareUrl = 'https://twitter.com/share?url='+newPageUrl;

                // Set urls
                let state = { 'vid': vidKey }
                window.history.pushState(state, newTitle, newPageUrl);  
                $('#fbShareBtn').attr('href', newFBShareUrl);
                $('#TwitterShareBtn').attr('href', newTWShareUrl);
                $('#page_props').attr('data-xpgkey', vidKey); 
                $('.comment_button_container').attr('data-cpgkey', vidKey);  
                load_video_data(vidKey);
            });
        });
        // Function to load video data
        function load_video_data(vid_key) {
            const upload_url = '<?php echo UPLOAD_PATH."videos_thumbnails/"; ?>';
            const formData = new FormData;
            formData.append('action', 'get_video');
            formData.append('key', vid_key);
            $.ajax({
                url: '../../backend/models/videos.mod.php',
                method: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    if (data.length > 0) {
                        $('#vidThumbnail').attr('src', upload_url+data[0].vid_thumbnail);
                        $('#vidCategory').html(data[0].vid_category);
                        $('#vidTitle').html(data[0].vid_title);
                        $('#vidDescription').html(data[0].vid_description);
                        $('#vidDate').html(data[0].vid_date);
                        $('#page_props').attr('data-xpgkey', vid_key); 
                        $('.comment_button_container').attr('data-cpgkey', vid_key);  
                    }
                }
            });
            // load comments
            load_vid_com_data();
        }
    });
</script>

<script>
    $( document ).ready(function () {
        // Load more script
        $(".moreBox").slice(0, 9).show();
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

    // Swiper Configuration -- Latest video section
    var swiper2 = new Swiper('.latest_video_swiper', {
            slidesPerView: 6,
            spaceBetween: 15,
            slidesPerGroup: 2,
            pagination: { 
            clickable: true,
        },
        navigation: {
            nextEl: '.latest_videos_btn_next',
            prevEl: '.latest_videos_btn_prev',
        }
    });
</script>

<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>
