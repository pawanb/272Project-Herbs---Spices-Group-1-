/*global Epitome, App */
/*jshint mootools:true */
define([
	'epitome/epitome-view',
	'models/comment',
	'models/user',
	'mustache',
	'views/pagination',
	'views/ubbcode'
], function (View, CommentModel, userModel, Mustache, pagination, ubb) {
	'use strict';

	var OuterTemplate = document.id('comment-outer-template'),
		formTemplate = document.id('ccomment-form-template'),
		commentTemplate = document.id('ccomment-comment-template'),
		menuTemplate = document.id('ccomment-menu-template');

	return new Class({
		// main view (presenter) encapsulating the app itself.

		Extends: View,

		user: new userModel(compojoom.ccomment.user),
		config: compojoom.ccomment.config,
		item: compojoom.ccomment.item,

		options: {

			template: OuterTemplate.get('html'),

			// eavesdrop on these events
			events: {
				'click:relay(button.ccomment-send)': 'processCommentForm',
				'click:relay(button.btn-ccomment-change-state)': 'changeState',
				'focus:relay(.ccomment-textarea)': 'textarea',
				'click:relay(.ccomment-voting)': 'voting',
				'click:relay(.ccomment-posting-as)': 'userInfo',
				'click:relay(.ccomment-notify input)': 'notify',
				'input:relay(.ccomment-form)': 'input',
				'click:relay(.ccomment-cancel)': 'cancel',
				'click:relay(.ccomment-quote)': 'quote',
				'click:relay(.btn-ccomment-edit)': 'edit',
				'click:relay(.ccomment-reply)': 'reply',
				'click:relay(.ccomment-add-new)': 'addNew',
				'click:relay(.ccomment-toggle-emoticons)': 'toggleEmoticons'
			},

			onToggleEmoticons: function (e, el) {
				el.getParent('form').getElement('div.ccomment-emoticons').toggleClass('hide');
			},

			onAddNew: function () {
				var form = this.element.getElements('.ccomment-form').pop();
				new Fx.Scroll(window).toElement(form).addEvent('complete', function() {
					form.getElement('textarea').focus();
				});

			},

			onReply: function (e, el) {
				var form = el.retrieve("element");
				if (!form) {
					var id = el.getParent('li').get('data-id'),
						parent = new Element('input', {
							type: 'hidden',
							name: 'parentid',
							value: id
						});
					form = this.createForm();

					parent.inject(form);

//          add the form to the page and then store it in the element storage
//          this way the second time the user clicks on reply the form will be hidden
					form.inject(el.getParent('li').getFirst('div'), 'after');
//					new DynamicTextarea(form.getElement('.ccomment-textarea'), {
//						minRows: 2
//					});
					el.store("element", form);
				} else {
					form.toggle();
				}

				// focus on the form if it is visible
				if (form.getStyle('display') === 'block') {
					form.getElement('textarea').focus();
				}
			},

			onEdit: function (e, el) {
				var id = el.getParent('li').get('data-id'),
					model = this.collection.getModelById(id),
					user = this.user,
					form = el.getParent('li').getChildren('form')[0];

				model.setOptions({
					'url': this.config.baseUrl+'index.php?option=com_comment&task=comment.edit&format=json&id=' + id + '&' + this.getToken() + '=1&component=' + this.item.component
				});
				if (!form) {
					form = this.element.getElement('form.ccomment-form');
				} else {
					//make sure that the form is visible
					form.setStyle('display', 'block');
				}

				model.addEvent('sync', function (comment) {
					if (comment != undefined) {
						if (comment.name == '') {
							comment.name = 'COM_COMMENT_ANONYMOUS';
						}
						form['comment'].value = comment.comment;
						if (form.getElement('input[name=id]')) {
							form.getElement('input[name=id]').set('value', comment.id);
						} else {
							new Element('input', {
								'type': 'hidden',
								'value': comment.id,
								name: 'id'
							}).inject(form);
						}
					} else {
						form['comment'].value += 'failed to fetch comment';
					}
					form['comment'].focus();
					form.getElement('textarea').retrieve('dynamictextarea').checkSize(true);
				});
				model.read();

				new Fx.Scroll(window).toElement(form);
			},

			onQuote: function (e, el) {
				var id = el.getParent('li').get('data-id'),
					model = this.collection.getModelById(id),
					form = el.getParent('li').getChildren('form')[0];

				model.setOptions({
					'url': this.config.baseUrl+'index.php?option=com_comment&task=comment.quote&format=json&id=' + id
				});
				if (!form) {
					form = this.element.getElement('form.ccomment-form');
				} else {
					//make sure that the form is visible
					form.setStyle('display', 'block');
				}

				model.addEvent('sync', function (comment) {
					if (comment != undefined) {
						if (comment.name == '') {
							comment.name = 'COM_COMMENT_ANONYMOUS';
						}
						form['comment'].value += '[quote=' + comment.name + ']' + comment.comment + '[/quote]';
					} else {
						form['comment'].value += 'failed to fetch comment';
					}
					form.getElement('textarea').focus();
					form.getElement('textarea').retrieve('dynamictextarea').checkSize(true);
				});
				model.read();

				new Fx.Scroll(window).toElement(form);
			},

			onCancel: function (e, el) {
				var form = el.getParent('form'), li = form.getParent('li');
				e.stop();
				form.reset();
				form.getElement('.ccomment-form-ubb') && form.getElement('.ccomment-form-ubb').setStyle('display', 'none');
				form.getElements('div.ccomment-actions').addClass('hide');
				form.getElements('div.ccomment-user-info').addClass('hide');
				form.getElement('input[name=id]') && form.getElement('input[name=id]').destroy();
				li && li.getElement('.ccomment-reply').retrieve('element').toggle();
			},

			onInput: function (e, el) {
				// which element is used
				var name = e.target.get('name'),
					self = this;
				var options = {
					name: function () {
						var name = e.target.value;
						self.user.set('name', name);
						self.element.getElements('.ccomment-posting-as').set('html', self.user.getDefaultName());
					},
					email: function () {
						self.user.set('email', e.target.value);
						self.element.getElements('.ccomment-avatar-form').set('src', self.user.get('avatar'));
					}
				};
				// execute the action
				options[name] && options[name]();
			},

			onVoting: function (e, el) {
				var id = el.getParent('li').get('data-id'),
					vote = el.get('data-vote').toInt(),
					model = this.collection.getModelById(id),
					user = this.user,
					self = this;

				model.setOptions({
					'url': self.config.baseUrl+'index.php?option=com_comment&task=comment.vote&vote=' + vote + '&id=' + id + '&format=json&' + this.getToken() + '=1'
				});

				model.addEvent('sync', function (response) {
					model.set('votes', response.votes);
					self.collection.addModel(model);

				});
				model.save();

			},

			onNotify: function (e, el) {
				if (el.get('checked')) {
					$$('.ccomment-form div.ccomment-user-info').removeClass('hide');
				} else {
					$$('.ccomment-form div.ccomment-user-info').addClass('hide');
				}
			},

			onUserInfo: function (e, el) {
				e.stop();
				el.getParent('form').getElements('div.ccomment-user-info').toggleClass('hide');
			},

			onTextarea: function (e, el) {
				var form = el.getParent('form'),
					name = form.getElement('.ccomment-name'),
					email = form.getElement('.ccomment-email');
				if (form.getElement('.ccomment-form-ubb')) {
					if (form.getElement('.ccomment-form-ubb').getStyle('display') != 'block') {
						form.getElement('.ccomment-form-ubb').setStyles({
							'display': 'block',
							'opacity': 0
						}).fade('in');
						el.setStyles({
							'border-radius': '3px 3px 0 0'
						});
					}
				}
				form.getElements('div.ccomment-actions.hide').toggleClass('hide');
				if (typeof this.config.captcha_pub_key !== 'undefined') {
					Recaptcha.create(this.config.captcha_pub_key,
						el.getParent('form').getElement('.ccomment-recaptcha-placeholder'),
						{
							theme: "white"
						}
					);
				}

				if((!this.user.getName() && (name && name.hasClass('required'))) ||
					(!this.user.getEmail() && (email && email.hasClass('required')))
				) {
					form.getElement('.ccomment-user-info').removeClass('hide');
				}
			},

			onChangeState: function (e, el) {
				var id = el.getParent('li').get('data-id'),
					action = el.get('data-action'),
					user = this.user,
					model = this.collection.findOne('#' + id),
					self = this,
					url = self.config.baseUrl+'index.php?option=com_comment&task=comment.changestate&id=' + id + '&format=json&' + this.getToken() + '=1';

				if (action === 'delete') {
					url += '&state=-1';
				} else if (action === 'publish') {
					url += '&state=1';
				} else if (action === 'unpublish') {
					url += '&state=0';
				}

				model.setOptions({
					url: url
				});
				model.addEvent('sync', function (response) {
					if (response.status === 'success') {
						if (action === 'delete') {
							self.collection.removeModel(model);
						} else {
							model.set('published', (action === 'publish') ? 1 : 0);
							self.collection.addModel(model);
						}
						self.buildCommentsList(self.element.getElement('.ccomment-comments-list'));
					}
				});

				if (action === 'delete') {
					model && model.destroy();
				} else {
					model.create();
				}

			},

			onProcessCommentForm: function (e, el) {
				e && e.stop && e.stop();
				this.processCommentForm(el);
			},

			'onFetch:collection': function () {
				var info = this.collection.info;
				if (info.total) {
					this.buildCommentsList(this.element.getElement('.ccomment-comments-list'));
					this.createPagination(info.page, info.countParents);
				}

				if (location.hash.indexOf('#!/ccomment-comment=') === 0) {
					var comment = location.hash.replace('#!/ccomment-comment=', '');
					new Fx.Scroll(window).toElement(document.id('ccomment-' + comment));
				}
			},

			'onChange:collection': function () {
				this.buildCommentsList(this.element.getElement('.ccomment-comments-list'));
			},

			onReady: function () {
				new ubb({container: this.element});

				this.render();
			}

		},


		template: function (data, template, partial) {
// refactor this to work with any other template engine in your constructor
			template = template || this.options.template;
			return Mustache.render(template, data, partial);
		},

		render: function () {
			this.element.set('html', this.template({comment_count: this.item.count}));

			if (this.config.comments_per_page) {
				if (this.config.pagination_position == 1 || this.config.pagination_position == 2) {
					new Element('div', {
						'class': 'hide pagination pagination-mini ccomment-pagination ccomment-pagination-top'
					}).inject(this.element, 'top');
				}

				if (this.config.pagination_position == 0 || this.config.pagination_position == 2) {
					new Element('div', {
						'class': 'hide pagination pagination-mini ccomment-pagination ccomment-pagination-bottom'
					}).inject(this.element);
				}
			}

			this.createForm().inject(this.element, this.config.form_position ? 'top' : 'bottom');

			new Element('div', {
				html: this.template({comment_count: this.item.count}, menuTemplate.get('html'))
			}).inject(this.element, 'top');

			if (this.config.copyright) {
				new Element('div', {
					html: this.template({}, document.id('ccomment-footer-template').get('html'))
				}).inject(this.element);
			}

			if(location.hash.indexOf('#!/ccomment') === 0) {
				new Fx.Scroll(window).toElement(this.element);
			}

			this.parent();
		},

		createPagination: function (start, total) {
			if (this.config.comments_per_page) {
				var self = this;

				if(total > self.config.comments_per_page) {
					self.element.getElements('.pagination').removeClass('hide');
				}

				new pagination({
					container: '.ccomment-pagination',
					total: total,
					itemsPerPage: self.config.comments_per_page,
					startPage: start,
					element: self.element
				}).addEvent('changePage', function (e, el) {
						var page = el.get('data-id');
						self.collection.fetch(true, {start: page});
					});
			}
		},

		createForm: function () {
			var formValues = {
					info: compojoom.ccomment.item,
					user: this.user
				},
				form = new Element('form', {
					html: this.template(formValues, formTemplate.get('html')),
					'class': 'ccomment-form control-group ccomment-new-comment'
				});

			var textarea = form.getElement('.ccomment-textarea');
			if(textarea) {
				textarea.store('dynamictextarea',
					new DynamicTextarea(textarea)
				);
			}

			// let us add placeholder support for browsers that don't support placeholders (mainly msie < 10)
			new PlaceholderSupport(form.getElements('input[placeholder],textarea[placeholder]'));

			return form;
		},

		buildCommentsList: function (root) {
			var commentEl = document.id(root),
				comments = this.collection.toJSON(),
				self = this;

			commentEl.empty();
			comments.each(function (comment) {
				self.positionComment(comment, commentEl)
			});
		},

		positionComment: function (comment, target, position) {
			if (typeof(position) === 'undefined') position = 'bottom';
			var template = commentTemplate.get('html'),
				li = new Element('li', {
					html: this.template(comment, template),
					'class': comment['class'] + (comment.published.toInt() ? ' ccomment-published' : ' ccomment-unpublished'),
					'data-id': comment.id
				});

			// if tree is not enabled, then we don't need nested comments
			if (comment.parentid.toInt() === -1 || !this.config.tree.toInt()) {
				// root. just push
				li.inject(target, position);
			}
			else {
				// need target
				var parentLi = target.getElement('#ccomment-' + comment.parentid).getParent('li'),
					replies = parentLi.getChildren('ul.ccomment-replies')[0],
					ul = new Element('ul', {
						'class': 'ccomment-replies ccomment-children-of-' + comment.parentid
					});
				if (!replies) {
					li.inject(ul.inject(parentLi) || target);
				} else {
					li.inject(replies)
				}
			}
		},

		processCommentForm: function (el) {
			var obj = {}, self = this,
				goTo = self.element.getElement('.ccomment-comments-list'), id, user = this.user,
				errorEl = self.element.getChildren('.ccomment-form')[0].getElement('.ccomment-error-form'),
				formValidator = new Form.Validator(el.getParent('form')),
				counter = 0;

			// if the button is disabled then the last request has still not returned.
			if(el.get('disabled')) {
				return;
			}

			formValidator.addEvent('elementFail', function(element, validators){
				if(validators.contains('required')) {
					errorEl.removeClass('hide');
					errorEl.getElement('div').set('html', self.translate('COM_COMMENT_PLEASE_FILL_IN_ALL_REQUIRED_FIELDS', 'Please fill in all required fields'));
				}
			});

			if (formValidator.validate()) {
				el.set('html',el.get('data-message-disabled'));
				el.set('disabled', 'true');

				el.getParent('form').getElements('input,textarea,select').each(function (input) {
					obj[input.get('name')] = input.get('value');
				});
				obj.page = this.collection.info.page;
				// hide the error message if we had any
				errorEl.addClass('hide');
				var m = new CommentModel(obj, {
					url: self.config.baseUrl+'index.php?option=com_comment&task=comment.insert&format=json&' + this.getToken() + '=1'
				});
				id = m.get('id');
				m.addEvent('sync', function (response, method) {
					var rerender = false, position = self.config.sort ? 'top' : 'bottom';
					el.set('html',el.get('data-message-enabled'));
					el.removeProperty('disabled');

					if (response.info) {
						var info = response.info;
						self.collection.info = response.info;
						self.collection.empty();
						self.collection.setUp(response.models);
						self.buildCommentsList(self.element.getElement('.ccomment-comments-list'));
						location.hash = '#!/ccomment-page=' + info.page;
						self.createPagination(info.page, info.countParents);
						el.getParent('form').reset();
						counter = info.countParents;
					} else {
						if (response.status == 'error') {
							errorEl.getElement('div').set('html', response.message);
							errorEl.removeClass('hide');
							return;
						} else if(response.status == 'info'){
							var divEl = errorEl.getElement('div');
							divEl.set('html', response.message);
							divEl.removeClass('alert-error').addClass('alert-info');
							errorEl.removeClass('hide');

							el.getParent('form').reset();
							// if we are replying to a comment we need to close the form
							if(el.getParent('li')) {
								el.getParent('li').getElement('.ccomment-reply').click();
							}

							new Fx.Scroll(window).toElement(divEl);
							return;
						} else {
							rerender = self.collection.getModelById(response.id) ? true : false;
							self.collection.addModel(response, true);
							if (rerender) {
								self.buildCommentsList(self.element.getElement('.ccomment-comments-list'));
							} else {
								// if the collection length is 1, then we need to clear the text in the ul
								if(self.collection.length === 1) {
									self.buildCommentsList(self.element.getElement('.ccomment-comments-list'));
								} else {
									self.positionComment(response, self.element.getElement('.ccomment-comments-list'), position);
								}
							}

							self.createPagination(self.collection.info.page, self.collection.info.countParents);
							if (!response.info) {
								goTo = document.id('ccomment-' + response.id);
							}

							el.getParent('form').reset();
							// if we are replying to a comment we need to close the form
							if(el.getParent('li')) {
								el.getParent('li').getElement('.ccomment-reply').click();
							}
							counter = self.collection.info.countParents.toInt()+1;
						}
					}

					new Fx.Scroll(window).toElement(goTo);
					// update counter - all this???
					self.element.getElement('.ccomment-menu').getParent('div').set('html',
						self.template({comment_count: counter}, menuTemplate.get('html')));
				});

				m.save();
			}
		},

		getToken: function() {
			return document.id('ccomment-token').getElement('input').get('name');
		},

		translate: function(key, def) {
			return Joomla.JText._(key, def);
		}

	});
});