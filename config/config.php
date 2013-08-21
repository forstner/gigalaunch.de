<?php
/* ======================= ABOUT THE PLATFORM */
$settings_platform_name = "gigalaunch";
$settings_platform_url = "http://gigalaunch.de";
$settings_errorLog = $settings_platform_name."_error.log"; // if empty, no errors are logged to file

/* ======================= DATABASE */
/* here the database credentials are beeing stored */
$settings_datasource = "mysql"; // right now can only be "mysql", could be postgress (not implemented) sqlite (not implemented)
$settings_database_server = "localhost";
$settings_database_name = $settings_platform_name;
$settings_database_user = "root";
$settings_database_pass = "root";
$settings_database_auth_table = "passwd"; // what the table is called, where the users & passwords (md5 hashes) are stored

/* ======================= USERS */
/* ================ DEFAULTS */

// $settings_default_home_after_login = "frontend_template.php"; // redirect all users, that have no home:somefile.php set in data field of passwd table, to this file after login
$settings_default_home_after_login = "frontend_UserManagement.php"; // redirect all users, that have no home:somefile.php set in data field of passwd table, to this file after login
require_once('./lib/php/lib_detectLang.php'); // will detect the currently used language
$settings_lang = detectLang();

/* ======================= OPTICS */
/* ================ LOGO */
$settings_logo = '<img id="logo" src="images/projectlogo.png" style="width:200px;"/>';

/* ======================= UPLOADS */
/* ================ GENERAL */
$upload_allowedExtensions = array("gif", "jpeg", "jpg", "png");
$upload_maximumFileSize = 2048;

/* ================ PROFILE PICTURES */
$settings_profilepicture_upload_dir = "images/profilepictures/";
$settings_profilepicture_dimensions ="115x115"; // what resolution do you allow for profile pictures

/* ======================= WHO IS THE ADMIN? WHO IS RESPONSIBLE? */
$settings_mail_admin = "admin@server.org";			// not used yet
$settings_mail_activation = $settings_mail_admin;	// this will be the sender/return address for activation mails send to your user after successfull registration with activation link
$settings_mail_activation_subject = "Activation successfull!";
$settings_mail_activation_text = "Thank you for registering @ localhost.com";
$settings_login_session_timeout = "1800";			// 1800seconds = 30min, 0 = no timeout, amounts of seconds that login-cookies are valid, after login (time until user has to re-login)

/* ======================= SINGLE/MULTIPLE PROJECTS? */
/*
 * personally i use /var/www/projectname as pdt/eclipse/aptana workspace
*
* 1x project: if you are only hosting one project: than you probably have this project structure
* /var/www/index.php
* /var/www/frontend_login.php
* ...
* /var/www/library <- library is located here
*
* multiple projects with virtualhosts in subdirectories of web-root
* than your folder structure is probably like this:
* /var/www/projectnamX/
* /var/www/projectnamY/
* /var/www/library/ <- library is still located here, and not redundant in projectnameX/library and projectnameY/library
* so you need to update library in only one place
*/
$settings_multiple_projects = true;

// automatically load filename.js
$settings_current_filename = "filename.js";

$url = $_SERVER['PHP_SELF']; // get filename of url called php file
$filename_and_ending = explode('/', $url);
$filename_and_ending = $filename_and_ending[count($filename_and_ending) - 1];
$filename_and_ending = explode('.', $filename_and_ending);
$settings_current_filename = $filename_and_ending[0];

$settings_meta = '
		<!-- meta -->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- apple-iphone specific stuff -->
		<meta name="apple-mobile-web-app-capable" content="yes"/>
		<meta name="apple-mobile-web-app-status-bar-style" content="white">
		<link rel="apple-touch-icon" href="images/opensource_icon.png"/>

		<!-- credits: who made this world a better place? -->
		<meta name="author" content="user">

		<!-- tools: what was used to make this world a better place -->
		<meta name="editor" content="pdt eclipse">

		<!-- css valid for all projects, includes the default jquery mobile css -->
		<link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.3.0.min.css" />
		<link rel="stylesheet" type="text/css" href="css/global.css"/>

		<!-- project wide css -->
		<link rel="stylesheet" type="text/css" href="css/projectWide.css"/>

		<!-- file wide css -->
		<link rel="stylesheet" type="text/css" href="css/'.$settings_current_filename.'.css"/>

		<!-- project wide js libraries: jquery, jquery mobile -->
		<script type="text/javascript" src="lib/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="lib/js/jquery.mobile-1.3.0.min.js"></script>

		<!-- timer plugin -->
		<script type="text/javascript" src="lib/js/lib_jquery.timer.js"></script>

		<!-- js-client-side-md5, so that no password gets over network unencrypted, esp not during registration -->
		<script type="text/javascript" src="lib/js/lib_webtoolkit.md5.js"></script>

		<!-- nice input validation plugin -->
		<script type="text/javascript" src="lib/js/lib_jquery.validate.js"></script>

		<!--  provices conversion function -->
		<script type="text/javascript" src="lib/js/lib_convert.js"></script>

		<!--  provices string operation functions -->
		<script type="text/javascript" src="lib/js/lib_strings.js"></script>

		<!-- client side functions to process server response -->
		<script type="text/javascript" src="lib/js/lib_general.js"></script>

		<!-- translations -->
		<script type="text/javascript" src="lib/js/lib_translate.js"></script>
				
		<!-- page specific js includes & custom js code -->
		<script type="text/javascript" src="'.$settings_current_filename.'.js"></script>
				
		';
		// if lang needs to be available in javascript, uncomment the following line and move it 2 lines up
		// <script>var lang = "'.$settings_lang.'";</script>

/* o detect mobile browser, if yes -> load different css do not paint a lot of blue stuff around the UI */
// require_once('detectmobilebrowser.php');
// $settings_detected_browser = 'desktop'; // is detected automatically/overwritten automatically, possible values are desktop,
?>