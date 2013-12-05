if (typeof jQuery.noConflict() == 'function') {	
	var jsnThemeFlowjQuery = jQuery.noConflict();
}
try {
	if (JSNISjQueryBefore && JSNISjQueryBefore.fn.jquery) {
		jQuery = JSNISjQueryBefore;
	}
} catch (e) {
	console.log(e);
}