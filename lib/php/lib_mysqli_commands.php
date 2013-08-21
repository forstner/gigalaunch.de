<?php
/*
 * this file handles all sorts of user-database-operations, it can not be called directly via url?parameter=evil
 * so it does not need all the ./lib/php/lib_session.php/./lib/php/lib_security.php, but the parent.php does!
*/

if(!class_exists("./class/php/class_mysqli_interface"))
{
	require_once('./class/php/class_mysqli_interface.php');
}
if(!function_exists("string2array"))
{
	require_once('./lib/php/lib_convert.php');
}

// init database object
$mysqli_object = new class_mysqli_interface();

/* ============ USERS */

/* create a new user-teamplate from database */
function newUser()
{
	$newUser = array();
	global $mysqli_object;
	global $settings_database_auth_table;
	global $settings_database_name;
	$tableDefinition = $mysqli_object->query("DESCRIBE ".$settings_database_auth_table);

	$target = count($tableDefinition);
	for($i=0;$i<$target;$i++)
	{
		$key = $tableDefinition[$i]->Field;
		$newUser[$key] = "";
	}

	return $newUser;
}

/* get all users that belong to that $groupname
 */
function getUsersByGroup($groupname)
{
	$result = null;
	global $mysqli_object;
	global $settings_database_auth_table;
	global $settings_database_name;
	$users = $mysqli_object->query("SELECT * FROM  `".$settings_database_auth_table."` WHERE  `groups` LIKE  '%".$groupname."%'");

	$target = count($users);
	for($i=0;$i<$target;$i++)
	{
		$groups = string2array($users[$i]->groups,"");
		
		if(in_array($groupname, $groups))
		{
			$result[] = $users[$i];
		}		
	}
	
	return $result;
}

function getGroupByUserID($userid)
{
	$data = getDataOfUsername($userid);
}

/* checks if the user exists */ 
function does_user_exist($username,$password = "",$user = null)
{
	$result = false; // default result value
	global $mysqli_object;
	global $settings_database_auth_table;
	
	if(!$user)
	{
		$user = getUserByUsername($username);
	}
	
	if($user)
	{
		if(!$password) // is there a password passed? or do we ask only for username? (password null or "")
		{
			/* check if there is already a user with that name and password */
			
			if($user->username == $username)
			{
				$result = true;
			}
		}
		else
		{
			/* check if there is already a user with that name */
			if($user->username == $username)
			{
				if($user->password == $password)
				{
					$result = true;
				}
			}
		}
	}

	return $result;
}

/* get $user as assoc-array
 */ 
function getUserByUsername($username)
{
	$result = null;
	global $mysqli_object;
	global $settings_database_auth_table;
	global $settings_database_name;
	$user_array = $mysqli_object->query("SELECT * FROM `".$settings_database_auth_table."` WHERE `username` = '".$username."'");
	if(isset($user_array[0]))
	{
		$result = $user_array[0];
	}
	return $result;
}

/* get $user as assoc-array by mail-address
 */
function getUserByMail($mail)
{
	$result = null;
	global $mysqli_object;
	global $settings_database_auth_table;
	global $settings_database_name;
	$user_array = $mysqli_object->query("SELECT * FROM `".$settings_database_auth_table."` WHERE `mail` = '".$mail."'");
	if(isset($user_array[0]))
	{
		$result = $user_array[0];
	}
	return $result;
}

/* returns an array of the data-details field of this user from database->passwd table
 */
function getDataOfUsername($username)
{
	$result = null;
	global $mysqli_object;
	global $settings_database_auth_table;
	global $settings_database_name;
	$user_array = $mysqli_object->query("SELECT * FROM `".$settings_database_auth_table."` WHERE `username` = '".$username."'");
	$result = $user_array[0];
	
	$result = string2array($result->data);
	
	return $result;
}

/* returns an array of the data-details field of this user from database->passwd table
 */
function getDataOfUserID($userID,$user = null)
{
	$result = null;
	if(!$user)
	{
		global $mysqli_object;
		global $settings_database_auth_table;
		global $settings_database_name;
		$user_array = $mysqli_object->query("SELECT * FROM `".$settings_database_auth_table."` WHERE `id` = '".$userID."'");
		if(isset($user_array))
		{
			if(isset($user_array[0]))
			{
				$result = $user_array[0];
			}
		}

		$data = $result->data;
	}
	else
	{
		$data = $user->data;
	}

	$result = string2array($data);

	return $result;
}

/* returns an array of all groups that the userID belongs to */
function getGroupsOfUser($user = null,$username = "")
{
	$result = null; 
	
	if(!$user)
	{
		if(!$username)
		{
			$user = getUserByUsername($username);
		}
	}

	$result = string2array($user->groups,"");

	return $result;
}

/* get $user as assoc-array
 */ 
function getUserByid($userid)
{
	$result = null;

	global $mysqli_object;
	global $settings_database_name;
	global $settings_database_auth_table;
	$user_array = $mysqli_object->query("SELECT * FROM `".$settings_database_auth_table."` WHERE `id` = '".$userid."'");
	if(isset($user_array))
	{
		if(isset($user_array[0]))
		{
			$result = $user_array[0];
		}
	}
	
	return $result;
}
/* get ALL $".$settings_database_auth_table." as assoc-array
 * iterate over list like this:
   	foreach ($".$settings_database_auth_table." as $key => $value) {
		$user = $value;
		foreach ($user as $key => $value) {
			print "$key: $value<br/>";
		}
	}
	you can specify a filter 
	$where = " WHERE `group` = 'groupadmin'"
 */ 
function getUsers($where = "")
{
	global $mysqli_object;
	global $settings_database_name;
	global $settings_database_auth_table;
	return $mysqli_object->query("SELECT * FROM `".$settings_database_auth_table."` ".$where);
}
function getDevices($where = "")
{
	global $mysqli_object;
	// global $settings_database_name;
	return $mysqli_object->query("SELECT * FROM `devices` ".$where);
}
function getDeviceByMac($mac = "")
{
	global $mysqli_object;
	// global $settings_database_name;
	return $mysqli_object->query("SELECT * FROM `devices` WHERE `mac` = '".$mac."';");
}
function getButtons($where = "")
{
	global $mysqli_object;
	global $settings_database_name;
	return $mysqli_object->query("SELECT * FROM `buttons` ".$where);
}
function getOutputs($where = "")
{
	global $mysqli_object;
	global $settings_database_name;
	
	return $mysqli_object->query("SELECT * FROM `outputs` ".$where);
}
function getInputs($where = "")
{
	global $mysqli_object;
	global $settings_database_name;
	
	return $mysqli_object->query("SELECT * FROM `inputs` ".$where);
}
/* get $session
 * $session hash is md5($username.$password.$salt)
 * returns timestamp until when the session is valid
 */ 
function getSessionExpiration($session,$user)
{
	$valid_until = null;
	// check if an user object was handed over
	if(!$user)
	{
		// no user object was handed over -> get user
		$user = getUserBySession($session);
	}

	if($user)
	{
		// hash found
		$valid_until = $user->loginexpires;
	}
	
	return $valid_until;
}

/* set $session
 * set session to browser as cookie and to mysql database
 * iterate over the list:
 */ 
function setSession($username,$password)
{
	global $mysqli_object;
	global $settings_database_name;
	
	global $settings_database_auth_table;
	global $settings_login_session_timeout;


	// the ip that the user had during login
	$ip_login = $_SERVER['REMOTE_ADDR'];
	
	// when the user logged in (ms since 1.1.1970
	$logintime = time();

	$salt = "";
	$salt = salt();

	$_SESSION['session'] = md5($username . $password . $salt);

	$valid_until = time(); // get current time
	$valid_until = $valid_until+($settings_login_session_timeout*1000);

	$mysqli_object -> query("UPDATE `".$settings_database_name."`.`".$settings_database_auth_table."` SET `logintime` = '".$logintime."', `ip_login` = '".$ip_login."', `loginexpires` = '".$valid_until."', `session` = '".$_SESSION['session']."' WHERE `".$settings_database_auth_table."`.`username` = '".$username."' AND `".$settings_database_auth_table."`.`password` = '".$password."';");

	return $valid_until;
}

/* get user by session
 */
function getUserBySession($session)
{
	global $mysqli_object;
	global $settings_database_name;
	
	global $settings_database_auth_table;
	$result = "";
	if($session)
	{
		$valid_until = null;
		$user_array = $mysqli_object->query("SELECT * FROM `".$settings_database_auth_table."` WHERE `session` = '".$session."'");
		// $user = $mysqli_object->query("SELECT * FROM `".$settings_database_name."`.`".$settings_database_auth_table."` WHERE `session` = '".$session."'");
		if(isset($user_array[0]))
		{
			// hash found
			$result = $user_array[0];
		}
	}
	
	return $result;
}

/* delete user */
function userdel($userID = null,$user = null)
{
	global $mysqli_object;
	global $settings_database_auth_table;
	global $settings_database_name;

	if(!isset($userID))
	{
		if(!empty($userID))
		{
			$userID = $user->id;
		}
	}

	if(!empty($userID))
	{
		$output = $mysqli_object->query("DELETE FROM  `".$settings_database_name."`.`".$settings_database_auth_table."` WHERE `".$settings_database_auth_table."`.`id` = ".$userID.";");
	}
	
	return $output;
}

/* add/register a new user
 * $groups = a,comma,separated,list,of,groupnames
 *
 * a User has currently these properties:
 
	id	
	username	
	mail	
	groups	
	password	
	session	
	ip_login	
	logintime	
	loginexpires	
	activation	
	data	
	status	

 * // arbitrary additional data about the user
 * $data = "key:value,key:value,"
 * */
function useradd($user) // $requested_username = "",$requested_password = "",$groups = "",$data = ""
{
	global $activation;
	global $mysqli_object;
	global $settings_database_auth_table;
	global $settings_database_name;
	global $settings_default_home_after_login;
	
	// under linux, when creating users there is always a a group created with the same name, that per default this user belongs to (it's "his" group)
	// search for username in groups, if not found add.
	if(strpos($data,"home:") !== false)
	{
		// allready contains home informations
	}
	else
	{
		$data .= ",home:".$settings_default_home_after_login.",";
	}

	// Create a unique  activation code:
	$activation = md5(uniqid(rand(), true));
	
	// under linux, when creating users there is always a a group created with the same name, that per default this user belongs to (it's "his" group)
	// search for username in groups, if not found add.
	if(strpos($groups,$requested_username) !== false)
	{
	    // allready contains username in group-list
	}
	else
	{
		$groups .= $requested_username.",";
	}

	// return data = false, return errors = true
	$output = $mysqli_object -> query("INSERT INTO `".$settings_database_name."`.`".$settings_database_auth_table."` (`id`, `username`, `password`, `activation`, `data`, `groups`) VALUES (NULL, '" . $requested_username . "', '" . $requested_password . "', '" . $activation . "', '" . $data . "', '" . $groups . "');",false,true);
	
	// check if given groups already exist, if not add
	if($groups)
	{
		$groups = string2array($groups, "");
		
		foreach ($groups as $key => $value)
		{
			if($value)
			{
				if(!does_group_exist($value))
				{
					$query = "INSERT INTO `".$settings_database_name."`.`groups` ( `id` , `groupname` ) VALUES ( NULL , '".$value."' );";
					$output = $mysqli_object -> query($query,false,true);
				}
			}
		}
	}

	return $output;
}

/* change user
 * $groups = a,comma,separated,list,of,groupnames
 * arbitrary additional details data about the user
 * data -> $data = "key:value,key:value,"
 */
function useredit($user2edit) // $userID, $requested_username = "",$requested_password = "",$groups = "",$data = ""
{
	global $mysqli_object;
	global $settings_database_auth_table;
	global $settings_database_name;
	global $settings_default_home_after_login;

	// under linux, when creating users there is always a a group created with the same name, that per default this user belongs to (it's "his" group)
	// search for username in groups, if not found add.
	if(strpos($user2edit->data,"home:") !== false)
	{
		// allready contains home informations
	}
	else
	{
		$user2edit->data .= ",home:".$settings_default_home_after_login.",";
	}

	// under linux, when creating users there is always a a group created with the same name, that per default this user belongs to (it's "his" group)
	// search for username in groups, if not found add.
	if(strpos($user2edit->groups,$requested_username) !== false)
	{
		// allready contains username in group-list
	}
	else
	{
		$user2edit->groups .= $requested_username.",";
	}

	// return data = false, return errors = true
	$query = "UPDATE  `".$settings_database_name."`.`".$settings_database_auth_table."` SET  `username` =  '".$requested_username."',
	`groups` =  '".$groups."',
	`password` =  '".$requested_password."',
	`data` = '".$data."' WHERE `".$settings_database_auth_table."`.`id` = '".$user2edit->id."';";
	
	$output = $mysqli_object -> query($query,false,true);

	// SET  `username` =  'username123' WHERE  `passwd`.`id` =1;

	// check if given groups already exist, if not add
	if($groups)
	{
		$groups = string2array($groups, "");

		foreach ($groups as $key => $value)
		{
			if($value)
			{
				if(!does_group_exist($value))
				{
					$query = "INSERT INTO `".$settings_database_name."`.`groups` ( `id` , `groupname` ) VALUES ( NULL , '".$value."' );";
					$output = $mysqli_object -> query($query,false,true);
				}
			}
		}
	}

	return $output;
}

/* ============ GROUP */
/* get a list of all available groups
 * $option = as array
* $option = as object
*/
function getGroups($option = "as object")
{
	$result = null;
	global $mysqli_object;
	global $settings_database_auth_table;
	global $settings_database_name;
	$result = $mysqli_object->query("SELECT * FROM `groups`");

	if($option == "as array")
	{
		$result_tmp = array();
		$target = count($result);
		for($i=0;$i<$target;$i++)
		{
			$result_tmp[] = $result[$i]->groupname;
		}

		$result = $result_tmp;
	}

	return $result;
}


/* get a list of all system-default groups, that should never be deleted
 * $option = as array
 * $option = as object
 */
function getSystemGroups($option = "as object")
{
	$result = null;
	global $mysqli_object;
	global $settings_database_auth_table;
	global $settings_database_name;
	$result = $mysqli_object->query("SELECT * FROM `groups` WHERE `system` = 1");

	if($option == "as array")
	{
		$result_tmp = array();
		$target = count($result);
		for($i=0;$i<$target;$i++)
		{
			$result_tmp[] = $result[$i]->groupname;
		}
		
		$result = $result_tmp;
	}

	return $result;
}

/* checks if a group exists */ 
function does_group_exist($groupname)
{
	$result = false; // default result value
	global $mysqli_object;
	global $settings_database_auth_table;
	
	$result_array = $mysqli_object->query("SELECT * FROM `groups` WHERE `groupname` LIKE '%".$groupname."%'");
	
	if($result_array)
	{
		$result = true;
	}
	
	return $result;
}

/* output all users of a given group as selectable <html> list
 * 
 // if $goup == * -> all users of all groups are
 // if $goup == "users" -> all users that are not admin
 // if $goup == "yourself" -> the currently logged in user 
 */
function generateUserList($group = "*")
{
	if(($group == "*") || ($group == "users"))
	{
		$users = getUsers();
	}
	else if($group == "yourself")
	{
		global $user;
		$users[] = $user;
	}
	else
	{
		$users = getUsersByGroup($group);
	}
		if($group == "*") $group = "All Users:";
		echo '
			<h4>'.$group.'</h4>
				<ul data-role="listview">';
	
		/* paint a list of users */
		foreach($users as $key => $user)
		{
			$paint = true;

			// if $goup == users -> all users that are not admin
			if($group == "users")
			{
				$groups_of_element = getGroupsOfUser($user);
				if(in_array("admins",$groups_of_element))
				{
					$paint = false;
				}
			}
			
			if($paint)
			{
				$data = string2array($user->data);
				if(!isset($data['profilepicture']))
				{
					$data['profilepicture'] = "";
				}
				echo '
				<li>
					<input type="checkbox" class="checkbox" name="checkbox_'.$user->username.'" id="checkbox_'.$user->username.'" data-mini="true" value="0" userid="'.$user->id.'"/>
					<a href="frontend_useredit.php?selectUserId='.$user->id.'" rel="external" data-ajax="false">
						<img id="profilepicture'.$user->id.'" src="'.$data['profilepicture'].'" class="profilepicture"/>
						<h3 id="username'.$user->id.'">'.$user->username.'</h3>
						<p>UserID:'.$user->id.','.$user->data.'</p>
					</a>
				</li>';
			}
		}
		echo '
				</ul>';
}
?>