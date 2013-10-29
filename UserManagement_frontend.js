// holds all users
var usersArray = [];
var groupsArray = [];

$(document).ready(function() {
	
	usersArray = generateUserlist("#userList > .content");
	groupsArray = generateGrouplist("#container_ListOfGroups");
	
	$("#username").bind( "change", function(event, ui) {
		var username = $(this).val();
		if(username.length < 3)
		{
			usernameTaken($(this).val(),function(taken){
				if(taken)
				{
					ServerStatusMessage(taken,$(".error_div")); // visualize the response
				}
			});
		}
	});
	
	$("#useraddForm").validate({
		submitHandler: function(form) {
			submitForm(form,
				function(result) // ResultHandler of the form-request -> process the result/answer of the server
				{
					ServerStatusMessage(result,$(".error_div")); // visualize the response

					// after a successful login
					if((result["action"] == "login") && (result["resultType"] == "success"))
					{
						// go to user's home
						window.location = result["goto"];
					}
				}
			);
		},
		rules: {
			username: {
				required: true,
				minlength: 3
			},
			password: {
				required: true,
				minlength: 8
			}
		},
		messages: {
			username: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 3 characters"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 8 characters long, should be a mix of numbers/special chars/UPPER/lowercase characters"
			}
		}
	});
});

