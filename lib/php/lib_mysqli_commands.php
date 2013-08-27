<?php
/*
 * this file handles all sorts of user-database-operations, it can not be called directly via url?parameter=evil
 * so it does not need all the ./lib/php/lib_session.php/./lib/php/lib_security.php, but the parent.php does!
*/

require_once('./class/php/class_mysqli_interface.php');
require_once('./lib/php/lib_convert.php');
require_once('./lib/php/lib_general.php');

// init database object
$mysqli_object = new class_mysqli_interface();

/* ============ USERS */

/* get table-definition (what keys does my table have) creates an example array-object */
function describe($table)
{
	$newUser = array();
	global $mysqli_object; global $worked; $worked = false; global $worked;
	global $settings_database_name;
	$tableDefinition = $mysqli_object->query("DESCRIBE ".$table);

	$target = count($tableDefinition);
	for($i=0;$i<$target;$i++)
	{
		$key = $tableDefinition[$i]->Field;
		$newUser[$key] = "";
	}

	return $newUser;
}

/* create a new user-teamplate-array-object as defined in database */
function newUser()
{
	global $settings_database_auth_table; global $settings_database_groups_table;
	return describe($settings_database_auth_table);
}

/* create a new goup-teamplate-array-object as defined in database */
function newGroup()
{
	global $settings_database_groups_table;
	return describe($settings_database_groups_table);
}

/* create a new record-teamplate-array-object as defined in database */
function newRecord($tableName)
{
	return describe($tableName);
}

/* checks if the user exists */ 
function userexist($user,$uniqueKey = "id")
{
	$result = null;

	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_name;
	global $settings_database_auth_table; global $settings_database_groups_table;
	$query = "";
	if($user)
	{
		// filter list
		if(isset($user[$uniqueKey]))
		{
			if(!empty($user[$uniqueKey]))
			{
				$query = "SELECT * FROM `".$settings_database_auth_table."` WHERE `".$uniqueKey."` = '".$user[$uniqueKey]."'";
			}
			else
			{
				return error("function userexist: given \$user has property named ".$uniqueKey." but it is empty.");
			}
		}
		else
		{
			return error("function userexist: given \$user has no property named ".$uniqueKey.".");
		}
	}
	else
	{
		return error("function userexist: no user given.");
	}
	$user_array = $mysqli_object->query($query);
	
	if(!empty($user_array))
	{
		$result = true;
	}
	else
	{
		$result = false;
	}

	return $result;
}

/* returns an array of all groups available (if no parameter given)
 * if $user given -> returns a list of all groups of that user
 * via $where you can filter the groups you want with your own sql query*/
function groups($group = null,$where = "")
{
	$result = false; // default result value
	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_auth_table; global $settings_database_groups_table;

	$query = "";
	if(empty($where))
	{
		$query = "SELECT * FROM `".$settings_database_groups_table."`";
	}
	else
	{
		$query = "SELECT * FROM `".$settings_database_groups_table."` ".$where;
	}

	$result = $mysqli_object->query($query);

	return $result;
}

/* get $user as assoc-array
 * by id/Username/Mail (in this order, if no $uniqueKey is given)
 */ 
function userget($user,$uniqueKey = "id")
{
	$result = null;

	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_name;
	global $settings_database_auth_table; global $settings_database_groups_table;
	$query = "";
	if($user)
	{
		// filter list
		$query = "SELECT * FROM `".$settings_database_auth_table."` WHERE `".$uniqueKey."` = '".$user[$uniqueKey]."'";
	}
	else
	{
		// return all users
		$query = "SELECT * FROM `".$settings_database_auth_table."`";
	}
	$user_array = $mysqli_object->query($query);
	if(isset($user_array))
	{
		if(count($user_array) <= 1)
		{
			if(isset($user_array[0]))
			{
				$result = $user_array[0];
			}
		}
		else
		{
			$result = $user_array; // multiple records returned
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
function users($where = "")
{
	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_name;
	global $settings_database_auth_table; global $settings_database_groups_table;
	return $mysqli_object->query("SELECT * FROM `".$settings_database_auth_table."` ".$where);
}
function getDevices($where = "")
{
	global $mysqli_object; global $worked; $worked = false;
	// global $settings_database_name;
	return $mysqli_object->query("SELECT * FROM `devices` ".$where);
}
function getDeviceByMac($mac = "")
{
	global $mysqli_object; global $worked; $worked = false;
	// global $settings_database_name;
	return $mysqli_object->query("SELECT * FROM `devices` WHERE `mac` = '".$mac."';");
}
function getButtons($where = "")
{
	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_name;
	return $mysqli_object->query("SELECT * FROM `buttons` ".$where);
}
function getOutputs($where = "")
{
	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_name;
	
	return $mysqli_object->query("SELECT * FROM `outputs` ".$where);
}
function getInputs($where = "")
{
	global $mysqli_object; global $worked; $worked = false;
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
	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_name;
	
	global $settings_database_auth_table; global $settings_database_groups_table;
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
	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_name;
	
	global $settings_database_auth_table; global $settings_database_groups_table;
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

/* delete user
 * $identifyByKey -> the key by which you want to identify your user
 * usually every user has a unique id given by the database
 * so it's savest to use id
 * 
 * but you might also want to delete all users named "joe"
 * 
 * so go
 * $user = newUser();
 * $user["username"] = "joe";
 * userdel($user,"username");
 * */
function userdel($user,$identifyByKey = "id")
{
	if(!is_array($user))
	{
		error("function userdel: expected input to be array");
		$worked = false;
		return $worked;
	}
	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_auth_table; global $settings_database_groups_table;
	global $settings_database_name;
	$worked = false;

	if(isset($user[$identifyByKey]))
	{
		if(!empty($user[$identifyByKey]))
		{
			$output = $mysqli_object->query("DELETE FROM  `".$settings_database_name."`.`".$settings_database_auth_table."` WHERE `".$settings_database_auth_table."`.`".$identifyByKey."` = '".$user[$identifyByKey]."';");
			$worked = true;
		}
		else
		{
			return error("function userdel: there is a property ".$identifyByKey." in \$user but it has no value.");
		}
	}
	else
	{
		return error("function userdel: there is no property ".$identifyByKey." in \$user given.");
	}
	
	return $worked;
}

/* add/register a new user
 * 
 * the properties a $user-array-object can have is defined through the database
 * (table defined in config/config.php -> $settings_database_auth_table e.g. passwd)
 * 
 * add a column there, and you have a new property attached to $user.
 * 
 * To create/add a $user you first need to get this database-defined-layout
 * 
 * $user = newUser();
 * 
 * Then you modify the array: username is required, anything else is optional.
 * 
 * $user["username"]= "user";
 * 
 * adduser($user);
 * 
 * That's it!
 * */
function useradd($user) // $requested_username = "",$requested_password = "",$groups = "",$data = ""
{
	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_auth_table; global $settings_database_groups_table; global $settings_uniqueUsernames;
	global $settings_database_name;
	global $settings_default_home_after_login;
	
	if(!is_array($user))
	{
		error("function useradd: expected input to be array");
		$worked = false;
		return $worked;
	}
	if(empty($user["username"]))
	{
		return error("function useradd: can not continue, \$user has no username");
	}
	
	if($settings_uniqueUsernames)
	{
		if(userexist($user,"username"))
		{
			return error("function useradd: can not continue, user ".$user["username"]." is taken and \$settings_uniqueUsernames is set to true.");
		}
	}

	// under linux, when creating users there is always a a group created with the same name, that per default this user belongs to (it's "his" group)
	// search for username in groups, if not found add.
	if(empty($user["home"]))
	{
		$user["home"] = $settings_default_home_after_login;
	}

	// Create a unique  activation code:
	$user["activation"] = md5(uniqid(rand(), true));
	
	// under linux, when creating users there is always a a group created with the same name, that per default this user belongs to (it's "his" group)
	// check if given groups already exist, if not add
	if(!groupexist($user["username"]))
	{
		$group = newGroup();
		$group["groupname"] = $user["username"];
		groupadd($group);
	}

	// search for username in groups, if not found add.
	// allready contains username in group-list
	$user["id"] = ""; // id will always be automatically set by database/backend/autoincrement, or things will become chaotic

	$values = array2sql($user,"INSERT");
	$query = "INSERT INTO `".$settings_database_name."`.`".$settings_database_auth_table."` ".$values;

	// return data = false, return errors = true
	$output = $mysqli_object -> query($query,false,true);
	
	// get the id of the just created user-object
	global $id_last;
	$user["id"] = $id_last;

	$worked = true;
	
	return $user;
}

/* change user
 * $groups = a,comma,separated,list,of,groupnames
 * arbitrary additional details data about the user
 * data -> $data = "key:value,key:value,"
 */
function useredit($UpdatedUser,$uniqueKey = "id") // $userID, $requested_username = "",$requested_password = "",$groups = "",$data = ""
{
	// check if user with this username allready exists -> warn
	
	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_auth_table; global $settings_database_groups_table;
	global $settings_database_name;
	global $settings_default_home_after_login;
	
	// get all info about user
	$user_database = userget($UpdatedUser,$uniqueKey);
	// add it
	$UpdatedUser = mergeObject($UpdatedUser,$user_database);

	$values = array2sql($UpdatedUser,"UPDATE");

	$query = "UPDATE `".$settings_database_name."`.`".$settings_database_auth_table."` SET ".$values." WHERE `".$settings_database_auth_table."`.`".$uniqueKey."` = '".$UpdatedUser->$uniqueKey."';";

	$output = $mysqli_object -> query($query,false,true);

	return $output;
}

/* ============ GROUP */
/* add a group to the system (list of available groups)
 * add/register a new user
*
* the properties a $user-array-object can have is defined through the database
* (table defined in config/config.php -> $settings_database_auth_table e.g. passwd)
*
* add a column there, and you have a new property attached to $user.
*
* To create/add a $user you first need to get this database-defined-layout
*
* $user = newUser();
*
* Then you modify the array: username is required, anything else is optional.
*
* $user["username"]= "user";
*
* adduser($user);
*
* That's it!
* */
function groupadd($group)
{
	if(!is_array($group))
	{
		error("function groupadd: expected input to be array");
		$worked = false;
		return $worked;
	}
	if(empty($group["groupname"]))
	{
		error("function groupadd: can not continue, \$group has no groupname");
		$worked = false;
		return $worked;
	}

	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_auth_table; global $settings_database_groups_table;
	global $settings_database_name;
	global $settings_default_home_after_login;

	// under linux, when creating users there is always a a group created with the same name, that per default this user belongs to (it's "his" group)
	// check if given groups already exist, if not add
	if(!groupexist($group["groupname"]))
	{
		// search for groupname in groups, if not found add.
		// allready contains groupname in group-list
		$group["id"] = ""; // id will always be automatically set by database/backend/autoincrement, or things will become chaotic
	
		$values = array2sql($group,"INSERT");
		$query = "INSERT INTO `".$settings_database_name."`.`".$settings_database_groups_table."` ".$values;
	
		// return data = false, return errors = true
		$output = $mysqli_object -> query($query,false,true);
		$worked = true;
	}
	else
	{
		return error("function groupadd: group allready exists.");
	}

	return $output;
}
	
/* delete a group */
function groupdel($group)
{
	if(!is_array($group))
	{
		error("function groupdel: expected input to be array");
		$worked = false;
		return $worked;
	}

	$result = null;
	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_auth_table; global $settings_database_groups_table;
	global $settings_database_name;

	if(isset($group["groupname"]) && (!is_null($group["groupname"])))
	{
		// check out if there are still users in this group -> refuse to delete
		$users = users();
		
		$group_in_use = false;
		$count = count($users);
		$username = "";
		for($i=0;$i<$count;$i++)
		{
			$username = $users[$i]->username;
			$groups = $users[$i]->groups;
			$groups_array = explode(",",$groups);
			$groupname = $group["groupname"];
			if(in_array($groupname, $groups_array))
			{
				$group_in_use = true;
				break;
			}
		}
		
		if($group_in_use)
		{
			error("function groupdel: can not delete group with name: ".$groupname." - the group is still in use by user ".$username);
			$worked = false;
			return $worked;
		}
		else
		{
			$query = "DELETE FROM `".$settings_database_name."`.`".$settings_database_groups_table."` WHERE `".$settings_database_groups_table."`.`groupname` = '".$groupname."';";
			$result = $mysqli_object -> query($query,false,true);
		}
	}
	else
	{
		error("function groupdel: given \$group has no groupname");
	}

	return $worked;
}

/* get a list of all available groups
 * $option = as array
* $option = as object
*/
function getGroups($option = "as object")
{
	$result = null;
	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_auth_table; global $settings_database_groups_table;
	global $settings_database_name;
	$result = $mysqli_object->query("SELECT * FROM `".$settings_database_groups_table."`");

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

/* checks if a group exists
 * 
 * alternative version:
 * 
 * $groups = groups(null,"WHERE `groupname` = '".$user["username"]."'");
 * -> then check if $groups array is empty.
 * */ 
function groupexist($groupname)
{
	$result = false; // default result value
	global $mysqli_object; global $worked; $worked = false;
	global $settings_database_auth_table; global $settings_database_groups_table;
	
	$query = "SELECT * FROM `".$settings_database_groups_table."` WHERE `groupname` = '".$groupname."'";
	$result_array = $mysqli_object->query($query);
	
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
		$users = users();
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