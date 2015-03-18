(function($){
$(document).ready(function(){
	new optionMail();
	// $("a.act-edit").on('click',function(){
	// 	tinyMCE.init({
	// 	        theme : "advanced",mode : "exact",
	// 	        mode : "textareas", 		    
	// 	        autoresize_min_height: 200,  
	// 			autoresize_max_height: 350,
	// 			theme_advanced_buttons1 : 'et_heading,bold,italic,|,link,unlink,bullist,numlist',
	// 			theme_advanced_buttons2 : '',
	// 			theme_advanced_buttons3 : '',
	// 			theme_advanced_statusbar_location : 'none',
	// 	        content_css : "../wp-includes/css/editor.min.css"
	// 	    }); 
	// 	tinymce.execCommand("mceAddControl", true, "et_description");
	// 	//tinymce.execCommand("mceAddControl", false, "et_description");
	// });

});

JobEngine.Models.ResumePlans = Backbone.Model.extend({
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
		//var _ajax_nonce = $("form#et_slide_form").find("input[name=et_ajaxnonce").val();
		// console.log(this.currentTarget);
		

		if ( options.data ){
			params.data = options.data;
		}
		else {
			params.data = model.toJSON();		}
		
		params.success = function(resp) {		
		thisModel.set( thisModel.parse(resp) );		
			switch( method ){
				case 'add':
					if( resp.success ) {
						thisModel.set('id',resp.data.id );
						thisModel.set('attach_url',resp.data.attach_url);
						thisModel.set( thisModel.parse(resp.data) );									
						pubsub.trigger('je:setting:SliderAdded', thisModel, resp);

						$("#slider_thumb_container span#slider_thumb_thumbnail").html('');									
						//$("textarea#description").val('');
						$("form#et_slide_form").find('#attach_id').val('');
						$("form#et_slide_form input[name=et_link]").val('http://');					
						tinyMCE.get('description').setContent('');
						$('#description').html('');
					} else {						
						alert(resp.msg);
					}					
					break;
				case 'delete':					
					pubsub.trigger('je:setting:SliderRemoved', thisModel, resp);
					thisModel.trigger('remove');
					//thisModel.destroy();
					break;
				case 'update':
					if( resp.success ) {						
						thisModel.set('attach_url',resp.data.attach_url);
						thisModel.trigger('updated');
						pubsub.trigger('je:setting:SliderUpdated', thisModel, resp);
					} else {
						alert(resp.msg);
					}
					break;
				default :
					pubsub.trigger('je:setting:SliderSynced', thisModel, resp);
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


var optionMail = Backbone.View.extend({
	el: '#et-slider',
	events: {		
		//'click .toggle-button' 					: 'onToggleFeature',
		'submit form#et_slide_form'	: 'submitFormAddPlan',
		'blur #et_link'				: 'parseUrl'	
		
	},
	initialize: function(){
		this.setupView();
		var view = this;
		var appView =	this;
		this.initSlides();	
		this.loading = new JobEngine.Views.BlockUi();
		$('.sortable').sortable({
			axis: 'y',
			handle: 'div.sort-handle'
		});
		$('ul.list-thumbnail').bind('sortupdate', function(e, ui){
			appView.updateSlideOrder();
		});
		this.add_slider	= this.$('form#et_slide_form').validate({
				rules	: {
					title		: "required",
					description : "required",
					attach_id   : "required",

					et_link : {
						// url: true,
						 required: true
					}
				
				 },
			    messages: {
			        attach_id: "Select an image.",
			    }
		});
		
	},
	initSlides : function(){
		// initilize payment plans
		var planCollection = new JobEngine.Views.SliderCollection({el : 'ul.list-thumbnail' });
	},
	
	submitFormAddPlan : function(event){
		//if(!this.add_slider.form()) return false;
		
		console.log('parse form html');
		console.log(event);
		event.preventDefault();
		
		var form = $(event.target);
		var element 	= $(event.currentTarget);
		var container 	= element.parent();
		var button = form.find('.engine-submit-btn');	
		
		var model = new JobEngine.Models.ResumePlans({
			title: form.find('input[name=title]').val(),			
			et_link: form.find('input[name=et_link]').val(),			
			description : form.find('textarea[name=description]').val(),
			// description : tinyMCE.get('description').getContent(),
			parrent : $("form#fadd").attr('data'),
			attach_id : form.find('input[name=attach_id]').val(),			
			attach_url  :'',
			et_ajaxnonce : form.find('span.et_ajaxnonce_add').attr('id'),			
		

		}),
			loading = new JobEngine.Views.LoadingButton({el : button});
		

		model.add({
			beforeSend : function() {
				loading.loading();
			},
			success : function( resp ){
				loading.finish();
				if(resp.success){
					form.find('input').val('');
					
				}
			}
		});
		
		return false;
	},
	parseUrl : function(event){
		var et_link = $("form#et_slide_form").find('#et_link');
		var url = et_link.val();
		if (url.toLowerCase().indexOf("http://") < 0 &&  url.toLowerCase().indexOf("https://") < 0 ){
			var new_url = 'http://' + url;
			et_link.val(new_url);
			et_link.focus();
		}	
		
	},

	setupView	: function(){

		// init logo upload
		var that		= this,
			$slider_thumb	= this.$('#slider_thumb_container');

		var blockUi = new JobEngine.Views.BlockUi();
		this.logo_uploader	= new JobEngine.Views.File_Uploader({
			el					: $slider_thumb,
			uploaderID			: 'slider_thumb',
			thumbsize			: 'large',
			multipart_params	: {
				_ajax_nonce	: $slider_thumb.find('.et_ajaxnonce').attr('id'),
				action		: 'et_attachment_upload'
			},
			cbUploaded		: function(up,file,res){
				if(res.success){					
					var attach_id = res.data.attach_id;					
					$slider_thumb.find("input#attach_id").val(attach_id);

					//that.job.author.set('slider_thumb',res.data,{silent:true});
				} else {
					pubsub.trigger('je:notification',{
						msg	: res.msg,
						notice_type	: 'error'
					});				
				}
			},
			beforeSend	: function(element){
				blockUi.block($slider_thumb.find('.company-thumbs'));
			},
			success : function(){
				blockUi.unblock();

			}
		});
		// edit
	},

	updateSlideOrder : function(){
		var order = $('ul.list-thumbnail').sortable('serialize');

		var params = ajaxParams;
		params.data = {
			action: 'et_sort_attachment',
			content : {
				order: order
			}
		};
		params.before = function(){	}
		params.success = function(data){
		}
		$.ajax(params);
	},
});


JobEngine.Views.SliderCollection = Backbone.View.extend({
	el : 'ul.list-thumbnail',
	initialize: function(){
		var view = this;
		view.views = [];
		view.collection = new JobEngine.Collections.Sliders( JSON.parse( $('#list_slide_data').html() ) );		
		view.$el.find('li').each(function(index){
			var $this = $(this);
			view.views.push( new JobEngine.Views.ResumeItem({
				model : view.collection.models[index],
				el : $this
			}) );
		});

		this.collection.bind('remove', this.removeView, this );
		this.collection.bind('add', this.addView, this );

		pubsub.on('je:setting:SliderAdded', this.addView, this);

	},
	add : function(model){

		this.collection.add(model);
	},
	removeView : function(model){
		
		var thisView = this;
		var viewToRemove = _.filter( thisView.views, function(vi){ 
			return vi.model.get('id') == model.get('id');
		})[0];

		_.without(thisView.views, viewToRemove);

		viewToRemove.fadeOut();
	},
	addView : function(model){

		//console.log(model);
		
		var view = new JobEngine.Views.ResumeItem({model: model});
		this.views.unshift( view );

		view.render().$el.hide().prependTo( this.$el ).fadeIn();
	}
});

JobEngine.Collections.Sliders = Backbone.Collection.extend({
	//model: JobEngine.Models.PaymentPlan,
	model: JobEngine.Models.ResumePlans,
	initialize: function(){ }
});

//	=============================================
//	View Payment Edit Form
//	=============================================
JobEngine.Views.SliderEditForm = Backbone.View.extend({
	tagName : 'div',
	events : {
		'submit form.edit-attachment' : 'saveSlide',
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
		this.add_slider	= this.$('form.edit-attachment').validate({
				rules	: {
					title		: "required",
					et_description : "required",					
					et_link : {
						url: true,
						required: true
					}
				
				},
			    messages: {
			        attach_id: "Select an image.",
			    }
		});
			
	},

	appear : function(){
		this.render().$el.hide().appendTo( this.options.parent ).slideDown();
	},
	/* for update */

	saveSlide : function(event){
		
		event.preventDefault();
		var form = this.$el.find('form');
		var view = this;

		this.model.set({
			title: form.find('input[name=title]').val(),	
			attach_id: form.find('input[name=attach_id]').val(),					
			et_link: form.find('input[name=et_link]').val(),
			description: form.find('textarea[name=description]').val()			
		});
		
		this.model.save(this.model.toJSON(), {
			beforeSend : function(){
				view.loading = new JobEngine.Views.LoadingButton({el : form.find('#save_resume_playment_plan') });
				view.loading.loading();
				

			},
			success : function(model, resp){
				console.log('resp success 0k');
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

JobEngine.Views.ResumeItem = Backbone.View.extend({
	tagName : 'li',
	className : 'item',
	events : {
		'click a.act-edit' : 'editPlans',
		'click a.act-del' : 'removeSlide',
		'click a.act-del-slider' : 'removeSlide',
		'click .slider-title': 'displayInputTitle',		
		'change #title_slider' : 'autoSaveTitle',
		'blur   #title_slider'	: 'close'
		
	},
	initialize: function(){
		//console.log(this.$el);
		this.model.bind('updated', this.render, this );
		this.model.bind('detroy', this.fadeOut, this);
		this.model.bind('remove', this.fadeOut, this);		
	},

	template : _.template("<div class='sort-handle'></div><span><%= title %></span>" +
		"<div class='actions'>" +
			"<a href='#' title='Edit' class='icon act-edit' rel='<%=id %>' data-icon='p'></a> " +
			"<a href='#' title='Delete' class='icon act-del' rel='<%= id %>' data-icon='D'></a>" +
		"</div>"),
	
	render : function(){
				
		this.$el.html( this.template(this.model.toJSON()) ).attr('data', this.model.id ).attr('id', 'slide_' + this.model.id);
		
		return this;
	},
	
	blockItem : function(){
		this.blockUi = new JobEngine.Views.BlockUi();
		this.blockUi.block(this.$el);
	},

	unblockItem: function(){
		this.blockUi.unblock();
	},

	editPlans : function(event){		
		event.preventDefault();
		//console.log(this.$el);
		var et_form = $(".et-form");
		
		if ( this.editForm && this.$el.find('.engine-payment-form').length > 0 ){ // cai nay dang mo.			
			this.editForm.closeForm(event); 
			
			
		} else if( this.$el.find('.engine-payment-form').length < 1 ){
				if($(".et-form").find(".engine-payment-form").length > 0)
					$(".et-form").find(".engine-payment-form").remove();
				this.editForm = new JobEngine.Views.SliderEditForm({ model: this.model, parent: this.$el });
		}
		// else{
		// 	console.log('vao 2');
			
		// }
		//modern
		//advanced
		//et_heading
	 	tinyMCE.init({
	        theme : "advanced",
	        mode : "textareas",
	        // plugins :"etHeading",	    
	        autoresize_min_height: 200,  
			autoresize_max_height: 350,
			theme_advanced_buttons1 : 'et_heading,bold,italic,|,link,unlink,bullist,numlist',
			theme_advanced_buttons2 : '',
			theme_advanced_buttons3 : '',
			theme_advanced_statusbar_location : 'none',
	        content_css : et_slider.url_style_tinymce,
	  //       setup  : function(ed){
			// 	ed.onChange.add(function(ed, l) {
			// 		var content	= ed.getContent();
			// 		if(ed.isDirty() || content === '' ){
			// 			ed.save();
			// 			jQuery(ed.getElement()).blur(); // trigger change event for textarea
			// 		}

			// 	});

			// 	// We set a tabindex value to the iframe instead of the initial textarea
			// 	ed.onInit.add(function() {
			// 		var editorId = ed.editorId,
			// 			textarea = jQuery('#'+editorId);
			// 		jQuery('#'+editorId+'_ifr').attr('tabindex', textarea.attr('tabindex'));
			// 		textarea.attr('tabindex', null);
			// 	});
			// }
	    });
	    //tinymce.execCommand("mceAddControl", true, "et_description");  
		//tinymce.execCommand("mceAddControl", true, "et_description");
		//tinyMCE.init({ mode: "exact", theme: "simple" });
		//tinyMCE.init({ mode: "none", theme: "simple" });
		//tinyMCE.execCommand('mceToggleEditor', false, "et_description");
       
        //tinyMCE.execCommand('mceFocus', false, 'et_description');                   
   		
   		//tinyMCE.execCommand('mceRemoveControl', false, 'et_description');
   		//tinyMCE.triggerSave();

		var $et_slider	= this.$('#et_slider_container');	

		var blockUi = new JobEngine.Views.BlockUi();
		this.logo_uploader	= new JobEngine.Views.File_Uploader({
			el					: $et_slider,
			uploaderID			: 'et_slider',
			thumbsize			: 'large',
			multipart_params	: {
				_ajax_nonce	: $et_slider.find('.et_ajaxnonce').attr('id'),
				action		: 'et_attachment_upload'
			},
			cbUploaded		: function(up,file,res){
				if(res.success){					
					var attach_id = res.data.attach_id;					
					$et_slider.find("input#attach_id").val(attach_id);
					
				} else {
					pubsub.trigger('je:notification',{
						msg	: res.msg,
						notice_type	: 'error'
					});
				
				}
			},
			beforeSend	: function(element){
				blockUi.block($et_slider.find('.company-thumbs'));
			},
			success : function(){
				blockUi.unblock();

			}
		});
	},
	removeSlide : function(event){	
		
		// ask user if he really want to delete
		if ( !confirm(et_slider.confirm_delete_slide) ) return false;
		
		event.preventDefault();
		var view = this;
		this.model.remove({
			beforeSend: function(){
				view.blockItem();
			},
			success: function(resp){							
				view.unblockItem();				

			}
		});
	},
	displayInputTitle : function (event){    	
    	this.$el.addClass("editing");
    	this.$el.find('input').focus();

	},

	autoSaveTitle : function(event){
	
		var id = this.model.attributes.id;
		var that = this.model;

		var title = $("#slider_" + id + " #title_slider").val();		
		var params		= _.extend(ajaxParams);
		params.success = function(resp) {
			if(resp.success){
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


	fadeOut : function(){
		this.$el.fadeOut(function(){ $(this).remove(); });
	}
});

})(jQuery);