/* open dialog delete */
function openDialogDelete()
{
	// generate list of selected users
	var counter = 0;
	var data2server = {};
	
	$("#deleteDialog_content").empty();

	// get all checked checkboxes
	var allCheckBoxes = $("input[type='checkbox']");
	var allCheckedCheckBoxes = [];
	
	for( var i = 0; i < allCheckBoxes.length; i++)
	{
		if($(allCheckBoxes[i]).prop('checked'))
		{
			allCheckedCheckBoxes.push(allCheckBoxes[i]);
		}
	}
	
	if(allCheckedCheckBoxes.length > 0)
	{
		// fill popup dialog with info
		for(i = 0;i < allCheckedCheckBoxes.length; i++)
		{
			checkbox = allCheckedCheckBoxes[i];
			var name = $(checkbox).attr("name");
			var id = $(checkbox).attr("id");
			var userid = $(checkbox).attr('userid');
			var key = "user2delete"+counter++;
			
			var imgSrc = $("#profilepicture"+userid).attr("src");
			var UserName = $("#username"+userid).text();
			$("#deleteDialog_content").append(
					"	<img class='profilePicture' src='"+imgSrc+"'/>" +
					"	<h3>"+UserName+"</h3>");
			$("#deleteDialog_content").append("</br>");
		}

		// show popup dialog
		$.mobile.changePage( "#deleteDialog", {
			transition: "pop",
			role: "dialog",
			reverse: false,
		});

	}
	else
	{
		displayServerError("type:error,id:NO USERS SELECTED,details:Please select a user to delete.","success");
	}

	/*
	<h3 class="ui-li-heading">usernameNew</h3>
	<img class="profilepicture ui-li-thumb" src="images/profilepictures/11.jpg">
	*/

}

/* delete the selected (checkbox) users */
function deleteUser()
{
	var counter = 0;
	var data2server = {};
	$("input[type='checkbox']").each(function() {
		if($(this).prop('checked'))
		{
			var value = $(this).attr('userid');
			var key = "user2delete"+counter++;
			data2server[key] = value; // adds key:value to object2
		}
	});
	
	// backend in php/ruby/python/java needs to implement this command: userdel.php
	if(data2server)
	{
		var jqxhr = $.post("userdel.php", data2server, function(response, responseText, jqXHR) {
			if(response)
			{
				displayServerError(response, responseText, jqXHR);
				if(responseText == "success")
				{
					// refresh user list, complete page refresh
					document.location.href = window.location.href;
				}
			}
		});
	}
}