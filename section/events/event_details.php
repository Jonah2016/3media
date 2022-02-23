<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    // Get URL
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $cur_page_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Retrieve events details
    $a_key    = strip_tags($_GET['eid']);
    $b_key    = stripslashes($a_key);
    $c_key    = htmlspecialchars($b_key, ENT_QUOTES);
    $hash_key = strip_tags($c_key);
    if (empty($hash_key)) {
        header("location:javascript://history.go(-1)");
        exit;
    } else {
        // Retrieve all event data by hashed key from event class
        $event_class = new EventController(['eve_hashed' => $hash_key]);
        $events = $event_class->getEvent();
        if(count($events) > 0) {
            foreach ($events as $key => $event) {
                $eve_enable_ticket_sales = $event['eve_enable_ticket_sales'];
                $eve_ticket_hashed       = $event['eve_ticket_hashed'];
                $eve_hashed              = $event['eve_hashed'];
                $eve_name                = htmlspecialchars_decode($event['eve_name']);
                $eve_description         = htmlspecialchars_decode($event['eve_description']);
                $eve_location            = $event['eve_location'];
                $eve_map_location        = $event['eve_map_location'];
                $eve_venue               = $event['eve_venue'];
                $eve_rating              = $event['eve_rating'];
                $eve_organiser           = $event['eve_organiser'];
                $eve_organiser_logo      = $event['eve_organiser_logo'];
                $eve_fb_link             = $event['eve_fb_link'];
                $eve_twitter_link        = $event['eve_twitter_link'];
                $eve_ig_link             = $event['eve_ig_link'];
                $eve_tags                = $event['eve_tags'];
                $eve_banner              = $event['eve_banner'];
                $eve_image1              = $event['eve_image1'];
                $eve_image2              = $event['eve_image2'];
                $eve_yt_video_link       = $event['eve_yt_video_link'];
                $eve_start_date          = $event['eve_start_date'];
                $eve_end_date            = $event['eve_end_date'];
                $eve_start_time          = $event['eve_start_time'];
                $eve_end_time            = $event['eve_end_time'];
                $eve_audience            = $event['eve_audience'];

                $eve_start_date          = $event['eve_start_date'];
                $eve_ticket_name1        = $event['eve_ticket_name1'];
                $eve_ticket_price1       = $event['eve_ticket_price1'];
                $eve_ticket_quantity1    = $event['eve_ticket_quantity1'];
                $eve_ticket_name2        = $event['eve_ticket_name2'];
                $eve_ticket_price2       = $event['eve_ticket_price2'];
                $eve_ticket_quantity2    = $event['eve_ticket_quantity2'];
                $eve_ticket_name3        = $event['eve_ticket_name3'];
                $eve_ticket_price3       = $event['eve_ticket_price3'];
                $eve_ticket_quantity3    = $event['eve_ticket_quantity3'];
                $eve_ticket_name4        = $event['eve_ticket_name4'];
                $eve_ticket_price4       = $event['eve_ticket_price4'];
                $eve_ticket_quantity4    = $event['eve_ticket_quantity4'];
                $eve_start_sales_on      = $event['eve_start_sales_on'];
                $eve_ends_sales_on       = $event['eve_ends_sales_on'];
                $eve_ticket_image        = $event['eve_ticket_image'];
                $eve_ticket_desc1        = $event['eve_ticket_desc1'];
                $eve_ticket_desc2        = $event['eve_ticket_desc2'];
                $eve_ticket_desc3        = $event['eve_ticket_desc3'];
                $eve_ticket_desc4        = $event['eve_ticket_desc4'];
                $eve_updated_at          = $event['eve_updated_at'];

                $new_eve_banner = (!empty($eve_banner)) ? UPLOAD_PATH."events/".$eve_banner : UPLOAD_PATH."templates/no_photo.png";
                $new_eve_image1 = (!empty($eve_image1)) ? UPLOAD_PATH."events/".$eve_image1 : UPLOAD_PATH."templates/no_photo.png";
                $new_eve_image2 = (!empty($eve_image2)) ? UPLOAD_PATH."events/".$eve_image2 : UPLOAD_PATH."templates/no_photo.png";

                $eve_date        = date_create($eve_start_date);
                $neo_eve_update  = date_format($eve_date,"M d, Y H:i:s");

                $update_date     = date_create($eve_updated_at);
                $neo_last_update = date_format($update_date,"M d, Y H:i:s");

                $sales_start     = date_create($eve_start_sales_on);
                $neo_sales_start = date_format($sales_start,"M d, Y H:i:s");

                $sales_ends      = date_create($eve_ends_sales_on);
                $neo_sales_ends  = date_format($sales_ends,"M d, Y H:i:s");

                // Check if ticket sales is oppened
                $nowDate     = date('Y-m-d');
                $nowDate     =date('Y-m-d', strtotime($nowDate));
                $salesStart  = date('Y-m-d', strtotime($eve_start_sales_on));
                $saleEnd     = date('Y-m-d', strtotime($eve_ends_sales_on));
                if ($eve_enable_ticket_sales == 1) {
                    $sales_opend = (($nowDate >= $salesStart) && ($nowDate <= $saleEnd)) ? true : false;
                } else {
                    $sales_opend = false;
                }

                $date          = date_create($eve_start_date." ".$eve_start_time);
                $neo_date      = date_format($date,"M d, Y H:i:s");
                $neo_date_only = date_format($date,"M d, Y");
                $neo_time_only = date_format($date,"H:i:s A");

                $tick_pag_url  = SECTION_PATH."tickets/?tid=".$eve_hashed;
            }
        }
    }

    $og_title        = "Event: ".$eve_name;
    $og_image        = $new_eve_banner;
    $og_url          = $cur_page_url;
    $og_description  = $eve_name;
    $page_title      = "Event: ".$eve_name;
    $event_active     = 'active';
    $event_per_active = 'active';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php");
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    $page_name = 'news-page';
?>

<style>
    <?php include_once("./event.css");  ?>
</style>

<!-- body -->
<div class="page_content ">
    <div class="container bg_white event_details_container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 boder_right_dark">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 box">
                        <div class="mx-3 mt-2 mb-3 event_det_title">
                            <h3 class="p-4 text-center"><?php echo $eve_name; ?></h3>
                        </div>  
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 width_height_sm mx-auto"> 
                        <div class="event_image_div d-flex align-items-center justify-content-center">
                            <div class="event_max_wh" style="background-image: url(<?php echo $new_eve_banner; ?>);"></div>
                            <a class="btn btn-lg shadow event_ticket_button top-50 position-absolute text-center" href="<?php echo $tick_pag_url; ?>">Buy Your Ticket</a>
                        </div>
                        <div class="row event_time_and_location">
                            <div class="col-lg-6 col-md-6 col-sm-12 event_time">
                                <div class="row">
                                    <div class="col-6 col-lg-6 col-md-6 col-sm-6">
                                        <div class="calender"><i class="bi bi-calendar3"></i></div>
                                    </div>
                                    <div class="col-6 col-lg-6 col-md-6 col-sm-6">
                                        <div class="pt-4 calender_desc">
                                            <h4>When ?</h4>
                                            <!-- display date of event -->
                                            <h4 id="displayDate"><?php echo $neo_date_only; ?></h4>
                                            <h3 class="mt-1">Starting at: <?php echo $neo_time_only; ?></h3>
                                        </div>
                                    </div>
                                </div> 
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 event_location">
                                <div class="row">
                                    <div class="col-6 col-lg-6 col-md-6 col-sm-6">
                                        <div class="pt-4 px-2 location_desc">
                                            <h4>Where ?</h4>
                                            <h4><?php echo $eve_venue; ?></h4>
                                            <h3 class="mt-1 fw-bold"><?php echo $eve_location; ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-6 col-md-6 col-sm-6">
                                        <a target="__blank" href="https://www.google.com/maps/place/<?php echo $eve_location; ?>/"><div class="second_calender"><i class="bi bi-geo-alt"></i></div></a>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 box mb-4 mt-4 width_height_sm mx-auto">
                        <div class="row">
                            <div class="latest_event_description">
                                <?php 
                                    if (!empty($eve_description)) {
                                        echo $eve_description;
                                    }else{
                                ?>
                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 w-100 mx-auto">
                                    <div class="show_exhausted" >
                                        <span class="bg-secondary text_white px-4 py-3 w-100 d-block"><strong>No event dscription found.</strong></span>
                                    </div>
                                </div>
                                <?php
                                    }
                                ?>
                            </div>
                        
                            <?php if (!empty($eve_image1) || !empty($eve_image2)): ?>
                            <div class="row d-flex align-items-center">
                                <?php if (!empty($eve_image1)): ?>
                                <div class="col-12 col-lg-6 col-md-6 col-sm-12 other_banner">
                                    <div class="py-2">
                                        <img class="fluid_img" src="<?php echo $new_eve_image1; ?>">
                                    </div>
                                </div>
                                <?php endif ?>
                                <?php if (!empty($eve_image2)): ?>
                                <div class="col-12 col-lg-6 col-md-6 col-sm-12 other_banner">
                                    <div class="py-2">
                                        <img class="fluid_img" src="<?php echo $new_eve_image2; ?>">
                                    </div>
                                </div>
                                <?php endif ?>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>            
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 px-0 similar_events">
                <div class="mx-3 rounded my-2 mt-5">
                    <h3 class="d-flex justify-content-start eve_similar_title pb-3">Similar Events</h3>
                    <?php
                        $events = $EVENTS_DATA;
                        if(count($events) > 1) {
                            $sliced_eve_array1 = array_slice($events, 1, 6, true);
                            foreach ($sliced_eve_array1 as $key => $event) {
                                $eve_hashed1     = $event['eve_hashed'];
                                $eve_name1       = htmlspecialchars_decode($event['eve_name']);
                                $eve_category1   = $event['eve_category'];
                                $eve_rating1     = $event['eve_rating'];
                                $eve_venue1      = $event['eve_venue'];
                                $eve_banner1     = $event['eve_banner'];
                                $eve_start_date1 = $event['eve_start_date'];
                                $eve_start_time1 = $event['eve_start_time'];

                                $date1     = date_create($eve_start_date1." ".$eve_start_time1);
                                $neo_date1 = date_format($date1,"M d, Y H:i:s");

                                $eve_pag_url1 = SECTION_PATH."events/event_details?eid=".$eve_hashed1;
                                $new_eve_banner1 = (!empty($eve_banner1)) ? UPLOAD_PATH."events/".$eve_banner1 : UPLOAD_PATH."templates/no_photo.png";
                    ?> 
                    <div class="pb-3 d-flex justify-content-center">
                        <div class="card w-100">
                            <img src="<?php echo $new_eve_banner1; ?>" class="card-img-top" alt="<?php echo $eve_name1; ?>">
                            <div class="card-body">
                                <h3 class="card-text fw-bold fs-4"><a href="<?php echo $eve_pag_url1; ?>"><?php echo $eve_name1; ?></a></h3>
                                <h3 class="card-text pt-2"><i class="bi bi-calendar3 fs-6"></i> <?php echo $neo_date1; ?></h3>
                                <h3 class="card-text pt-2"><i class="bi bi-geo-alt fs-6"></i> <?php echo $eve_venue1; ?></h3>
                            </div>
                        </div>
                    </div>
                    <?php
                            }
                        } else {
                    ?> 
                    <div class=" w-100 mx-auto">
                        <div class="show_exhausted" >
                            <span class="bg-secondary text_white px-4 py-3 w-100 d-block"><strong>No similar events found.</strong></span>
                        </div>
                    </div>
                    <?php
                            }
                    ?> 
                </div>
            </div>    
        </div>
    </div>         
</div>


<!-- footer -->
<?php 
require_once(LAYOUTS_PATH . "/main_footer.php"); 
require_once(LAYOUTS_PATH . "/footer.php"); 
?>
