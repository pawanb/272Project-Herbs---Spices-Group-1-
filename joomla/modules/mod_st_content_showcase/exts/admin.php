<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;
?>
<script>
	var stContentShowcase = {};
	jQuery.noConflict();
	(function($){
		$(document).ready(function(){
			document.getElementById('module-form').addEvent('submit', function(){
		  		$('#stExtsParams').val($('#module-form').serialize());
		  	});
		});
	})(jQuery);
</script>