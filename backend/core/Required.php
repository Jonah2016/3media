<?php

// composer autoload file
require ROOT_PATH.'/vendor/autoload.php';

// phpprcode from library
require_once(BACKEND_ROOT_PATH.'libraries/phpqrcode/qrlib.php');
// uils from library
require_once(BACKEND_ROOT_PATH . 'libraries/utils.lib.php');
// gGobal functions from library
require_once(BACKEND_ROOT_PATH . 'libraries/global_functions.lib.php');

// Products controllers and classes
require_once(BACKEND_ROOT_PATH . 'classes/News.cl.php');
require_once(BACKEND_ROOT_PATH . 'controllers/News.ctrl.php');

// Ads controllers and classes
require_once(BACKEND_ROOT_PATH . 'classes/Ads.cl.php');
require_once(BACKEND_ROOT_PATH . 'controllers/Ads.ctrl.php');

// Videos controllers and classes
require_once(BACKEND_ROOT_PATH . 'classes/Videos.cl.php');
require_once(BACKEND_ROOT_PATH . 'controllers/Videos.ctrl.php');

// Awards controllers and classes
require_once(BACKEND_ROOT_PATH . 'classes/Awards.cl.php');
require_once(BACKEND_ROOT_PATH . 'controllers/Awards.ctrl.php');

// Events controllers and classes
require_once(BACKEND_ROOT_PATH . 'classes/Events.cl.php');
require_once(BACKEND_ROOT_PATH . 'controllers/Events.ctrl.php');


// Instantiate .env file from composer
$dotenv =  Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// Prepare utils data
$utils_data = [
	"uploads_path" => UPLOAD_PATH,
	"assets_path" => ASSETS_PATH,
	"backend_base_path" => BACKEND_BASE_PATH,
];

// Instantiate all classes
$utils_class           = new UtilsLibrary($utils_data);
$global_class          = new GlobalFunctions(null);
$news_class            = new NewsController(null);
$ads_class             = new AdsController(null);
$video_class           = new VideoController(null);
$award_category_class  = new AwardCategoryController(null);
$award_nominee_class   = new NomineeController(null);
$award_winner_class    = new WinnerController(null);
$award_performer_class = new PerformerController(null);
$event_class           = new EventController(null);

// Retrieve all settings data from utils class
$SETTINGS_DATA = $utils_class->getGeneralSettings();

// Retrieve all about data from utils class
$ABOUT_DATA = $utils_class->getAboutDetails();

// Retrieve all main categories data from utils class
$NEWS_CATEGORIES_DATA = $utils_class->getMainNewsCategories();

// Retrieve all distinct news categories data from utils class
$DIST_NEWS_CATEGORIES_DATA = $utils_class->getDistinctCategories();

// Retrieve all news data from News class
$NEWS_DATA = $news_class->getAllNews();

// Retrieve all featured news data from News class
$FEATURED_NEWS_DATA = $news_class->getAllFeaturedNews();

// Retrieve all ads data from Ads class
$ADS_DATA = $ads_class->getAllAds();

// Retrieve all video data from Video class
$VIDEO_DATA = $video_class->getAllVideos();

// Retrieve all award category data from AwardCategories class
$AWARD_CATEGORIES_DATA = $award_category_class->getAllAwardCategories();

// Retrieve all award nominees data from AwardNominees class
$AWARD_NOMINEES_DATA = $award_nominee_class->getAllNominees();

// Retrieve all award winner data from AwardWinners class
$AWARD_WINNERS_DATA = $award_winner_class->getAllWinners();

// Retrieve all award performers data from AwardPerformers class
$AWARD_PERFORMERS_DATA = $award_performer_class->getAllPerformers();

// Retrieve all events data from Event class
$EVENTS_DATA = $event_class->getAllEvents();






