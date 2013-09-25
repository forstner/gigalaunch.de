/* backend used */
var backendUrl =  "lib/lib_users.php";

/* returns an array of all users available (if no parameter given)
*
* if $user given -> get $user as assoc-array
* by id (default) if no $uniqueKey is given
* (you can also specify get user by username,mail -> $uniqueKey)
*
* via $where you can filter the users you want with your own sql query
*/
function users(ResultHandler,user = null,uniqueKey = null,uniqueValue = null,where = "")
{
	if(!uniqueValue)
	{
		if(user)
		{
			uniqueValue = user[uniqueKey];
		}
	}

	var urlObject = new Object();
	urlObject["action"] = "users";
	urlObject["uniqueKey"] = uniqueValue;
	urlObject["uniqueValue"] = uniqueValue;
	urlObject["where"] = where;

	var urlString = $.param(urlObject);

	submitUrl(backendUrl+"?"+urlString,ResultHandler);
}

/* delete the selected (checkbox) users */
function deleteUser()
{
	var counter = 0;
	var data2server = {};
	$("input[type='checkbox']").each(function() {
		if($(this).prop('checked'))
		{
			var value = $(this).attr('userid');
			var key = "user2delete"+counter++;
			data2server[key] = value; // adds key:value to object2
		}
	});
	
	// backend in php/ruby/python/java needs to implement this command: frontend_useredit.php
	if(data2server)
	{
		var jqxhr = $.post("frontend_useredit.php", data2server, function(response, responseText, jqXHR) {
			if(response)
			{
				displayServerMessage(response, responseText, jqXHR);
				if(responseText == "success")
				{
					// refresh user list, complete page refresh
					document.location.href = window.location.href;
				}
			}
		});
	}
}