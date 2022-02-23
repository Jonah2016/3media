<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    // Passed as param into header meta tags
    $og_title       = "Ticket Payment";
    $page_title     = "Ticket Payment";
    $event_active   = 'active';
    // Passed as param into TicketNavbar component
    $payment_active = "instruction_text_active";

    // Include header
    require_once(LAYOUTS_PATH . "/header.php");
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    $page_name = 'ticket-page';

    // Select random route
    $route_check = [ 'zLc9H5zH3BCVx7AkUSGnwcL4kPAax4SHycudUm', 'Qau7FkKRfDxQP5j8FLtdafYunUiLrFV8Cnm6Rb', 'G2uGfeydjtWGh3DCgPNapgmfDg2XgKpQPd3EVr', 'HVmBub7XH8yiRc957ny5F8tftr9cmprF586bKM', 'Cm4yS5WfjyEAdp8xSaAwRcneFngKQdzwLfZyzi', 'pb8ptwtWdZj4hWiu2K2ZMP8D25AvmxtWecSVtH', 'giMBjVfZpeeQhvDxPuMjWvPCh6Tybw2yEPH82V', 'ZAQKWHppWgdnjnuC6Z8RuU8dF7zTnARpun9aVL', 'VFurJCbRj5aKhkHR8cYKFdBGCzfTMqQTJniHPc', 'J9BMfhdDVjPM3K8XH7J7W33ZdVXP6jvteLcM4U', 'nBcEkYuWmXyiKn84ZWQELJGdZJSM47iNdyCgyL', 'GSyC8zw2kmUfSxF5NN3L575k8pV9PrfLU4dpBA', '8CRrgSuGzuaH2US33WkQvtBWMytxVkJHK6JnmD', '8h4hWgqagXpNu7E4uGKK5kSUeVfuhKjV8gZaUM', '66dZV3HeXupBp6SvYht83MN8Q2f8pD4Ax558ZH', 'tPDRinu3vuNAQA9zbKEzTAWVUTEgMRAJxwJqxu', 'ceC74BT2TGuVTKVU8M6KJ2JmT3TLyxMJAL8U23', 'GD8GBvMtH3FfzeS2yNn7GbGfm5edJfZXPP3v4M', '98Ue5eQp4HgXJ9NA7zzqB2iwj28MpZPtFzxehU', 'UCNm9uEHWc6VypeKbqcSBQgFNmrbQjFfkNeJpU', 'gKdSuB76ywyk2TZVRtMcMF2p9Hd772CmmQTe7g', 'ChY3AcFZ8MAcWVkcfPjyZAYB6c6dfqaRahmWPf', 'bQJc8EPfGE4MqwLh587kdgxzY86fxqeTLxBEkC', 'Pe4D3BJK5Gxa6AwGmbMXEEAmSTjvRCbVZkiyc2', 'R3Lvy5mbbmZN3YbYH64bkXLXaBAprd8czVLnV6', 'WYuS8rdmQPzSaKqgBWrD7cFZfv29qcbvDiJ2NM', 'xbEPWx28YbV3wJXHAw28eSfzej34gBZS2gCubM', 'jAFjvzya5QKSDahDaKqJZQUarT564Pc2zY3LWK', 'rhcf9xNFPSJPG7ZjGMBmvt2XQZyAUv4JzbHuZQ', 'D4yRxLMexivB5q8rQ5gY74KnaimqLiaCSjAaxQ', 'TN9JLrbKWWFuVvFnbMRUJZnxL3CEZytnUEeRxXeg', 'KdYPFdpEFZmcjpyMFepYu9kqDiMV7KFEjRRY89g4', 'YzV9vVu49qRd38JEybt5q8L4KBBGPLTna67YKexM', '944zPSrjuLxu6CjX8bEzPnvFbwUTgggTVj3fPq3u', 'FfwtyEXYFNHctctSL37ub3Zh2m6V9YqdKnApbpvV', '4jjCxRkS6QZumaQi6tcDGkpdtqbKD5tSWR57tRxf', 'u2RcHjAJizfaiQVTGNnicB7KKumtFFdA3ACqi3Az', 'eibSd53WX4TgJzwYxSTc3buRZSMikkcc4MEh4xK6', 'MBP9mMbQdU9e4nLGAivQ7VyuQ9nfVZZM8cJRxzPG', 'MJQcUh9rMgE7ZmHXjXfndQnKwvCMdZrFrdZhVVyQ', 'ECmSWCRiQj66D3Jg4NHSb2BFj5EgaeYJytiDuD4y', '25qZQwhGVm5MA7ndLuTmruzQh6EpAPKBU76Mcecp', '4vFKHgBnSfPyqzthnmWGCbVQQyqkVKuVziAFx75A', 'zMAderUikxxcDyTACTYwu8KSVQSAxBvg9bkmYJFv', 'f645DWKthWcrNjJV73pPewQMRmv73AMHvdwEevKM', 'u2uyVkinnFWmrHr59Qp4BAeWDS5V6wgc5Gn2QNJ5', 'pAemPNwQaz3NYhBDr8HibpERD2WS5qen7Ah3CaUE', 'KwJWggLKNVDQrA2VEjG7hB49Jr27Xt6VSXXfp3YC', 'CJSAPfY4Y9CQErjW7Z8RfWtMruaZZJrZCtYhGxEU', 'ZYQTMRQNthAjznwcCVY2dFjQ2BJ2fkjEELThq2eY' ];
    shuffle($route_check);
    $route_id = $route_check[0];
?>

<style>
    <?php include_once("./ticket.css");  ?>
</style>

<div class="page_content">
    <div class="row bg_light d-flex align-items-center justify-content-center vh-100">
        <div class="container-lg bg_white clean_shadow">
            <div class="col-lg-12 col-sm-12 col-md-12">
                <!-- ticket process navbar -->
                <div><?php require_once(COMPONENT_PATH.'/TicketNavbar.php'); ?></div>

                <div class="row">
                    <div class="col-12 mb-3 event_info">
                        <div class="py-3 mx-5 px-5 ticketInfo">
                            <h3>Checkout</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-lg-10 col-md-10 offset-md-1 offset-lg-1 offset-sm-0 col-sm-12 m-auto mb-5 whole_invoice">
                    <div class="row d-flex align-items-center invoice_header py-3 px-2 noselect">
                        <div class="col-8 col-lg-8 col-md-8 col-sm-8">
                            <h3 class="p-3 fs-4">Items in your cart</h3>
                        </div>
                        <div class="col-4 col-lg-4 col-md-4 col-sm-4">
                            <button class="btn btn-lg btn-danger fs-6" id="emptyCart">Empty Cart</button>
                        </div>
                    </div>
                    <?php
                        if(isset($_SESSION["cart_item"])){
                            $item_total = 0;
                            $event_code = "";
                    ?> 
                    <div class="row invoice_items"> 
                        <?php       
                            if (count($_SESSION["cart_item"]) > 0) {
                                foreach ($_SESSION["cart_item"] as $key => $item) {
                        ?>
                        <div class="col-lg-12 col-md-12 sol-sm-12 single_invoice_item">
                            <div class="row d-flex align-items-center m-auto py-3">
                                <div class="col-2 col-lg-3 col-md-3 col-sm-2 single_invoice_item_image">
                                    <div class="p-0 p-lg-3 p-md-3 p-sm-0 "><img class="noselect fluid_img" src="<?php echo $item["event_img"]; ?>"></div>
                                </div>
                                <div class="col-4 col-lg-4 col-md-4 col-sm-4 single_invoice_item_desc">
                                    <h3 class="fs-6 fw-bolder"><?php echo $item["event_name"]." [ ".$item["ticket_name"]." ]"; ?></h3>
                                </div>
                                <div class="col-2 col-lg-2 col-md-2 col-sm-2 single_invoice_item_desc">
                                    <?php 
                                        $tprice = floatval($item["ticket_price"]);
                                        $tqty   = floatval($item["ticket_qty"]);
                                        $each_row_price = $tprice*$tqty;
                                    ?>
                                    <h3 class="fw-bolder"><?php echo "(".$item["ticket_qty"].") x ".DEFAULT_CURRENCY. " ".number_format($tprice); ?></h3>
                                </div>
                                <div class="col-2 col-lg-2">
                                    <h3 class="px-4 fs-6 fw-bold"><?php echo DEFAULT_CURRENCY." ".number_format($each_row_price); ?></h3>
                                </div>
                                <div class="col-1 col-lg-1 noselect">
                                    <a class="px-4 fw-bold removeCartItem" data-id="<?php echo $key; ?>"><span class="bi bi-x-square-fill text-danger fs-5"></span></a>
                                </div>
                            </div>
                        </div>
                        <?php
                                    $item_total += $tprice*$tqty;
                                    $event_code = $item["event_code"];
                                } 
                            } else {
                        ?>
                        <div class="col-lg-12 col-md-12 sol-sm-12 single_invoice_item">
                            <div class="row">
                                <p class="fs-4 fw-bold p-4">Your cart is empty.</p>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                        <div class="pt-3 px-4 noselect">
                            <div class="mb-3 total_payment">
                                <h3 class="fw-bolder">Total: <?php echo DEFAULT_CURRENCY." ".number_format($item_total); ?></h3>
                                <?php if ($item_total >= 1): ?>
                                    <a class="mt-2 btn btn-success w-100 py-3 fw-bolder" href="<?php echo SECTION_PATH.'tickets/payment_details?cid='.$route_id; ?>" id="confirmDetails">Confirm Your Details</a>
                                <?php endif ?>
                            </div>    
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


<script>
    const cart_url = "./Cart.js";
    $.getScript(cart_url);
</script>

<!-- footer -->
<?php 
    require_once(LAYOUTS_PATH . "/main_footer.php"); 
    require_once(LAYOUTS_PATH . "/footer.php"); 
?>