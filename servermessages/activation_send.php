<?php
require_once("../config/config.php");
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
				<h3>SUCCESS: REGISTRATION SUCCESSFULL!</h3>
				<p>
				<div id="details">Check your mails, you should have gotten an activation link in your mail.
				Please click that link to validate your email address.
				<br>
				If you have not gotten an activation mail soon, please contact the <a href="mailto:<?php global $settings_mail_admin; echo $settings_mail_admin; ?>">administrator</a>. </div>
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