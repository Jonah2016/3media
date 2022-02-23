<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    $page_title = '3Music: Features news shots';
    $snap_active = 'active';
    $page_name = 'snapshot-page';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php"); 
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");
?>

<style>
    <?php include_once("./snap_shot.css");  ?>
</style>

<!-- body -->
<div class="page_content">
    <div class="scroll-container">
        <div class="row" style="background-color:white">
          <?php
            $news_posts1 = $FEATURED_NEWS_DATA;
            if(count($news_posts1) > 0) {
                $sliced_news_post1 = array_slice($news_posts1, 0, 150, true);
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
                    <div class="scroll-area col-lg-3 col-md-12 col-sm-12 m-0 p-0" style="height:90vh; border: 1px solid whitesmoke;box-shadow:6px 6px whitesmoke">
                        <div class="box">
                             <div style="height:90vh;">
                                 <img class="fluid_img snap_img" src="<?php echo $new_cover_image1; ?>">
                             </div>
                             <div class="snapshot_desc p-2 pb-4">
                                 <h3 class="snapshot_desc_title m-4"><a class="fs-4" href="<?php echo $news_page_url1; ?>"><?php echo $n1_title; ?></a></h3>
                                 <p class="snapshot_desc_brief px-4"><?php echo $n1_briefing; ?></p>
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


<!-- footer -->
<?php
require_once(LAYOUTS_PATH . "/main_footer.php");
require_once(LAYOUTS_PATH . "/footer.php");
?>
