<!-- ============= NAVBAR COMPONENT ============== -->
<nav class="navbar navbar-expand-lg sticky-top navbar-dark nav_wrapper noselect">
<div class="container navbar_container">
    <a class="navbar-brand text-dark navbar_logo" href="<?php echo BASE_PATH; ?>"><img height="100%" width="45px" src="<?php echo ASSETS_PATH."/img/logo_sk_white.png"; ?>" alt="3Music"></a>
    <div class="nav-item px-4">
        <?php if (count($_SESSION["cart_item"]) > 0): ?>
        <a href="<?php echo SECTION_PATH.'tickets/ticket_checkout'; ?>" title="your cart items" class="position-relative"><i class="bi bi-cart3 fs-3 text-light"></i><span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-secondary" id="cartTotalDisplay"><?php echo count($_SESSION["cart_item"]); ?></span></a>
        <?php endif ?>
    </div>
    <div id="fadeShow">
        <button class="btn icon icon--transparent" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"  aria-expanded="false" aria-label="Toggle navigation" aria-controls="navbarSupportedContent">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    <div class="collapse navbar-collapse" id="main_nav">
        <ul class="navbar-nav nav_btn_container">
            <li class="nav-item <?php if (isset($home_active)) { echo $home_active; } ?>"> <a class="nav-link" href="<?php echo BASE_PATH; ?>">Home </a> </li>
            <li class="nav-item <?php if (isset($snap_active)) { echo $snap_active; } ?>"><a class="nav-link" href="<?php echo SECTION_PATH; ?>snap_shots/"> Snap Shots </a></li>
            <li class="nav-item <?php if (isset($news_active)) { echo $news_active; } ?>"><a class="nav-link" href="<?php echo SECTION_PATH; ?>news/"> News </a></li>
            <li class="nav-item <?php if (isset($music_active)) { echo $music_active; } ?>"><a class="nav-link" href="<?php echo SECTION_PATH; ?>music/"> Music </a></li>
            <li class="nav-item <?php if (isset($videos_active)) { echo $videos_active; } ?>"><a class="nav-link" href="<?php echo SECTION_PATH; ?>videos/"> Videos </a></li>
            <li class="nav-item <?php if (isset($award_active)) { echo $award_active; } ?>"><a class="nav-link" href="<?php echo SECTION_PATH; ?>award/"> 3Music Awards </a></li>
            <li class="nav-item <?php if (isset($event_active)) { echo $event_active; } ?>"><a class="nav-link" href="<?php echo SECTION_PATH; ?>events/"> Events </a></li>
            <li class="nav-item dropdown has-megamenu">
                <a class="nav-link megamenu_icon" href="#" data-bs-toggle="dropdown"><i class="fas fa-bars"></i></a>
                <div class="dropdown-menu megamenu" id="megamenu1" role="menu">
                    <div class="container">
                        <div class="row">
                            <div class="col-2 col-lg-3 col-md-3 col-sm-2">
                                <a class="megamenu_logo" href="<?php echo BASE_PATH; ?>"><img src="<?php echo ASSETS_PATH.'/img/logo.png'; ?>" alt="Logo"></a>
                            </div>
                            <div class="col-8 col-lg-6 col-md-6 col-sm-8">
                                <form class="megamenu_search_form" method="POST" action="<?php echo SECTION_PATH; ?>search/" novalidate enctype="multipart/form-data" accept-charset="utf-8">
                                    <div class="input-group mb-1 border rounded-pill">
                                        <input type="text" placeholder="Search 3music.tv" name="search_param" class="form-control bg-none border-0">
                                        <div class="input-group-append border-0">
                                            <button id="button-addon3" type="submit" name="search" class="btn btn-link text-light"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-2 col-lg-3 col-md-3 col-sm-2">
                                <a type="button" data-bs-toggle="collapse" data-bs-target="#megamenu1" aria-label="close menu" class="btn btn-lg megamenu_close_btn"><i class="bi bi-x text-light"></i></a>
                            </div>
                        </div>
                        <div class="row g-3 megamenu_content mb-5">
                            <div class="col-lg-3 col-6">
                                <div class="col-megamenu">
                                    <h6 class="megamenu_title px-2">Sections</h6>
                                    <ul class="list-unstyled">
                                        <li class="nav-item megamenu_list <?php if (isset($home_active)){ echo $home_active; } ?>">
                                            <a class="nav-link px-2" href="<?php echo BASE_PATH; ?>">Home </a> 
                                        </li>
                                        <li class="nav-item megamenu_list <?php if (isset($snap_active)){ echo $snap_active; } ?>">
                                            <a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>snap_shots/"> Snap-shots </a>
                                        </li>
                                        <li class="nav-item megamenu_list <?php if (isset($news_active)) { echo $news_active; } ?>">
                                            <a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>news/"> News </a>
                                        </li>
                                        <li class="nav-item megamenu_list <?php if (isset($music_active)) { echo $music_active; } ?>">
                                            <a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>music/"> Music </a>
                                        </li>
                                        <li class="nav-item megamenu_list <?php if (isset($videos_active)) { echo $videos_active; } ?>">
                                            <a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>videos/"> Videos </a>
                                        </li>
                                        <li class="nav-item megamenu_list <?php if (isset($award_active)) { echo $award_active; } ?>">
                                            <a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>award/"> 3Music Awards </a>
                                        </li>
                                        <li class="nav-item megamenu_list <?php if (isset($event_active)) { echo $event_active; } ?>">
                                            <a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>events/"> Events </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="col-megamenu">
                                    <h6 class="megamenu_title px-2">News</h6>
                                    <ul class="list-unstyled">
                                        <li class="nav-item megamenu_list <?php if (isset($news_lts_active)) { echo $news_lts_active; } ?>">
                                            <a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>news/">Latest</a>
                                        </li>
                                        <li class="nav-item megamenu_list <?php if (isset($news_ent_active)) { echo $news_ent_active; } ?>">
                                            <a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>news/entertainment">Entertainment</a>
                                        </li>
                                        <li class="nav-item megamenu_list <?php if (isset($news_spt_active)) { echo $news_spt_active; } ?>">
                                            <a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>news/sports">Sports</a>
                                        </li>
                                        <li class="nav-item megamenu_list <?php if (isset($news_fas_active)) { echo $news_fas_active; } ?>">
                                            <a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>news/fashion_lifestyle">Fashion & Lifestyle</a>
                                        </li>
                                        <li class="nav-item megamenu_list <?php if (isset($news_cul_active)) { echo $news_cul_active; } ?>">
                                            <a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>news/culture">Culture</a>
                                        </li>
                                        <li class="nav-item megamenu_list <?php if (isset($music_active)) { echo $music_active; } ?>">
                                            <a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>music/">Music</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="col-megamenu">
                                    <h6 class="megamenu_title">Follow us on</h6>
                                    <ul class="list-unstyled">
                                        <li class="nav-item megamenu_list"><i class="text-light bi bi-facebook bi-center pr-2"> </i> <a class="nav-link px-2" target="__blank" href="https://web.facebook.com/3musicnetworks">Facebook</a></li>
                                        <li class="nav-item megamenu_list"><i class="text-light bi bi-twitter bi-center pr-2"> </i> <a class="nav-link px-2" target="__blank" href="https://twitter.com/3musicnetworks">Twitter</a></li>
                                        <li class="nav-item megamenu_list"><i class="text-light bi bi-youtube bi-center pr-2"> </i> <a class="nav-link px-2"  target="__blank" href="https://www.youtube.com/3MUSICNetworks/">Youtube</a></li>
                                        <li class="nav-item megamenu_list"><i class="text-light bi bi-instagram bi-center pr-2"> </i> <a class="nav-link px-2" target="__blank" href="https://www.instagram.com/3musicnetworks/">Instagram</a></li>
                                        <li class="nav-item megamenu_list"><i class="text-light fab fa-tiktok pr-2"> </i> <a class="nav-link px-2" target="__blank" href="https://www.tiktok.com/@3music.tv?lang=en">Tiktok</a></li> 
                                        <li class="nav-item megamenu_list <?php if (isset($contact_active)) { echo $contact_active; } ?> pt-1"><a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>contact/">Contact us</a></li>
                                    </ul>
                                </div>
                            </div>    
                            <div class="col-lg-3 col-6">
                                <div class="col-megamenu">
                                    <h6 class="megamenu_title">3Music Awards</h6>
                                    <ul class="list-unstyled">
                                        <li class="nav-item megamenu_list <?php if (isset($award_news_active)) { echo $award_news_active; } ?>"><a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>award/ ?>">Latest News</a></li>
                                        <li class="nav-item megamenu_list <?php if (isset($award_nom_active)) { echo $award_nom_active; } ?>"><a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>award/nominees">Nominees</a></li>
                                        <li class="nav-item megamenu_list <?php if (isset($award_win_active)) { echo $award_win_active; } ?>"><a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>award/winners">Winners</a></li>
                                        <li class="nav-item megamenu_list <?php if (isset($award_abt_active)) { echo $award_abt_active; } ?>"><a class="nav-link px-2" href="<?php echo SECTION_PATH; ?>award/about_awards">About the Award</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row"><hr class="bg-light text-light"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Suscription -->
                                <?php include(COMPONENT_PATH.'/SubscriptionHorizontalNoAd1.php') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto nav_right_side">
            <?php if ($sett_data['sett_voting_opened'] == 1): ?>
            <li class="nav-item px-3 py-2 bg_primary nav_link_award shake <?php if(isset($award_vot_active)){ echo $award_vot_active; } ?>"><a class="" href="<?php echo SECTION_PATH.'award/voting'; ?>"> Voting Opened</a></li>
            <?php endif ?>
            <li class="nav-item"><a class="soc-link" target="__blank" href="https://web.facebook.com/3musicnetworks"> <i class="bi bi-facebook bi-center"></i> </a></li>
            <li class="nav-item"><a class="soc-link" target="__blank" href="https://twitter.com/3musicnetworks"> <i class="bi bi-twitter bi-center"></i> </a></li>
            <li class="nav-item"><a class="soc-link" target="__blank" href="https://www.youtube.com/3MUSICNetworks/"> <i class="bi bi-youtube bi-center"></i> </a></li>
            <li class="nav-item"><a class="soc-link" target="__blank" href="https://www.instagram.com/3musicnetworks/"> <i class="bi bi-instagram bi-center"></i> </a></li>
            <li class="nav-item"><a class="soc-link" target="__blank" href="https://www.tiktok.com/@3music.tv?lang=en"> <i class="fab fa-tiktok "></i> </a></li>
        </ul>
    </div>
</div>
</nav>
<!-- ============= NAVBAR COMPONENT END// ============== -->

<!-- Page Wrapper -->
<div class="page_wrapper">
    
