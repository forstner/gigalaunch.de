/* does all sorts of default initialization stuff
 * all checkboxes should change their value="0" to "1" if checked, because this is transmitted when submitting a form */
var CurrentFilename = "";
$(document).ready(function() {
	// init
	CurrentFilename = getCurrentFilename(true);
	
	// setTitle
	setTitle();

	// this page specific javascript
	$.ajax({
		type: "GET",
		url: CurrentFilename+".js",
		dataType: "script"
	});

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
	
	var result = [];

	if(jQuery.isArray(response))
	{
		if(response.length > 0)
		{
			if(response["error"] != undefined)
			{
				// process json-array-response
			}
		}
	}
	else
	{
		var string_array = response.split(",");

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

/* converts a form into a json compatible javascript object */
$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

/* change the label of a jQM button */
function buttonChangeLabel(button,value)
{
	$(button).prev('span').find('span.ui-btn-text').text(value);
	$(button).prop('value', value);
}

/* load the logo */
function loadLogo()
{
	document.write('<img id="logo" src="images/projectlogo.png" style="width:200px;"/>');
}

/* checks if it is empty */
function validate(input) {
	var valid = true;
	var label = $(input).prev(); // get label
	var elementName = $(input).attr("name");
	
	var labelval = label.text();
	
	var star = returnLastXChars(labelval,1);
	
	if(star == "*")
	{
		if($(input).val() == "")
		{
			valid = false;
			$(label).css("color", "red");
		}
		else
		{
			$(label).css("color", "#777777");
		}
	}
	
	if(valid)
	{
		if(elementName == "email")
		{
			$(input).next().fadeOut("slow"); // email_error
		}
	}
	else
	{
		$(input).next().fadeIn("slow"); // email_error
	}
	
	return valid;
}

/* read all input fields of a form, assemble target.php?key=value url and submit via jqxhr request. */
function submitForm(form) {
	
	var title = getTitle();
	var data = null;
	var url = title+"_backend.php?";

	url += $(form).serialize();

	var jqxhr = $.post(url, data, function(response, status, xhr) {
		if (response) {
			if (status == "success") {
				var result_array = response.split(',');
				if (result_array[1] == "mail send successfully") {
					alert("Vielen Dank für Ihre Anfrage, diese wurde erfolgreich verschickt!");
				}
				if (result_array[1] == "mail send failed") {
					alert("Es ist ein technischer Fehler beim verschicken der Anfrage aufgetreten, bitte Kontaktieren Sie uns über das Impressum, Danke!");
				}
				if (result_array[1] == "domain not valid") {
					alert("Ihre Mail-Adresse "+result_array[0]+" scheint keine gültige Domain zu sein.");
				}
			}
		}
	});
}

/* get filename of current file.html -> file */
function getCurrentFilename(withEnding = false)
{
	//this gets the full url
	var url = window.location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	if(!withEnding)
	{
		filename = chopLastCharX(filename,4);
	}
	
	return filename;
}

/* set title automatically, by getting the name from the url-filename, login_frontend -> login */
function setTitle() 
{
	document.title = getTitle();
	
	return document.title;
}

/* set title automatically, by getting the name from the url-filename, login_frontend -> login */
function getTitle() 
{
	// set title automatically depending on CurrentFilename
	CurrentFilename = getCurrentFilename();

	var CurrentFilename_array = CurrentFilename.split("_");
	var title = CurrentFilename_array[0];
	document.title = title;
	
	return title;
}