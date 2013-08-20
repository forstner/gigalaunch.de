<?php
/* ================= please put this on top of every page, modify the allowed users/groups entries to manage access per page. */
error_reporting(E_ALL); // turn the reporting of php errors on
$allowed_users = "all users including guests"; // a list of userIDs that are allowed to access this page 
$allowed_groups = "all groups including guests"; // a list of groups, that are allowed to access this page
require('lib_security.php'); // will mysql-real-escape all input
include("config/config.php"); // load project-config file
// // login needs to be open for all in order to login! require('lib_session.php'); // will immediately exit and redirect to login if the session is not valid/has expired/user is not allowed to access the page
/* ================= */

require ('lib_mysqli_commands.php');
require('lib_general.php');

if(!empty($_REQUEST['email']))
{
	require ('config/config.php');
	
	$user = getUserByMail($_REQUEST['email']);
	
	if(does_user_exist($_REQUEST['username'],null,$user)) // check if username exists
	{
		// at this point we know the username exists
		// let's compare the submitted password_encrypted to value of the array key (the right password)
		if(does_user_exist($_REQUEST['username'],$_REQUEST['password_encrypted'],$user)) // check if username with that password exists
		{
			// password is correct
			session_start();
			setSession($_REQUEST['username'],$_REQUEST['password_encrypted']);
			
			$data = getDataOfUsername($_REQUEST['username']);
			if($settings_login_session_timeout > 0)
			{
				// echo('type:success,id:login successful,details:you have now access for '.seconds2minutes($settings_login_session_timeout).' minutes');
				// sleep(3);
				if(isset($data['home']))
				{
					header("Location: ".$data['home']);
				}
				else
				{
					header("Location: ".$settings_default_home_after_login);
				}
			}
			else
			{
				// echo('type:success,id:login successful,details:you have now access. live long and prosper! :)');
				// sleep(3);
				header("Location: servermessages/session_expired.php");
			}
		}
		else
		{
			// exit('type:error,id:username or password wrong,details:Either username or password did not match. ');
			header("Location: servermessages/wrong_username_or_password.php");
		}
	} else {
		// exit('type:error,id:username or password wrong,details:Either username or password did not match. ');
		header("Location: servermessages/wrong_username_or_password.php");
	}
}
?>