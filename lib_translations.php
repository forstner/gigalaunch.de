<?php
/* receives ajax/javascript-post-requests with hash#separated#keywords of translations
 * returns the translated texts again #hash#separated
 */ 
if(isset($_REQUEST["translations"]))
{
	$result = "";
	$translations = $_REQUEST["translations"];
	$translations_array = explode('#',$translations);
	
	$translations_array_count = count($translations_array);
	for($i = 0;$i < $translations_array_count;$i++)
	{
		translate($translations_array[$i]);
	}
}
/* get appropriate translation for the $keyword */
function translate($keyword)
{
	$result = null;
	global $mysqli_object;
	global $settings_database_auth_table;
	global $settings_database_name;
	$result = $mysqli_object->query("SELECT * FROM `translations` WHERE `keyword` = '".$keyword."'");

	return $result;
}
?>