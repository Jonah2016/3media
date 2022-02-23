<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    $page_title   = 'Events: Upcoming events';
    $event_active = 'active';
    $page_name    = 'events-page';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php"); 
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");
?>

<style>
    <?php include_once("./event.css");  ?>
</style>

<!-- body -->
<div class="page_content">
    <div class="container">
        <div class="row align-items-center mobile_view">
            <div class="col-lg-12 col-md-12 col-sm-12 mt-3 event_col">
                <div class="row">
                    <?php  
                        $events = $EVENTS_DATA;
                        if(count($events) > 0) {
                            $sliced_eve_array = array_slice($events, 0, 1, true);
                            foreach ($sliced_eve_array as $key => $event) {
                                $eve_hashed              = $event['eve_hashed'];
                                $eve_name                = htmlspecialchars_decode($event['eve_name']);
                                $eve_category            = $event['eve_category'];
                                $eve_description         = $event['eve_description'];
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
                                $eve_enable_ticket_sales = $event['eve_enable_ticket_sales'];
                                $eve_ticket_hashed       = $event['eve_ticket_hashed'];
                                $eve_ticket_image        = $event['eve_ticket_image'];
                                $eve_audience            = $event['eve_audience'];

                                $date          = date_create($eve_start_date." ".$eve_start_time);
                                $neo_date      = date_format($date,"M d, Y H:i:s");
                                $neo_date_only = date_format($date,"M d, Y");
                                $neo_time_only = date_format($date,"H:i:s A");

                                $neo_eve_pag_url = SECTION_PATH."events/event_details?eid=".$eve_hashed;
                                $neo_eve_banner = (!empty($eve_banner)) ? UPLOAD_PATH."events/".$eve_banner : UPLOAD_PATH."templates/no_photo.png";
                    ?>
                    <div class="col-12 bg_black">
                        <div class="row event_image d-flex align-items-center justify-content-center">
                            <div class="event_background">
                                <h3 class="pb-3 pt-4 event_title shadow"><a class="text-white" href="<?php echo $neo_eve_pag_url; ?>"><?php echo $eve_name; ?></a></h3> 
                                <!-- countdown start-->
                                <div class="m-3">
                                    <div id="countdown" class="count_down" data-date="<?php echo $neo_date; ?>">
                                        <ul class="">
                                            <li class="p-3 mb-1 bg_light clean_shadow count_down_item"><span id="days"></span>Days</li>
                                            <li class="p-3 mb-1 bg_light clean_shadow count_down_item"><span id="hours"></span>Hours</li>
                                            <li class="p-3 mb-1 bg_light clean_shadow count_down_item"><span id="minutes"></span>Minutes</li>
                                            <li class="p-3 mb-1 bg_light clean_shadow count_down_item"><span id="seconds"></span>Seconds</li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- countdown end-->
                                <a class="btn btn-lg event_ticket_button mx-1 text_primary mt-3 mb-5 shadow" href="<?php echo $neo_eve_pag_url; ?>">Veiw Details</a>
                                <a class="btn btn-lg event_ticket_button mx-1 text_primary mt-3 mb-5 shadow" href="<?php echo SECTION_PATH.'tickets/?tid='.$eve_hashed; ?>">Buy Ticket</a>
                            </div>
                        </div>
                    </div>                    
                    <div class="col-lg-6 col-sm-6 event_time" data-aos="fade-down-right">
                        <div class="calender"><i class="bi bi-calendar3"></i></div>
                        <div class="width_sm position-absolute top-0 end-0">
                            <div class="px-4 py-3 calender_desc">
                                <h4>When ?</h4>
                                <!-- display date of event -->
                                <h4 id="displayDate"><?php echo $neo_date_only; ?></h4>
                                <h3 class="mt-1">Starting at: <?php echo $neo_time_only; ?></h3>
                            </div>    
                        </div>    
                    </div>
                    <div class="col-lg-6 col-sm-6 event_location" data-aos="fade-down-left">
                        <a target="__blank" href="https://www.google.com/maps/place/<?php echo $eve_location; ?>/"><div class="second_calender"><i class="bi bi-geo-alt"></i></div></a>
                        <div class="width_sm position-absolute top-0 start-0">
                            <div class="px-4 py-3 location_desc">
                                <h4>Where ?</h4>
                                <h4><?php echo $eve_venue; ?></h4>
                                <h3 class="mt-1 fw-bold"><?php echo $eve_location; ?></h3>
                            </div>
                        </div>
                    </div>
                    <?php
                            }
                        }
                    ?>    
                </div> 
                <div class="row row_color">
                    <h3 class="header_h3 text_black mt-3">Upcoming Events</h3>
                    <?php
                        $events = $EVENTS_DATA;
                        if(count($events) > 1) {
                            $sliced_eve_array1 = array_slice($events, 1, 50, true);
                            foreach ($sliced_eve_array1 as $key => $event) {
                                $eve_hashed              = $event['eve_hashed'];
                                $eve_name                = htmlspecialchars_decode($event['eve_name']);
                                $eve_category            = $event['eve_category'];
                                $eve_description         = $event['eve_description'];
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
                                $eve_enable_ticket_sales = $event['eve_enable_ticket_sales'];
                                $eve_ticket_hashed       = $event['eve_ticket_hashed'];
                                $eve_ticket_image        = $event['eve_ticket_image'];
                                $eve_audience            = $event['eve_audience'];
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

                                $date          = date_create($eve_start_date." ".$eve_start_time);
                                $neo_date      = date_format($date,"M d, Y H:i:s");
                                $neo_date_only = date_format($date,"M d, Y");
                                $neo_time_only = date_format($date,"H:i:s A");

                                $eve_pag_url = SECTION_PATH."events/event_details?eid=".$eve_hashed;
                                $new_eve_banner = (!empty($eve_banner)) ? UPLOAD_PATH."events/".$eve_banner : UPLOAD_PATH."templates/no_photo.png";
                    ?> 
                    <div class="col-lg-4 my-3" data-aos="fade-down-left">
                        <div class="card h-100" style="width: 100%;">
                            <div class="image-hover">
                                <img src="<?php echo $new_eve_banner; ?>" class="card-img-top eve_image_section" alt="<?php echo $eve_name; ?>">
                            </div>
                            <div class="card-body">
                                <div class="row d-flex justify-content-center pb-2">
                                    <?php if (!empty($eve_ticket_name1)): ?>
                                       <div class= "col mb-1">
                                           <div class="h-100 p-1 text-uppercase ticket_price">
                                               <h3 class="p-1"><?php echo $eve_ticket_name1; ?></h3>
                                               <h3 class="p-1"><?php echo DEFAULT_CURRENCY." ".$eve_ticket_price1; ?></h3>
                                           </div>
                                       </div> 
                                    <?php endif ?>
                                    <?php if (!empty($eve_ticket_name2)): ?>
                                       <div class= "col mb-1">
                                           <div class="h-100 p-1 text-uppercase ticket_price">
                                               <h3 class="p-1"><?php echo $eve_ticket_name2; ?></h3>
                                               <h3 class="p-1"><?php echo DEFAULT_CURRENCY." ".$eve_ticket_price2; ?></h3>
                                           </div>
                                       </div> 
                                    <?php endif ?>
                                    <?php if (!empty($eve_ticket_name3)): ?>
                                       <div class= "col mb-1">
                                           <div class="h-100 p-1 text-uppercase ticket_price">
                                               <h3 class="p-1"><?php echo $eve_ticket_name3; ?></h3>
                                               <h3 class="p-1"><?php echo DEFAULT_CURRENCY." ".$eve_ticket_price3; ?></h3>
                                           </div>
                                       </div> 
                                    <?php endif ?>
                                    <?php if (!empty($eve_ticket_name4)): ?>
                                       <div class= "col mb-1">
                                           <div class="h-100 p-1 text-uppercase ticket_price">
                                               <h3 class="p-1"><?php echo $eve_ticket_name4; ?></h3>
                                               <h3 class="p-1"><?php echo DEFAULT_CURRENCY." ".$eve_ticket_price4; ?></h3>
                                           </div>
                                       </div> 
                                    <?php endif ?>
                                </div>
                                <div class="h-100">
                                    <h3 class="my-2 latest_event_name fs-4"><a href="<?php echo $eve_pag_url; ?>"><?php echo $eve_name; ?></a></h3>
                                    <div class="my-3"><i class="bi bi-map"></i><span class="px-2 fw-bold"><?php echo $eve_location; ?></span></div>
                                    <div class="my-3 event_date"><i class="bi bi-calendar-event"></i><span class="px-2 fw-bold"><?php echo $neo_date; ?></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                            }
                        } else {
                    ?>
                    <div class="col-12 boder_all_grey">
                        <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>No upcoming events to display now. Visit again later. </strong></span></div>
                    </div>
                    <?php } ?>         
                </div>
            </div>
        </div>
    </div>         
</div>

<script src="https://rawgit.com/ckrack/scrollsnap-polyfill/develop/dist/scrollsnap-polyfill.bundled.js"></script>


<script>
    const event_url = "./Event.js";
    $.getScript(event_url);
</script>

<!-- footer -->
<?php 
    require_once(LAYOUTS_PATH . "/main_footer.php"); 
    require_once(LAYOUTS_PATH . "/footer.php"); 
?>
