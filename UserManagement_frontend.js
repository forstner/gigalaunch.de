$(document).ready(function() {
	getAllUsers();
});

/* get a list of all users */
function getAllUsers()
{
	var usersArray = users(
					function(result) // ResultHandler
					{
						if(result)
						{
							$("#content").append('<ul id="userList"></ul>');

							$.each(result,
								function(index, value) {
								
								if((typeof result[index]) == "object") // only execute on returned data in object form, not on other properties action = users ... are also returned.
								{
									$("#userList").append('\
											<li>\
											<input type="checkbox" class="checkbox" name="checkbox_'+result[index]['username']+'" id="checkbox_'+result[index]['username']+'" data-mini="true" value="0" userid="'+result[index]['id']+'"/>\
											<a href="frontend_useredit.php?selectUserId='+result[index]['id']+'" rel="external" data-ajax="false">\
											<img id="profilepicture'+result[index]['id']+'" src="'+result[index]['profilepicture']+'" class="profilepicture"/>\
											<h3 id="username'+result[index]['id']+'">'+result[index]['username']+'</h3>\
											<p>UserID:'+result[index]['id']+'</p>\
											</a>\
									</li>');
								}
							
							});

							$("#userList").listview();
							
						}
						else
						{
							displayServerMessage(result,$("#login_error_div")); // visualize the response
						}
					}
				); // get array of users
}