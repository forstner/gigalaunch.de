<?php
/* ================= */
error_reporting(E_ALL); // turn the reporting of php errors on
$allowed_users = "1,2,3,4,5"; // a list of userids that are allowed to access this page
$allowed_groups = "admin,admins"; // a list of groups, that are allowed to access this page
require_once('./lib/php/lib_security.php'); // will mysql-real-escape all input
require_once("config/config.php"); // load project-config file
require_once('./lib/php/lib_session.php'); // will immediately exit and redirect to login if the session is not valid/has expired/user is not allowed to access the page
/* ================= */

/* handle user-registeration */
/* is it an activation ? */
$received_activation = "";
require_once('./lib/php/lib_general.php');
// loads require ("./lib/php/lib_security.php");

// init database
$mysqli_object = new class_mysqli_interface();

// 1. get user
if(isset($_REQUEST['selectUserId']))
{
	$user2edit = getUser($_REQUEST['selectUserId']);
}
if(isset($_REQUEST['editUserId']))
{
	$user2edit = getUser($_REQUEST['editUserId']);
}

// 2. put all user's data into the input fields
$data = getDataOfUserID(null,$user2edit);
// 3. wait for a change request
$UserGroups = getgetGroupsOfUser($user2edit);

if(!empty($_REQUEST['selectUserId'])) /* is it an select user action? */
{
}

if(!empty($_REQUEST['editUserId'])) /* is it an change user action? */
{
	// check if unsername allready taken, by different user id
	$user_with_requested_username = getUserByUsername($_REQUEST['username']);
	
	if(isset($user_with_requested_username))
	{
		if($user_with_requested_username->id != $user2edit->id)
		{
			exit('type:error,id:Username already taken,details:Username already taken. Please choose different one.');
		}
	}
	
	if ($_REQUEST['password'] != $_REQUEST['password_confirm']) {
		exit('type:error,id:password missmatch,details:the passwords you entered did not match. ');
	} else {
		/* update user record */
		/*
		 * "$_REQUEST"	Array [16]	
				username	david	
				password	5f4dcc3b5aa765d61d8327deb882cf99	
				password_confirm	5f4dcc3b5aa765d61d8327deb882cf99	
				checkbox_group_david	1	
				checkbox_group_admins	1	
				checkbox_group_elektriker	0	
				checkbox_group_kunde	1	
				checkbox_group_geraet	1	
				checkbox_group_username	0	
				firstname	david	
				lastname	forstner	
				email	admin@dwaves.de	
				home	frontend_UserManagement.php	
				Submit	Save	
				submitted	1	
				editUserId	3	
		 */

		/* merge existing with new data */
		$userdata = "";
		$data['firstname'] = $_REQUEST['firstname'];
		$data['lastname'] = $_REQUEST['lastname'];
		$data['email'] = $_REQUEST['email'];
		$data['home'] = $_REQUEST['home'];
		if(isset($_REQUEST['profilepicture']))
		{
			$data['profilepicture'] = $_REQUEST['profilepicture'];
		}
		$userdata = array2string($data);

		// get informations about groups
		$UserGroups = getREQUESTSstarting("checkbox_group");
		$groups_string = "";
		foreach ($UserGroups as $key => $value)
		{
			if($value == "1")
			{
				$count = strlen("checkbox_group_");
				$key_count = strlen($key);
				$substring = substr($key, $count, $key_count);
				$groups_string .= $substring.",";
			}
		}

		// overwrite properties of the instance
		$user2edit->data = $userdata;
		$user2edit->username = $_REQUEST['username'];
		$user2edit->password = $_REQUEST['password'];
		$user2edit->groups = $groups_string;
		
		// CHANGE/UPDATE/EDIT THE USER
		$output = useredit($user2edit);
	
		// check if any error
		if(!$output)
		{
			exit('type:success,id:edit user successfull,details:The details/Credentials of the user where edited user successfully.');
		}
		else
		{
			exit('type:error,id:registration failed,details:'.$output);
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
<div data-role="page" id="useredit">
	<div data-role="header" data-position="inline" data-backbtn="true">
		<div class="ui-bar ui-bar-b">
			<a href="#" onclick="window.history.back();" data-role="button" data-inline="true" data-mini="true" data-icon="back">Back</a>
		</div>
	</div>
	<div data-role="content">
	<h4> add new User </h4>
	<?php
		// include upload form
		$upload_change_filename = $user2edit->username;
		$category = "profilepicture";
		$upload_dir = "images/profilepictures/";
		if(isset($data))
		{
			if(isset($data['profilepicture']))
			{
				$showImage = $data['profilepicture'];
			}
		}
		require ("./lib/php/lib_upload.php");
	?>
		<form id="usereditForm" class="usereditForm" action="frontend_useredit.php" method="post" accept-charset="UTF-8">
			<h4>Edit User:</h4>
			<!-- credentials -->
			<label for="username">UserName*:</label>
			<input type="text" name="username" id="username" maxlength="250" style="editable:false;" value="<?php echo $user2edit->username; ?>"/>

			<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
			<div id="error" class="error" data-role="collapsible" data-content-theme="c">
				<h3>error/status</h3>
				<p>
					<div id="details">details</div>
				</p>
			</div>
			
			<label for="password">Password*:</label> <input type="password" name="password" id="password" maxlength="250" value="<?php echo $user2edit->password; ?>"/>
			<label for="password_confirm">Password check*:</label>
			<input type="password" name="password_confirm" id="password_confirm" maxlength="250" value="<?php echo $user2edit->password; ?>"/>

			<?php
			/* get a list of all available user groups */
			echo '
			<fieldset data-role="controlgroup" data-type="vertical">
				<h4>Groups</h4>
				<input type="checkbox" name="checkbox_group_'.$user2edit->username.'" id="checkbox_group_default" class="custom" data-mini="true" value="1" class="ui-disabled"/>
				<label class="checkbox_group_default_label" for="checkbox_group_default">'.$user2edit->username.'</label>
			';

			$AllGroups = getGroups("as array");

			// groups that do not exist in $SytemGroups, will be appended to $SytemGroups array and returned as result
			$target = count($AllGroups);
			for($i=0;$i<$target;$i++)
			{
				$groupname = $AllGroups[$i];

				// do not add another default_group checkbox
				if($groupname != $user2edit->username)
				{
					// if the user belongs to that group check the checkbox
					if(in_array($groupname,$UserGroups))
					{
						echo '
						<input type="checkbox" name="checkbox_group_'.$groupname.'" id="checkbox_group_'.$groupname.'" class="custom checked" data-mini="true"  value="1" checked="true"/>
						<label for="checkbox_group_'.$groupname.'">'.$groupname.'</label>
										';
					}
					else
					{
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
			<input type="text" name="firstname" id="firstname" maxlength="250" value="<?php if(isset($data)) echo $data['firstname']; ?>"/>
			
			<label for="lastname">Lastname*: </label>
			<input type="text" name="lastname" id="lastname" maxlength="250" value="<?php if(isset($data)) echo $data['lastname']; ?>"/>
			
			<label for="email">Email*:</label>
			<input type="text" name="email" id="email" maxlength="250" value="<?php if(isset($data)) echo $data['email']; ?>"/>

			<label for="home" title="this will be the default site the uesr get's redirected to after login">home:</label>
			<input type="text" name="home" id="home" maxlength="250" value="<?php if(isset($data)) echo $data['home']; ?>"/>

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
			
			<input type="hidden" name="editUserId" value="<?php echo $user2edit->id; ?>">
		</form>
	</div>
	<div data-role="footer">
		<a href="#" data-role="button" data-rel="back" data-theme="c">Cancel</a>
	</div> 
</div>
</body>