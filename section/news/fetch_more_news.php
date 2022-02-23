<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    if (isset($_POST['action']) && $_POST['action']=="fetch_news" && isset($_POST['displayed_array']) && !empty($_POST['displayed_array'])) {
        $displayed_array = htmlspecialchars($_POST['displayed_array'], ENT_QUOTES);
        // Retrieve all news data by cateory and ids from News class
        $home_news_class = new NewsController([
            'news_category'         => null,
            'already_displayed_ids' => $displayed_array
        ]);
        $news_posts01 = $home_news_class->getAllNewsByCategory();
        $n01_count_one = 1;
        if(count($news_posts01) > 0) {
            $sliced_news_posts01 = array_slice($news_posts01, 0, 250, true);
            foreach ($sliced_news_posts01 as $key => $news_data01) {
                $n01_id = $news_data01['news_id'];
                $n01_hashed = $news_data01['news_hashed'];
                $n01_category = (!empty($news_data01['news_category'])) ? explode(",", $news_data01['news_category']) : [];
                $n01_category_str = $n01_category[0];
                $n01_title = $news_data01['news_title'];
                $n01_briefing = htmlspecialchars_decode($news_data01['news_briefing']);
                $n01_body = htmlspecialchars_decode($news_data01["news_body"]);
                $n01_author = $news_data01['news_author'];
                $n01_date = $news_data01['formated_date'];
                $n01_cover_image = $news_data01['news_cover_image'];

                $news_page_url01 = SECTION_PATH."news/article?nid=".$n01_hashed;
                $new_cover_image01 = (!empty($n01_cover_image)) ? UPLOAD_PATH."news/".$n01_cover_image : UPLOAD_PATH."templates/no_photo.png";
?>

<div class="col-lg-8 newsBox moreBox" style="display: none;">
    <div class="card float-right hor_post_content_hsmd">
        <div class="row">
            <?php if ($n01_count_one % 5 == 0) : ?>
                <div class="col-5 col-lg-5 col-md-5 col-sm-5">
                    <div class="img_container_hmd noselect">
                        <div class="post_label_container">
                            <?php if (sizeof($n01_category) > 1) : ?>
                                <?php
                                foreach ($n01_category as $key01 => $n01_cat_name) {
                                    $n01_neo_cat_name = $n01_cat_name;
                                    ?>
                                    <a href="<?php echo $global_class->getCategoryUrl($n01_neo_cat_name); ?>"><span class="post_label text-uppercase"> <?php echo  $n01_neo_cat_name; ?> </span></a>
                                    <?php
                                }
                                ?>                                        
                            <?php else : ?>
                                <a href="<?php echo $global_class->getCategoryUrl($n01_category_str); ?>"><span class="post_label text-uppercase"> <?php echo $n01_category_str; ?> </span></a>
                            <?php endif ?> 
                        </div>
                        <img class="noselect d-block w-100 fluid_img lazy" data-src="<?php echo $new_cover_image01; ?>" src="<?php echo $new_cover_image01; ?>" alt=" <?php echo $n01_title; ?> ">
                    </div>
                </div>
                <div class="col-7 col-lg-7 col-md-7 col-sm-7">
                    <div class="card-block hor_post_captions">
                        <h6 class="post_category py-2 noselect"><span>BY <?php echo $n01_author; ?></span> | <?php echo $n01_date; ?></h6>
                        <h4 class="hor_post_card_title"><a href="<?php echo $news_page_url01; ?>"><?php echo $n01_title; ?></a></h4>
                        <p class="hor_post_card_desc"><?php echo $n01_briefing; ?></p>
                    </div>
                </div>
            <?php else : ?>
                <div class="col-5 col-lg-5 col-md-5 col-sm-5">
                    <div class="img_container_hsmd noselect">
                        <img class="noselect d-block w-100 fluid_img lazy" data-src="<?php echo $new_cover_image01; ?>" src="<?php echo $new_cover_image01; ?>" alt=" <?php echo $n01_title; ?> ">
                    </div>
                </div>
                <div class="col-7 col-lg-7 col-md-7 col-sm-7">
                    <div class="card-block hor_post_captions">
                        <h6 class="post_category py-2 noselect">
                            <?php if (sizeof($n01_category) > 1) : ?>
                                <?php foreach ($n01_category as $key01 => $n01_cat_name) { ?>
                                <span><a href="<?php echo $global_class->getCategoryUrl($n01_cat_name); ?>"><?php echo $n01_cat_name; ?></a></span> |
                                <?php } ?>
                            <?php else : ?>
                                <span><a href="<?php echo $global_class->getCategoryUrl($n01_category_str); ?>"><?php echo $n01_category_str; ?></a></span> | 
                            <?php endif ?>
                            BY <?php echo $n01_author; ?> | <?php echo $n01_date; ?>
                        </h6>
                        <h4 class="hor_post_card_title"><a href="<?php echo $news_page_url01; ?>"><?php echo $n01_title; ?></a></h4>
                        <p class="hor_post_card_desc"><?php echo $n01_briefing; ?></p>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<?php
            $n01_count_one++;
        }
    }
}
?>
