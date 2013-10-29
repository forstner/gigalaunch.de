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

// css valid for all projects, includes the default jquery mobile css
dynamically_load_js_and_css("css/jquery.mobile-1.3.0.min.css");
dynamically_load_js_and_css("css/global.css");

// project wide css
dynamically_load_js_and_css("css/projectWide.css");

// project wide js libraries: jquery, jquery mobile
dynamically_load_js_and_css("lib/js/jquery-1.10.2.js");
dynamically_load_js_and_css("lib/js/jquery.mobile-1.3.2.js");

// timer plugin
dynamically_load_js_and_css("lib/js/lib_jquery.timer.js");

// js-client-side-md5, so that no password gets over network unencrypted, esp not during registration
dynamically_load_js_and_css("lib/js/lib_webtoolkit.md5.js");

// nice input validation plugin
dynamically_load_js_and_css("lib/js/lib_jquery.validate.js");

//  provices conversion function
dynamically_load_js_and_css("lib/js/lib_convert.js");

//  provices string operation functions
dynamically_load_js_and_css("lib/js/lib_strings.js");

// general stuff, client side functions to process server response
dynamically_load_js_and_css("lib/js/lib_general.js");

// translations
dynamically_load_js_and_css("lib/js/lib_translate.js");