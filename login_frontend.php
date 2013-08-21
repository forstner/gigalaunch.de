<?php
/* ================= please put this on top of every page, modify the allowed users/groups entries to manage access per page. */
error_reporting(E_ALL); // turn the reporting of php errors on
$allowed_users = "all users including guests"; // a list of userIDs that are allowed to access this page 
$allowed_groups = "all groups including guests"; // a list of groups, that are allowed to access this page
require_once('./lib/php/lib_security.php'); // will mysql-real-escape all input
require_once("config/config.php"); // load project-config file
// // login needs to be open for all in order to login! require_once('./lib/php/lib_session.php'); // will immediately exit and redirect to login if the session is not valid/has expired/user is not allowed to access the page
/* ================= */

require_once('./lib/php/lib_mysqli_commands.php');
require_once('./lib/php/lib_general.php');

if(!empty($_REQUEST['username']) && !empty($_REQUEST['password_encrypted']))
{
	require_once('config/config.php');
	
	$user = getUserByUsername($_REQUEST['username']);
	
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
<!DOCTYPE html> 
<html> 
<head> 
	<title><?php global $settings_current_filename; echo $settings_current_filename; ?></title>
	<?php global $settings_meta; echo $settings_meta; ?>
</head>
<body>
	<div data-role="page" id="login">
		<div data-role="header" data-position="inline">
			<?php global $settings_logo; echo $settings_logo; ?>
		</div>
		<div data-role="content">
			<h4>Login:</h4>
			<form id="loginForm" class="loginForm" action="frontend_login.php" method="post" accept-charset="UTF-8" data-ajax="false">
				<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
				<div id="error" class="error" data-role="collapsible">
					<h3>error/status</h3>
					<p>
					<div id="details">details</div>
					</p>
				</div>
				
				<!-- credentials -->
				<!-- username input -->
				<label for="username">UserName*:</label> <input type="text" name="username" id="username" maxlength="250" value="username"/>

				<!-- password input -->
				<!-- should not be submitted, because it has no name -->
				<label for="password_cleartext">Password*:</label> <input type="password" id="password_cleartext" maxlength="250" value="password"/>

				<!-- onkeypress this hidden field is updated and transmitted  type="hidden" -->
				<label for="password_encrypted">md5 Encrypted Password:</label><input id="password_encrypted" name="password_encrypted" id="password_encrypted" value="5f4dcc3b5aa765d61d8327deb882cf99"/>

				<!-- submit button -->
				<input type="submit" name="Submit" value="login" />

			</form>
		</div> 
		<div data-role="footer">
			<!-- if a user is not registered yet, they can click on this button -->
			<a href="frontend_useradd.php" rel="external">register</a>
		</div> 
	</div>
</body>
</html>