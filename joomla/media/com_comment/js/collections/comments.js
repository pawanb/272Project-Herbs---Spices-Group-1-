define([
		'epitome/epitome-collection-sync',
		'models/comment'
	], function(Collection, Model){
	'use strict';

	return new Class({

		Extends: Collection,

		model: Model,

		options: {
			urlRoot: compojoom.ccomment.config.baseUrl+'index.php?option=com_comment&task=comments.getcomments&format=json&contentid='+compojoom.ccomment.item.contentid+'&component='+compojoom.ccomment.item.component
		},

		getParent: function(model){
			var parentId = model.get('parent_id');
			return this.findOne('#' + parentId);
		},

		postProcessor: function(json){
			if(json.info) {
				this.info = json.info;
				json = json.models;
			}
			// apply a post-processor to response
			return json;
		}
	});

});