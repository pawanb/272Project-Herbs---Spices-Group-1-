/*global Epitome, App */
/*jshint mootools:true */
define([
	'epitome/epitome-view'
], function(View){
	'use strict';

	return new Class({

		Extends: View,

		options: {
			events: {
				'click:relay(.ccomment-pagination a)': 'changePage'
			},

			itemsPerPage: 10,
			total: 100,
			maxPages: 5,
			startPage: 1,
			container: '.pagination',

			onChangePage: function(e, el){
				this.render(el.get('data-id'));
			}
		},

		initialize: function(options){
			this.parent(options);
			this.render(this.options.startPage);
		},

		render: function(start){
			var pages = Math.ceil(this.options.total / this.options.itemsPerPage),
				container = new Element('div'), i;
			start = (start) ? start.toInt() : 1;

			if (pages > 1){
				var prev = start - 1 ? start-1 : 1;
				new Element('a', {
					'html': '«',
					'data-id': prev,
					'class': start == 1 ? 'disabled' : '',
					href: '#!/ccomment-page=' + ((start == 1) ? '1' : prev)
				}).inject(container);

				if (pages <= 6){
					for (i = 1; i <= pages; i++){

						new Element('a', {
							html: i,
							href: '#!/ccomment-page=' + i,
							'data-id': i,
							'class': i == start ? 'active' : ''
						}).inject(container);
					}
				} else{
					if (start == 1 || ((start - 1) <= 3)){
						for (i = 1; i <= 5; i++){

							new Element('a', {
								html: i,
								href: '#!/ccomment-page=' + i,
								'data-id': i,
								'class': i == start ? 'active' : ''
							}).inject(container);
						}

						new Element('span', {
							html: '...'

						}).inject(container);

						new Element('a', {
							html: pages,
							href: '#!/ccomment-page=' + pages,
							'data-id': pages
						}).inject(container);

					} else if ((start - 1) > 3 && pages - start > 3){

						new Element('a', {
							html: 1,
							href: '#!/ccomment-page=1',
							'data-id': 1
						}).inject(container);

						new Element('span', {
							html: '...'
						}).inject(container);

						i = start - 2;
						var end = start + 2;


						for (i; i <= end; i++){

							new Element('a', {
								html: i,
								href: '#!/ccomment-page=' + i,
								'class': i == start ? 'active' : '',
								'data-id': i
							}).inject(container);
						}

						new Element('span', {
							html: '...'

						}).inject(container);

						new Element('a', {
							html: pages,
							href: '#!/ccomment-page=' + pages,
							'data-id': pages
						}).inject(container);

					} else{
						new Element('a', {
							html: 1,
							href: '#!/ccomment-page=' + 1,
							'data-id': 1
						}).inject(container);

						new Element('span', {
							html: '...'

						}).inject(container);

						for (i = pages - 4; i <= pages; i++){

							new Element('a', {
								html: i,
								href: '#!/ccomment-page=' + i,
								'data-id': i,
								'class': i == start ? 'active' : ''
							}).inject(container);
						}
					}

				}

				var next = (start == pages) ? start : start.toInt() + 1;
				new Element('a', {
					'html': '»',
					'data-id': next,
					'class': (start.toInt()+1 > pages) ? 'disabled' : '',
					href: '#!/ccomment-page=' + ((start.toInt()+1 > pages) ? pages : next)
				}).inject(container);
			}

			$$(this.options.container).set('html', container.get('html'));
		}
	});

});