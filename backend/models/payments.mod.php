<?php

    require('../core/Auth.php');
    require_once(BACKEND_ROOT_PATH . 'classes/Payment.cl.php');
    require_once(BACKEND_ROOT_PATH . 'controllers/Payment.ctrl.php');


    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) === "initialize_payment") {
        $rid         = htmlspecialchars(strip_tags(trim($_POST['rid'])), ENT_QUOTES);
        $payFname    = htmlspecialchars(strip_tags(trim($_POST['payFname'])), ENT_QUOTES);
        $payLname    = htmlspecialchars(strip_tags(trim($_POST['payLname'])), ENT_QUOTES);
        $payEmail    = htmlspecialchars(strip_tags(trim($_POST['payEmail'])), ENT_QUOTES);
        $payPhone    = htmlspecialchars(strip_tags(trim($_POST['payPhone'])), ENT_QUOTES);
        $payLocation = htmlspecialchars(strip_tags($_POST['payLocation']), ENT_QUOTES);
        $cartData    = $_SESSION["cart_item"];

        $payment = new PaymentController([
            'rid'          => $rid,
            'pay_fname'    => $payFname,
            'pay_lname'    => $payLname,
            'pay_email'    => $payEmail,
            'pay_phone'    => $payPhone,
            'pay_location' => $payLocation,
            'cart_data'    => $cartData
        ]);
        $result = $payment->processPayment();

        echo json_encode($result);
        exit();
    }


    