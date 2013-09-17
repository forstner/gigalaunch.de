<?php
/* ================= please put this on top of every page, modify the allowed users/groups entries to manage access per page. */
error_reporting(E_ALL); // turn the reporting of php errors on
$allowed_users = "all users including guests"; // a list of userIDs that are allowed to access this page 
$allowed_groups = "all groups including guests"; // a list of groups, that are allowed to access this page
require_once('./lib/php/lib_security.php'); // will mysql-real-escape all input
require_once("config/config.php"); // load project-config file
/* ================= */
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

	<!-- css valid for all projects, includes the default jquery mobile css -->
	<link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.3.0.min.css" />
	<link rel="stylesheet" type="text/css" href="css/global.css"/>

	<!-- project wide css -->
	<link rel="stylesheet" type="text/css" href="css/projectWide.css"/>

	<!-- file wide css -->
	<link rel="stylesheet" type="text/css" href="css/'+CurrentFilename+'.css"/>

	<!-- project wide js libraries: jquery, jquery mobile -->
	<script type="text/javascript" src="lib/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="lib/js/jquery.mobile-1.3.0.min.js"></script>

	<!-- timer plugin -->
	<script type="text/javascript" src="lib/js/lib_jquery.timer.js"></script>

	<!-- js-client-side-md5, so that no password gets over network unencrypted, esp not during registration -->
	<script type="text/javascript" src="lib/js/lib_webtoolkit.md5.js"></script>

	<!-- nice input validation plugin -->
	<script type="text/javascript" src="lib/js/lib_jquery.validate.js"></script>

	<!--  provices conversion function -->
	<script type="text/javascript" src="lib/js/lib_convert.js"></script>

	<!--  provices string operation functions -->
	<script type="text/javascript" src="lib/js/lib_strings.js"></script>

	<!-- client side functions to process server response -->
	<script type="text/javascript" src="lib/js/lib_general.js"></script>

	<!-- translations -->
	<script type="text/javascript" src="lib/js/lib_translate.js"></script>
			
	<!-- page specific js includes & custom js code -->
	<script type="text/javascript" src="'+CurrentFilename+'.js"></script>
</head>
<body>
	<div data-role="page" id="forgottenPassword">
		<div data-role="header" data-position="inline">
			<?php global $settings_logo; echo $settings_logo; ?>
		</div>
		<div data-role="content">
			<h4 class="translate">password forgotten?</h4>
			<form id="forgottenPasswordForm" class="forgottenPasswordForm" action="forgottenPassword_backend.php" method="post" accept-charset="UTF-8" data-ajax="false">
				<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
				<div id="error" class="error" data-role="collapsible">
					<h3>error/status</h3>
					<p>
					<div id="details">details</div>
					</p>
				</div>
				
				<label for="mail">mail*:</label>
				<input type="text" name="mail" id="mail" maxlength="250" value=""/>

				<!-- submit button -->
				<input type="submit" name="Submit" class="translate" value="Please mail me a new password." />

			</form>
		</div> 
		<div data-role="footer">
			<!-- if a user is not registered yet, they can click on this button -->
			<a href="frontend_useradd.php" rel="external">register</a>
		</div> 
	</div>
</body>
</html>