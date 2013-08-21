<?php
require_once("../config/config.php");
?>
<!doctype html>
<html>
<head>
<meta http-equiv="refresh" content="10; URL=../frontend_login.php">
<title>redirect</title>
</head>
<body>
	<div id="parent">
		<div id="zentriert" class="gradientV">
			<fieldset>
				<h3>ERROR: GROUP NO ACCESS RIGHTS</h3>
				<p>
				<div id="details">
				your user is not in a group that has access rights to this page.
				<br>
				<br>If you think this is a error/mistake: please contact the <a href="mailto:<?php global $settings_mail_admin; echo $settings_mail_admin; ?>">administrator</a>. </div>
				... you will be taken back to <a href="../frontend_login.php">login</a>. in 10 seconds.
				</p>
			</fieldset>
			</form>
			</ul>
		</div>
	</div>
	</div>
</body>
</html>