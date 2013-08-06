/* all checkboxes should change their value="0" to "1" if checked, because this is transmitted when submitting a form */
$(document).ready(function() {
	$("input[type='checkbox']").bind( "change", function(event, ui) {
		if($(this).prop("checked"))
		{
			$(this).val("1");
		}
		else
		{
			$(this).val("0");
		}
	});
});

/*
 * displays the info/error messages coming from the server inside a div of this format:
 
 2 = outputIDNumber
 
			<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
			<div id="error2" class="error" data-role="collapsible" data-content-theme="c">
				<h3>error/status2</h3>
				<p>
					<div id="details2">details</div>
				</p>
			</div>

 * after a request in colorful ways, without reloading the entire page (ajax) to immediately give the user feedback
 * about the user's last action.
 * 
 * if you have multiple output-divs, you can pass this function an outputIDNumber (1,2,3..)
 * to target error1/details1 and error2/details2 divs.
 * 
 * */
function displayServerError(response, responseText, jqXHR, outputIDNumber)
{
	var result = analyseServerResponse(response);
	
	if(!outputIDNumber)
	{
		outputIDNumber = "";
	}
	
	fadeSpeed = 400;
	selector = "#error"+outputIDNumber;
    $(selector).fadeIn(fadeSpeed, function() {
		if (responseText == "error") {
			// probably connection problems
			selector = "#error"+outputIDNumber+" .ui-btn-text";
			$(selector).text("error: response:"+response+ ",responseText:"+responseText);
			selector = "#details"+outputIDNumber;
			$(selector).text(jqXHR.status + " " + jqXHR.statusText);
		}
		else if (responseText == "success") {
			// response from server

			result["id"] // a unique string, that identifies the message/problem/status
			result["details"] // details of the response

			// paint in warning color
			if(result["type"] == "error")
			{
				selector = "#error"+outputIDNumber+" a";
				$(selector).css("background","red");
				selector = "#error"+outputIDNumber+" .ui-btn-text";
				$(selector).text(result["id"]);
				selector = "#details"+outputIDNumber;
				$(selector).text(result["details"]);
				
				selector = "#error"+outputIDNumber;
				$(selector).css("diplay","block");
				$(selector).css("opacity","1");
			}
			else if(result["type"] == "success")
			{
			// all ok remove warning color
				selector = "#error"+outputIDNumber+" a";
				$(selector).css("background","green"); // default is: linear-gradient(#FFFFFF, #F1F1F1) repeat scroll 0 0 #EEEEEE;
				$(selector).css("diplay","none");
				selector = "#error"+outputIDNumber+" .ui-btn-text";
				$(selector).text(result["id"]);
				$("#details"+outputIDNumber).text(result["details"]);
				
				selector = "#error"+outputIDNumber;
				$(selector).css("diplay","block");
				$(selector).css("opacity","1");
			}
		}
    });

    return result;
}

/*
 * analyse the answer/response/response of a server-command, formatted like this:
	exit('type:error,id:Username already taken,message:
		<h3>server says</h3>
		<div id="error_details">
			<p>Username already taken. Please choose different one.</p>
		</div>
	');
	
	response["id"] // a unique string, that identifies the message/problem/status
	response["message"] // the message ready to be displayed inside a div
	response["type"] == "error"/"status"/"info"/"what you can think of"
 */

function analyseServerResponse(response) {
	var string_array = response.split(",");
	
	var result = [];

	string_sub_array = string_array[0];
	string_sub_array = string_sub_array.split(":");
	result["type"] = string_sub_array[1];

	string_sub_array = string_array[1];
	string_sub_array = string_sub_array.split(":");
	result["id"] = string_sub_array[1];
	
	string_sub_array = string_array[2];
	string_sub_array = string_sub_array.split(":");
	result["details"] = "";
	if(string_sub_array[1])
	{
		result["details"] += string_sub_array[1]+":";
	}
	if(string_sub_array[2])
	{
		result["details"] += string_sub_array[2]+":";
	}
	if(string_sub_array[3])
	{
		result["details"] += string_sub_array[3]+":";
	}
	if(string_sub_array[4])
	{
		result["details"] += string_sub_array[4]+":";
	}

	return result;
}

/* pass a $("#form") and get a object with key=value input data of that form */
function form2Object(form)
{
	var formObject = {};
	$(form).find(":input").each(function() {
		// The selector will match buttons; if you want to filter
		// them out, check `this.tagName` and `this.type`; see
		// below
		formObject[this.name] = $(this).val();
	});
	
	return formObject;
}
/* creates a dialog that asks the User for confirmation, to delete the users */
function createDialogDoYouReallyWantTo(title, text, executeFunction)
{
    return $("<div class='dialog' title='" + title + "'><p>" + text + "</p></div>")
    .dialog({
        resizable: false,
        height:140,
        modal: true,
        buttons: {
            "Confirm": function() {
                $( this ).dialog( "close" );
                executeFunction();
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        }
    });
}