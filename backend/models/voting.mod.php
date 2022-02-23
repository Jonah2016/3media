<?php

    require('../core/Auth.php');
    require_once(BACKEND_ROOT_PATH . 'classes/Voting.cl.php');
    require_once(BACKEND_ROOT_PATH . 'controllers/Voting.ctrl.php');

    // ================================= AWARDS - VOTING =======================================
    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "process_voting") {
        // Set parameters
        $name1             = "browsingToken"; // Storage name for browsing token
        $name2             = "browsingCountry"; // Storage name for country
        $name3             = "browsingCountryPhoneCode"; // Storage name for country code
        $name4             = "browsingCountryRegion"; // Storage name for country region
        $tokenValue        = $global_class->generateRandomString(37); // Set random string as new token
        $SessionExpire     = 2592000; // time string to expire session [ 86400 = 30 days ]
        $allowed_countries = ['GH']; // Set of countries allowed to vote

        // getIpAddress() and getLocationData() called from "library/global_functions.lib.php"
        $ip                = '192.168.1.145'; # htmlspecialchars(strip_tags($global_class->getIpAddress()), ENT_QUOTES);
        $locationData      = $global_class->getLocationData($ip);
        $countryName       = "Ghana"; # htmlspecialchars($global_class->locationData['country'], ENT_QUOTES);
        $countryCode       = "GH"; # htmlspecialchars($global_class->locationData['country_code'], ENT_QUOTES);
        $countryPhoneCode  = "+233"; # htmlspecialchars($global_class->locationData['country_phone'], ENT_QUOTES);
        $countryRegion     = "GA"; # htmlspecialchars($global_class->locationData['region'], ENT_QUOTES);
        // Submitted values
        $awvs_nominee_id   = $_POST['awvs_nominee_id'];
        $awvs_category_id  = $_POST['awvs_category_id'];
        $voted_for         = $_POST['voted_for'];

        $voting = new VotingController([
            'name1'             => $name1,
            'name2'             => $name2,
            'name3'             => $name3,
            'name4'             => $name4,
            'tokenValue'        => $tokenValue,
            'SessionExpire'     => $SessionExpire,
            'allowed_countries' => $allowed_countries,
            'ip'                => $ip,
            'locationData'      => $locationData,
            'countryName'       => $countryName,
            'countryCode'       => $countryCode,
            'countryPhoneCode'  => $countryPhoneCode,
            'countryRegion'     => $countryRegion,
            'awvs_nominee_id'   => $awvs_nominee_id,
            'awvs_category_id'  => $awvs_category_id,
            'voted_for'         => $voted_for
        ]);
        $result = $voting->processVoting();

        echo json_encode($result);
        exit();
    }
