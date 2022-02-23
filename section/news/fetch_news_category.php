<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    if (isset($_POST['action']) && $_POST['action']=="fetch_news_category" && isset($_POST['category']) && !empty($_POST['category'])) {
        $new_search_category = htmlspecialchars($_POST['category'], ENT_QUOTES);
        $displayed_array     = htmlspecialchars($_POST['displayed_array'], ENT_QUOTES);

        // Retrieve all news data by cateory and ids from News class
        $home_news_class = new NewsController([
            'news_category'         => $new_search_category,
            'already_displayed_ids' => $displayed_array
        ]);
        $news_posts02 = $home_news_class->getAllNewsByCategory();
        if(count($news_posts02) > 0) {
            $sliced_news_posts02 = array_slice($news_posts02, 0, 250, true);
            foreach ($sliced_news_posts02 as $key => $news_data02) {
                $n02_hashed      = $news_data02['news_hashed'];
                $n02_title       = $news_data02['news_title'];
                $n02_briefing    = htmlspecialchars_decode($news_data02['news_briefing']);
                $n02_author      = $news_data02['news_author'];
                $n02_date        = $news_data02['formated_date'];
                $n02_cover_image = $news_data02['news_cover_image'];

                $news_page_url02 = SECTION_PATH."news/article?nid=".$n02_hashed;
                $new_cover_image02 = (!empty($n02_cover_image)) ? UPLOAD_PATH."news/".$n02_cover_image : UPLOAD_PATH."templates/no_photo.png";

?>
<div class="col-6 col-lg-4 col-md-4 col-sm-6 post_card_md p-0 newsBox moreBox" style="display: none;">
    <div class="post_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1 h-100">
        <div class="card h-100">
            <div class="row">
                <div class="col-12">
                    <div class="img_container_md">
                        <img class="n oselect d-block w-100 fluid_img lazy" data-src="<?php echo $new_cover_image02; ?>" src="<?php echo $new_cover_image02; ?>" alt="<?php echo $n02_title; ?>">
                    </div>
                </div>
                <div class="col-12">
                    <div class="card-block py-5 px-4">
                        <h6 class="post_category py-2">By <?php echo $n02_author; ?> | <?php echo $n02_date; ?></h6>
                        <p class="post_title pb-3"><a href="<?php echo $news_page_url02; ?>"><?php echo $n02_title; ?></a></p>
                        <p class="post_short_desc_md"><?php echo $n02_briefing; ?></p>
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
