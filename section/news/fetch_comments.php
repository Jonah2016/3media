<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    if (isset($_POST['action']) && $_POST['action']=="fetch_comments" && isset($_POST['page_id']) && $_POST['page_id']!="") {
        $search_string = htmlspecialchars(strip_tags($_POST['page_id']), ENT_QUOTES);

        $red_bg_arr = ['A','C','E','K','P'];
        $blue_bg_arr = ['B','H','J','L','N'];
        $orange_bg_arr = ['M','R','T'];
        $green_bg_arr = ['U','V','X','Z'];
        $info_bg_arr = ['O','D','I','S'];
        $sec_bg_arr = ['F','Q','W','Y','G'];
        $grey_bg_arr = ['1','2','3','4','5','6','7','8','9','0',' '];

?>
<style>
    <?php include_once("./comments.css");  ?>
</style>

<div class="comments-container bg_light p-3">

    <ul id="comments-list" class="comments-list">
    <?php

        // Retrieve all news comments data by ids from News class
        $news_class = new NewsController(['search_param' => $search_string]);
        $main_comments = $news_class->getNewsComments();
        if(count($main_comments) > 0) {
            foreach ($main_comments as $key => $mcom_data) {                
                $ncom_page_hashed    = $mcom_data['ncom_page_hashed'];
                $ncom_post_hashed1   = $mcom_data['ncom_post_hashed'];
                $ncom_parent_hashed1 = $mcom_data['ncom_parent_hashed'];
                $ncom_name           = $mcom_data['ncom_name'];
                $ncom_content        = htmlspecialchars_decode($mcom_data['ncom_content']);
                $ncom_type           = $mcom_data['ncom_type'];
                $ncom_country        = $mcom_data['ncom_country'];
                $formated_date       = $global_class->time_elapsed_string($mcom_data['ncom_created_at']);
                $name_init           = (!empty($ncom_name)) ? strtoupper(mb_substr($mcom_data['ncom_name'], 0, 1)) : $name_init = "";

                if (!empty($name_init)) {
                    if (in_array($name_init, $red_bg_arr)) {
                        $new_name_init_bg = "bg-danger text_white";
                    } elseif (in_array($name_init, $blue_bg_arr)) {
                        $new_name_init_bg = "bg-primary text_white";
                    } elseif (in_array($name_init, $orange_bg_arr)) {
                        $new_name_init_bg = "bg-warning text_white";
                    } elseif (in_array($name_init, $green_bg_arr)) {
                        $new_name_init_bg = "bg-success text_white";
                    } elseif (in_array($name_init, $sec_bg_arr)) {
                        $new_name_init_bg = "bg-secondary text_white";
                    } elseif (in_array($name_init, $info_bg_arr)) {
                        $new_name_init_bg = "bg-info text_white";
                    } else {
                        $new_name_init_bg = "bg-secondary text_white";
                    }
                } else {
                    $name_init = "";
                    $new_name_init_bg = "bg-secondary text_white";
                }
        ?>
        <li>
            <div class="comment-main-level">
                <!-- Avatar -->
                <div class="comment-avatar <?php echo $new_name_init_bg; ?>"><span class="avatar_init"><?php echo $name_init; ?></span></div>
                <!-- main comment content -->
                <div class="comment-box">
                    <div class="comment-head">
                        <h6 class="comment-name by-author"><a href="#"><?php echo $ncom_name; ?></a></h6>
                        <span><?php echo $formated_date; ?></span>
                        <a class="reply_btn" data-id="<?php echo $ncom_post_hashed1; ?>" data-rpgkey="<?php echo $ncom_page_hashed; ?>" data-rpkey="<?php echo $ncom_post_hashed1; ?>" data-rpname="<?php echo $ncom_name; ?>" data-rtype="<?php echo 'reply'; ?>" type="button"><i class="fa fa-reply"></i></a>
                    </div>
                    <div class="comment-content">
                <?php echo $ncom_content; ?>
                    </div>
                    <div id="<?php echo 'reply_'.$ncom_post_hashed1; ?>"></div>
                </div>
            </div>
            <!-- Commentss replies -->
            <ul class="comments-list reply-list">
            <?php
                // Retrieve news replies data by ids from News class
                $news_class = new NewsController(['ncom_parent_hashed' => $ncom_post_hashed1]);
                $replies = $news_class->getNewsReplies();
                if(count($replies) > 0) {
                    foreach ($replies as $key => $reply_data) {  
                        $ncom_page_hashed2   = $reply_data['ncom_page_hashed'];
                        $ncom_post_hashed2   = $reply_data['ncom_post_hashed'];
                        $ncom_parent_hashed2 = $reply_data['ncom_parent_hashed'];
                        $ncom_name2          = $reply_data['ncom_name'];
                        $ncom_content2       = htmlspecialchars_decode($reply_data['ncom_content']);
                        $ncom_type2          = $reply_data['ncom_type'];
                        $ncom_country2       = $reply_data['ncom_country'];
                        $formated_date2      = $global_class->time_elapsed_string($reply_data['ncom_created_at']);
                        $name_init2          = (!empty($ncom_name2)) ? strtoupper(mb_substr($ncom_name2, 0, 1)) : $name_init2 = "";
                        
                        if (!empty($name_init2)) {
                            if (in_array($name_init2, $red_bg_arr)) {
                                $new_name_init_bg2 = "bg-danger text_white";
                            } elseif (in_array($name_init2, $blue_bg_arr)) {
                                $new_name_init_bg2 = "bg-primary text_white";
                            } elseif (in_array($name_init2, $orange_bg_arr)) {
                                $new_name_init_bg2 = "bg-warning text_white";
                            } elseif (in_array($name_init2, $green_bg_arr)) {
                                $new_name_init_bg2 = "bg-success text_white";
                            } elseif (in_array($name_init2, $sec_bg_arr)) {
                                $new_name_init_bg2 = "bg-secondary text_white";
                            } elseif (in_array($name_init2, $info_bg_arr)) {
                                $new_name_init_bg2 = "bg-info text_white";
                            }
                        } else {
                            $name_init2 = "";
                            $new_name_init_bg2 = "bg-secondary text_white";
                        }
            ?>
            <li>
                <!-- Avatar -->
                <div class="noselect comment-avatar <?php echo $new_name_init_bg2; ?>"><span class="avatar_init"><?php echo $name_init2; ?></span></div>
                <!-- Reply comment content -->
                <div class="comment-box">
                    <div class="comment-head">
                        <h6 class="comment-name"><a href="#"><?php echo $ncom_name2; ?></a></h6>
                        <span><?php echo $formated_date2; ?></span>
                        <a class="reply_btn" data-id="<?php echo $ncom_post_hashed2; ?>" data-rpgkey="<?php echo $ncom_page_hashed2; ?>" data-rpkey="<?php echo $ncom_parent_hashed2; ?>" data-rpname="<?php echo $ncom_name2; ?>" data-rtype="<?php echo 'reply'; ?>" type="button"><i class="fa fa-reply"></i></a>
                    </div>
                    <div class="comment-content">
                       <?php echo $ncom_content2; ?>
                    </div>
                    <div id="<?php echo 'reply_'.$ncom_post_hashed2; ?>"></div>
                </div>
            </li>
            <?php
                    }
                }
            ?>
            </ul>
        </li>
        <?php 
                }
            } else { 
        ?>
        <div class="col-12 boder_all_grey" style="width:90%; margin:auto">
            <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>Be the first to comment on this post.</strong></span></div>
        </div>
    <?php } ?>
    </ul>
</div>
<?php
    } else {
?>
<div class="col-12 boder_all_grey" style="width:90%; margin:auto">
    <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>Be the first to comment on this post.</strong></span></div>
</div>
<?php } ?>
