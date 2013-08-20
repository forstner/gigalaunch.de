function translate(keyword)
{
	data = { username: username };

	var jqxhr = $.post("lib_translations.php", data, function(response, responseText, jqXHR) {
		  if(response)
		  {
			  displayServerError(response, responseText, jqXHR);
		  }
	});
}