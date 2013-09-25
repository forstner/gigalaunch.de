<?php
/* ================= please put this on top of every page, modify the allowed users/groups entries to manage access per page. */
error_reporting(E_ALL); // turn the reporting of php errors on
$allowed_users = "all users including guests"; // a list of userIDs that are allowed to access this page 
$allowed_groups = "all groups including guests"; // a list of groups, that are allowed to access this page
require_once('./lib/php/lib_security.php'); // will mysql-real-escape all input
require_once("config/config.php"); // load project-config file
// // login needs to be open for all in order to login! require_once('./lib/php/lib_session.php'); // will immediately exit and redirect to login if the session is not valid/has expired/user is not allowed to access the page
/* ================= */

$result = Array();

require_once('./lib/php/lib_mysqli_commands.php');

if($_REQUEST['action'] == "users")
{
	$result = Array();
	$result["goto"] = $home; // header("Location: ".$home);
	$result["expires"] = seconds2minutes($settings_login_session_timeout);
	answer($result,"login","success","success","you have now access. live long and prosper! Login expires in ".seconds2minutes($settings_login_session_timeout)." minutes.");

	answer(null,"login","failed","failed","wrong username or password.");
}	
?>