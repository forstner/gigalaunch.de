<?php
require("config/config.php");
global $errors;
$mysqli_link = null;
global $mysqli_link; // a pointer symbolizing the connection to the mysql database

$mysqli_object = null;
global $mysqli_object; // this class, which contains functions and objects such as $mysqli_link

/* mysqli.php
 * 1. loads config.php (database credentials) per default
* 2. establishes a link to the mysql database
* 3. selects a default database (the one given in config/config.php)
* 4. handles all mysql interaction, databaseresults are returned as Array.
*
* return each record as as key=>value element of an array (where key is column-name, and value is corresponding value)

"$output" =
0 = Array
ID = 2
username = test
password = password
name = name
email = email

1 = Array
2 = Array
...

* ... if you want to replace mysql with postgress,
* there needs to be a postgress.php which similar structure than this one.
*/
class mysqli_custom {

	/* constructor */
	function __construct()
	{
		global $mysqli_link;
		global $settings_database_server;
		global $settings_database_name;
		global $settings_database_user;
		global $settings_database_pass;

		/* this is how flash player / AIR apps needs it's xml data
		 $output = "<?xml version=\"1.0\" encoding=\"utf-8\"?><sqlxml>";
		$output .= " <database_connection>0</database_connection>\n";
		$output .= " <error>".utf8_encode(mysqli_error())." </error>\n";
		*/

		$mysqli_link = mysqli_connect($settings_database_server, $settings_database_user, $settings_database_pass, $settings_database_name);

		if (!$mysqli_link)
		{
			// something went wrong, find out what and send back details to jquery-ajax-request
			$error_details = mysqli_connect_errno().":".mysqli_connect_error();
			exit('type:error,id:mysqli_connect failed,details:'.$error_details);
		}
	}

	/* send query to database and return each element as key=>value array
	 *
	* "$output" = Array [3]
	0 = Array [5]
	ID = 2
	username = test
	password = password
	name = name
	email = email

	1 = Array [5]
	2 = Array [5]
	...
	*
	* $return_data -> true or false
	* true means: parse the mysql-result and return all data that is there (select = read)
	* false means: i do not expect any data to be returned (insert/update does not read any data)
	*/
	public static function query($query,$return_data = true)
	{
		global $mysqli_link;
		global $mysqli_object;
		global $settings_database_server;
		global $settings_database_name;
		global $settings_database_user;
		global $settings_database_pass;
		global $settings_datasource;

		$output = array();

		$result = $mysqli_link->select_db($settings_database_name);
		if(!$result)
		{
			// 1. something went wrong
			// check if database exists
			$query = "SHOW DATABASES";
			$result = mysqli_query(query);

			$error_details = " Selecting database failed: ".mysqli_connect_error();

			if($echo_errors)
			{
				exit('type:error,id:select_db failed,details:'.$error_details);
			}
		}
		else
		{
			// 2. execute query, check for query errors
			$result = mysqli_query($mysqli_link,$query);

			if(!$result)
			{
				$error = $query." returns error: ".mysqli_errno($mysqli_link). ": ".mysqli_error($mysqli_link);
				$error = str_replace(",", " ", $error);
				$error = str_replace(":", " ", $error);
				$settings_datasource = str_replace(",", " ", $settings_datasource);
				$settings_datasource = str_replace(":", " ", $settings_datasource);
				
				exit('type:error,id:database error,details:'.$error.',datasource:'.$settings_datasource);
			}

			if($return_data)
			{
				if(!is_bool($result)) // query(UPDATE) = returns true/false
				{
					while ($obj = $result->fetch_object()) {
						$output[] = $obj;
					}
					mysqli_free_result($result);
				}
			}
		}
	  
		return $output;
	}

	/* filter evil characters that could make mysql stumble or return a file that contains the whole database
	 *
	* CAN ONLY BE USED IF THERE IS A DATABASE CONNECTION/LINK OPEN!
	*
	* do it like this:
	// init database
	$mysqli_object = new mysql("".$settings_database_name."");

	* */
	function escape($input)
	{
		global $mysqli_object;
		global $mysqli_link;
		return mysqli_escape_string($mysqli_link,$input);
	}
}
?>