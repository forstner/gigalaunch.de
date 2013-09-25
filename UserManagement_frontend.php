<!-- ================= TODO
o change all php to javascript, php generated sources out 
-->
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

	<!-- user management functions -->
	<script type="text/javascript" src="lib/lib_users.js"></script>
	
	<!-- =========== THESE LINES YOU WILL HAVE TO ADAPT MANUALLY FOR EVERY PAGE =========== -->
	<link rel="stylesheet" type="text/css"        href="UserManagement_frontend.css"/> <!-- page specific css -->
	<script                type="text/javascript"  src="UserManagement_frontend.js"></script> <!-- page specific js -->
	
</head>
<body>
	<div data-role="page" id="admin">
		<div data-role="header" data-position="inline" data-backbtn="true">
			<div class="ui-bar ui-bar-b">
				<a onclick="getAllUsers();" rel="external" data-ajax="false" class="nav_button admins" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">all</a>
				<a rel="external" data-ajax="false" class="nav_button admins" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">admins</a>
				<a rel="external" data-ajax="false" class="nav_button users" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">users</a>
				<a rel="external" data-ajax="false" class="nav_button yourself" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">yourself</a>
			</div>
		</div>
		<div id="content" data-role="content">
			<h4>All Users:</h4>
		</div>
		<!-- 
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
		 -->
		<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
		<div id="login_error_div"></div>
		
		<div data-role="footer">
				<div data-role="navbar">
					<ul>
						<li>
							<a data-icon="minus" href="#" onclick="openDialogDelete();">DELETE</a>
						</li>
						<li>
							<a data-icon="plus" href="useradd.php" rel="external" data-ajax="false">ADD</a>
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
	</div>
	<!-- end page -->

	<!-- dialog -->
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
</html>