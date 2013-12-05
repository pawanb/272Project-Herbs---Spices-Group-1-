/*global Epitome, App */
/*jshint mootools:true */
define(['epitome/epitome-model-sync'], function(ModelSync){
	'use strict';

	// define CRUD mapping.
	var methodMap = {
		'create': 'POST',
		'read': 'GET',
		'update': 'POST',
		// unsafe to call a method delete in IE7/8
		'delete_': 'GET'
	};


	return new Class({

		Extends: ModelSync,

		options: {
			defaults: {
				name: 'anonymous',
				comment: '',
				votes: 0
			},
			//urlRoot: 'data/1/comments/',
			emulateREST: false,
			useJSON: false
		},

		sync: function(method, model) {
			// internal low level api that works with the model request instance.
			var options = {};

			// determine what to call or do a read by default.
			method = method && methodMap[method] ? methodMap[method] : methodMap['read'];
			options.method = method;

			// if it's a method via POST, append passed object or use exported model
			if (method == methodMap.create || method == methodMap.update){
				options.data = model || this.toJSON();

				// pre-processor of data support
				this.preProcessor && (options.data = this.preProcessor(options.data));
			}

			options.url = this.options.url;

			// pass it all to the request
			this.request.setOptions(options);

			// call the request class' corresponding method (mootools does that).
			this.request[method](model);

			return this;
		},

		preProcessor: function(data) {
			var filteredData = {};

			Object.each(data, function(value, key) {
				filteredData['jform['+key+']'] = value;
			});

			return filteredData;
		}
	});

});