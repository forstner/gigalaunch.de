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
	<meta http-equiv="refresh" content="99; URL=../frontend_login.php">
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
	Contact the <a href="mailto:<?php global $settings_mail_admin; echo $settings_mail_admin; ?>">administrator</a>. </div>
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

/* merge all values from objectB into objectA,
 * overwriting values of objectA with similar properties/keys, adding keys/properties that exist in B but not in A to A */ 
function mergeObject($A,$InToObjectB)
{
	foreach ($A as $key => $value)
	{
		if(!is_null($value))
		{
			if(!empty($value))
			{
				$InToObjectB->$key = $value;
			}
		}
	}
	
	return $InToObjectB;
}

/* this takes timestampt, md5-hashes it then cuts it down to 8 characters */
function salt()
{
	$salt = substr(md5(time()), 8); // date("F")
	return $salt;
}

/* send mail */
function sendMail($from,$to,$subjet,$text)
{
	// assemble header utf8
	$header = ('From: ' . $from . '\r\n');
	$header .= ('Reply-To: ' . $from . '\r\n');
	$header .= ('Bcc: '.$from.'\r\n');
	$header .= ('Return-Path: ' . $from . '\r\n');
	$header .= ('X-Mailer: PHP/' . phpversion() . '\r\n');
	$header .= ('X-Sender-IP: ' . $_SERVER['REMOTE_ADDR'] . '\r\n');
	$header .= ('Content-type: text/html\r\n');
	$header .= ("MIME-Version: 1.0\r\n");
	$header .= ("Content-Type: text/html; charset=utf-8\r\n");
	$header .= ("Content-Transfer-Encoding: 8bit\r\n\r\n");
	$valid_sender = '-f '.$settings_mail_activation;
		
	/* Verschicken der Mail */
	if(mail($to, $subject, $text, $header, $valid_sender))
	{
		// 	echo "Mail sent successfully!";
		exit ('type:success,id:registration successfull;sending activation mail successfull!,details:Thank you for registering :) You should receive an registration mail soon.');
		// sleep(3);
		// header("Location: servermessages/activation_send.php");
	}
	else
	{
		// echo"Mail not sent!";
		exit('type:success,id:registration successfull;sending activation mail failed!,details:Thank you for registering :) You should receive an registration mail soon.');
		// sleep(3);
		header("Location: servermessages/activation_mail_failed.php");
	}
}

/* generate a password and md5 hash it */
function generatePassword($length = 8) {
	
	$result = "";

    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }
    
    return $result;
}

/* write the error to a log file */
function logError($error)
{
	file_put_contents($settings_errorLog, $error."\n", FILE_APPEND);
}

/* build a query for inserting an array
* $mode == "INSERT" -> (key1,key2,key3) VALUES (value1,value2,value3)
* $mode == "UPDATE" -> key1 = value1,key2 = value2,key3 = value3
* */
function arrayobject2sqlvalues($ArrayOrObject,$mode)
{
	global $settings_database_name;
	global $settings_database_auth_table; global $settings_database_groups_table;
	
	$query = "";
	$count = 0;
	
	if(is_array($ArrayOrObject))
	{
	}
	else if(is_object($ArrayOrObject))
	{
		$ArrayOrObject = object2array($ArrayOrObject);
	}
	else
	{
		return error("function arrayobject2sqlvalues: input is of type ".gettype($ArrayOrObject)." array or object expected.");
	}

	$target = count($ArrayOrObject);
	$target = $target - 1;
	$columns = "";
	$values = "";

	if($mode == "INSERT")
	{
		foreach ($ArrayOrObject as $key => $value)
		{
			if(($key == "id")||($key == "ID")) $value = "NULL";
			
			if($count == 0)
			{
				$columns = "`".$key."`";
				$values = "'".$value."'";
			}
			else
			{
				$values = $values . "," . "'".$value."'";
				$columns = $columns . ",`".$key."`";
			}
				
			$count++;
		}
		$query = "($columns) VALUES ($values)";
	}

	if($mode == "UPDATE")
	{
		foreach ($ArrayOrObject as $key => $value)
		{
			if(($key != "id")&&($key != "ID"))
			{
				if($count != $target)
				{
					$query .= "`".$key."` =  '".$value."',";
				}
				else
				{
					$query .= "`".$key."` =  '".$value."'"; // do not add , at the end
				}
			}
			$count++;
		}
	}

	return $query;
}

/* outputs a warning and if $settings_log_errors == true, outputs to error.log */
function error($message)
{
	trigger_error($message);

	global $settings_log_errors;
	global $worked;
	$worked = false;
	if(!empty($settings_log_errors)){
		log2file($settings_log_errors,$message);
	}
	
	return false;
}

/* outputs a warning and if $settings_log_errors == true, outputs to error.log */
function operation($operation)
{
	global $settings_log_operations;
	if(!empty($settings_log_operations)){
		log2file($settings_log_operations,$operation);
	}
}

/* write the error to a log file */
function log2file($file,$this)
{
	file_put_contents($file, time().": ".$this."\n", FILE_APPEND);
}

/* convert multi dimensional objects to array
 * credits: http://www.if-not-true-then-false.com/2009/php-tip-convert-stdclass-object-to-multidimensional-array-and-convert-multidimensional-array-to-stdclass-object
 */
function object2array($object) {
	if (is_object($object)) {
		// Gets the properties of the given object
		// with get_object_vars function
		$object = get_object_vars($object);
	}

	if (is_array($object)) {
		/*
			* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return array_map(__FUNCTION__, $object);
	}
	else {
		// Return array
		return $object;
	}
}

/* convert multi dimensional arrays to objects
 * credits: http://www.if-not-true-then-false.com/2009/php-tip-convert-stdclass-object-to-multidimensional-array-and-convert-multidimensional-array-to-stdclass-object/
 */
function array2object($array) {
	if (is_array($array)) {
		/*
			* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return (object) array_map(__FUNCTION__, $array);
	}
	else {
		// Return object
		return $array;
	}
}

/* check if an object or array has an an property, and if that property has an value */
function haspropertyandvalue($objectOrArray,$property,$caller)
{
	$result = false;
	
	if(is_array($objectOrArray) || is_object($objectOrArray))
	{
		if(!is_null($objectOrArray))
		{
			if(is_array($objectOrArray)) $objectOrArray = array2object($objectOrArray);
			
			if(isset($objectOrArray->$property))
			{
				if(!is_null($objectOrArray->$property))
				{
					$result = true;
				}
				else
				{
					return error("function ".$caller.": \$objectOrArray has property ".$property." but without value. Argh!");
				}
			}
			else
			{
				return error("function ".$caller.": \$objectOrArray has no property ".$property.". Argh!");
			}
		}
		else
		{
			return error("function ".$caller.": is null. Argh!");
		}
	}
	else
	{
		$caller = "haspropertyandvalue";
		return error("function ".$caller.": input \$objectOrArray is of type ".gettype($objectOrArray)." but i need object or array. Argh!");
	}

	return $result;
}