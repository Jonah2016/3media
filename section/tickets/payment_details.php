<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    // Retrieve chosen ticket hash id
    $a_key      = strip_tags($_GET['cid']);
    $b_key      = stripslashes($a_key);
    $c_key      = htmlspecialchars($b_key, ENT_QUOTES);
    $p_hash_key = strip_tags($c_key);

    // Select random route
    $route_check = [ 'zLc9H5zH3BCVx7AkUSGnwcL4kPAax4SHycudUm', 'Qau7FkKRfDxQP5j8FLtdafYunUiLrFV8Cnm6Rb', 'G2uGfeydjtWGh3DCgPNapgmfDg2XgKpQPd3EVr', 'HVmBub7XH8yiRc957ny5F8tftr9cmprF586bKM', 'Cm4yS5WfjyEAdp8xSaAwRcneFngKQdzwLfZyzi', 'pb8ptwtWdZj4hWiu2K2ZMP8D25AvmxtWecSVtH', 'giMBjVfZpeeQhvDxPuMjWvPCh6Tybw2yEPH82V', 'ZAQKWHppWgdnjnuC6Z8RuU8dF7zTnARpun9aVL', 'VFurJCbRj5aKhkHR8cYKFdBGCzfTMqQTJniHPc', 'J9BMfhdDVjPM3K8XH7J7W33ZdVXP6jvteLcM4U', 'nBcEkYuWmXyiKn84ZWQELJGdZJSM47iNdyCgyL', 'GSyC8zw2kmUfSxF5NN3L575k8pV9PrfLU4dpBA', '8CRrgSuGzuaH2US33WkQvtBWMytxVkJHK6JnmD', '8h4hWgqagXpNu7E4uGKK5kSUeVfuhKjV8gZaUM', '66dZV3HeXupBp6SvYht83MN8Q2f8pD4Ax558ZH', 'tPDRinu3vuNAQA9zbKEzTAWVUTEgMRAJxwJqxu', 'ceC74BT2TGuVTKVU8M6KJ2JmT3TLyxMJAL8U23', 'GD8GBvMtH3FfzeS2yNn7GbGfm5edJfZXPP3v4M', '98Ue5eQp4HgXJ9NA7zzqB2iwj28MpZPtFzxehU', 'UCNm9uEHWc6VypeKbqcSBQgFNmrbQjFfkNeJpU', 'gKdSuB76ywyk2TZVRtMcMF2p9Hd772CmmQTe7g', 'ChY3AcFZ8MAcWVkcfPjyZAYB6c6dfqaRahmWPf', 'bQJc8EPfGE4MqwLh587kdgxzY86fxqeTLxBEkC', 'Pe4D3BJK5Gxa6AwGmbMXEEAmSTjvRCbVZkiyc2', 'R3Lvy5mbbmZN3YbYH64bkXLXaBAprd8czVLnV6', 'WYuS8rdmQPzSaKqgBWrD7cFZfv29qcbvDiJ2NM', 'xbEPWx28YbV3wJXHAw28eSfzej34gBZS2gCubM', 'jAFjvzya5QKSDahDaKqJZQUarT564Pc2zY3LWK', 'rhcf9xNFPSJPG7ZjGMBmvt2XQZyAUv4JzbHuZQ', 'D4yRxLMexivB5q8rQ5gY74KnaimqLiaCSjAaxQ', 'TN9JLrbKWWFuVvFnbMRUJZnxL3CEZytnUEeRxXeg', 'KdYPFdpEFZmcjpyMFepYu9kqDiMV7KFEjRRY89g4', 'YzV9vVu49qRd38JEybt5q8L4KBBGPLTna67YKexM', '944zPSrjuLxu6CjX8bEzPnvFbwUTgggTVj3fPq3u', 'FfwtyEXYFNHctctSL37ub3Zh2m6V9YqdKnApbpvV', '4jjCxRkS6QZumaQi6tcDGkpdtqbKD5tSWR57tRxf', 'u2RcHjAJizfaiQVTGNnicB7KKumtFFdA3ACqi3Az', 'eibSd53WX4TgJzwYxSTc3buRZSMikkcc4MEh4xK6', 'MBP9mMbQdU9e4nLGAivQ7VyuQ9nfVZZM8cJRxzPG', 'MJQcUh9rMgE7ZmHXjXfndQnKwvCMdZrFrdZhVVyQ', 'ECmSWCRiQj66D3Jg4NHSb2BFj5EgaeYJytiDuD4y', '25qZQwhGVm5MA7ndLuTmruzQh6EpAPKBU76Mcecp', '4vFKHgBnSfPyqzthnmWGCbVQQyqkVKuVziAFx75A', 'zMAderUikxxcDyTACTYwu8KSVQSAxBvg9bkmYJFv', 'f645DWKthWcrNjJV73pPewQMRmv73AMHvdwEevKM', 'u2uyVkinnFWmrHr59Qp4BAeWDS5V6wgc5Gn2QNJ5', 'pAemPNwQaz3NYhBDr8HibpERD2WS5qen7Ah3CaUE', 'KwJWggLKNVDQrA2VEjG7hB49Jr27Xt6VSXXfp3YC', 'CJSAPfY4Y9CQErjW7Z8RfWtMruaZZJrZCtYhGxEU', 'ZYQTMRQNthAjznwcCVY2dFjQ2BJ2fkjEELThq2eY' ];

    // Session params
    $upFname    = $_SESSION['upFname'];
    $upLname    = $_SESSION['upLname'];
    $upEmail    = $_SESSION['upEmail'];
    $upPhone    = $_SESSION['upPhone'];
    $upLocation = $_SESSION['upLocation'];

    $re_route = SECTION_PATH.'tickets/ticket_checkout';
    if (empty($p_hash_key) || (isset($_SESSION["cart_item"]) && empty($_SESSION["cart_item"]))) {
        header("location:javascript://history.go(-1)");
        exit;
    } else {
        if (!in_array($p_hash_key, $route_check)) {
            header("location:".$re_route);
            exit;
        }
    }

    // Passed as param into header meta tags
    $og_title               = "Confirm Payment Details";
    $page_title             = "Confirm Payment Details";
    $event_active           = 'active';
    // Passed as param into TicketNavbar component
    $confirm_details_active = "instruction_text_active";

    // Include header
    require_once(LAYOUTS_PATH . "/header.php");
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    $page_name = 'confirm-details-page';
    
?>
<style>
    <?php include_once("./ticket.css");  ?>
</style>

<div class="page_content">
    <div class="bg_light d-flex align-items-center justify-content-center h-100">
        <div class="container-lg clean_shadow">
            <!-- ticket process navbar -->
            <div><?php require_once(COMPONENT_PATH.'/TicketNavbar.php'); ?></div>
            <div class="row">
                <div class="col-12 event_info noselect">
                    <div class="py-3 mx-1 px-1 mx-lg-5 px-lg-5 ticketInfo">
                        <h3>Confirm Payment Details</h3>
                        <span class="text-danger">Please note that, a confirmation email which include your ticket details will be sent to this email and phone number you provide. Be sure to provide correct credentials.</span>
                    </div>
                </div>
            </div>
            <div class="row user_details">
                <div class="container-lg my-5">
                    <div class="row d-flex justify-content-center" id="paymentProcessContainer">
                        <form class="form personal_details_form" id="userPaymentDetails" method="post" novalidate enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 col-lg-8 col-md-8 col-sm-12 offset-lg-2 offset-md-2 offset-sm-0">
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6 col-sm-12 mb-2 mb-lg-4">
                                            <input type="text" placeholder="First name" maxlength="30" value="<?php echo $upFname; ?>" name="pay_fname" id="pay_fname" class="form-control form-control-lg"/>
                                        </div>
                                         <div class="col-12 col-lg-6 col-md-6 col-sm-12 mb-2 mb-lg-4">
                                            <input type="text" placeholder="Last name" maxlength="30" value="<?php echo $upLname; ?>" name="pay_lname" id="pay_lname" class="form-control form-control-lg"/>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2 mb-lg-4">
                                        <input type="email" placeholder="Email address" name="pay_email" maxlength="80" value="<?php echo $upEmail; ?>" id="pay_email" class="form-control form-control-lg"/>
                                    </div>
                                    <div class="col-12 mb-2 mb-lg-4">
                                        <input placeholder="Phone Number" type="tel" name="pay_phone" maxlength="15" value="<?php echo $upPhone; ?>" id="pay_phone" class="form-control form-control-lg"/>
                                    </div>
                                    <div class="col-12 mb-2 mb-lg-4">
                                        <input type="text" placeholder="Location" name="pay_location" maxlength="120" id="pay_location" value="<?php echo $upLocation; ?>" class="form-control form-control-lg"/>
                                        <input type="hidden" id="rid" data-rid="<?php echo $p_hash_key; ?>" name="rid" readonly>
                                    </div>
                                     <div class="col-12 mb-2 mb-lg-4" id="checkoutBtnContainer">
                                        <!-- proceed to payment btn or submit btn loaded here -->
                                    </div>
                                </div>
                            </div>
                        </form>   
                    </div>
                </div>
            </div>
        </div> 
    </div>        
</div>

<script>
    const tick_pay_url = "./Ticket.js";
    $.getScript(tick_pay_url);
</script>

<script>
    const tick_paymnt_url = "./Payment.js";
    $.getScript(tick_paymnt_url);
</script>

<!-- footer -->
<?php 
    require_once(LAYOUTS_PATH . "/main_footer.php"); 
    require_once(LAYOUTS_PATH . "/footer.php"); 
?>
