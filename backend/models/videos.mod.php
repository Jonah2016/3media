<?php

require('../core/Auth.php');
// Videos controllers and classes
require_once(BACKEND_ROOT_PATH . 'classes/Videos.cl.php');
require_once(BACKEND_ROOT_PATH . 'controllers/Videos.ctrl.php');


if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_video") {
    $vid_hashed = htmlspecialchars(strip_tags(trim($_POST['key'])), ENT_QUOTES);
    $videos = new VideoController(['vid_hashed' => $vid_hashed]);
    $result = $videos->getVideo();

    echo json_encode($result);
    exit();
}

if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_all_videos") {
    $videos = new VideoController(null);
    $result = $videos->getAllVideos();

    echo json_encode($result);
    exit();
}

if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_videos_by_category") {
    $vid_category          = htmlspecialchars(strip_tags(trim($_POST['category'])), ENT_QUOTES);
    $already_displayed_ids = htmlspecialchars(strip_tags($_POST['displayed_array']), ENT_QUOTES);

    $videos = new NewsController([
        'vid_category'          => $vid_category,
        'already_displayed_ids' => $already_displayed_ids
    ]);
    $result = $videos->getAllVideosByCategory();

    echo json_encode($result);
    exit();
}