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
								
								$("#userList").append('\
								<li>\
									<input type="checkbox" class="checkbox" name="checkbox_'+result[index]['username']+'" id="checkbox_'+result[index]['username']+'" data-mini="true" value="0" userid="'+result[index]['id']+'"/>\
									<a href="frontend_useredit.php?selectUserId='+result[index]['id']+'" rel="external" data-ajax="false">\
										<img id="profilepicture'+result[index]['id']+'" src="'+result[index]['profilepicture']+'" class="profilepicture"/>\
										<h3 id="username'+result[index]['id']+'">'+result[index]['username']+'</h3>\
										<p>UserID:'+result[index]['id']+'</p>\
									</a>\
								</li>');

								/* jquery mobile generated source -> does not look nice
								$("#userList").append('\
										<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-li-has-thumb ui-first-child ui-btn-up-c"><div class="ui-btn-inner ui-li"><div class="ui-btn-text">\
										<div class="ui-checkbox"><input type="checkbox" userid="'+result[index]['id']+'" value="0" data-mini="true" id="checkbox_'+result[index]['username']+'" name="checkbox_'+result[index]['username']+'" class="checkbox"></div>\
										<a onclick="useredit('+result[index]['id']+')" data-ajax="false" rel="external" class="ui-link-inherit">\
											<img class="profilepicture ui-li-thumb" src="'+result[index]['profilepicture']+'" id="profilepicture_'+result[index]['username']+'">\
											<h3 id="'+result[index]['username']+'1" class="ui-li-heading">'+result[index]['username']+'</h3>\
											<p class="ui-li-desc"></p>\
										</a>\
									</div>\
									<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span></div></li>\
									');
								}
								*/
							
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