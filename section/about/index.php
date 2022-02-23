<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    $page_title = 'About: Learn More About History, Description of 3Music';
    $about_active = 'active';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php"); 
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    // Retrieve about details
    $abt_organisation_name = "";
    $abt_brief_description = "";
    $abt_full_description  = "";
    $abt_photo_one         = "";
    $abt_photo_two         = "";
    $abt_photo_three       = "";
    $cover_photo           = "";
    $abt_photo_two         = "";
    $abt_photo_three       = "";

    $stmt01 = $db_connect->prepare("SELECT abt_organisation_name, abt_brief_description, abt_full_description, abt_photo_one, abt_photo_two, abt_photo_three FROM about_page ");           
    $stmt01->execute();
    if($stmt01->rowCount() > 0)
    {
        while($row01=$stmt01->fetch(PDO::FETCH_ASSOC))
        {
            $abt_organisation_name = $row01['abt_organisation_name'];
            $abt_brief_description = $row01['abt_brief_description'];
            $abt_full_description  = $row01['abt_full_description'];
            $abt_photo_one         = $row01['abt_photo_one'];
            $abt_photo_two         = $row01['abt_photo_two'];
            $abt_photo_three       = $row01['abt_photo_three'];

            if (!empty($abt_photo_one)) { $cover_photo = UPLOAD_PATH."system/".$abt_photo_one; } else { $cover_photo = ASSETS_PATH."/img/about_bg.webp"; }
            if (!empty($abt_photo_two)) { $abt_photo_two = UPLOAD_PATH."system/".$abt_photo_two; } else { $abt_photo_two = ASSETS_PATH."/img/logo.png"; }
            if (!empty($abt_photo_three)) { $abt_photo_three = UPLOAD_PATH."system/".$abt_photo_three; } else { $abt_photo_three = ASSETS_PATH."/img/logo.png"; }
        }
    }

    $page_name = 'about-page';
 
?>
<style>
    <?php include_once("./about.css");  ?>
</style>

<div class="page_content">
    <!-- Hero section -->
    <section class="hero_banner noselect">
        <div class="overlay"></div>
        <div class="tint"></div>
        <div class="hero_banner_image_container"><img class="fluid_img hero_banner_image" src="<?php echo $cover_photo; ?>"></div>
        <div class="container h-100 hero_banner_text">
            <div class="d-flex text-center align-items-center">
                <div class="w-100">
                    <h1 class="hero_banner_title">
                        <span class="hero_banner_title_text">3music.tv</span>
                    </h1>
                    <h2 class="hero_banner_title_sm" style="">
                        <span class="hero_banner_title_text"><i class="fas fa-quote-left"></i> here for the music <i class="fas fa-quote-right"></i></span>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <section class="mission_section bg_light">
        <div class="container-lg px-lg-5 px-md-5 px-sm-3 px-3">
            <div class="section_title">
                <h2>Our Mission</h2>
            </div>
            <div class="mission_content">
                <p>"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.  "</p>
                <div class="pt-2" id="showMoreAbout">
                    <div id="collapseAboutFull" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#showMoreAbout">
                        <div class="section_title pt-5">
                            <h2>Our Story</h2>
                        </div>
                        <p style="font-size: 1.25rem !important;"><?php echo $abt_full_description; ?></p>
                    </div>
                    <a id="headingOne" href="#" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAboutFull" aria-expanded="true" aria-controls="collapseAboutFull" >Learn more about our story <i class="bi bi-arrow-right-square bi-middle"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Minor about section 1 -->
    <section id="about_section_minor" class="about_section_minor ">
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <div class="row gx-0">
                <div class="col-lg-6 d-flex flex-column justify-content-center aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                    <div class="content p-5">
                        <h2>3music.tv</h2>
                        <h4><i class="fas fa-quote-left"></i> <span class="p-2">Get instant access to what's trending, no matter where you are. Our team's recommendations for news, sports, entertainment, and music are your go-to sources. </span><i class="fas fa-quote-right"></i></h4>
                        <div class="text-center text-lg-start mt-4">
                            <a href="<?php echo SECTION_PATH.'news/'; ?>" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                                <span>Explore</span><i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center aos-init aos-animate right_img_container" data-aos="zoom-out" data-aos-delay="200">
                    <img src="<?php echo $abt_photo_two; ?>" class="fluid_img right_img" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- Subscription section -->
    <div class="bg_light"><?php require_once(COMPONENT_PATH.'/Subscription.php'); ?></div>

    <!-- Minor about section 2 -->
    <section id="about_section_minor" class="about_section_minor ">
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <div class="row gx-0">
                <div class="col-lg-6 d-flex align-items-center aos-init aos-animate " data-aos="zoom-out" data-aos-delay="200">
                    <div class="video_container">
                        <iframe class="video" src="https://www.youtube.com/embed/Nq5Vn2ZyhEs?autoplay=0&showinfo=0&controls=0" title="3music.tv video" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture; autoplay; modestbranding;" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-lg-6 d-flex flex-column justify-content-center aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                    <div class="content p-5">
                        <h2>3music awards</h2>
                        <h4><i class="fas fa-quote-left"></i> <span class="p-2">Take a look at some of the great footage from our yearly flagship awards ceremony. See recent nominations and recent winners, as well as related news and blogs. </span><i class="fas fa-quote-right"></i></h4>
                        <div class="text-center text-lg-start mt-4">
                            <a href="<?php echo SECTION_PATH.'award/'; ?>" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                                <span>Explore</span><i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News swiper section -->
    <div class="bg_light more_news_section">
        <div class="container">
            <div class="section_title"><h2>News</h2></div>
            <div><?php include_once(COMPONENT_PATH.'/NewsSlider.php'); ?></div>
        </div>
    </div>

    <div class="gototop js-top"> <a href="#" class="js-gotop"><i class="fa fa-arrow-up"></i></a></div>
</div>
<?php require_once(LAYOUTS_PATH . "/main_footer.php"); ?>


<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>