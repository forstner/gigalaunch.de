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

	<!-- general stuff, client side functions to process server response -->
	<script type="text/javascript" src="lib/js/lib_general.js"></script>

	<!-- translations -->
	<script type="text/javascript" src="lib/js/lib_translate.js"></script>

	<!-- =========== THESE LINES YOU WILL HAVE TO ADAPT MANUALLY FOR EVERY PAGE =========== -->
	<link rel="stylesheet" type="text/css"        href="login_frontend.css"/> <!-- page specific css -->
	<script                type="text/javascript"  src="login_frontend.js"></script> <!-- page specific js -->
</head>
<body>
	<div data-role="page" id="login">
		<div data-role="header" data-position="inline">
			<script type="text/javascript">loadLogo();</script>
		</div>
		<div data-role="content">
			<h4>Login:</h4>
			<form id="loginForm" class="loginForm" action="" method="post" accept-charset="UTF-8">
			
				<!-- credentials -->
				<!-- username input -->
				<label for="username">UserName*:</label> <input type="text" name="username" id="username" maxlength="250" value="username"/>

				<!-- password input -->
				<!-- should not be submitted, because it has no name -->
				<label for="password_cleartext">Password*:</label> <input type="password" id="password_cleartext" maxlength="250" value="password"/>

				<!-- onkeypress this hidden field is updated and transmitted  type="hidden" -->
				<label for="password_encrypted">md5 Encrypted Password:</label><input id="password_encrypted" name="password_encrypted" id="password_encrypted" value="5f4dcc3b5aa765d61d8327deb882cf99"/>

				<!-- submit button -->
				<input id="signupsubmit" name="signup" type="submit" value="login"/>

				<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
				<div class="error_div"></div>
			</form>
		</div> 
		<div data-role="footer">
			<!-- if a user is not registered yet, they can click on this button -->
			<a href="frontend_useradd.php" rel="external">register</a>
		</div> 
	</div>
</body>
</html>