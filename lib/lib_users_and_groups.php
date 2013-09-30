<?php
/* provides services for jquery-js-clients in concerns of user management by utilizing the lib/lib_mysqli_commands.php */
chdir(".."); // or all the require_once fail, because the paths are wrong.
require_once('./lib/php/lib_mysqli_commands.php');

if(isset($_REQUEST["action"]))
{
	/* =============== users */

	/* list users */
	if($_REQUEST["action"] == "users")
	{
		// comment("get definition of user from database");
		$user = newUser();
		$users = users($user,$_REQUEST["uniqueKey"],$_REQUEST["uniqueValue"],$_REQUEST["where"]);

		if($users)
		{
			answer($users, "users", "success");
		}
		else
		{
			answer($users, "users", "failed");
		}
	}
	
	/* =============== group */
	
	/* list groups */
	if($_REQUEST["action"] == "groups")
	{
		// comment("get definition of group from database");
		$group = newGroup();
		$groups = groups($group,$_REQUEST["uniqueKey"],$_REQUEST["uniqueValue"],$_REQUEST["where"]);

		if($groups)
		{
			answer($groups, "groups", "success");
		}
		else
		{
			answer($groups, "groups", "failed");
		}
	}
}
?>