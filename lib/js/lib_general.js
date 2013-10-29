/* does all sorts of default initialization stuff
 * all checkboxes should change their value="0" to "1" if checked, because this is transmitted when submitting a form */
var CurrentFilename = ""; // to enable the dynamic loading of page specific css and js, one needs to determine the current filename
$(document).ready(function() {
	CurrentFilename = getCurrentFilename();
	
	// setTitle
	setTitle();

	// fill all <div class="logo"> with content
	loadLogo();
	// loading page specific js and css automatically without backend-languages (php) is doable, but it comes with drawbacks... -> firebug not displaying javascript syntax errors so i decided to not do it.
	// load page specific javascript
	/* need to load it manually... firebug not working properly
	$.ajax({
		type: "GET",
		url: CurrentFilename+".js",
		dataType: "script"
	});
	*/
	// load page specific css
	/* maybe this is confusing for people
	$("<link/>", {
		   rel: "stylesheet",
		   type: "text/css",
		   href: CurrentFilename+".css"
		}).appendTo("head");
	*/

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
 * displays the anser/result/info/error messages coming from the server inside a div of this format:

 the html:
	<!-- where errors are displayed (put it directly next to the interactive element, that can produce an error) -->
	<div id="error2" class="error" data-role="collapsible" data-content-theme="c">
		<h3>error/status2</h3>
		<p>
			<div id="details2">details</div>
		</p>
	</div>

 * after a request in colorful ways, without reloading the entire page (ajax) to immediately give the user feedback about the user's last action.
 * 
 * * {action":"login","resultType":"success","resultValue":"success","details":"you have now access. live long and prosper! Login expires in 30 minutes."}
 * */
function ServerStatusMessage(answer, output)
{
	if(!output)
	{
		// if no output object given, try to access one via class="status"
		output = $(".status");
	}

	// does one have a element where to display the result/answer/output
	if(output)
	{
		// then display
		$(output).html("<div class='status' data-role='collapsible'> "+answer["resultType"]+": "+answer["action"]+" "+answer["details"]+"</div>");
		var outputId = "'#"+$(output).attr("id");
		
		var status = output.children(":first");
		
		// color the message
		if((answer["resultType"] == "success") || (answer["resultType"] == "true"))
		{
			$(status).css("background","green"); // default is: linear-gradient(#FFFFFF, #F1F1F1) repeat scroll 0 0 #EEEEEE;
		}
		else if((answer["resultType"] == "failed") || (answer["resultType"] == "error") || (answer["resultType"] == "false"))
		{
			$(status).css("background","orange");
		}

		$(status).fadeIn(400);
	}
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
	ask("path to logo", function(path_to_logo){
		$(".logo").html('<img id="logo" src="'+path_to_logo+'" style="width:200px;"/>');
	});
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
function submitForm(form,ResultHandler) {
	
	var title = getTitle();
	var data = null;
	var url = title+"_backend.php?";

	url += $(form).serialize();

	var jqxhr = $.post(url, data, function(response, responseText, jqXHR) {
		if (response) {
			// process json result/response
			var response_array = jQuery.parseJSON(response);

			// if not empty
			if(response_array)
			{
				// execute ResultHandler
				ResultHandler(response_array);
			}
		}
	});
}

/* ask Server a question. right now this is not for submitting forms. */
function ask(question,ResultHandler) {
	
	var url = "answer.php?question="+question;
	var data = null;
	
	var jqxhr = $.post(url, data, function(response, responseText, jqXHR) {
		if (response) {
				// execute ResultHandler
				ResultHandler(response);
			}
		});
}

/* the "manual" way of communicating with the backend is to assemble your custom url, simply submit a specific url to the backend */
function submitUrl(url,ResultHandler)
{
	var data = null;
	var jqxhr = $.post(url, data, function(response, responseText, jqXHR) {
		if (response) {
			// process json result/response
			var response_array = jsonDecode(response);

			// if not empty
			if(response_array)
			{
				// execute ResultHandler
				ResultHandler(response_array);
			}
		}
	});
}

/* decodes a json string into a javascript-object
 * 
 * example:
 * {"0":{"id":"240","usern...Value":"","details":""}", "success", Object { readyState=4, responseText="{"0":{"id":"240","usern...Value":"","details":""}", status=200, more...}]
 * */
function jsonDecode(JsonEncodedString)
{
	return jQuery.parseJSON(JsonEncodedString);
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

/* write message to firebug-browser-javascript-console */
function log(message)
{
	console.log(message);
}