(function($){

$(document).ready(function(){
	new etSliderAdmin();

	$("input.et-shortcode").on("click", function () {
  		$(this).select();
	});
	
});

JobEngine.Models.Slider = Backbone.Model.extend({
	initialize : function(){},
	parse : function(resp){			
		if ( resp.data ){
			return resp.data;
		}
	},
	remove : function(options){
		
		this.sync('delete', this, options);
	},
	add : function(options){
		this.sync('add', this, options);
	},

	sync	: function(method, model, options) {
		options	= options || {};
		var success	= options.success || function(resp){ };
		var beforeSend	= options.beforeSend || function(){ };
		var params		= _.extend(ajaxParams, options);
		var thisModel	= this;
		var action	= 'et_sync_attachment';

		if ( options.data ){
			params.data = options.data;
		}
		else {
			params.data = model.toJSON();
		}
		params.success = function(resp) {
			
			thisModel.set( thisModel.parse(resp) );
			switch( method ){
				case 'add':
					if( resp.success ) {
						pubsub.trigger('je:setting:sliderAdded', thisModel, resp);						
						window.location.href='admin.php?page=et-slider&action=edit&id=' + resp.data.id;
					} else {
						alert(resp.msg);
					}
					
					break;
				case 'delete':
					pubsub.trigger('je:setting:sliderRemoved', thisModel, resp);
					thisModel.trigger('remove');
					//thisModel.destroy();
					break;
				case 'update':
					if( resp.success ) {
						thisModel.trigger('updated');
						pubsub.trigger('je:setting:sliderUpdated', thisModel, resp);
					} else {
						alert(resp.msg);
					}
					break;
				default :
					pubsub.trigger('je:setting:sliderSynced', thisModel, resp);
					break;
			}
			success(resp);
		};

		params.beforeSend = function(){
			beforeSend();
		};
		//params.method	= method;
		params.data = jQuery.param( {method : method, action : action, content : params.data });

		return jQuery.ajax(params);
	}
});


var etSliderAdmin = Backbone.View.extend({
	el: '#et-slider',
	events: {		
		'submit form#add-slider': 'submitFormAddSlider',
		
		//'click .mail-template  .reset-default'	: 'resetDefaultMailTemplate',
	},
	initialize: function(){		
		var view = this;
		var appView =	this;
		this.initPaymentPlans();	
		this.loading = new JobEngine.Views.BlockUi();
		this.add_slider	= this.$('form#add-slider').validate({
				rules	: {
					title		: "required",			
				
				}
		});		
		
	},
	initPaymentPlans : function(){
		// initilize payment plans
		var planCollection = new JobEngine.Views.PaymentPlanCollection({el : 'ul.list_slider' });
	},

	submitFormAddSlider : function(event){
		if(!this.add_slider.form()) return false;		
		event.preventDefault();
		var form = $(event.target);
		var name='abc';
		var element 	= $(event.currentTarget);
		var container 	= element.parent();
		var button = form.find('.engine-submit-btn');		
	
		
		var model = new JobEngine.Models.Slider({
			title: form.find('input[name=title]').val(),
			id :null
			
		}),
			loading = new JobEngine.Views.LoadingButton({el : button});
		
		model.add({
			beforeSend : function() {
				loading.loading();
			},

			success : function( resp ){
				loading.finish();
				if(resp.success)
					form.find('input').val('');

			}
		});
		
		return false;
	}
	
});


JobEngine.Views.PaymentPlanCollection = Backbone.View.extend({
	el : 'ul#list_slider',
	initialize: function(){
		var view = this;
		view.views = [];
		view.collection = new JobEngine.Collections.Payments( JSON.parse( $('#et_slider_data').html() ) );		
		view.$el.find('li').each(function(index){
			var $this = $(this);
			view.views.push( new JobEngine.Views.SliderItem({
				model : view.collection.models[index],
				el : $this
			}) );
		});
		this.collection.bind('remove', this.removeView, this );
		this.collection.bind('add', this.addView, this );

		pubsub.on('je:setting:sliderAdded', this.addView, this);
		console.log('add finish');

	},
	add : function(model){
		this.collection.add(model);
	},
	removeView : function(model){
		alert('remove View');
		var thisView = this;
		var viewToRemove = _.filter( thisView.views, function(vi){ 
			return vi.model.get('id') == model.get('id');
		})[0];

		_.without(thisView.views, viewToRemove);

		viewToRemove.fadeOut();
	},
	addView : function(model){
		console.log(' vao addView');
		var view = new JobEngine.Views.SliderItem({model: model});
		this.views.unshift( view );

		view.render().$el.hide().prependTo( this.$el ).fadeIn();
	}
});

JobEngine.Collections.Payments = Backbone.Collection.extend({
	//model: JobEngine.Models.PaymentPlan,
	model: JobEngine.Models.Slider,
	initialize: function(){ }
});

//	=============================================
//	View Payment Edit Form
//	=============================================
JobEngine.Views.PaymentEditForm = Backbone.View.extend({
	tagName : 'div',
	events : {
		'submit form.edit-plan' : 'savePlan',
		'click .cancel-edit' : 'cancel'
	},
	template : '', //_.template( $('#template_edit_form').html() ),
	render : function(){
		
		this.$el.html( this.template( this.model.toJSON() ) );
		return this;
	},
	initialize : function(options){
		// apply template for view
		if ( $('#template_edit_form').length > 0 )
			this.template = _.template( $('#template_edit_form').html() );

		this.model.bind('update', this.closeForm, this);
		this.appear();
	},

	appear : function(){
		this.render().$el.hide().appendTo( this.options.parent ).slideDown();
	},

	savePlan : function(event){
		event.preventDefault();
		var form = this.$el.find('form');
		var view = this;
		this.model.set({
			title: form.find('input[name=title]').val(),
			
		});
		
		this.model.save(this.model.toJSON(), {
			beforeSend : function(){
				view.loading = new JobEngine.Views.LoadingButton({el : form.find('#save_resume_playment_plan') });
				view.loading.loading();
			},
			success : function(model, resp){
				view.loading.finish();
				if(resp.success)
					view.closeForm(); 

			}
		});
		
	},
	cancel : function(event){
		event.preventDefault();
		this.closeForm();
	},
	closeForm : function(){
		this.$el.slideUp( 500, function(){ $(this).remove(); });
	}
});

JobEngine.Views.SliderItem = Backbone.View.extend({
	tagName : 'li',
	className : 'item',
	events : {	
		'click a.act-del' : 'removeSlider',
		'click .act-edit-slider': 'displayInputTitle',	
		'change #title_slider' : 'autoSaveTitle',
		'blur   #title_slider'	: 'close'
	},

	initialize: function(){
		var that = this;
		//console.log(this.$el);
		this.model.bind('updated', this.render, this );
		this.model.bind('detroy', this.fadeOut, this);
		this.model.bind('remove', this.fadeOut, this);
		
	},
    	//<div class='title-hide form-item'><input type='text' name='title' id='title_slider' value = '". $attachment->post_title."'/></div>
	template : _.template("<a href='admin.php?page=et-slider&action=edit&id=<%= id %>'><span class = 'slider-title'><strong><%= title %></strong></span> </a>" +
		"<div class='title-hide form-item'><input type='text' id='title_slider' name='title' value = '<%= title %>' /> </div>" +
		'<input name="shortcode" type = "text" id="shortcode" value= "[et_slider id= <%= id %>]" class = "bg-grey-input not-empty" readonly ="readonly" /> ' +
		"<div class='actions'>" +
			"<a href='#' title='Edit' class='icon act-edit act-edit-slider' rel='id' data-icon='p'></a> " +
			"<a href='#' title='Delete' class='icon act-del' rel='id' data-icon='D'></a>" +
		"</div>"),

	render : function(){
		console.log(this.model);
		this.$el.html( this.template(this.model.toJSON()) ).attr('data', this.model.id ).attr('id', 'slider_' + this.model.id);
		return this;
	},

	blockItem : function(){
		this.blockUi = new JobEngine.Views.BlockUi();
		this.blockUi.block(this.$el);
	},

	unblockItem: function(){
		this.blockUi.unblock();
	},
	displayInputTitle : function (event){
		// $("li.item").removeClass('editing');
		// $(this.el).addClass('editing');	
    	
    	this.$el.addClass("editing");
    	this.$el.find('input').focus();
      //this.input.focus();
  

	},
	autoSaveTitle : function(event){
	
		var id = this.model.attributes.id;
		var that = this.model;

		var title = $("#slider_" + id + " #title_slider").val();		
		var params		= _.extend(ajaxParams);
		params.success = function(resp) {
			if(resp.success){
				//console.log(this);
				// this.$el.find(".slider-title").html('<strong>' + title + '</strong>');
				// this.$el.removeClass('editing');
				$("#slider_" + id).find('.slider-title').html('<strong> ' + title  +' </strong>' );
				$("#slider_" + id).removeClass('editing');				
			
			}			
		}
		params.data = jQuery.param( {action : 'et_save_slider', title : title,id : id });
		return jQuery.ajax(params);

	},
	close: function(event) {	 	
    	this.$el.removeClass('editing');
    },

	removeSlider : function(event){		
		// ask user if he really want to delete
			if ( !confirm(et_slider.confirm_delete_slider) ) return false;
		
		event.preventDefault();
		var view = this;
		// call delete request
		this.model.remove({
			beforeSend: function(){
				view.blockItem();
			},
			success: function(resp){
				view.unblockItem();
			}
		});
	},

	fadeOut : function(){
		this.$el.fadeOut(function(){ $(this).remove(); });
	}
});
// for delete a resume plan




})(jQuery);