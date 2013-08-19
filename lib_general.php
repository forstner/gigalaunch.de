<?php
/* just very general functions, is included via config.php
 * so that it is available to all files */

/* when a group of checkboxes is transmitted via form
 * name="checkbox_group_admins"
 * name="checkbox_group_users"
 * ... one wants to extract all this group info into one array/object
 */
function getREQUESTSstarting($with)
{
	$result = array();
	$count = strlen($with);
	foreach ($_REQUEST as $key => $value)
	{
		$substring = substr($key, 0, $count);
		if($substring == $with)
		{
			$result[$key] = $value;
		}
	}
	
	return $result;
}

/* generates a server response as html page 
 * input: exit('type:error,id:session expired,details:Please re-login!. ');
 */
function generateServerMessage($message)
{
	$type = ""; // can be error, success
	$id = ""; // unique id of the error
	$details = ""; // give details to add meaning and allow users/admins to debug the problem

	$array = explode(',',$message);
	
	$target = count($array);
	for($i=0;$i<$target;$i++)
	{
		$key_value = explode(':',$array[$i]);
		if($i == 0)
		{
			$type = $key_value[1];
		}
		else if($i == 1)
		{
			$id = $key_value[1];
		}
		else if($i == 2)
		{
			$details = $key_value[1];
		}
		
	}
	echo '
	<!doctype html>
	<html>
	<head>
	<meta http-equiv="refresh" content="99; URL=../frontend_frontend_login.php">
	<title>redirect</title>
	</head>
	<body>
	<div id="parent">
	<div id="zentriert" class="gradientV">
	<fieldset>
	<h3>'.$type.': '.$id.'</h3>
	<p>
	<div id="details">
	'.$details.'
	<br>
	<hr>
	<h3>not your fault?</hr>
	Contact the <a href="mailto:<?php global $settings_email_admin; echo $settings_email_admin; ?>">administrator</a>. </div>
	</p>
	</fieldset>
	</form>
	</ul>
	</div>
	</div>
	</div>
	</body>
	</html>';
}

/* merge two arrays with unique values, adds a value to an array, if such an value does not exist yet.
 * example:
 * groups that do not exist in $SytemGroups, will be appended to $SytemGroups array and returned as result
 	$SytemGroups = getSystemGroups();
	$groups_tmp = AddToArrayIfNotExist($groups, $SytemGroups);
*/
function AddToArrayIfNotExist($array1,$array2)
{
	$result = $array1; // In PHP arrays are assigned by copy, while objects are assigned by reference.
	foreach ($array2 as $key => $value)
	{
		if(!in_array($value,$result))
		{
			$result[] = $value; // push
		}
	}

	return $result;
}
/* this takes timestampt, md5-hashes it then cuts it down to 8 characters */
function salt()
{
	$salt = substr(md5(time()), 8); // date("F")
	return $salt;
}
?>