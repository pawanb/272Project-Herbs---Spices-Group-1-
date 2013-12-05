if (typeof jQuery.noConflict() == 'function') {	
	var jsnThemeStripjQuery = jQuery.noConflict();
}

try {
	if (JSNISjQueryBefore && JSNISjQueryBefore.fn.jquery) 
	{
		jQuery = JSNISjQueryBefore;
	}
} catch (e) {}