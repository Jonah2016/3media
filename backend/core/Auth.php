<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
     
    // Config file
    require_once('Config.php');

    // Required classes and controllers
    require_once (CORE_PATH . '/Required.php' );

    // Get settings data from utils
    foreach ($SETTINGS_DATA as $key => $val) {
        $sett_data = $val;
    }

    // Get about data from utils
    foreach ($ABOUT_DATA as $key => $val) {
        $abt_data = $val;
    }

    // Set session variables for user payment details 
    if (!isset($_SESSION['upKey'])) {
        $_SESSION['upKey']      = "";
        $_SESSION['upFname']    = "";
        $_SESSION['upLname']    = "";      
        $_SESSION['upEmail']    = "";
        $_SESSION['upPhone']    = "";
        $_SESSION['upLocation'] = ""; 
        $_SESSION['upEvHash']   = "";
        $_SESSION['upTicket']   = "";

        // Set cookie variables for user payment details 
        setcookie('upKey', "");
        setcookie('upEvHash', "");
        setcookie('upTicket', "");
    }

    // Set cart item session variable
    if (!isset($_SESSION['cart_item'])) {
        $_SESSION["cart_item"] = [];
    }
