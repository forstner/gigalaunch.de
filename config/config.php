<?php
/* ======================= ABOUT THE PLATFORM */
$settings_platform_name = "gigalaunch";
$settings_platform_url = "http://gigalaunch.de";
$settings_errorLog = $settings_platform_name."_error.log"; // if empty, no errors are logged to file

$settings_log_errors = "log/error.log"; // if errors should be logged to file, if not leave this empty
$settings_log_operations = "log/operations.log"; // if there should be a line written for every operation done (so you may be able to track problems)

$settings_uniqueUsernames = true; // please leave this at true, otherwise useredit may fail, true: two users can NOT have the same username, false: two users can have the same username (identification is mainly done over an unique database generated id)

/* ======================= DATABASE */
/* here the database credentials are beeing stored */
$settings_datasource = "mysql"; // right now can only be "mysql", could be postgress (not implemented) sqlite (not implemented)
$settings_database_server = "localhost";
$settings_database_name = $settings_platform_name;
$settings_database_user = "root";
$settings_database_pass = "root";
$settings_database_auth_table = "passwd"; // what the table is called, where the users & passwords (md5 hashes) are stored
$settings_database_groups_table = "groups"; // what the table is called, where the groups are stored
$settings_lastDatabase = "";
$settings_lastTable = "";
$settings_lastColumn = "";

/* ======================= USERS */
/* ================ DEFAULTS */

// $settings_default_home_after_login = "frontend_template.php"; // redirect all users, that have no home:somefile.php set in data field of passwd table, to this file after login
$settings_default_home_after_login = "frontend_UserManagement.php"; // redirect all users, that have no home:somefile.php set in data field of passwd table, to this file after login
require_once('./lib/php/lib_detectLang.php'); // will detect the currently used language
$settings_lang = detectLang();

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

// if lang needs to be available in javascript, uncomment the following line and move it 2 lines up
// <script>var lang = "'.$settings_lang.'";</script>

/* o detect mobile browser, if yes -> load different css do not paint a lot of blue stuff around the UI */
// require_once('detectmobilebrowser.php');
// $settings_detected_browser = 'desktop'; // is detected automatically/overwritten automatically, possible values are desktop,
?>