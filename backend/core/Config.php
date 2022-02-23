<?php

// Error reporting.
// ini_set("error_reporting", "false");
// error_reporting(0);

// Defaults
date_default_timezone_set('UTC');
define("APP_VERSION", "1.0");

// Email account
define('EMAIL_HOST', '3music.tv');
define('SECURE_SMTP', 'smtp.secureserver.net');
define('EMAIL_ADDRESS', 'tickets@3music.tv');
define('EMAIL_PORT', 465);

//App name
define('APP_NAME', '3 Music Networks Limited');

// Site Descriptions
define('SITE_NAME', '3 Music.tv');

// Default currency
define('DEFAULT_CURRENCY', 'GHC');

//API_URL
define('API_URL', 'https://3music.tv/api/');

// Call back url
define('PAYSTACK_CALLBACK', 'http://localhost/3musicApp/backend/models/payment_callback.mod.php');

//APPROOT
define('APP_ROOT', dirname(dirname(__FILE__)));

//URLROOT (Dynamic links)
define('BASE_URL', 'http://localhost/3musicApp');

//backend URLROOT (Dynamic links)
define('BACKEND_BASE_URL', 'http://localhost/3musicApp/backend');

//Frontend URLROOT (Dynamic links)
define('FRONTEND_BASE_URL', 'http://localhost/3musicApp/frontend');

// Routing Paths
define("BASE_PATH", "/3musicApp/");

// Routing Backend Paths
define("BACKEND_BASE_PATH", "/3musicApp/backend/");

// Routing Frontend Paths
define("FRONTEND_BASE_PATH", "/3musicApp/frontend/");

// Main Root Paths
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/3musicApp/");

// Backend Root Paths
define("BACKEND_ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/3musicApp/backend/");

// Frontend Root Paths
define("FRONTEND_ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/3musicApp/frontend/");

// Path to static files
defined("ASSETS_PATH")
    or define("ASSETS_PATH", FRONTEND_BASE_PATH . 'assets');

// Path to static files
defined("SECTION_PATH")
    or define("SECTION_PATH", BASE_PATH . 'section/');

// Path to core files
defined("CORE_PATH")
    or define("CORE_PATH", BACKEND_ROOT_PATH . 'core');

// Path to library files
defined("LIBRARIES_PATH")
    or define("LIBRARIES_PATH", BACKEND_BASE_PATH . 'libraries');

// Path to models files
defined("MODELS_PATH")
    or define("MODELS_PATH", BACKEND_BASE_PATH . 'models');

// Path to classes files
defined("CLASSES_PATH")
    or define("CLASSES_PATH", BACKEND_BASE_PATH . 'classes');

// Path to controllers files
defined("CONTROLLERS_PATH")
    or define("CONTROLLERS_PATH", BACKEND_BASE_PATH . 'controllers');

// Path to templates and layout files
defined("LAYOUTS_PATH")
    or define("LAYOUTS_PATH", FRONTEND_ROOT_PATH . 'resources/layouts');

// Path to components files
defined("COMPONENT_PATH")
    or define("COMPONENT_PATH", FRONTEND_ROOT_PATH . 'components');

// Path to modals
defined("MODALS_PATH")
    or define("MODALS_PATH", FRONTEND_ROOT_PATH . 'resources/modals');

// Path to uploads directory
defined("UPLOAD_PATH")
    or define("UPLOAD_PATH", BASE_PATH . 'uploads/');

// Path to url uploads directory
defined("UPLOAD_URL_PATH")
    or define("UPLOAD_URL_PATH", BASE_URL . '/uploads/');

// Connection to database
require_once("Connection.php");
// Instantiate db connection
$DB = new DB_CONN();
$db_connect = $DB->connect();
