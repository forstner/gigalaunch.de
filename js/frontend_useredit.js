$(document).ready(function() {
	$('#checkbox_group_default').attr("checked",true).checkboxradio("refresh"); // check all checkboxes that the user belongs to
	$('#checkbox_group_default').checkboxradio('disable'); // disable checkbox / do not allow user interaction

	// user usually belongs to user's default group
	// $('#checkbox_group_default').prop('checked', true);

		// immediately check if the username is taken -> inform user
		// on focus out
		$("#username").focusout(validateUsername);
		// on input change (wait 3 seconds)
	    $("#username").keyup(validateUsername);
	    function validateUsername()
	    {
	    	var username = "";
	    	username = $("#username").val();
	    	$(".checkbox_group_default_label > .ui-btn-inner > .ui-btn-text").text(username);
	    	$("#checkbox_group_default").attr("name","checkbox_group_"+username);

			var activeTimer = window.setInterval(
				function() {
					window.clearInterval(activeTimer);
			    	data = { username: username };

					var jqxhr = $.post("backend_username_available.php", data, function(response, responseText, jqXHR) {
						  if(response)
						  {
							  displayServerError(response, responseText, jqXHR);
						  }
					});
				}
				, 1000); // wait for a second before the request is fired
		}

	    // do only submit if all input fields are valid
		$.validator.setDefaults({
			submitHandler: function()
			{
		    	// serialize data (form2object)
		    	var question = form2Object($("#usereditForm")); // why? because password would be not md5-js-client-side-encrypted/transfered passwords
		    	question["password"] = MD5($("#password").val());
		    	question["password_confirm"] = MD5($("#password_confirm").val());
		    	question["profilepicture"] = $("#profilepicture").attr("src");
		    	
		    	// handles the submit of the form ajax-javascript way (not default form post)
		    	
				var jqxhr = $.ajax({
					type: 'POST',
		    		url: 'useredit.php',
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
		    				var result = displayServerError(response, responseText, jqXHR, 1);
		    				if	(result["type"] == "success")
		    				{
		    					// show message "ok" for 3 seconds then go back to previous page
		    					var activeTimer2 = window.setInterval(
		    							function() {
		    								window.clearInterval(activeTimer2);
		    								window.history.back();
		    							}
		    							, 3000); // wait for a second before the request is fired
		    				}
		    			}
		    		},
		    		error: function(jqXHR, responseText, errorThrown )
		    		{
		    			var result = displayServerError(response, responseText, jqXHR, 1);
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
		$("#usereditForm").validate({
			rules: {
				firstname: {
					required: false,
					minlength: 3
				},
				lastname: {
					required: false,
					minlength: 3
				},
				username: {
					required: false,
					minlength: 3
				},
				password: {
					required: false,
					minlength: 8
				},
				password_confirm: {
					required: false,
					minlength: 8,
					equalTo: "#password"
				},
				email: {
					required: false,
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
					minlength: "Your password must be at least 8 characters long, a secure password consists of a mix of numbers/special chars/UPPER/lowercase characters"
				},
				password_confirm: {
					required: "Please provide a password",
					minlength: "Your password must be at least 8 characters long, a secure password consists of a mix of numbers/special chars/UPPER/lowercase characters",
					equalTo: "Please enter the same password as above"
				},
				email: "Please enter a valid email address"
			}
		});

		// propose username by combining first- and lastname
		$("#username").focus(function() {
			var firstname = $("#firstname").val();
			var lastname = $("#lastname").val();
			if(firstname && lastname && !this.value) {
				this.value = firstname + "." + lastname;
			}
		});
});