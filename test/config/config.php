<?php 
/* here the database credentials are beeing stored */
$settings_datasource = "mysql"; // right now can only be "mysql", could be postgress (not implemented) sqlite (not implemented)
$settings_database_server = "localhost";
$settings_database_name = "gigalaunch_wpt";
$settings_database_user = "root";
$settings_database_pass = "root";
$settings_database_auth_table = "passwd"; // what the table is called, where the users & passwords (md5 hashes) are stored
$settings_email_activation = "admin@server.org"; // this will be the sender/return address for activation mails send to your user after successfull registration with activation link
$settings_email_admin = "admin@server.org"; // not used yet
$settings_login_session_timeout = "1000"; // 0 = no timeout, amounts of seconds that login-cookies are valid, after login (time until user has to re-login)
/* 
 * personally i use /var/www/projectname as pdt/eclipse/aptana workspace
 * 
 * 1x project: if you are only hosting one project: than you probably have this project structure
 * /var/www/index.php
 * /var/www/login.php
 * ...
 * /var/www/library <- library is located here
 *  
 * multiple projects with virtualhosts in subdirectories of web-root
 * than your folder structure is probably like this:
 * /var/www/projectnamX/
 * /var/www/projectnamY/
 * /var/www/library/ <- library is still located here, and not redundant in projectnameX/library and projectnameY/library
 * so you need to update library in only one place
 */
$settings_multiple_projects = true;

/* global (for all pages) meta informations */
if($settings_multiple_projects)
{
	$parentfolder = "../";
}
else
{
	$parentfolder = "";	
}
$settings_meta = '
		<!-- meta -->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		
		<!-- apple-iphone specific stuff -->
		<meta name="apple-mobile-web-app-capable" content="yes"/>
		<meta name="apple-mobile-web-app-status-bar-style" content="white">
		<link rel="apple-touch-icon" href="images/opensource_icon.png"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- credits: who made this world a better place? -->
		<meta name="author" content="user">
		
		<!-- tools: what was used to make this world a better place -->
		<meta name="editor" content="pdt eclipse">
		
		<!-- default jquery mobile css -->
		<link rel="stylesheet" type="text/css" href="'.$parentfolder.'library/css/jquery.mobile-1.3.0.css" />
		<link rel="stylesheet" type="text/css" href="'.$parentfolder.'library/css/desktop_and_mobile.css" />
		
		<!-- custom project css -->
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		
		<!-- default js libraries: jquery, jquery mobile -->
		<script type="text/javascript" src="'.$parentfolder.'library/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="'.$parentfolder.'library/js/jquery.mobile-1.3.0.js"></script>

		<!-- client side functions to process server response -->
		<script type="text/javascript" src="'.$parentfolder.'library/js/gigalaunch.js"></script>

		<!-- page specific js includes & custom js code -->
		';
?>
