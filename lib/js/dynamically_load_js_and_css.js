/******* dynamically_load_js_and_css ********/
// so if you need to globally include stuff, here you can do it without search replace/copy pasting all over the world
function dynamically_load_js_and_css(filename) {
	var filetype = filename.substring(filename.length, filename.length - 3);
	filetype = filetype.replace(".", "");

	if (filetype == "js") { // if filename is a external JavaScript file
		document.write('<script src="'+filename+'" type="text/javascript"></script>');
	} else if (filetype == "css") { // if filename is an external CSS file
		document.write('<link rel="stylesheet" type="text/css" href="'+filename+'"/>');
	}
}

// #set1 ie7 downward compatible
// #set2 -> not ie7

dynamically_load_js_and_css("css/global.css");

// project wide css
dynamically_load_js_and_css("css/projectWide.css");

// timer plugin
dynamically_load_js_and_css("lib/js/lib_jquery.timer.js");

// js-client-side-md5, so that no password gets over network unencrypted, esp not during registration
dynamically_load_js_and_css("lib/js/lib_webtoolkit.md5.js");

//  provices conversion function
dynamically_load_js_and_css("lib/js/lib_convert.js");

//  provices string operation functions
dynamically_load_js_and_css("lib/js/lib_strings.js");

// general stuff, client side functions to process server response
dynamically_load_js_and_css("lib/js/lib_general.js");

// translations
dynamically_load_js_and_css("lib/js/lib_translate.js");

/* get filename of current file.php -> file */
function getCurrentFilename(withEnding)
{
	withEnding = typeof withEnding !== 'undefined' ? withEnding : false;

	//this gets the full url
	var url = window.location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	if(!withEnding)
	{
		filename = filename.substring(0, filename.length - 4);
	}
	
	return filename;
}

var CurrentFilename = ""; // to enable the dynamic loading of page specific css and js, one needs to determine the current filename
CurrentFilename = getCurrentFilename();
dynamically_load_js_and_css(CurrentFilename+'.js');
dynamically_load_js_and_css(CurrentFilename+'.css');