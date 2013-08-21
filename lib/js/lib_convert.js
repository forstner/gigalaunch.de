/* all sorts of conversion functions */

function dec2octal(input) {
	input = parseInt(input);
	var octal = input.toString(8);
	return octal;
}
function dec2bin(input) {
	input = parseInt(input);
	var bin = input.toString(2);
	return bin;
}
/* convert a binary to decimal */
function bin2dec(input) {
	var result = "";
	// keep binary as string
	result = parseInt(input, 2); // radix 2
	return result;
}
/* convert a decimal to hex*/
function dec2hex(input) {
	var result = "";
	result = parseInt(input);
	// result = result + 255; // der schlaubi schlumpf meint das muss so http://st-on-it.blogspot.de/2009/07/decimal-to-hex-and-hex-to-decimal-in.html wehe er hat nicht recht.
	result = result.toString(16).toUpperCase();

	return result;
}
/* convert a hex to decimal */
function hex2dec(input) {
	var result = "";
	// keep binary as string
	result = parseInt(input, 16); // radix 16
	return result;
}
/* convert bin2hex */
function bin2hex(input) {
	var result = "";
	var dec = bin2dec(input);
	result = dec2hex(dec);

	return result;
}
/* convert hex2bin */
function hex2bin(input) {
	var result = "";
	var dec = hex2dec(input);
	result = dec2bin(dec);

	return result;
}