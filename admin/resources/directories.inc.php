<?php

    // BASE_URL ->  ADMIN_BASE_PATH

    //APPROOT
    define('APP_ROOT', dirname(dirname(__FILE__)));

    //URLROOT (Dynamic links)
    define('BASE_URL', 'http://localhost/3musicApp');

    //admin URLROOT (Dynamic links)
    define('ADMIN_BASE_URL', 'http://localhost/3musicApp/admin');

    // Routing Paths
    define("BASE_PATH", "/3musicApp/");

    // Routing admin Paths
    define("ADMIN_BASE_PATH", "/3musicApp/admin/");

    // Main Root Paths
    define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/3musicApp/");

    // admin Root Paths
    define("ADMIN_ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/3musicApp/admin/");

    // Path to static files
    defined("ASSETS_PATH")
        or define("ASSETS_PATH", ADMIN_BASE_PATH . 'assets');

    // Path to library files
    defined("LIBRARY_PATH")
        or define("LIBRARY_PATH", ADMIN_ROOT_PATH . 'resources/library');

    // Path to classes files
    defined("CLASSES_PATH")
        or define("CLASSES_PATH", ADMIN_ROOT_PATH . 'classes');

    // Path to templates and layout files
    defined("LAYOUT_PATH")
        or define("LAYOUT_PATH", ADMIN_ROOT_PATH . 'resources/layouts');

    // Path to modals
    defined("MODALS_PATH")
        or define("MODALS_PATH", ADMIN_ROOT_PATH . 'resources/form-modals');

    // Uploads path
    defined("UPLOADS_PATH")
        or define("UPLOADS_PATH", BASE_PATH . 'uploads/');

    // Uploads path
    defined("UPLOADING_PATH")
            or define("UPLOADING_PATH", ROOT_PATH . 'uploads/');

?>