<?php
include_once("config/config.php");

/* if frontend needs info from backend, will not provide any confidential stuff here */
$question = $_REQUEST["question"];
if($question == "path to logo")
{
	echo $settings_platform_logo;
}
?>