$(document).ready(function() {

// do only submit if all input fields are valid
	$.validator.setDefaults({
		submitHandler: function()
		{
	    	// serialize data (form2object)
	    	var data = form2Object($("#forgottenPasswordForm")); // why? because password would be not md5-js-client-side-encrypted/transfered passwords

	    	// handles the submit of the form ajax-javascript way (not default form post)
	    	
			var jqxhr = $.ajax({
				type: 'POST',
	    		url: 'forgottenPassword_backend.php',
	    		data: data,
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
	    				var result = displayServerMessage(response, responseText, jqXHR, 1);
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
	    			var result = displayServerMessage(response, responseText, jqXHR, 1);
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
	$("#forgottenPasswordForm").validate({
		rules: {
			email: {
				required: true,
				email: true
			}
		},
		messages: {
			email: "Please enter a valid email address"
		}
	});
});