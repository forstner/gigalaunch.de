<?php
require("../config/config.php");
?>
<!doctype html>
<html>
<head>
<meta http-equiv="refresh" content="30; URL=../frontend_login.php">
<title>redirect</title>
</head>
<body>
	<div id="parent">
		<div id="zentriert" class="gradientV">
			<fieldset>
				<h3>PARTLY SUCCESSFULL!?</h3>
				<p>
				<div id="details">User was registered, but server could not send the activation mail.
				<br>
				please contact the <a href="mailto:<?php global $settings_email_admin; echo $settings_email_admin; ?>">administrator</a>. </div>
				<br>
				You will be redirected to the <a href="../frontend_login.php">login</a> page... in 30 seconds. 
				</p>
			</fieldset>
			</form>
			</ul>
		</div>
	</div>
	</div>
</body>
</html>