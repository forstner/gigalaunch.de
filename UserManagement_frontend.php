<!-- ================= TODO
o test adding users
o test deleting users
o change all php to javascript, php generated sources out
currently on: getting page useradd to work (form like login)
o test profile picture upload :-D
... is broken. i don't know yet how to jquery->upload without page refresh. (it's a bigger problem so i won't fix it now)
... submit is wrong... because it submitts the whole form instead of triggering a upload
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

	<script type="text/javascript" src="lib/js/dynamically_load_js_and_css.js"></script>
	
	<!-- include library with user management commands -->
	<script type="text/javascript" src="lib/lib_users_and_groups.js"></script>	
</head>
<body>
	<div data-role="page" id="userList">
		<div data-role="header" data-position="inline" data-backbtn="true">
			<div class="ui-bar ui-bar-b">
				<a onclick="getAllUsers();" rel="external" data-ajax="false" class="nav_button admins" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">all</a>
				<a rel="external" data-ajax="false" class="nav_button admins" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">admins</a>
				<a rel="external" data-ajax="false" class="nav_button users" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">users</a>
				<a rel="external" data-ajax="false" class="nav_button yourself" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">yourself</a>
			</div>
		</div>
		<div class="content" data-role="content">
			<h4>All Users:</h4>
		</div>
		<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
		<div class="error_div"></div>
		
		<div data-role="footer">
			<div data-role="navbar">
				<ul>
					<li>
						<a data-icon="minus href="#popup_deleteUser" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" data-transition="pop">DELETE</a>
					</li>
					<li>
						<a data-icon="plus" href="#userAdd" rel="external" data-ajax="false">ADD</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- /footer -->
	</div>
	<!-- end page user list -->

	<div data-role="page" id="userAdd">
		<div data-role="header" data-position="inline" data-backbtn="true">
			<div class="ui-bar ui-bar-b">
				<a onclick="getAllUsers();" rel="external" data-ajax="false" class="nav_button admins" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">all</a>
				<a rel="external" data-ajax="false" class="nav_button admins" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">admins</a>
				<a rel="external" data-ajax="false" class="nav_button users" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">users</a>
				<a rel="external" data-ajax="false" class="nav_button yourself" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">yourself</a>
			</div>
		</div>
		<div class="content" data-role="content">
			<h4>add new User</h4>
			<form id="useraddForm" class="useraddForm"
				action="frontend_useradd.php" method="post" accept-charset="UTF-8">
				<h4>Register New User:</h4>
				<!-- credentials -->
				<label for="username">UserName*:</label>
				<input type="text" name="username" id="username" maxlength="250" />

				<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
				<div class="error_div"></div>

				<label for="password">Password*:</label> <input type="password"
					name="password" id="password" maxlength="250" /> <label
					for="password_confirm">Password check*:</label> <input
					type="password" name="password_confirm" id="password_confirm"
					maxlength="250" />
					
				<!-- here user can select and upload a profile picture, disabled temporarily -->
				<!--  
				<div id="fileUpload">
					<h4>ProfilePicture:</h4>
					<form action="./lib/php/lib_upload.php?" method="post" enctype="multipart/form-data" rel="external" data-ajax="false">
						<div id="_div" class="profilePictureParent">
							<img id="_div" src="" class="profilePicture"/>
						</div>
						<input type="file" name="file" id="file"><br>
						<input type="submit" name="submit" value="upload"><input type="hidden" name="selectUserId" value="">
					</form>
				</div>
				 -->

				<!-- get a list of all available user groups -->
				<fieldset data-role="controlgroup" data-type="vertical">
					<h4>Groups</h4>
					<div id="container_ListOfGroups"></div>
				</fieldset>
				
				<!-- DETAILS -->
				<div id="details">
					<h4>Details:</h4>
					<!-- additional infos about the user (optional, goes into passwd->data column, key:value,key:value,key:value, style  -->
					<label for="firstname">Firstname: </label>
					<input type="text" name="firstname" id="firstname" maxlength="250" /> <label for="lastname">Lastname: </label>
					<input type="text" name="lastname" id="lastname" maxlength="250" />
					<label for="email">Email*:</label>
					<input type="text" name="email" id="email" maxlength="250" /> <label
						for="home"
						title="this will be the default site the uesr get's redirected to after login">home:</label>
						
					<input type="text" name="home" id="home" maxlength="250" value="" />
					<a data-icon="plus" href="#dialog_add_detail_field" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" data-transition="pop">Add details</a>
				</div>
			</form>
		</div>

		<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
		<div class="error_div"></div>
		
		<div data-role="footer">
			<div data-role="navbar">
				<ul>
					<li>
						<a data-icon="minus" onclick="window.history.back();">CANCEL</a>
					</li>
					<li>
						<a data-icon="plus" onclick="" rel="external" data-ajax="false">SAVE</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- /footer -->
	</div>
	<!-- end page user list -->

	<!-- dialogs -->
	<!-- dialog_add_detail_field -->
	<div data-role="popup" id="dialog_add_detail_field" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
		<div data-role="header" data-theme="a" class="ui-corner-top">
			<h1>Please specify the field to add:</h1>
		</div>
		<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
			<label for="FieldName">FieldName:</label>
			<input type="text" name="FieldName" id="FieldName" maxlength="250" />
			<a onclick="addField();" href="#" data-role="button" data-inline="true" data-transition="flow" data-theme="b">Add</a>  
		</div>
	</div>
	
	<!-- dialog_deleteUser -->
	<div data-role="popup" id="popup_deleteUser" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
		<div data-role="header" data-theme="a" class="ui-corner-top">
			<h1>Do you really ...</h1>
		</div>
		<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
			<h3 class="ui-title">Are you sure you want to delete this user?</h3>
			<p>This action cannot be undone.</p>
			<h1>...want to delete these Users?</h1>
			<div id="dialog_deleteUser_content">
			</div>
			<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>    
			<a onclick="deleteUser();" href="#" data-role="button" data-inline="true" data-rel="back" data-transition="flow" data-theme="b">Delete</a>  
		</div>
	</div>
</body>
</html>