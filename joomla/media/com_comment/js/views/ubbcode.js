/*jshint mootools:true */
define(function(){
	'use strict';

	return new Class({
		Implements: [Options],
		options: {
			container: 'ccomment',
			// ubb or emoticon
			type: 'ubb'
		},

		initialize: function(options){
			this.setOptions(options);
			this.container = document.id(this.options.container);

			this.start();
		},

		start: function(){
			var self = this;
			this.container.addEvent('click:relay(.ccomment-ubb-container span.ccomment-ubb)', function(){
				self.insertTag(this);
			});

			this.container.addEvent('change:relay(.ccomment-ubb-container select)', function(){
				self.insertSelect(this);
			});

			this.container.addEvent('click:relay(.ccomment-emoticons span)', function(){
				self.insertTag(this);
			});
		},

		insertTag: function(el){
			this.insert(el.get('data-open'), el.get('data-close') ? el.get('data-close') : '', el);
		},

		insertSelect: function(el){
			var selected = el.getSelected();
			this.insert(selected.get('data-open'), selected.get('data-close'), el);
		},

		insert: function(open, close, el){
			var txtarea = el.getParent('form').getElement('textarea'),
				selLength = txtarea.textLength,
				selStart = txtarea.selectionStart,
				selEnd = txtarea.selectionEnd,
				s1 = (txtarea.value).substring(0, selStart),
				s2 = (txtarea.value).substring(selStart, selEnd),
				s3 = (txtarea.value).substring(selEnd, selLength);


			if (open == "[url="){
				// append guessed protocol if not detected
				if (s2.substring(7, 4) != "://"){
					s2 = "http://" + s2;
				}
			}
			txtarea.value = s1 + open + s2 + close + s3;
			txtarea.selectionStart = selStart + (open.length + s2.length + close.length);
			txtarea.selectionEnd = txtarea.selectionStart;

			txtarea.focus();
		}

	});

});