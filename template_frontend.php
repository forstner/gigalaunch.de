<?php
/* ================= please put this on top of every page */
error_reporting(E_ALL); // turn the reporting of php errors on
$allowed_users = "1,2,3,4,5,"; // a list of userIDs that are allowed to access this page
require_once("config/config.php");
// require_once('lib_session.php'); // will immediately exit and redirect to login if the session is not valid/has expired/user is not allowed to access the page
/* ================= */

// footer used for every div subpage
$footer = '<div data-role="footer">
				<div data-role="navbar">
					<ul>
						<li>
							<a data-icon="grid" rel="external" href="#subpage1" tooltip="load link via ajax into this page (js of page to load will">link to subdivpage1</a>
						</li>
						<li>
							<a data-icon="bars" rel="external" href="frontend_template.php#subpage2" tooltip="load link via ajax into this page (js of page to load will">link to subdivpage2</a>
						</li>
						<li>
							<a data-icon="forward" rel="external" href="frontend_useradd.php" data-role="button" data-inline="true" data-mini="true" tooltip="this will completely load/go to an external page, initializing all the javascript of this external page, which is good if you plan to do modular web applications">go to external page</a>
						</li>
					</ul>
				</div>
				<!-- /navbar -->
			</div>
<!-- /footer -->';

// header used for every div subpage
$header = '
		<div data-role="header" data-position="inline" data-backbtn="true">
			<div class="ui-bar ui-bar-b">
				<a href="#" onclick="window.history.back();" data-role="button" data-inline="true" data-mini="true" data-icon="back">Back</a>
				<a class="nav_button subpage1" href="#subpage1" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="grid">subpage1</a>
				<a class="nav_button subpage2" href="#subpage2" data-role="button" data-theme="a" data-inline="true" data-mini="true" data-icon="bars">subpage2</a>
				<a class="nav_button home" data-theme="e" href="frontend_useradd.php" data-role="button" data-inline="true" data-mini="true" data-icon="plus" rel="external" data-ajax="false">useradd</a>
			</div>
		</div>
		';
?>
<!DOCTYPE html> 
<html>
<head> 
	<title><?php global $settings_current_filename; echo $settings_current_filename; ?></title>
	
	<?php global $settings_meta; echo $settings_meta; ?>
	<?php global $settings_current_filename; echo $settings_current_filename; ?></title>
</head> 
<body> 
	<!-- js applied only to this page, external file is better for firebug -->
	<div data-role="page" id="subpage1">
		<?php echo $header; ?>
		<div data-role="content">
			<h4>systematic</h4>
			<p>jqm allows you to put several "sub-div-pages" inside one page.
			<br>
			but i recommend building/testing programs/websites on a modular basis.
			<br>
			meaning: instead of putting everything inside one page, there are components (frontend_useradd.php)
			that you want to reuse.
			<br>
			jqm can also blend/slide smoothly to external pages.
			<br>
			meaning:
			<br>
			frontend_login.php -> does login, nothing else<br>
			frontend_useradd.php -> allows you to add users (this dialog can be reused)<br>
			<br>
			testing:
			<br>
			write test-documentation for every module, change, test, release.
			<br>
			<br>
			have more fun!
			</p>
		</div>
		<?php echo $footer; ?>
	</div>
	
	<div data-role="page" id="subpage2">
		<?php echo $header; ?>
		<div data-role="content">
			<div data-role="collapsible-set" data-theme="c" data-content-theme="d">
				<div data-role="collapsible">
				    <h4><strong> Platform </strong> support in 1.3.0</h4>
						<p>jQuery Mobile has broad support for the vast majority of all modern desktop, smartphone, tablet, and e-reader platforms. In addition, feature phones and older browsers&nbsp;are supported because of our progressive enhancement approach.&nbsp;We’re very proud of our commitment to universal accessibility through our broad support for all popular platforms.</p>
						<p>We use a 3-level graded platform support system: <strong>A</strong> (full), <strong>B</strong> (full minus Ajax), <strong>C</strong> (basic HTML). The visual fidelity of the experience and smoothness of page transitions are highly dependent on the CSS rendering capabilities of the device and platform so not all A grade experience will be pixel-perfect but that’s the nature of the web.</p>
						<p>* <strong>Note</strong>: If jQuery core 1.8+ is used with jQuery Mobile, iOS 3.x and BB5 are re-graded to C level support because core dropped support for methods these platforms need for full functionality.</p>
				</div>

				<div data-role="collapsible">
				    <h4><strong> A-grade</strong> – Full enhanced experience with Ajax-based animated page transitions.</h4>
					<ul>
					<li><strong>Apple iOS 3.2*-6.1</strong> -&nbsp;Tested on the original iPad (4.3 / 5.0), iPad 2 (4.3 / 5.1 / 6.1), iPad 3 (5.1 / 6.0), iPad Mini (6.1), 3GS (4.3), 4 (4.3 / 5.1), and 4S (5.1 / 6.0), and 5 (6.0)</li>
					<li><strong>Android 2.1-2.3</strong> – Tested on the HTC Incredible (2.2), original Droid (2.2), HTC Aria (2.1), Google Nexus S (2.3). Functional on 1.5 &amp; 1.6 but performance may be sluggish, tested on Google G1 (1.5)</li>
					<li><strong>Android 3.2 (Honeycomb)&nbsp;</strong> – Tested on the Samsung Galaxy Tab 10.1 and Motorola XOOM</li>
					<li><strong>Android 4.0 (ICS)&nbsp;</strong> – Tested on a Galaxy Nexus. Note: transition performance can be poor on <em>upgraded</em> devices</li>
					<li><strong>Android 4.1 (Jelly Bean)&nbsp;</strong> – Tested on a Galaxy Nexus and Galaxy 7</li>
					<li><strong>Windows Phone 7.5-7.8</strong> – Tested on the HTC Surround (7.5), HTC Trophy (7.5), LG-E900 (7.5), Nokia Lumia 800 (7.8)</li>
					<li><strong>Blackberry 6-10</strong> – Tested on the Torch 9800 (6) and Style 9670 (6), BlackBerry® Torch 9810 (7), BlackBerry Z10 (10)</li>
					<li><strong>Blackberry Playbook&nbsp;(1.0-2.0)</strong> – Tested on PlayBook</li>
					<li><strong>Palm WebOS (1.4-3.0)</strong> – Tested on the Palm Pixi (1.4), Pre (1.4), Pre 2 (2.0), HP TouchPad(3.0)</li>
					<li><strong>Firefox Mobile 18</strong> – Tested on Android 2.3 and 4.1 devices</li>
					<li><strong>Chrome for Android 18</strong> – Tested on Android 4.0 and 4.1 devices</li>
					<li><strong>Skyfire 4.1</strong> -&nbsp;Tested on Android 2.3 device</li>
					<li><strong>Opera Mobile 11.5-12</strong>: Tested on Android 2.3</li>
					<li><strong>Meego 1.2</strong> – Tested on Nokia 950 and N9</li>
					<li><strong>Tizen</strong> (pre-release) – Tested on early hardware</li>
					<li><strong>Samsung&nbsp;Bada 2.0</strong> – Tested on a Samsung Wave 3, Dolphin browser</li>
					<li><strong>UC Browser</strong> – Tested on Android 2.3 device</li>
					<li><strong>Kindle 3, Fire, and Fire HD </strong> -&nbsp;Tested on the built-in WebKit browser for each</li>
					<li><strong>Nook Color 1.4.1</strong> – Tested on original Nook Color, not Nook Tablet</li>
					<li><strong>Chrome <strong>Desktop </strong>16-24</strong>&nbsp;- Tested on OS X 10.7 and Windows 7</li>
					<li><strong>Safari <strong>Desktop </strong>5-6</strong>&nbsp;- Tested on OS X 10.8</li>
					<li><strong>Firefox Desktop 10-18</strong> – Tested on&nbsp;OS X 10.7 and Windows 7</li>
					<li><strong>Internet Explorer 8-10</strong> – Tested on Windows XP, Vista and 7, Windows Surface RT</li>
					<li><strong>Opera Desktop&nbsp;10-12</strong> -&nbsp;Tested on&nbsp;OS X 10.7 and Windows 7</li>
					</ul>
				</div>

				<div data-role="collapsible">
				    <h4><strong>B-grade</strong> – Enhanced experience except without Ajax navigation features.</h4>
					<ul>
					<li><strong>Blackberry 5.0*</strong>:&nbsp;Tested on the Storm 2 9550, Bold 9770</li>
					<li><strong>Opera Mini 7</strong> -&nbsp;Tested on iOS 6.1 and Android 4.1</li>
					<li><strong>Nokia Symbian^3 </strong>- Tested on Nokia N8 (Symbian^3), C7 (Symbian^3), also works on N97 (Symbian^1)</li>
					<li><strong>Internet Explorer 7</strong> – Tested on Windows XP</li>
					</ul>
				</div>
				
				<div data-role="collapsible">
				    <h4><strong>C-grade</strong></strong> – Basic, non-enhanced HTML experience that is still functional</h4>
					<ul>
					<li><strong>Internet Explorer 6 and older</strong> – Tested on Windows XP</li>
					<li><strong>iOS 3.x and older</strong> – Tested on original iPhone (3.1), iPhone 3 (3.2)</li>
					<li><strong>Blackberry 4.x</strong> -&nbsp;Tested on the Curve 8330</li>
					<li><strong>Windows Mobile</strong>&nbsp;- Tested on the HTC Leo (WinMo 5.2)</li>
					<li><strong>All older smartphone platforms and featurephones</strong> – Any device that doesn’t support media queries will receive the basic, C grade experience</li>
					</ul>
				</div>
			</div>
		</div>
		<?php echo $footer; ?>
	</div>
</body>
</html>