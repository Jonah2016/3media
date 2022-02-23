<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );
?>
<?php
    if(isset($_POST['action']) && $_POST['action']=="fetch_videos" && isset($_POST['displayed_array']) && !empty($_POST['displayed_array'])) {

        $displayed_array = htmlspecialchars($_POST['displayed_array'], ENT_QUOTES);
        // Retrieve main video details
        $video_class = new VideoController([
            'vid_category'          => null,
            'already_displayed_ids' => $displayed_array
        ]);
        $video_posts01 = $video_class->getAllVideosByCategory();
        if(count($video_posts01) > 0) {
            $sliced_video_post01 = array_slice($video_posts01, 0, 120, true);
            foreach ($sliced_video_post01 as $key => $video_data01) {
                $v01_id          = $video_data01['vid_id'];
                $v01_hashed      = $video_data01['vid_hashed'];
                $v01_category    = $video_data01['vid_category'];
                $v01_title       = $video_data01['vid_title'];
                $v01_author      = $video_data01['vid_author'];
                $v01_date        = $video_data01['formated_vid_date'];
                $v01_thumbnail   = $video_data01['vid_thumbnail'];
                $v01_youtube_url = $video_data01['vid_youtube_url'];

                $new_video_page_url01 = SECTION_PATH."videos/video?vid=".$v01_hashed;
                $new_thumbnail01 = (!empty($v01_thumbnail)) ? UPLOAD_PATH."videos_thumbnails/".$v01_thumbnail : "https://img.youtube.com/vi/".$v01_youtube_url."/default.jpg";

?>
    <div class="col-6 col-lg-3 col-md-3 col-sm-6 video_card_md px-1 newsBox moreBox" style="display: none;">
        <div class="video_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1 h-100">
            <div class="card h-100">
                <div class="row">
                    <div class="col-12">
                        <div class="vid_thumb_container_md">
                            <a href="<?php echo $new_video_page_url01; ?>" class="video_play_button"><i class="bi bi-play-circle"></i></a>
                            <img class="d-block w-100 fluid_img" src="<?php echo $new_thumbnail01; ?>" alt="<?php echo $v01_title; ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card-block py-2 px-4">
                            <h6 class="post_category py-2"><span><a href="#"><?php echo $v01_category; ?></a></span> | By <?php echo $v01_author; ?> | <?php echo $v01_date; ?></h6>
                            <p class="post_title pb-3"><a href="<?php echo $new_video_page_url01; ?>"><?php echo $v01_title; ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php         
            }
        }
    } 
?>