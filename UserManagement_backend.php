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

/* create new  user */
if($_REQUEST['action'] == "new")
{
	$user = newUser(); // get database layout of an UserObject-Instance (basically all the keys but no values, not a real user record just the layout of it)
	$user->id = $_REQUEST['UserID']; // set the user id of the UserObject-Instance to 0, so we are looking for a user with id == 0
	
	// now editing/updating the properties
	$user->username = $_REQUEST['username'];
	$user->firstname = $_REQUEST['firstname'];
	$user->lastname = $_REQUEST['lastname'];
	$user->password = $_REQUEST['password_encrypted'];
	$user->groups = $_REQUEST['groups'];

	useradd($user); // returns the user-object from database, containing a new, database generated id, that is important for editing/deleting the user later
	
	global $output;
	
	if($output)
	{
		// if there is output on edit -> something is bad -> and $output should contain the error message that is forwareded to the client
		// answer($result = null,$action = "",$resultType = "",$resultValue = "",$details = "")
		answer(null,"update","failed","failed",$output,"UserManagement_backend.php: action newUser failed");
	}
	else
	{
		// if there is no output on edit -> everything is okay
		answer($result,"update","success","success","user updated successfully");
	}
}
/* update an existing user */
if($_REQUEST['action'] == "update")
{
	$user = newUser(); // get database layout of an UserObject-Instance (basically all the keys but no values, not a real user record just the layout of it)
	$user->id = $_REQUEST['UserID']; // set the user id of the UserObject-Instance to 0, so we are looking for a user with id == 0
	$user = getFirstElementOfArray(users($user)); // now passing this $user[id] to the function users which then extracts a real user with this id.
	
	// now editing/updating the properties
	$user->username = $_REQUEST['username'];
	$user->firstname = $_REQUEST['firstname'];
	$user->lastname = $_REQUEST['lastname'];
	$user->password = $_REQUEST['password_encrypted'];
	$user->groups = $_REQUEST['groups'];

	// writing to database, for more examples please check out: lib_mysqli_commands.test.php
	useredit($user);
	
	global $output;
	
	if($output)
	{
		// if there is output on edit -> something is bad -> and $output should contain the error message that is forwareded to the client
		// answer($result = null,$action = "",$resultType = "",$resultValue = "",$details = "")
		   answer(null,"update","failed","failed",$output,"UserManagement_backend.php: useredit/update failed.");
	}
	else
	{
		// if there is no output on edit -> everything is okay
		answer($result,"update","success","success","user updated successfully");
	}
}

/* get list of users */
if($_REQUEST['action'] == "users")
{
	$result = Array();
	$result["goto"] = $home; // header("Location: ".$home);
	$result["expires"] = seconds2minutes($settings_login_session_timeout);
	answer($result,"login","success","success","you have now access. live long and prosper! Login expires in ".seconds2minutes($settings_login_session_timeout)." minutes.");
}	
?>