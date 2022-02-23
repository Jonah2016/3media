<?php

require('../core/Auth.php');
// Events controllers and classes
require_once(BACKEND_ROOT_PATH . 'classes/Events.cl.php');
require_once(BACKEND_ROOT_PATH . 'controllers/Events.ctrl.php');


if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_event") {
    $eve_hashed = htmlspecialchars(strip_tags(trim($_POST['eve_hashed'])), ENT_QUOTES);
    $events = new EventController(['eve_hashed' => $eve_hashed]);
    $result = $events->getEvent();

    echo json_encode($result);
    exit();
}

if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_all_events") {
    $events = new EventController(null);
    $result = $events->getAllEvents();

    echo json_encode($result);
    exit();
}

if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_event_tickets") {
    $eve_hashed = htmlspecialchars(strip_tags(trim($_POST['eve_hashed'])), ENT_QUOTES);
    $events = new EventController([
        'eve_hashed' => $eve_hashed,
    ]);
    $result = $events->getEventTickets();

    echo json_encode($result);
    exit();
}
