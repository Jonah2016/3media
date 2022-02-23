<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    $page_title = '3Music Award: Explore more about the 3Music awards.';
    $award_active = 'active';
    $award_news_active = 'active';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php");
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    // Retrieve about details
    $award_cover_image = "";
    $award_photo_one   = "";
    $award_photo_two   = "";
    $award_photo_three = "";
    $stmt01 = $db_connect->prepare("SELECT award_cover_image, award_photo_one, award_photo_two, award_photo_three, award_description FROM about_award ");
    $stmt01->execute();
    if ($stmt01->rowCount() > 0) {
        while ($row01=$stmt01->fetch(PDO::FETCH_ASSOC)) {
            $award_cover_image = $row01['award_cover_image'];
            $award_photo_one   = $row01['award_photo_one'];
            $award_photo_two   = $row01['award_photo_two'];
            $award_photo_three = $row01['award_photo_three'];
            $award_description = $row01['award_description'];

            (!empty($award_cover_image)) ? $award_cover_image = UPLOAD_PATH."awards/".$award_cover_image : "";
            (!empty($award_photo_one)) ? $award_photo_one = UPLOAD_PATH."awards/".$award_photo_one : "";
            (!empty($award_photo_two)) ? $award_photo_two = UPLOAD_PATH."awards/".$award_photo_two : "";
            (!empty($award_photo_three)) ? $award_photo_three = UPLOAD_PATH."awards/".$award_photo_three : "";
        }
    }

    $src_category = '3music awards';
    $page_name = 'award-page';
?>

<style>
    <?php include_once("./award.css");  ?>
</style>

<div class="page_content">
    <!-- Hero section -->
    <section class="row bg_black">
        <div class="col-lg-8 col-md-8 col-sm-12 bg_black">
            <div class="award_hero_carousel">
                <div id="awardHeroSection" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#awardHeroSection" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#awardHeroSection" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#awardHeroSection" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#awardHeroSection" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    </div>
                    <div class="carousel-inner">

                        <div class="carousel-item active">
                            <div class="carousel-caption d-md-block"> 
                                <!-- <h2 class="hero_title">3Music Awards</h2> -->
                                <a href="#award_nav" class="btn btn-lg bouncy explore_btn "><i class="explore_icon bi bi-caret-down-fill"></i></a>
                            </div>
                            <div class="overlay"></div>
                            <div class="slide_img_contain">
                                <img src="<?php echo $award_cover_image; ?>" class="d-block fluid_img noselect w-100" alt="slider image">
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="carousel-caption d-md-block">
                                <!-- <h2>3Music Awards</h2> -->
                                <a href="#award_nav" class="btn btn-lg bouncy explore_btn "><i class="explore_icon bi bi-caret-down-fill"></i></a>
                            </div>
                            <div class="overlay"></div>
                            <div class="slide_img_contain">
                                <img src="<?php echo $award_photo_one; ?>" class="d-block fluid_img noselect w-100" alt="slider image">
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="carousel-caption d-md-block">
                                <!-- <h2>3Music Awards</h2> -->
                                <a href="#award_nav" class="btn btn-lg bouncy explore_btn "><i class="explore_icon bi bi-caret-down-fill"></i></a>
                            </div>
                            <div class="overlay"></div>
                            <div class="slide_img_contain">
                                <img src="<?php echo $award_photo_two; ?>" class="d-block fluid_img noselect w-100" alt="slider image">
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="carousel-caption d-md-block">
                                <!-- <h2>3Music Awards</h2> -->
                                <a href="#award_nav" class="btn btn-lg bouncy explore_btn "><i class="explore_icon bi bi-caret-down-fill"></i></a>
                            </div>
                            <div class="overlay"></div>
                            <div class="slide_img_contain">
                                <img src="<?php echo $award_photo_three; ?>" class="d-block fluid_img noselect w-100" alt="slider image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 px-1">
            <div class="row">
                <?php
                    $news_displayed_array1 = [];

                    $n1_id = 0;
                    $n1_hashed = "";
                    // Retrieve all news data by cateory and ids from News class
                    $news_class = new NewsController([
                        'news_category'         => $src_category,
                        'already_displayed_ids' => null
                    ]);
                    $news_posts1 = $news_class->getAllNewsByCategory();
                    if(count($news_posts1) > 0) {
                        $sliced_news_post1 = array_slice($news_posts1, 0, 3, true);
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

                            array_push($news_displayed_array1, $n1_id);
                            $news_page_url1   = SECTION_PATH."news/article?nid=".$n1_hashed;
                            $new_cover_image1 = (!empty($n1_cover_image)) ? UPLOAD_PATH."news/".$n1_cover_image : UPLOAD_PATH."templates/no_photo.png";
                ?>
                <div class="col-md-12 col-12 no_paddding_x animate-box fadeIn animated-fast" data-animate-effect="fadeIn">
                    <div class="hero_news_post_container_2">
                        <div class="hero_news_post_img_container" style="height: 29.6vh; width:100%"><img class="fluid_img noselect" src="<?php echo $new_cover_image1; ?>" alt=" <?php echo $n1_title; ?> "></div>
                        <div class="hero_news_post_container_position_absolute"></div>
                        <div class="hero_news_post_container_position_absolute_font_2">
                            <div class="news_txt_container"><a href="#" class="hero_news_date"> <i class="bi bi-calendar-event bi-center pr-2"></i> <?php echo $n1_date; ?> | <span class="hero_author"><?php echo 'By '.$n1_author; ?></span> </a></div>
                            <div class="news_txt_container"><a href="<?php echo $news_page_url1; ?>" class="hero_txt_2"> <?php echo $n1_title; ?> </a></div>
                        </div>
                    </div>
                </div>
                <?php 
                        }
                    }
                ?>
            </div>
        </div>
    </section>

    <section class="bg-light award_nav_section" id="award_nav">
        <div class="row">
            <div class="container">
                <!-- Awards navbar -->
                <?php require_once(COMPONENT_PATH.'/AwardsNavbar.php') ?>
            </div>
        </div>
    </section>
                
    <section class="bg-light latest_award_news_section ">
        <div class="container bg_light no_paddding_x">
            <div class="row">
                <div class="container bg_light cat_title_container no_paddding_x">
                    <div class="col-lg-12 page_heading"><h2>Latest 3Music Awards News</h2></div>
                </div>
            </div>
            <!-- medium posts -->
            <div class="container bg_light ">
                <div class="row">
                    <?php
                        $news_displayed_array2 = [];
                        $search_string1 = (!empty($news_displayed_array1)) ? implode(" , ", $news_displayed_array1) : $n1_id;

                        $n2_id = 0;
                        $n2_hashed = "";
                        // Retrieve all news data by cateory and ids from News class
                        $news_class = new NewsController([
                            'news_category'         => $src_category,
                            'already_displayed_ids' => $search_string1
                        ]);
                        $news_posts2 = $news_class->getAllNewsByCategory();
                        if(count($news_posts2) > 0) {
                            $sliced_news_post2 = array_slice($news_posts2, 0, 15, true);
                            foreach ($sliced_news_post2 as $key => $news_data2) {
                                $n2_id           = $news_data2['news_id'];
                                $n2_hashed       = $news_data2['news_hashed'];
                                $n2_category     = (!empty($news_data2['news_category'])) ? explode(",", $news_data2['news_category']) : [];
                                $n2_category_str = $n2_category[0];
                                $n2_title        = $news_data2['news_title'];
                                $n2_author       = $news_data2['news_author'];
                                $n2_date         = $news_data2['formated_date'];
                                $n2_cover_image  = $news_data2['news_cover_image'];
                                $n2_briefing     = $news_data2['news_briefing'];

                                array_push($news_displayed_array2, $n2_id);
                                $news_page_url2   = SECTION_PATH."news/article?nid=".$n2_hashed;
                                $new_cover_image2 = (!empty($n2_cover_image)) ? UPLOAD_PATH."news/".$n2_cover_image : UPLOAD_PATH."templates/no_photo.png";
                            ?>
                    <div class="col-6 col-lg-4 col-md-4 col-sm-6 post_card_md p-0">
                        <div class="post_card_content_md mb-1 mb-lg-0 mb-md-0 mb-sm-1  h-100">
                            <div class="card  h-100">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="img_container_md">
                                            <img class="d-block w-100 fluid_img noselect" src="<?php echo $new_cover_image2; ?>" alt="<?php echo $n2_title; ?>">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card-block py-5 px-4">
                                            <h6 class="post_category py-2"><span><a href="#">By <?php echo $n2_author; ?></a></span> | <?php echo $n2_date; ?></h6>
                                            <p class="post_title pb-3"><a href="<?php echo $news_page_url2; ?>"><?php echo $n2_title; ?></a></p>
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
                            <span class="bg-secondary px-4 py-3 d-block w-100"><strong>Nothing to show under this section. Explore other sections.</strong></span>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <div class="row" id="award_news_data">
                    <!-- 3 Music award blog loaded here -->
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

<!-- Footer section -->
<?php require_once(LAYOUTS_PATH . "/main_footer.php"); ?>


<script>
    // Fetch news and hide
    $(document).ready(function() {
        let category = '3music awards';
        let action = 'fetch_news_category';
        let all_displayed_news_arr = '<?php echo $qry = (!empty($news_displayed_array2)) ? implode(" , ", $news_displayed_array2)." , ".$search_string1 : $search_string1;   ?>';
        function load_awd_data() {
            $.ajax({
                url: "../news/fetch_news_category.php",
                method: "POST",
                cache: true,
                data: { 'action': action, 'category': category, 'displayed_array': all_displayed_news_arr },
                success: function(data) {
                    $("#culture_news_data").html(data);
                }
            });
        }
        load_awd_data();
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
 

<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>
