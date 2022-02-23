<?php

require('../core/Auth.php');
// Ads controllers and classes
require_once(BACKEND_ROOT_PATH . 'classes/Ads.cl.php');
require_once(BACKEND_ROOT_PATH . 'controllers/Ads.ctrl.php');


if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_ad") {
    $adverts_id     = htmlspecialchars(strip_tags(trim($_POST['adverts_id'])), ENT_QUOTES);
    $advertisements = new AdsController(['adverts_id' => $adverts_id]);
    $result         = $advertisements->getAd();

    echo json_encode($result);
    exit();
}


if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_ad_by_params") {
    $date_now          = htmlspecialchars(strip_tags(trim($_POST['date_now'])), ENT_QUOTES);
    $adverts_category  = htmlspecialchars(strip_tags(trim($_POST['adverts_category'])), ENT_QUOTES);
    $adverts_dimension = htmlspecialchars(strip_tags(trim($_POST['adverts_dimension'])), ENT_QUOTES);
    $adverts_type      = htmlspecialchars(strip_tags(trim($_POST['adverts_type'])), ENT_QUOTES);
    $advertisements    = new AdsController([
        'date_now'          => $date_now,
        'adverts_category'  => $adverts_category,
        'adverts_dimension' => $adverts_dimension,
        'adverts_type'      => $adverts_type
    ]);
    $result = $advertisements->getAdByParams();

    echo json_encode($result);
    exit();
}


if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_all_ads") {
    $advertisements = new AdsController(null);
    $result         = $advertisements->getAllAds();

    echo json_encode($result);
    exit();
}
