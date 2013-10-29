<?php
/* handle user-creation/registeration */

/* ================= please put this on top of every page, modify the allowed users/groups entries to manage access per page. */
error_reporting(E_ALL); // turn the reporting of php errors on
$allowed_users = "all users including guests"; // a list of userIDs that are allowed to access this page
$allowed_groups = "all groups including guests"; // a list of groups, that are allowed to access this page
require_once('./lib/php/lib_security.php'); // will mysql-real-escape all input
require_once("config/config.php"); // load project-config file
require_once('./lib/php/lib_session.php'); // will immediately exit and redirect to login if the session is not valid/has expired/user is not allowed to access the page
/* ================= */

/* is it an activation ? */
$received_activation = "";
require_once('./lib/php/lib_general.php');
// loads require ("./lib/php/lib_security.php");

// init database
$mysqli_object = new class_mysqli_interface();

if(!empty($_REQUEST['activation']))
{
	$received_activation = $_REQUEST['activation'];

	if(strlen($received_activation)>0)
	{
		$received_activation = $mysqli_object->escape($_REQUEST['activation']);
		// http://localhost/PDT/LOGIN_PHP/frontend_useradd.php?activation=ef0521b52aaefa764753e84759dc5910
		$mysqli_object->query("UPDATE `".$settings_database_name."`.`".$settings_database_auth_table."` SET `activation` = 'activated' WHERE `".$settings_database_auth_table."`.`activation` = '".$received_activation."';");

		header("Location: servermessages/activation.php");
	}
}
else if(!empty($_REQUEST['username']) && empty($_REQUEST['password'])) /* is it a username-taken test? */
{
	$requested_username = $mysqli_object->escape($_REQUEST['username']);
	if (userexist($requested_username,null,null)) {
		exit('type:error,id:Username already taken,details:Username already taken. Please choose different one.');
	}
	else
	{
		exit('type:success,id:username available,details:checked with server and username is still available. please continue with registration.');
	}
}
else if(!empty($_REQUEST['username']) && !empty($_REQUEST['password'])) /* is it an registration? */
{
	$requested_username = $mysqli_object->escape($_REQUEST['username']);
	$requested_password = $mysqli_object->escape($_REQUEST['password']); // is already otherwise use md5(password) here before storing password in database
	$requested_password_confirm = $mysqli_object->escape($_REQUEST['password_confirm']);  // is already otherwise use md5(password) here before storing password in database

	//sleep(2);
	// usleep(150000); // why i do no know?

	if (userexist($requested_username,null,null)) {
		exit('type:error,id:Username already taken,details:Username already taken. Please choose different one.');
	}

	if ($requested_password_confirm != $requested_password) {
		exit('type:error,id:password missmatch,details:the passwords you entered did not match. ');
	} else {
		/* insert user record */

		$activation = "";
		
		/* collect data about the user via php */
		$userdata = "";
		$userdata .= "firstname:".$_REQUEST['firstname'].",";
		$userdata .= "lastname:".$_REQUEST['lastname'].",";
		$userdata .= "email:".$_REQUEST['email'].",";
		$userdata .= "ip_during_registration:".$_SERVER['REMOTE_ADDR'].",";
		$userdata .= "port_during_registration:".$_SERVER['REMOTE_PORT'].",";

		$device = $_SERVER['HTTP_USER_AGENT'];
		// replace all : and , because they interfere with the key:value, system
		$device = str_replace(":", "-", $device);
		$device = str_replace(",", "-", $device);
		
		$userdata .= "device_during_registration:".$device.",";
		$userdata .= "home:".$_REQUEST['home'].",";

		if(isset($_REQUEST['profilepicture'])) $userdata .= "profilepicture:".$_REQUEST['profilepicture'].",";

		// get informations about groups
		$groups = getREQUESTSstarting("checkbox_group");
		$groups_string = "";
		foreach ($groups as $key => $value)
		{
			if($value == "1")
			{
				$count = strlen("checkbox_group_");
				$key_count = strlen($key);
				$substring = substr($key, $count, $key_count);
				$groups_string .= $substring.",";
			}
		}

		// ADD THE USER
		$output = useradd($requested_username,$requested_password,$groups_string,$userdata);

		// check if any error
		if(!$output)
		{
			global $settings_mail_activation;

			// send activation code
			// what will be in that e-mail
			$from = $settings_mail_activation;
			$to = $_REQUEST['email'];
			$subject = $settings_mail_activation_subject;
			$text = $settings_mail_activation_text." Please click : <a href='frontend_login.php?activation=".$activation."'>this link to activate your account</a>";

			sendMail($from,$to,$subjet,$text);
		}
		else
		{
			exit('type:error,id:registration failed,details:'.$output);
			// sleep(3);
			// header("Location: registration_failed.php");
		}
	}
}
?>
<!DOCTYPE html> 
<html> 
<head> 
	 
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
	
	<script type="text/javascript" src="lib/js/dynamically_load_js_and_css.js"></script>
</head> 
<body> 
<div data-role="page" id="useradd">
	<div data-role="header" data-position="inline" data-backbtn="true">
		<div class="ui-bar ui-bar-b">
			<a href="#" onclick="window.history.back();" data-role="button" data-inline="true" data-mini="true" data-icon="back">Back</a>
		</div>
	</div>
	<div data-role="content">
	<!-- php pass info to javascript via hidden divs -->
	<div class="invisible">
	<?php
	// -> if user is a guest (not logged in) display message & redirect to index.html -> which redirects to login
	// -> if user is a admin (logged in) display message & go one page back
	echo "<div id='session_valid'>".$session_valid."</div>";
	?>
	</div>
	<h4> add new User </h4>
	<?php
		// include upload form
		$category = "profilepicture";
		$upload_dir = "images/profilepictures/";
		require ("./lib/php/lib_upload.php");
	?>
		<form id="useraddForm" class="useraddForm" action="frontend_useradd.php" method="post" accept-charset="UTF-8">
			<h4>Register New User:</h4>
			<!-- credentials -->
			<label for="username">UserName*:</label>
			<input type="text" name="username" id="username" maxlength="250" />
			
			<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
			<div id="error" class="error" data-role="collapsible" data-content-theme="c">
				<h3>error/status</h3>
				<p>
					<div id="details">details</div>
				</p>
			</div>
			
			<label for="password">Password*:</label> <input type="password" name="password" id="password" maxlength="250" />
			<label for="password_confirm">Password check*:</label>
			<input type="password" name="password_confirm" id="password_confirm" maxlength="250" />

			<?php
			/* get a list of all available user groups */
			echo '
			<fieldset data-role="controlgroup" data-type="vertical">
				<h4>Groups</h4>
				<input type="checkbox" name="checkbox_group_default" id="checkbox_group_default" class="custom checkbox_group_default" data-mini="true" value="1" class="ui-disabled" checked="true"/>
				<label class="checkbox_group_default_label" for="checkbox_group_default">username</label>
			';

			/* new user should not be able to be in admin group,
			 * only admins can add admins
			 * UNLESS PASSWD table IS completely EMPTY (fresh install) = HE/SHE IS THE FIRST USER! then he/she needs be admin.
			 */
			$allUsers = users();
			// is the only user of the system so far
			if(!$allUsers)
			{
				echo '
				<input type="checkbox" name="checkbox_group_admins" id="checkbox_group_admins" class="custom checkbox_group_default" data-mini="true" value="1" class="ui-disabled" checked="true"/>
				<label class="checkbox_group_admins_label" for="checkbox_group_admins">admins</label>
				';
			}

			/*
			if(($allowed_users != "all users including guests") && ($allowed_groups != "all groups including guests"))
			{
			}
			*/
			// is logged in user?
			if($session_valid)
			{
				$groups = getSystemGroups();
				$target = count($groups);
				for($i=0;$i<$target;$i++)
				{
					$display_group = true;
					if(groupname == "admins")
					{
						// 	is admin?
						if(!in_array("admins",$groups)) $display_group = false;
					}
					
					if($display_group)
					{
						$groupname = $groups[$i]->groupname;
						echo '
						<input type="checkbox" name="checkbox_group_'.$groupname.'" id="checkbox_group_'.$groupname.'" class="custom" data-mini="true"  value="0"/>
						<label for="checkbox_group_'.$groupname.'">'.$groupname.'</label>
						';
					}
				}
			}

			echo ' 
			</fieldset>
			';
			?>

			<h4> Details: </h4>
			<!-- additional infos about the user (optional, goes into passwd->data column, key:value,key:value,key:value, style  -->
			<label for="firstname">Firstname*: </label>
			<input type="text" name="firstname" id="firstname" maxlength="250" />
			
			<label for="lastname">Lastname*: </label>
			<input type="text" name="lastname" id="lastname" maxlength="250" />
			
			<label for="email">Email*:</label>
			<input type="text" name="email" id="email" maxlength="250" />

			<label for="home" title="this will be the default site the uesr get's redirected to after login">home:</label>
			<input type="text" name="home" id="home" maxlength="250" value="<?php global $settings_default_home_after_login; echo $settings_default_home_after_login; ?>"/>
			
			<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
			<div id="error1" class="error" data-role="collapsible" data-content-theme="c">
				<h3>error/status1</h3>
				<p>
					<div id="details1">details</div>
				</p>
			</div>

			<!-- default submit the ajax way button -->
			<input id="submitButton" type="submit" name="Submit" value="Save"/>
			
			<!-- this should enable submit-on-enter-key -->
			<input type="hidden" name="submitted" id="submitted" value="1"/>
		</form>
	</div>
	<div data-role="footer">
		<a href="#" data-role="button" data-rel="back" data-theme="c">Cancel</a>
	</div> 
</div>
</body>