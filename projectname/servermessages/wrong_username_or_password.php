<?php
require("../config/config.php");
?>
<!doctype html>
<html>
<head>
<meta http-equiv="refresh" content="3; URL=../login.php">
<title>redirect</title>
</head>
<body>
	<div id="parent">
		<div id="zentriert" class="gradientV">
			<fieldset>
				<h3>ERROR: LOGIN FAILED!</h3>
				<p>
				<div id="details">Sorry, but the given username+password combination was not valid.
				<br>
				<h3>not your fault?</hr>
				Contact the <a href="mailto:<?php global $settings_email_admin; echo $settings_email_admin; ?>">administrator</a>. </div>
				<br>
				You will be redirected to the <a href="../login.php">login</a> page... in 3 seconds. 
				</p>
			</fieldset>
			</form>
			</ul>
		</div>
	</div>
	</div>
</body>
</html>