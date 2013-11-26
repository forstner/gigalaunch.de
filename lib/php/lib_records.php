<?php
/* provides services for jquery-js-clients in concerns of record management by utilizing the lib/php/lib_mysqli_commands.php */
chdir(".."); // or all the require_once fail, because the paths are wrong.
chdir(".."); // or all the require_once fail, because the paths are wrong.
/* ================= please put this on top of every page, modify the allowed records/groups entries to manage access per page. */
error_reporting(E_ALL); // turn the reporting of php errors on
$allowed_users = "only logged in users"; // a list of userIDs that are allowed to access this page 
$allowed_groups = "root"; // a list of groups, that are allowed to access this page
require_once('./lib/php/lib_security.php'); // will mysql-real-escape all input
require_once('./lib/php/lib_mysqli_commands.php');
require_once("config.php"); // load project-config file
// // login needs to be open for all in order to login! require_once('./lib/php/lib_session.php'); // will immediately exit and redirect to login if the session is not valid/has expired/user is not allowed to access the page
/* ================= */

$result = Array();

require_once('./lib/php/lib_mysqli_commands.php');

if(isset($_REQUEST["action"]))
{
	/* list users */
	if($_REQUEST["action"] == "records")
	{
		if(isset($_REQUEST["table"]))
		{
			// comment("get definition of record from database");
			$NewRecord = newRecord($_REQUEST["table"]);
			
			// records
			if(isset($_REQUEST["where"]))
			{
				// comment("get all records with custom filter"); // example: "WHERE `key1` = 'value1'"
				$records = records(null,"id",$_REQUEST["where"]);
			}
			else
			{
				// comment("get a list of all records");
				$records = records();
			}
	
			if($records)
			{
				answer($records, "records", "success");
			}
			else
			{
				answer($records, "records", "failed");
			}
		}
	}

	/* create new user */
	if($_REQUEST['action'] == "new")
	{
		$record = newRecord(); // get database layout of an RecordObject-Instance (basically all the keys but no values, not a real record record just the layout of it)
		$record->id = $_REQUEST['RecordID']; // set the record id of the RecordObject-Instance to 0, so we are looking for a record with id == 0

		// now editing/updating the properties
		$record->recordname = $_REQUEST['recordname'];
		$record->firstname = $_REQUEST['firstname'];
		$record->lastname = $_REQUEST['lastname'];
		$record->password = $_REQUEST['password_encrypted'];
		$record->groups = $_REQUEST['groups'];

		recordadd($record); // returns the record-object from database, containing a new, database generated id, that is important for editing/deleting the record later
	}
	/* update an existing record */
	if($_REQUEST['action'] == "update")
	{
		$record = newRecord(); // get database layout of an RecordObject-Instance (basically all the keys but no values, not a real record record just the layout of it)
		$record->id = $_REQUEST['RecordID']; // set the record id of the RecordObject-Instance to 0, so we are looking for a record with id == 0
		$record = getFirstElementOfArray(records($record)); // now passing this $record[id] to the function records which then extracts a real record with this id.

		// now editing/updating the properties
		$record->recordname = $_REQUEST['recordname'];
		$record->firstname = $_REQUEST['firstname'];
		$record->lastname = $_REQUEST['lastname'];
		$record->password = $_REQUEST['password_encrypted'];
		$record->groups = $_REQUEST['groups'];

		// writing to database, for more examples please check out: lib_mysqli_commands.test.php
		recordedit($record);
	}

	/* delete record */
	if($_REQUEST['action'] == "delete")
	{
		$record = newRecord(); // get database layout of an RecordObject-Instance (basically all the keys but no values, not a real record record just the layout of it)
		$record->id = $_REQUEST['RecordID']; // set the record id of the RecordObject-Instance to 0, so we are looking for a record with id == 0
		recorddel($record);
	}
}

/* examples */
/*
// recordget
comment("get definition of arbitrary record from database");
$NewRecord = newRecord("datarecord");

// records
comment("get a list of all records");
$records = records();
success();

// get all records with custom filter
comment("get all records with custom filter");
$records = records(null,"id","WHERE `key1` = 'value1'");
success();

// recordadd
comment("recordadd - add a arbitrary record to a arbitrary table");
$NewRecord->id = "auto";
$NewRecord->key1 = "value1";
$NewRecord->key2 = "value2";
$NewRecord->key3 = "value3";
$NewRecord = recordadd($NewRecord); // returns the record-object from database, containing a new, database generated id, that is important for editing/deleting the record later
success();

// recordchange
comment("recordedit: change record");
$NewRecord->key2 = "newvalue2";
$NewRecord->key3 = "newvalue3";
success(recordedit($NewRecord));

// records by id/Mail/Username
comment("get record by ID");
$records = records($NewRecord);
success();

// getUserByUsername
comment("get User by key1");
$records = records($NewRecord,"key1");
success();

// getUserByMail
comment("get User by key2");
$records = records($NewRecord,"key2");
success();

// recorddel
comment("recorddel: del record");
success(recorddel($NewRecord));
 */
?>