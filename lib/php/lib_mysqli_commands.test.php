<?php
echo "<hr><h1 color='red'>test lib_mysqli_commands database management commands</h1><br>";
chdir('../../');
include_once("./lib/php/lib_mysqli_commands.php");
include_once("config/config.php");

echo "<hr><h1 color='red'>test database user management commands</h1><br>";

comment("get definition of user from database");
$user = newUser();
success();

// userdel with id
$user->id = 0;
comment("delete User by id (default)");
success(userdel($user));

// userdel with username
comment("delete user by username (all users with this username if reuse allowed)");
$user->username = "user";
success(userdel($user,"username"));
$user->username = "superuser";
success(userdel($user,"username"));

// groupdel - delete a group ALSO UPDATE USER RECORDS!
comment("groupdel - delete a group ALSO UPDATE USER RECORDS!");
$group->groupname = "user";
success(groupdel($group));

// useradd
comment("add user to database");
$user->username = "user";
$user->mail = "mail@mail.de";
$user->firstname = "firstname";
$user->lastname = "lastname";
$user = useradd($user); // returns the user-object from database, containing a new, database generated id, that is important for editing/deleting the user later
success();

// userget by id/Mail/Username
comment("get user by ID");
$user = userget($user);
success();

// getUserByUsername
comment("get User by Username");
$user = userget($user,"username");
success();

// getUserByMail
comment("get User by mail");
$user = userget($user,"mail");
success();

// userget
comment("get a list of all users");
$users = userget();
success();
	
// useredit
comment("edit User (if it exists)");
$user->mail = "new@mail.de";
$user->username = "superuser";
success(useredit($user));

// userexist
comment("userexist");
success(userexist($user));

echo "<hr><h1 color='red'>test database Group management commands</h1><br>";

// groupdel - delete a group ALSO UPDATE USER RECORDS!
comment("groupdel - delete a group (can not be deleted if users are still in a group)");
$group = newGroup();
$group->groupname = "test";
success(groupdel($group));

// groupadd
/* the database-concept behind groups is like this:
 * 1. there is a column in the passwd table which contains a comma-separated list of all groups that the user belongs to.
 * 2. the table groups contains all available groups, you can add your own column-properties to the table, enriching the amounts of properties a group can have.
 */
comment("groupadd");
$group = groupadd($group); // returns the group-object from database, containing a new, database generated id, that is important for editing/deleting the group later
success();

// groupexist
comment("groupexist - test if a group exists by id");
groupexist($group);
success();

// groupchange, also update the name in all user records!!!
comment("groupedit");
$group->groupname = "changedTest";
success(groupedit($group));

// get group by id
comment("get group by id");
success(groups($group,"id"));

// get group by groupname
comment("get group by groupname");
success(groups($group,"groupname"));

// get all available groups
comment("get all available groups");
success(groups());

// get groups with filter
// get system groups
comment("get groups of user");
success(groups($user));

// get system groups
comment("get groups of user");
success(groups(null,"WHERE `system` = 1"));

// get all groups with this groupname
$groupname = "user";
comment("get groups of user");
success(groups(null,"WHERE `".$settings_database_groups_table."` LIKE '%".$groupname."%'"));

// groupadduser - add user to a group
comment("add user to a group");
success(groupadduser($user,$group));

// groupremuser - remove user from group
comment("groupremuser - remove user from group");
success(groupremuser($user,$group));

// recordget
comment("get definition of arbitrary record from database");
$DataRecord = newRecord("tableName");

// recordadd
comment("recordadd - add a arbitrary record to a arbitrary table");
$DataRecord->id = "auto";
$DataRecord->key1 = "value1";
$DataRecord->key2 = "value2";
$DataRecord->key3 = "value3";
success(recordadd($DataRecord));

// recordchange
comment("change record");
$DataRecord->key2 = "newvalue2";
$DataRecord->key3 = "newvalue3";
success(recordadd($DataRecord));

// recorddel
comment("del record");
success(recorddel($DataRecord));

// this functionalities need to be implemented with the very general functions above:
// getDevices
// getDeviceByMac
// getButtons
// getOutputs
// getInputs
// getSessionExpiration
// setSession
// getUserBySession
// getGroups
// getSystemGroups
// groupexist
// generateUserList
// usersByGroup

/* print an array or variable like print_r would do it but with browser readable <br> instead of \n linebreaks */
function print_r_html($input)
{
	echo str_replace(array("\r\n", "\r","\n"), "<br>", print_r($input,true));
}

/* explain what is being done */
function comment($input)
{
	echo "<h3>".strval($input)."____________________________________________________________</h3><br>";
}
// colorful output about the outcomes of the functions
function success()
{
	global $worked;
	if($worked)
	{
		echo "<h3 style='color:green;'>worked</h3><br>";
	}
	else
	{
		echo "<h3 style='color:red;'>failed</h3><br>";
	}
}
?>