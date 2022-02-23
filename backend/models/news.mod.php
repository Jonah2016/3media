<?php

require('../core/Auth.php');
// News controllers and classes
require_once(BACKEND_ROOT_PATH . 'classes/News.cl.php');
require_once(BACKEND_ROOT_PATH . 'controllers/News.ctrl.php');


if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_all_featured_news") {
    $news    = new NewsController();
    $result  = $news->getAllFeaturedNews();

    echo json_encode($result);
    exit();
}

if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_news") {
    $news_hashed = htmlspecialchars(strip_tags(trim($_POST['news_hashed'])), ENT_QUOTES);
    $news        = new NewsController(['news_hashed' => $news_hashed]);
    $result      = $news->getNews();

    echo json_encode($result);
    exit();
}

if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_all_news") {
    $news   = new NewsController(null);
    $result = $news->getAllNews();

    echo json_encode($result);
    exit();
}

if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_news_by_category") {
    $news_category         = htmlspecialchars(strip_tags(trim($_POST['category'])), ENT_QUOTES);
    $already_displayed_ids = htmlspecialchars(strip_tags($_POST['displayed_array']), ENT_QUOTES);

    $news = new NewsController([
        'news_category' => $news_category,
        'already_displayed_ids' => $already_displayed_ids
    ]);
    $result  = $news->getAllNewsByCategory();

    echo json_encode($result);
    exit();
}

if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "fetch_comments") {
    $search_param = htmlspecialchars(strip_tags(trim($_POST['page_id'])), ENT_QUOTES);
    $news         = new NewsController(['search_param' => $search_param]);
    $result       = $news->getNewsComments();

    echo json_encode($result);
    exit();
}

if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_news_replies") {
    $ncom_parent_hashed = htmlspecialchars(strip_tags(trim($_POST['ncom_parent_hashed'])), ENT_QUOTES);
    $news               = new NewsController(['ncom_parent_hashed' => $ncom_parent_hashed]);
    $result             = $news->getNewsReplies();

    echo json_encode($result);
    exit();
}