<?php

    require('../core/Auth.php');
    require_once(BACKEND_ROOT_PATH . 'classes/User.cl.php');
    require_once(BACKEND_ROOT_PATH . 'controllers/User.ctrl.php');

    // ================================= AWARDS - VOTING =======================================
    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "subscribe") {
        // Set parameters
        // getIpAddress() called from "library/global_functions.lib.php"
        $ip = htmlspecialchars(strip_tags($global_class->getIpAddress()), ENT_QUOTES);
        // Submitted values
        $subscribe_email   = htmlspecialchars(strip_tags(trim($_POST['subscribe_email'])), ENT_QUOTES);

        $subscription = new SubscriptionController([
            'subs_ip'         => $ip,
            'subscribe_email' => $subscribe_email
        ]);
        $result = $subscription->processSubscription();

        echo json_encode($result);
        exit();
    }


    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "save_user_payment_details") {
        // Set parameters
        $pay_hash_key = $global_class->generateRandomString(27);
        $pay_fname    = htmlspecialchars(strip_tags(trim($_POST['pay_fname'])), ENT_QUOTES);
        $pay_lname    = htmlspecialchars(strip_tags(trim($_POST['pay_lname'])), ENT_QUOTES);
        $pay_email    = htmlspecialchars(strip_tags(trim($_POST['pay_email'])), ENT_QUOTES);
        $pay_phone    = htmlspecialchars(strip_tags(trim($_POST['pay_phone'])), ENT_QUOTES);
        $pay_location = htmlspecialchars(strip_tags(trim($_POST['pay_location'])), ENT_QUOTES);
        $event_hash   = htmlspecialchars(strip_tags(trim($_POST['eid'])), ENT_QUOTES);
        $ticket_name  = htmlspecialchars(strip_tags(trim($_POST['tp'])), ENT_QUOTES);

        $payment_details = new TicketPaymentController([
            'pay_hash_key' => $pay_hash_key,
            'pay_fname'    => $pay_fname,
            'pay_lname'    => $pay_lname,
            'pay_email'    => $pay_email,
            'pay_phone'    => $pay_phone,
            'pay_location' => $pay_location,
            'event_hash'   => $event_hash,
            'ticket_name'  => $ticket_name
        ]);
        
        $result = $payment_details->addUserPaymentDetails();

        echo json_encode($result);
        exit();
    }
