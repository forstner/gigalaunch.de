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
	
	<!-- load page specific css -->
	<script src="login_frontend.js" type="text/javascript"></script>

	<!-- load page specific js -->
	<link rel="stylesheet" type="text/css" href="login_frontend.css"/>
</head>
<body>
	<div data-role="page" id="login">
		<div data-role="header" data-position="inline">
			<div class="logo"><!-- here the function loadLogo(); in lib_general.js will load the logo from the config file. --></div>
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

				<!-- login button -->
				<input id="button_login" name="button_login" type="submit" value="login"/>

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
