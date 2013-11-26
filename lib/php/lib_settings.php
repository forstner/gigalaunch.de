<?php
/* provides server settings for jquery-js-clients  */
chdir(".."); // or all the require_once fail, because the paths are wrong.
chdir(".."); // or all the require_once fail, because the paths are wrong.
/* ================= please put this on top of every page, modify the allowed users/groups entries to manage access per page. */
error_reporting(E_ALL); // turn the reporting of php errors on
$allowed_users = "only logged in users"; // a list of userIDs that are allowed to access this page
$allowed_groups = "Admin"; // a list of groups, that are allowed to access this page
require_once('./lib/php/lib_security.php'); // will mysql-real-escape all input
require_once('./lib/php/lib_mysqli_commands.php');
require_once("config.php"); // load project-config file
/* ================= */

// check if session (cookie) was allready started
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // if not start
}
if (!isset($_SESSION['session'])) // check if session key is set (all logged in users get a random session key, with an expiration time... (stored in database)
{
	// no session is set, redirect to login, return stuff that not-logged in users may see (project-logo, project-name)
	$settings["settings_platform_name"] = $settings_platform_name;
	$settings["settings_platform_logo"] = $settings_platform_logo;
}
else
{
	// session is set, check if user is valid
	require_once('./lib/php/lib_session.php'); // login needs to be open for all in order to login!, will immediately exit and redirect to login if the session is not valid/has expired/user is not allowed to access the page
	$settings["settings_platform_name"] = $settings_platform_name;
	$settings["settings_platform_logo"] = $settings_platform_logo;
	$settings["settings_platform_url"] = $settings_platform_url;
	$settings["settings_errorLog"] = $settings_log_errors;

	$settings["settings_log_errors"] = $settings_log_errors;
	$settings["settings_log_operations"] = $settings_log_operations;
	
	/* ======================= USER */
	$settings_user_loggedInUserUsername = ""; // username of the currently logged in user
	$settings_user_loggedInUserGroups = ""; // comma,separated,list of all groups the currently logged in user belongs to
	$settings_user_loggedInUser_session_time_left = "";			// how much time is left until automatic logout
	
	$settings_user_loggedInUser_session_time_left = $valid_until - time();
	$settings_user_loggedInUser_session_time_left_inMinutes = $settings_user_loggedInUser_session_time_left / 1000 / 60;
	$settings["settings_user_loggedInUser_session_time_left_inMinutes"] = $settings_user_loggedInUser_session_time_left_inMinutes;
	
	$settings["settings_user_loggedInUserUsername"] = $user->username;
	$settings["settings_user_loggedInUserGroups"] = $user->groups;

	/* ======================= DEVELOPMENT */
	$settings["settings_debug_mode"] = $settings_debug_mode;
}

echo json_encode($settings);
?>
