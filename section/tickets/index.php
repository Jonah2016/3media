<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    // Get URL
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $cur_page_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Retrieve ticket hash id details
    $a_key    = strip_tags($_GET['tid']);
    $b_key    = stripslashes($a_key);
    $c_key    = htmlspecialchars($b_key, ENT_QUOTES);
    $hash_key = strip_tags($c_key);
    if (empty($hash_key)) {
        header("location:javascript://history.go(-1)");
        exit;
    } else {
            $eve_hashed = null;
            // Retrieve all news data by hashced key from News class
            $event_class = new EventController(['eve_hashed' => $hash_key]);
            $tickets = $event_class->getEvent();
            if(count($tickets) > 0) {
                foreach ($tickets as $key => $ticket) {
                    $eve_enable_ticket_sales = $ticket['eve_enable_ticket_sales'];
                    $eve_ticket_hashed       = $ticket['eve_ticket_hashed'];
                    $eve_hashed              = $ticket['eve_hashed'];
                    $eve_location            = $ticket['eve_location'];
                    $eve_map_location        = $ticket['eve_map_location'];
                    $eve_name                = htmlspecialchars_decode($ticket['eve_name']);
                    $eve_start_date          = $ticket['eve_start_date'];
                    $eve_ticket_name1        = $ticket['eve_ticket_name1'];
                    $eve_ticket_price1       = $ticket['eve_ticket_price1'];
                    $eve_ticket_quantity1    = $ticket['eve_ticket_quantity1'];
                    $eve_ticket_name2        = $ticket['eve_ticket_name2'];
                    $eve_ticket_price2       = $ticket['eve_ticket_price2'];
                    $eve_ticket_quantity2    = $ticket['eve_ticket_quantity2'];
                    $eve_ticket_name3        = $ticket['eve_ticket_name3'];
                    $eve_ticket_price3       = $ticket['eve_ticket_price3'];
                    $eve_ticket_quantity3    = $ticket['eve_ticket_quantity3'];
                    $eve_ticket_name4        = $ticket['eve_ticket_name4'];
                    $eve_ticket_price4       = $ticket['eve_ticket_price4'];
                    $eve_ticket_quantity4    = $ticket['eve_ticket_quantity4'];
                    $eve_start_sales_on      = $ticket['eve_start_sales_on'];
                    $eve_ends_sales_on       = $ticket['eve_ends_sales_on'];
                    $eve_ticket_image        = $ticket['eve_ticket_image'];
                    $eve_ticket_desc1        = $ticket['eve_ticket_desc1'];
                    $eve_ticket_desc2        = $ticket['eve_ticket_desc2'];
                    $eve_ticket_desc3        = $ticket['eve_ticket_desc3'];
                    $eve_ticket_desc4        = $ticket['eve_ticket_desc4'];
                    $eve_updated_at          = $ticket['eve_updated_at'];

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

                    $eve_pag_url     = BASE_URL."section/events/event_details?eid=".$eve_hashed;
                    $tick_pag_url    = BASE_URL."section/tickets/?tid=".$eve_hashed;
                    $new_tick_banner = (!empty($eve_ticket_image)) ? UPLOAD_PATH."tickets/".$eve_ticket_image : UPLOAD_PATH."templates/no_photo.png";
                }
        } else {
            header("location:javascript://history.go(-1)");
            exit;
        }
    }

    // Passed as param into header meta tags
    $og_title             = "Event Ticket: ".$eve_name;
    $og_image             = $new_tick_banner;
    $og_url               = $cur_page_url;
    $og_description       = $eve_name;
    $page_title           = "Event Ticket: ".$eve_name;
    $event_active         = 'active';
    // Passed as param into TicketNavbar component
    $choose_ticket_active = "instruction_title_active"; 
    $page_id              = $eve_hashed;

    // Include header
    require_once(LAYOUTS_PATH . "/header.php");
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    $page_name = 'ticket-page';
?>

<style>
    <?php include("./ticket.css");  ?>
</style>

<!-- body -->
<div class="page_content">
    <div class="row ticketing">
        <div class="container-lg my-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <!-- ticket process navbar -->
                <div><?php require_once(COMPONENT_PATH.'/TicketNavbar.php'); ?></div>

                <div class="row">
                    <div class="col-12 mb-3 event_info">
                        <div class="p-3 ticketInfo">
                            <h3><?php echo $eve_name; ?></h3>
                            <h5><span class="bi bi-pin-map-fill fs-4"></span> <span class="fw-bold fs-4 px-2"><?php echo $eve_location; ?></span></h5>
                            <h4>Ticket sales date: <span class="fw-bold"><?php echo $neo_sales_start; ?> to <?php echo $neo_sales_ends; ?></span></h4>
                            <h4>Event begins on: <span class="fw-bold"><?php echo $neo_eve_update; ?></span></h4>
                        </div>
                    </div>
                </div>
            </div>
            <?php  
                $in_session = "0";
                $n1 = ($eve_ticket_name1 == "") ?  0 : 1;
                $n2 = ($eve_ticket_name2 == "") ?  0 : 1;
                $n3 = ($eve_ticket_name3 == "") ?  0 : 1;
                $n4 = ($eve_ticket_name4 == "") ?  0 : 1;

                $n_total = ($n1 + $n2 + $n3 + $n4);
                if ($n_total > 0) {

                for ($i=1; $i < $n_total+1; $i++) { 
                    $ticket_name     = "eve_ticket_name".$i;
                    $ticket_price    = "eve_ticket_price".$i;
                    $ticket_quantity = "eve_ticket_quantity".$i;
                    $ticket_desc     = "eve_ticket_desc".$i;

                    $neo_ticket_name  = htmlspecialchars($$ticket_name, ENT_QUOTES);
                    $neo_ticket_desc  = $$ticket_desc;
                    $neo_ticket_price = $$ticket_price;
                    $neo_tickname     = $global_class->removeSpecialChar($neo_ticket_name);
                    $neo_ticketID     = $neo_tickname."_".$hash_key;
            ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 shadow mb-3 ">
                    <div class="row ticket_row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="py-3 ticket_image">
                                <img class="noselect fluid_img" src="<?php echo $new_tick_banner; ?>"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 single_ticket">
                            <div class="p-3">
                                <h4 class="fs-4"><?php echo $neo_ticket_name; ?></h4>
                                <div class="p-2">
                                    <?php echo $neo_ticket_desc; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="m-3 single_ticket_pricing">
                                <div class="pt-lg-4 pt-md-4 pt-sm-0 pricing">
                                    <h3 class="fs-4"><?php echo DEFAULT_CURRENCY. " ".$neo_ticket_price; ?></h3>
                                    <h4 class="pt-1">Last updated: <?php echo $neo_last_update; ?></h4>
                                </div>
                                <?php if ($sales_opend === true): ?>
                                <div class="p-3 cart noselect">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="quantity_input">
                                                <div><label for="ticketQuantity">Quantiy</label></div>
                                                <input type="number" name="ticketQuantity" id="qty_<?php echo $neo_tickname; ?>" class="py-3 form-control-lg" maxlength="10" min="0" value="1" step="1" size="2">
                                            </div>
                                        </div>
                                        <?php
                                            if(isset($_SESSION["cart_item"]) && !empty($_SESSION["cart_item"])) {
                                                $session_code_array = array_keys($_SESSION["cart_item"]);
                                                if(in_array($neo_ticketID, $session_code_array)) {
                                                    $in_session = "1";
                                                }
                                            }
                                        ?>
                                        <div class="col-lg-6 col-md-6 col-sm-12 noselect">
                                            <a  id="<?php echo 'add_'.$neo_tickname; ?>"  
                                                data-trim_name="<?php echo $neo_tickname; ?>"  
                                                data-tname="<?php echo $neo_ticket_name; ?>"   
                                                data-ecode="<?php echo $hash_key; ?>" 
                                                data-event_name="<?php echo $eve_name; ?>"  
                                                <?php if($in_session != "0") { ?> 
                                                     class="btn btn-md btn-secondary disabled shadow-sm mt-4 py-3 addToCart" 
                                                <?php } else { ?> 
                                                     class="btn btn-md btn-dark shadow-sm mt-4 py-3 addToCart" style="display:block"
                                                <?php } ?> >
                                                <i class="bi bi-cart-plus fs-5"></i> Add to cart 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="p-3 cart">
                                    <div class="row mt-2 mx-auto">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <a class="btn btn-md btn-dark w-100 shadow-sm mt-4 py-3 px-2 <?php echo 'disabled'; ?>" disabled >Ticket Sale Closed </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
            ?>
            <div class="row mt-3 mb-5 noselect">
                <div class="col-lg-6 col-md-6 offset-md-3 offset-sm-0 col-sm-12" data-cart_not_empty="<?php echo $in_session; ?>" id="proceedToCartContainer">
                <?php if($in_session != "0") { ?> 
                    <!-- proceed to cart button displayed here -->
                <?php } ?> 
                </div>
            </div>
            <?php
                } else {
            ?> 
            <div class="col-12 mt-3 mb-4 mx-auto">
                <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>No tickets available yet, please visit later.</strong></span></div>
            </div>
            <?php
                }
            ?>                
        </div>
    </div>         
</div>


<script>
    const tick_url = "./Ticket.js";
    $.getScript(tick_url);
</script>
<script>
    const cart_url = "./Cart.js";
    $.getScript(cart_url);
</script>

<!-- footer -->
<?php 
require_once(LAYOUTS_PATH . "/main_footer.php"); 
require_once(LAYOUTS_PATH . "/footer.php"); 
?>
