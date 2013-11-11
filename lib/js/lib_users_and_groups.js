/* =============== user management functons */

/* get's a list of users in the given html-template/format
 * example:
 * */
(function($) {
    $.fn.usersList = function(ResultHandler,template) {
    	$(this).append(users(ResultHandler,null,null,null,null,template));
    	
    	return this;
    };
})(jQuery);

/* returns an array of all users available (if no parameter given)
 * 
* if $user given -> get $user as assoc-array
* by id (default) if no $uniqueKey is given
* (you can also specify get user by username,mail -> $uniqueKey)
*
* via $where you can filter the users you want with your own sql query
*/
function users(ResultHandler,user,uniqueKey,uniqueValue,where,template)
{
	user = typeof user !== 'undefined' ? user : null;
	uniqueKey = typeof uniqueKey !== 'undefined' ? uniqueKey : null;
	uniqueValue = typeof uniqueValue !== 'undefined' ? uniqueValue : null;
	where = typeof where !== 'undefined' ? where : "";
	
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
	urlObject["template"] = template;

	var urlString = $.param(urlObject);

	submitUrl("lib/php/lib_users_and_groups.php?"+urlString,ResultHandler);
}

/* checks if username is allready taken
*/
function usernameTaken(username,ResultHandler)
{
	var urlObject = new Object();
	urlObject["action"] = "users";
	urlObject["uniqueKey"] = "username";
	urlObject["uniqueValue"] = username;
	urlObject["where"] = "";

	var urlString = $.param(urlObject);

	submitUrl("lib/php/lib_users_and_groups.php?"+urlString,ResultHandler);
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
	
	// backend in php/ruby/python/java needs to implement this command: UserManagement_backend.php
	if(data2server)
	{
		var jqxhr = $.post("UserManagement_backend.php", data2server, function(response, responseText, jqXHR) {
			if(response)
			{
				ServerStatusMessage(response, responseText, jqXHR);
				if(responseText == "success")
				{
					// refresh user list, complete page refresh
					document.location.href = window.location.href;
				}
			}
		});
	}
}

/* get a list of all users and outputs it as a <ul><li>-list.
 * where = an div-id, where the user list should be put into.
 * */
function generateUserlist(where,ResultHandler)
{
	var usersArray = users(
					function(result) // ResultHandler
					{
						if(result)
						{
							$(where).append('<ul></ul>');

							$.each(result,
								function(index, value) {
								
								if((typeof result[index]) == "object") // only execute on returned data in object form, not on other properties action = users ... are also returned.
								{
									$(where+" > ul").append('\
											<li>\
											<input type="checkbox" class="checkbox" name="checkbox_'+result[index]['username']+'" id="checkbox_'+result[index]['username']+'" data-mini="true" value="0" userid="'+result[index]['id']+'"/>\
											<a href="UserManagement_backend.php?selectUserId='+result[index]['id']+'" rel="external" data-ajax="false">\
											<img id="profilepicture'+result[index]['id']+'" src="'+result[index]['profilepicture']+'" class="profilepicture"/>\
											<h3 id="username'+result[index]['id']+'">'+result[index]['username']+'</h3>\
											<p>UserID:'+result[index]['id']+'</p>\
											</a>\
									</li>');
								}
							
							});

							// jquery mobile transform this into a listview();
							$(where+" > ul").listview();
							
						}
						else
						{
							ServerStatusMessage(result,$(".error_div")); // visualize the response
						}
						
						ResultHandler(result);
					}
				); // get array of users
	
	return usersArray;
}

/* =============== group management functons */

/* get a list of all users and outputs it as a <ul><li>-list.
 * where = an div-id, where the user list should be put into.
 * type = what form you would like to have the list, possible values: checkboxes
 * */
function generateGrouplist(where,type,ResultHandler)
{
	type = typeof type !== 'undefined' ? type : "checkboxes";

	var groupsArray = groups(
					function(result) // ResultHandler
					{
						if(result)
						{
							$(where).append('<ul></ul>');

							$.each(result,
								function(index, value) {
								
								if((typeof result[index]) == "object") // only execute on returned data in object form, not on other properties action = groups ... are also returned.
								{
									if(type == "checkboxes")
									{
										/*
										$(where+" > ul").append('\
												<li>\
												<input type="checkbox" class="checkbox" name="checkbox_'+result[index]['groupname']+'" id="checkbox_'+result[index]['groupname']+'" data-mini="true" value="0" groupid="'+result[index]['id']+'"/>\
												<a href="groupManagement_backend.php?selectgroupId='+result[index]['id']+'" rel="external" data-ajax="false">\
												<img id="profilepicture'+result[index]['id']+'" src="'+result[index]['profilepicture']+'" class="profilepicture"/>\
												<h3 id="groupname'+result[index]['id']+'">'+result[index]['groupname']+'</h3>\
												<p>groupID:'+result[index]['id']+'</p>\
												</a>\
										</li>');
										*/
										$(where+" > ul").append('\
											<li>\
												<input type="checkbox" id="checkbox_group_'+result[index]['groupname']+'" class="custom checkbox_group_default" name="spam[]" validate="required:true, minlength:2" data-mini="true" value="1" class="ui-disabled" checked="true"/>\
												<label class="checkbox_group_default_label" for="checkbox_group_default">'+result[index]['groupname']+'</label>\
												<img id="profilepicture_'+result[index]['id']+'" src="'+result[index]['profilepicture']+'" class="profilepicture"/>\
											</li>');
									}
								}
							
							});

							// jquery mobile transform this into a listview();
							$(where+" > ul").listview();
							
						}
						else
						{
							ServerStatusMessage(result,$(".error_div")); // visualize the response
						}
						
						ResultHandler(result);
					}
				); // get array of groups
	
	return groupsArray;
}

/* returns an array of all groups available (if no parameter given)
*
* if $group given -> get $group as assoc-array
* by id (default) if no $uniqueKey is given
* (you can also specify get group by groupname,mail -> $uniqueKey)
*
* via $where you can filter the groups you want with your own sql query
*/
function groups(ResultHandler,group,uniqueKey,uniqueValue,where)
{
	group = typeof group !== 'undefined' ? group : null;
	uniqueKey = typeof uniqueKey !== 'undefined' ? uniqueKey : null;
	uniqueValue = typeof uniqueValue !== 'undefined' ? uniqueValue : null;
	where = typeof where !== 'undefined' ? where : "";

	if(!uniqueValue)
	{
		if(group)
		{
			uniqueValue = group[uniqueKey];
		}
	}

	var urlObject = new Object();
	urlObject["action"] = "groups";
	urlObject["uniqueKey"] = uniqueValue;
	urlObject["uniqueValue"] = uniqueValue;
	urlObject["where"] = where;

	var urlString = $.param(urlObject);

	submitUrl("lib/php/lib_users_and_groups.php?"+urlString,ResultHandler);
}