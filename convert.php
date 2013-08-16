<?php
function seconds2minutes($seconds)
{
	$minutes = $seconds / 60;
	$array = explode('.',$minutes);
	$minutes = $array[0];
	
	return $minutes;
}

/* take array as input
 * output string key:value,key:value or list,with,elements
*/
function object2string($input, $key_value_delimiter = ":", $element_delimiter = ",")
{
	$result = "";
	if($input)
	{
		if(!$key_value_delimiter) // if no key-value-delimiter is given one is ignoring the keys which does element1,element2...
		{
			foreach ($_REQUEST as $key => $value)
			{
				$result .= $value.$element_delimiter;
			}
		}
		else
		{
			foreach ($_REQUEST as $key => $value)
			{
				$result .= $key.$key_value_delimiter.$value.$element_delimiter;
			}
		}
	}
	
	return $result;
}

/* take string key:value,key:value or list,with,elements
 * firstname:firstname,lastname:lastname,email:mail@mail.de,ip_during_registration:127.0.0.1,port_during_registration:58993,device_during_registration:Mozilla/5.0 (X11; Linux x86_64; rv-21.0) Gecko/20100101 Firefox/21.0,home:template.php,
* and make it an php-array
*/
function string2array($input, $key_value_delimiter = ":", $element_delimiter = ",")
{
	$result = array();
	if($input)
	{
		$elements = explode($element_delimiter,$input);
		$target = count($elements);
		for($i=0;$i<$target;$i++)
		{
			if(!$key_value_delimiter) // is there a $key_value_delimiter given? if not, it's maybe a list,with,elements
			{
				if($elements[$i])
				{
					$result[] = $elements[$i];
				}
			}	
			else
			{
				$key_value = explode($key_value_delimiter,$elements[$i]);
				if($key_value[0])
				{
					$result[$key_value[0]] = $key_value[1]; 
				}
			}			
		}			
	}
	
	return $result;
}

/* take string key:value,key:value or list,with,elements
 * firstname:firstname,lastname:lastname,email:mail@mail.de,ip_during_registration:127.0.0.1,port_during_registration:58993,device_during_registration:Mozilla/5.0 (X11; Linux x86_64; rv-21.0) Gecko/20100101 Firefox/21.0,home:template.php,
* and make it an php-array
*/
function array2string($input, $key_value_delimiter = ":", $element_delimiter = ",")
{
	$result = "";
	if($input)
	{
		foreach ($input as $key => $value)
		{
			if(!$key_value_delimiter) // is there a $key_value_delimiter given? if not, it's maybe a list,with,elements
			{
				$result .= $value+$element_delimiter;
			}
			else
			{
				$result .= $key.$key_value_delimiter.$value.$element_delimiter;
			}
		}
	}

	return $result;
}
?>