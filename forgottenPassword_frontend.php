<?php
/* ================= please put this on top of every page, modify the allowed users/groups entries to manage access per page. */
error_reporting(E_ALL); // turn the reporting of php errors on
$allowed_users = "all users including guests"; // a list of userIDs that are allowed to access this page 
$allowed_groups = "all groups including guests"; // a list of groups, that are allowed to access this page
require('lib_security.php'); // will mysql-real-escape all input
include("config/config.php"); // load project-config file
/* ================= */
?>
<!DOCTYPE html> 
<html> 
<head> 
	<title><?php global $settings_current_filename; echo $settings_current_filename; ?></title>
	<?php global $settings_meta; echo $settings_meta; ?>
</head>
<body>
	<div data-role="page" id="forgottenPassword">
		<div data-role="header" data-position="inline">
			<?php global $settings_logo; echo $settings_logo; ?>
		</div>
		<div data-role="content">
			<h4 translate="this">password forgotten?</h4>
			<form id="forgottenPasswordForm" class="forgottenPasswordForm" action="forgottenPassword_backend.php" method="post" accept-charset="UTF-8" data-ajax="false">
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
				<input type="submit" name="Submit" value="forgottenPassword" />

			</form>
		</div> 
		<div data-role="footer">
			<!-- if a user is not registered yet, they can click on this button -->
			<a href="frontend_useradd.php" rel="external">register</a>
		</div> 
	</div>
</body>
</html>