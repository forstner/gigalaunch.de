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
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

<title>usermanagement</title>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="css/offcanvas.css" rel="stylesheet">

<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>
	<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><img
					src="images/opensource_icon_18x18.png">hausautomation</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="#">Home</a></li>
					<li><a login_frontend.phphref="#about">About</a></li>
					<li><a href="#contact">Contact</a></li>
				</ul>
			</div>
			<!-- /.nav-collapse -->
		</div>
		<!-- /.container -->
	</div>
	<!-- /.navbar -->

	<div class="container">

		<div class="row row-offcanvas row-offcanvas-right">

			<div class="col-xs-12 col-sm-9">
				<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs"
						data-toggle="offcanvas">Toggle nav</button>
				</p>
				<div class="jumbotron">
					<h1>UserManagement</h1>
					<p>Here you can edit or delete existing or add new Users. To delete
						a user, please hit the edit button first.</p>
				</div>
				<div class="listOfusers row"></div>
				<!--/row-->
			</div>
			<!--/span-->

			<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar"
				role="navigation">
				<div class="list-group">
					<a href="#" class="list-group-item active">Link</a> <a href="#"
						class="list-group-item">Link</a> <a href="#"
						class="list-group-item">Link</a> <a href="#"
						class="list-group-item">Link</a> <a href="#"
						class="list-group-item">Link</a> <a href="#"
						class="list-group-item">Link</a> <a href="#"
						class="list-group-item">Link</a> <a href="#"
						class="list-group-item">Link</a> <a href="#"
						class="list-group-item">Link</a> <a href="#"
						class="list-group-item">Link</a>
				</div>
			</div>
			<!--/span-->
		</div>
		<!--/row-->

		<hr>

		<!-- user add/edit form -->
		<div class="row row-offcanvas row-offcanvas-right">
			<h4>Edit User:</h4>
			<div class="jumbotron">
				<label>Firstname:</label>
				<input id="Firstname" name="Firstname" type="text" class="form-control" required>
				<label>Lastname:</label>
				<input id="Lastname" name="Lastname" type="text" class="form-control" required>
				<img id="profilepicture" class="profilepicture" src="images/profilepictures/asian_model_profilepicture.jpg" alt="profile Picture">
			</div>
			<form class="form-userEdit" action="UserManagement_backend.php" onsubmit="javascript: return false;">
				<!-- username -->
				<label>UserName:</label>
				<input id="username" name="username" type="text" class="form-control" required>
				<!-- password -->
				<label >Password:</label>
				<!-- should not be submitted, because it has no name -->
				<input id="password_cleartext" type="password" class="form-control" placeholder="password" required>
				<!-- password check -->
				<input id="password_check" type="password" class="form-control" placeholder="password Again" required>
				<!-- onkeypress this hidden field is updated and transmitted  type="hidden" -->
				<input id="password_encrypted" name="password_encrypted" type="text" class="form-control" placeholder="generated encrypted password" required>
				<label>belongs to these Groups:</label>
				<p>tip on one of these buttons to make the user belong to this group (active button) or remove user from group (disabled button).</p>
				<ul class="groups nav nav-pills">
				</ul>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
				<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
				<div class="error_div"></div>
			</form>
		</div>

		<footer>
			<p>&copy; Company 2013</p>
		</footer>

	</div>
	<!--/.container-->


	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="lib/js/jquery.js"></script>
	<script src="lib/js/bootstrap.min.js"></script>
	<script src="lib/js/lib_webtoolkit.md5.js"></script>
	<script src="lib/js/lib_general.js"></script>
	<script src="lib/js/lib_users_and_groups.js"></script>
	<script>
    $(document).ready(function() {
        users(function(data)
		{
			$(".listOfusers").fillTemplate(data,'<div class="col-6 col-sm-6 col-lg-4"><div class="thumbnail"><img class="profilepicture" src="$profilepicture" alt="profile Picture"><div class="caption"><h3>$firstname $lastname</h3><p>Username: $username</p><p>mail: <a href="mailto:$mail">$mail</a></p><p style="text-align: right;"><a href="#" class="btn btn-primary" role="button">Edit</a></p></div></div></div>');
		});

        groups(function(data)
		{
			$(".groups").fillTemplate(data,'<li><a href="#">$groupname</a></li>');
		});
    });
    </script>
</body>
</html>