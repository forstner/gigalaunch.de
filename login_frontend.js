$(document).ready(function() {
	/* handles the submit of the form javascript way (not calling an url) */
	// validate signup form on keyup and submit
	$("#loginForm").validate({
		submitHandler: function(form) {
			submitForm(form,
					function(result) // ResultHandler of the form-request -> process the result/answer of the server
					{
						displayServerMessage(result,$(".error_div")); // visualize the response

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
	
	// manually syncing fields
	$("#password_cleartext").keyup(
	    function()
	    {
			password_cleartext = $("#password_cleartext").val();
			password_encrypted = MD5(password_cleartext); 
			$("#password_encrypted").val(password_encrypted);
	    }
	);
});