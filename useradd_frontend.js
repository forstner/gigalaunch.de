$(document).ready(function() {
	// $('#checkbox_group_default').attr("checked",true).checkboxradio("refresh"); // check checkbox per default - user usually belongs to user's default group
	$('.checkbox_group_default').checkboxradio('disable'); // disable checkbox / do not allow user interaction
	
	var session_valid = $("#session_valid").text(); 

		// immediately check if the username is taken -> inform user
		// on focus out
		$("#username").focusout(validateUsername);
		// on input change (wait 3 seconds)
	    $("#username").keyup(validateUsername);
	    
	    // 1. is a username entered? if not -> ARGH!
	    // 2. ask the database if the username is not taken/free for registration
	    function validateUsername()
	    {
	    	var username = "";
	    	username = $("#username").val();
	    	
	    	// 1. is a username entered? if not -> ARGH!
	    	if(!username)
	    	{
	    		ServerStatusMessage("type:error,id:no username entered,details:Please enter a username it can not be nothing!","success");
	    	}
	    	else
	    	{
	    		$(".checkbox_group_default_label > .ui-btn-inner > .ui-btn-text").text(username);
	    		$("#checkbox_group_default").attr("name","checkbox_group_"+username);
	    		
	    		// 2. ask the database if the username is not taken/free for registration
	    		var activeTimer = window.setInterval(
	    				function() {
	    					window.clearInterval(activeTimer);
	    					data = { username: username };
	    					
	    					// should not be backend_username_available.php, because this is only working for logged in users (not guests that want to register)
	    					var jqxhr = $.post("frontend_useradd.php", data, function(response, responseText, jqXHR) {
	    						if(response)
	    						{
	    							ServerStatusMessage(response, responseText, jqXHR);
	    						}
	    					});
	    				}
	    				, 1000); // wait for a second before the request is fired
	    	}
		}
	    
	    // do only submit if all input fields are valid
		$.validator.setDefaults({
			submitHandler: function()
			{
		    	// serialize data (form2object)
		    	var question = form2Object($("#useraddForm")); // why? because password would be not md5-js-client-side-encrypted/transfered passwords
		    	question["password"] = MD5($("#password").val());
		    	question["password_confirm"] = MD5($("#password_confirm").val());
		    	question["profilepicture"] = $("#profilepicture").attr("src");
		    	
		    	// handles the submit of the form ajax-javascript way (not default form post)
		    	
				var jqxhr = $.ajax({
					type: 'POST',
		    		url: 'frontend_useradd.php',
		    		data: question,
		    		success: function(response, responseText, jqXHR)
		    		{
		    			/*
								A function to be called if the request succeeds.
								The function gets passed three arguments:
									1. The response returned from the server, formatted according to the dataType parameter;
									2. a string responseText describing the status;
									3. and the jqXHR (in jQuery 1.4.x, XMLHttpRequest) object.
								As of jQuery 1.5, the success setting can accept an array of functions. Each function will be called in turn. This is an Ajax Event.
		    			 */
		    			if(response)
		    			{
		    				var result = ServerStatusMessage(response, responseText, jqXHR, 1);
		    				if	(result["type"] == "success")
		    				{
		    					// show message "ok" for 3 seconds then go back to previous page
		    					var activeTimer2 = window.setInterval(
		    							function() {
		    								window.clearInterval(activeTimer2);

		    								// -> if user is a guest (not logged in) display message & redirect to index.html -> which redirects to login
		    								// -> if user is a admin (logged in) display message & go one page back
		    								if(session_valid == "true")
		    								{
		    									window.history.back();
		    								}
		    								else
		    								{
		    									window.location = "index.html";
		    								}
		    							}
		    							, 3000); // wait for a second before the request is fired
		    				}
		    			}
		    		},
		    		error: function(jqXHR, responseText, errorThrown )
		    		{
		    			var result = ServerStatusMessage(response, responseText, jqXHR, 1);
		    			/* A function to be called if the request fails.
		    			 * The function receives three arguments:
						   		 1. The jqXHR (in jQuery 1.4.x, XMLHttpRequest) object,
						   		 2. a string describing the type of error that occurred and an optional exception object, if one occurred.
						   		 3. Possible values for the second argument (besides null) are "timeout", "error", "abort", and "parsererror".

		    			 * When an HTTP error occurs, errorThrown receives the textual portion of the HTTP status,
		    			 * such as "Not Found" or "Internal Server Error."
		    			 * As of jQuery 1.5, the error setting can accept an array of functions. Each function will be called in turn.
		    			 * Note: This handler is not called for cross-domain script and cross-domain JSONP requests. This is an Ajax Event.
		    			 */
		    		}
		    	});
			}
		});

		
		// validate signup form on keyup and submit
		$("#useraddForm").validate({
			rules: {
				firstname: {
					required: true,
					minlength: 3
				},
				lastname: {
					required: true,
					minlength: 3
				},
				username: {
					required: true,
					minlength: 3
				},
				password: {
					required: true,
					minlength: 8
				},
				password_confirm: {
					required: true,
					minlength: 8,
					equalTo: "#password"
				},
				email: {
					required: true,
					email: true
				}
			},
			messages: {
				firstname: {
					required: "Please enter your firstname",
					minlength: "Your name must consist of at least 3 characters"
				},
				lastname: {
					required: "Please enter your lastname",
					minlength: "Your name must consist of at least 3 characters"
				},
				username: {
					required: "Please enter a username",
					minlength: "Your username must consist of at least 3 characters"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 8 characters long, should be a mix of numbers/special chars/UPPER/lowercase characters"
				},
				password_confirm: {
					required: "Please provide a password",
					minlength: "Your password must be at least 8 characters long, should be a mix of numbers/special chars/UPPER/lowercase characters",
					equalTo: "Please enter the same password as above"
				},
				email: "Please enter a valid email address"
			}
		});
});