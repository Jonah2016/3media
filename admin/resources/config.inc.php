<?php  
	// This file contains all the main configuration settings of this app
	
	require_once("directories.inc.php");

	// ini_set('mysql.connect_timeout', 300);
    // ini_set('default_socket_timeout', 300);
	
	// Define default time zone
	date_default_timezone_set('UTC');
 
	// Error reporting.
	// ini_set("error_reporting", "true");
	// error_reporting(E_ALL|E_STRCT);

	// Defaults
	date_default_timezone_set('UTC');
	define("APP_VERSION", "1.0");

	// Email account
	define('EMAIL_HOST', '3music.tv');
	define('SECURE_SMTP', 'smtp.secureserver.net');
	define('EMAIL_ADDRESS', 'admin@3music.tv');

	//App name
	define('APP_NAME', '3Music');

	// Site Descriptions
	define('SITE_NAME', '3music');

	// Connect to database
	require_once("connect.inc.php");

?>