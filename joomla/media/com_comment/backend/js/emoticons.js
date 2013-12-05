/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 25.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

var emoticons = new Class({

	initialize: function(el) {
		var self = this;
		this.el = document.id(el);

		this.el.addEvent('change', function() {
			self.showEmoticons();
		});

		self.showEmoticons();
	},

	showEmoticons: function() {
		var selected = this.el.getSelected().get('value');
		$$('.emoticons').setStyle('display', 'none');

		document.id('emoticons-'+selected).setStyle('display', 'block');
	}
});