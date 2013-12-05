/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 16.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

var settings = new Class({
	Implements: [Options],
	options: {
		element: 'template',
		component: 'com_content'
	},

	initialize: function(options) {
		var self = this;
		this.setOptions(options);
		this.element = document.id(this.options.element);

		this.element.addEvent('change', function() {
			self.getTemplateParams();
		});

		self.getTemplateParams();
	},

	getTemplateParams: function() {
		var selected = this.element.getSelected().get('value');

		new Request.HTML({
			url: 'index.php?option=com_comment&task=template.getparams&format=raw&component='+this.options.component,
			data: 'template='+selected,
			update: 'template-params',
			onSuccess: function(){
				$$('.radio.btn-group label').addClass('btn');

				document.id('template-params').addEvent('click:relay(.btn-group label:not(.active))', function(){

					var label = this;
					var input = document.id(label.get('for'));
					if (!input.get('checked')) {
						label.getParent('.btn-group').getElements("label").removeClass('active').
							removeClass('btn-success').removeClass('btn-danger').removeClass('btn-primary');
						if (input.get('value') == '') {
							label.addClass('active btn-primary');
						} else if (input.get('value') == 0) {
							label.addClass('active btn-danger');
						} else {
							label.addClass('active btn-success');
						}
						input.set('checked', true);
					}
				});
				$$('.btn-group input[checked=checked]').forEach(function(el){
					if (el.get('value') == '') {
						$$("label[for=" + el.get('id') + "]").addClass('active btn-primary');
					} else if (el.get('value') == 0) {
						$$("label[for=" + el.get('id') + "]").addClass('active btn-danger');
					} else {
						$$("label[for=" + el.get('id') + "]").addClass('active btn-success');
					}
				});
			}
		}).send();
	}
});