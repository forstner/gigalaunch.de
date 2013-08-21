<?php
/* handle user-deletion */
/* ================= please put this on top of every page, modify the allowed users/groups entries to manage access per page. */
error_reporting(E_ALL); // turn the reporting of php errors on
$allowed_users = "all users including guests"; // a list of userIDs that are allowed to access this page
$allowed_groups = "all groups including guests"; // a list of groups, that are allowed to access this page
require_once('lib_security.php'); // will mysql-real-escape all input
require_once("config/config.php"); // load project-config file
require_once('lib_session.php'); // will immediately exit and redirect to login if the session is not valid/has expired/user is not allowed to access the page
/* ================= */

/* is it an activation ? */
$received_activation = "";
// require ("lib_mysqli_commands.php");
require_once('lib_general.php');
// loads require ("lib_security.php");

// init database
$mysqli_object = new lib_mysqli_interface();
$result = "";

if(!empty($_REQUEST['user2delete0']))
{
	foreach($_REQUEST as $key => $userID) {
		
		$output = userdel($userID);
		
		if(empty($output))
		{
			$result .= 'type:success,id:user deleted successfully,details:the user with userID:'.$value.' was successfully deleted.;';
		}
		else
		{
			$result .= 'type:error,id:user delete failed,details:the user with userID:'.$value.' could not be deleted, '.$output;
		}
	}
	
	exit($result);
}
?>