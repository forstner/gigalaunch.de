<?php
require("../config/config.php");
?>
<!doctype html>
<html>
<head>
<meta http-equiv="refresh" content="10; URL=../frontend_frontend_login.php">
<title>redirect</title>
</head>
<body>
	<div id="parent">
		<div id="zentriert" class="gradientV">
			<fieldset>
				<h3>ERROR: ACCESS NOT ALLOWED</h3>
				<p>
				<div id="details">the $allowed_groups variable is missing in the page that you requested, the platform can not
				detemine if you are allowed to access this page.... please contact the <a href="mailto:<?php global $settings_email_admin; echo $settings_email_admin; ?>">administrator</a>. </div>
				<br>
				You will be taken back to <a href="../frontend_frontend_login.php">login</a> in 10 seconds... 
				</p>
			</fieldset>
			</form>
			</ul>
		</div>
	</div>
	</div>
</body>
</html>