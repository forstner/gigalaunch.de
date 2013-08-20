<?php
/* ================= please put this on top of every page, modify the allowed users/groups entries to manage access per page. */
error_reporting(E_ALL); // turn the reporting of php errors on
$allowed_users = "all logged in users"; // a list of userIDs that are allowed to access this page
$allowed_groups = ""; // a list of groups, that are allowed to access this page
require('lib_security.php'); // will mysql-real-escape all input
include("config/config.php"); // load project-config file
require('lib_session.php'); // will immediately exit and redirect to login if the session is not valid/has expired/user is not allowed to access the page
/* ================= */

// what list of users should be displayed right now?
$group = "*";
if(isset($_REQUEST['group'])) $group = $_REQUEST['group'];

// is the user in group admins? -> then show all users
global $UserGroups;
global $user;
$is_admin = false;
if(in_array('admins', $UserGroups))
{
	// yes he/she is, no restrictions
	$is_admin = true;
}

echo '
<!DOCTYPE html> 
<html>
<head> 
	<title>';global $settings_current_filename; echo $settings_current_filename; echo '</title>';
	global $settings_meta; echo $settings_meta;
	echo '
</head>
<body>';
	
echo '
	<div data-role="page" id="admin">
		<div data-role="header" data-position="inline" data-backbtn="true">
			<div class="ui-bar ui-bar-b">';
if($is_admin)
{
	if($group == "admins") {
		// highlight
		echo '<a href="frontend_UserManagement.php?group=admins" rel="external" data-ajax="false" class="nav_button admins" data-role="button" data-theme="e" data-inline="true" data-mini="true" data-icon="bars">admins</a>';
	}
	else {
		echo '<a href="frontend_UserManagement.php?group=admins" rel="external" data-ajax="false" class="nav_button admins" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">admins</a>';
	}
	
	if($group == "users") {
		// highlight
		echo '<a href="frontend_UserManagement.php?group=users" rel="external" data-ajax="false" class="nav_button users" data-role="button" data-theme="e" data-inline="true" data-mini="true" data-icon="bars">users</a>';
	}
	else {
		echo '<a href="frontend_UserManagement.php?group=users" rel="external" data-ajax="false" class="nav_button users" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">users</a>';
	}
}

if($group == "yourself") {
	// highlight
	echo '<a href="frontend_UserManagement.php?group=yourself" rel="external" data-ajax="false" class="nav_button yourself" data-role="button" data-theme="e" data-inline="true" data-mini="true" data-icon="bars">yourself</a>';
}
else {
	echo '<a href="frontend_UserManagement.php?group=yourself" rel="external" data-ajax="false" class="nav_button yourself" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">yourself</a>';
}


echo '
		<a href="frontend_useradd.php" rel="external" data-ajax="false" class="nav_button home" data-theme="a" data-role="button" data-inline="true" data-mini="true" data-icon="plus">useradd</a>
	</div>
</div>
<div data-role="content">
';

if($is_admin)
{
	// yes he/she is, no restrictions
	generateUserList($group);
}
else
{
	// no, i don't hink so, only display the logged in user
	if(!($group == "admins"))
	{
		generateUserList($user->username);
	}
}
	
echo '</div>'; // end content

// footer
echo '<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
		<div id="error" class="error" data-role="collapsible" data-content-theme="c">
			<h3>error/status</h3>
			<p>
				<div id="details">details</div>
			</p>
		</div>
		
		<div data-role="footer">
				<div data-role="navbar">
					<ul>
						<li>
							<a data-icon="minus" href="#" onclick="openDialogDelete();">DELETE</a>
						</li>
						<li>
							<a data-icon="plus" href="frontend_useradd.php" rel="external" data-ajax="false">ADD</a>
						</li>
		<!--
						<li>
							<a data-icon="star" href="#">SAVE</a>
						</li>
		-->
					</ul>
				</div>
				<!-- /navbar -->
			</div>
<!-- /footer -->
</div>'; // end page

// dialog
echo '
<div data-role="dialog" id="deleteDialog">
	<div data-role="header" data-theme="d">
		<h1>Do you really ...</h1>
	</div>
	<div data-role="content">
		<h1>...want to delete these Users?</h1>
		<div id="deleteDialog_content">
		</div>
		<a href="#" onclick="deleteUser();" data-role="button" data-rel="back" data-theme="b">Delete</a>       
		<a href="#" data-role="button" data-rel="back" data-theme="c">Cancel</a>    
	</div>
</div>
</body>
</html>';
?>