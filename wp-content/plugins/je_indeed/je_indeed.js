(function($){
	$(document).ready(function(){
		new ET_Import();
	});
	
	ET_Import	= Backbone.View.extend({
		el : 'div#je_import',
		events : {
			'change #publisher_id'				: 'updatePublisherId',
			'click #save_settings' 				: 'updateSetting',
			'change select[name=apply_cat]' 	: 'massChangeCat',
			'change select[name=apply_type]' 	: 'massChangeType',
			'change input.setall' 				: 'massCheck',
			'submit form#import' 				: 'saveImportation',
			'mouseover #import_search_result table td.jobtitle a' : 'showCompanyInfo',
			'mouseout #import_search_result table td.jobtitle a' : 'hideCompanyInfo',
			'click .et-menu-content li a' 		: 'changeMenu',
			'click #delete_indeed' 				: 'deleteIndeed',
			'click .paginate a' 				: 'paginate',
			'click #add-indeed-schedule'		: 'openScheduleForm',
			'submit #indeed_schedule_form' 		: 'submitNewSchedule',
			'click #schedule_list td a.power' 	: 'toggleSchedule',
			'click #schedule_list td a.delete'  : 'deleteSchedule',
			//'keyup #recurrence' 				: 'keyupRecurrence',
			'change #recurrence' 				: 'changeRecurrence',
			'click .import-paginator a.page' 	: 'changeSearchPage',
			'change #indeed_options input.option'	: 'changeInputOptions',
			'click #delete_old_jobs' 			: 'deleteOldJobs'
		},

		initialize : function () {
			this.styleSelector(this.$el);
			this.blockUi = new JobEngine.Views.BlockUi();
			this.loading = false;
		},

		styleSelector : function(container){
			// apply custom look for select box
			$(container).find('.select-style select').each(function(){
				var $this = jQuery(this),
					title = $this.attr('title'),
					selectedOpt	= $this.find('option:selected');
				
				if( selectedOpt.val() !== '' ){
					title = selectedOpt.text();
				}

				$this.css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
					.after('<span class="select">' + title + '</span>')
					.change(function(){
						var val = jQuery('option:selected',this).text();
						jQuery(this).next().text(val);
					});
			});
		},

		updatePublisherId : function (e) {
			var blockUI = new JobEngine.Views.BlockUi();

			$.ajax ({
				url  : 'admin-ajax.php',
				data : {
					action : 'update-publisher-id',
					publisher_id	: $('#publisher_id').val()
				},
				type : 'post',
				beforeSend : function () {
					blockUI.block($('#publisher_id'));
				},
				success : function (response) {
					blockUI.unblock();
				}
			});
		},

		updateSetting :  function () {
			var view = this,				
				loadingButton = new JobEngine.Views.LoadingButton({el: '#save_settings'});
			
			$.ajax ({
				url  : 'admin-ajax.php',
				data : {
					action 			: 'indeed_update_settings',
					data    		: $('form#indeed_job').serialize (), 
					//publisher_id	: $('#publisher_id').val()
				},

				type : 'post',
				beforeSend : function () {
					loadingButton.loading();
				},
				success : function (response) {
					loadingButton.finish();
					
				}
			});
		},

		changeSearchPage : function(event){
			event.preventDefault();
			var target 	= $(event.currentTarget),
				page 	= parseInt(target.attr('data')),
				start 	= (parseInt(target.attr('data')) - 1) * 25,
				loading = new JobEngine.Views.LoadingButton({el: '.import-tb-container'}),
				view 	= this;

			$('form#indeed_job input[name=start]').val(start);

			var params 	= {
					url 	: et_globals.ajaxURL,
					type 	: 'post',
					data 	: {
						action 	: 'indeed-search-job',
						data    : $('form#indeed_job').serialize (), 
						publisher_id	: $('#publisher_id').val()
					},
					beforeSend : function(){
						view.blockUi.block('.import-tb-container');
					},
					success : function(response){
						view.blockUi.unblock();
						if(!response.success) {
							$('#indeed_search').parent().append('<div id="indeed_error" class="error">'+response.msg[0]+'</div>')
						} else {
							if(typeof response.data.results.result.length === 'undefined') {
								fillDataToTable( {"0" :response.data.results.result });
								$('.import-paginator').html('')
							}
							else {
								fillDataToTable(response.data.results.result);
								if (response.data.totalresults > 25){
									var html 		= view.createPaginator(page, response.data.totalresults),
										resultText 	= response.data.totalresults + ' jobs found: ';
									html = resultText + html;
									$('.import-paginator').html(html);
								}else {
									$('.import-paginator').html('')
								}
							}
							view.styleSelector($('.import-tb-container > table'));
						}
					}
				}
			$.ajax(params);
		},

		createPaginator : function(current, total){
			var arr 	= [],
				next 	= current + 1,
				prev 	= current - 1,
				totalPage = Math.ceil(total/25),
				start 	= Math.max(current - 3, 1),
				end  	= Math.min(current + 3, totalPage);

			if (current != 1) arr.push('prev');
			if (start > 1) arr.push('...');
			for(i = start; i <= end; i++){
				arr.push(i);
			}
			if (end < totalPage) arr.push('...');
			if (current < totalPage) arr.push('next');

			// build html
			var html = '';
			_.each(arr, function(ele, index){
				if (ele == 'prev')
					html += '<a class="page-prev page" href="#" data="' + prev + '">' + ele + '</a>';
				else if (ele == 'next')
					html += '<a class="page-prev page" href="#" data="' + next + '">' + ele + '</a>';
				else if (ele == '...')
					html += '<span class="page-sep">' + ele + '</span>';
				else if (current == ele)
					html += '<span class="page-current page">' + ele + '</span>';
				else 
					html += '<a class="page-prev page" href="#" data="' + ele + '">' + ele + '</a>';
			});

			return html;
		},

		changeInputOptions : function(event){
			var ele 	= $(event.currentTarget),
				data 	= {
					name : ele.attr('name'),
					value : ele.val()
				};
			if (ele.attr('type') == 'checkbox'){
				data.value = ele.is(':checked') ? 1 : 0;
			}

			var params = {
				url 	: et_globals.ajaxURL,
				type 	: 'post',
				data 	: {
					action : 'indeed-change-option',
					content : data
				},
				beforeSend : function(){
					if (ele.hasClass('delete-limit-days'))
						$('#delete_old_jobs').attr('disabled', 'disabled');
				},
				success : function(response){
					if (ele.hasClass('delete-limit-days'))
						$('#delete_old_jobs').removeAttr('disabled');
				}
			};

			$.ajax(params);
		},

		deleteOldJobs : function(event){
			event.preventDefault();
			var target = $(event.currentTarget),
				view = this,
				msg = $('<span style="margin-left: 10px">Loading...</span>');

			params = {
				url 	: et_globals.ajaxURL,
				type 	: 'post',
				data 	:  {
					action	: 'indeed-delete-old-jobs'
				},
				beforeSend: function(){
					target.attr('disabled', 'disabled');
					target.after(msg);
				},
				success : function(response){ 
					target.removeAttr('disabled');
					if (response.success){
						msg.html(response.msg);
						msg.delay(1500).fadeOut('normal', function(){ $(this).remove() });
						view.goToPage(1);
					}
				}
			}
			$.ajax(params);
		},

		massCheck : function(e){
			var isChecked 	= $(e.currentTarget).is(':checked');
			var table 		= $(e.currentTarget).parents('table');
			if ( isChecked )
				table.find('input.allow').attr('checked','checked');
			else 
				table.find('input.allow').removeAttr('checked');
		},

		massChangeCat : function(e){
			var value 			= $(e.currentTarget).val();
			var table 			= $('.import-tb-container > table');
			var affected_rows 	= _.map( table.find('tr:not(:eq(0)) input.allow:checked'), function(element){
				return $(element).closest('tr').find('select.job_cat');
			});

			_.each(affected_rows, function(data, index){
				$(data).val(value);
				$(data).trigger('change');
			});
		},

		massChangeType : function(e){
			var value 			= $(e.currentTarget).val();
			var table 			= $('.import-tb-container > table');
			var affected_rows 	= _.map( table.find('tr:not(:eq(0)) input.allow:checked'), function(element){
				return $(element).closest('tr').find('select.job_type');
			});

			_.each(affected_rows, function(data, index){
				$(data).val(value);
				$(data).trigger('change');
			});
		},

		showCompanyInfo:  function(e){
			var container = $(e.currentTarget).parent();
			var quote = container.find('.bubble-quote');
			var link = $(e.currentTarget);
			var pos = {x : link.offset().left, y: link.offset().top};
			var dim = {w : (link.width() / 2) - (quote.width() / 2), h: link.height() + 60};

			$('body').children('.bubble-quote').remove();
			quote.clone().appendTo($('body')).offset({left : pos.x + dim.w, top: pos.y - dim.h })
				.css({
					opacity: 0,
					display: 'block'
				})
				.animate({
					opacity: 1,
					top: '+=10'
			});
		},

		hideCompanyInfo : function(e){
			$('body').children('.bubble-quote').animate({
					opacity: 0,
					top: '-=10'
			}, 'normal', function(){ $(this).remove() });
		},

		saveImportation : function(e){
			e.preventDefault();
			var data = $('form#import').serialize(),
				loadingBtn = new JobEngine.Views.LoadingButton({el : $('form#import').find('button') }),
				view = this;

			var params = {
				url : je_indeed.ajax_url,
				type : 'post',
				data: data + '&action=indeed-save-imported-jobs',
				
				beforeSend: function(){
					loadingBtn.loading();
				},
				success : function(resp){
					loadingBtn.finish();
					//view.goToPage(1);
					alert(resp.msg);
				}
			}
			$.ajax(params);
		},

		changeMenu : function(event){			
			event.preventDefault();
			var target = $(event.currentTarget),
				menu = target.attr('href');
			// 
			$('.et-menu-content li a').removeClass('active');
			target.addClass('active');
			// display content
			$('.setting-content .et-main-main').hide();
			$(menu).show();
			if(menu == '#indeed-manage') {
				this.goToPage(1);
			}
		},

		deleteIndeed : function(event){
			event.preventDefault();
			// 
			if ($('#ijobs table td input:checked').length <= 0){
				return alert('Please choose as least one job');
			}

			// getting selected jobs
			var that	=	this;
			var paged = parseInt($.trim($('.indeed-controls .paginate > span.current').html()));			
			var ids = [];
			$('#ijobs table td input:checked').each(function(){
				ids.push($(this).val());
			});

			// generate ajax params
			var params = {
				url 	: je_indeed.ajax_url,
				type 	: 'post',
				data 	: {
					action : 'indeed-delete-jobs',
					content : {
						ids : ids,
						page : paged,
						page_max : $('.paginate > *').length
					}
				},
				beforeSend: function(){
					$(event.currentTarget).addClass('disable');
					that.blockImportedJobs();
				},
				success : function(resp){
					that.unblockImportedJobs();
					if (resp.success){
						// unchecked the check box
						$('#ijobs table tr th input[type=checkbox]').removeAttr('checked');
						// refresh imported job
						fillImportedData(resp.data.jobs);
						// refresh pagination
						if(paged > 1)
							that.goToPage(parseInt(paged -1));
						else 
							that.goToPage(1);
					}
				}
			};

			$.ajax(params);
		},

		paginate : function(event){
			event.preventDefault();

			var page = parseInt($.trim($(event.currentTarget).html()));
			this.goToPage(page);
		},

		goToPage : function(page){
			var view = this;
			var params = {
				url 	: je_indeed.ajax_url,
				type 	: 'post',
				data 	: {
					action : 'indeed-change-page',
					content : {
						page : page
					}
				},
				beforeSend : function(){
					view.blockImportedJobs();
				},
				success : function(resp){
					view.unblockImportedJobs();					
					if (resp.success){
						// refresh imported job
						fillImportedData(resp.data.jobs);
						// refresh pagination
						var html = '';
						if(resp.data.pages_max <= 6 && resp.data.pages_max > 0 ){
							for($i = 1; $i <= resp.data.pages_max; $i++){
								if ($i == resp.data.page)
									html += '<span class="current">' + $i + '</span>';
								else 
									html += '<a href="#">' + $i + '</a>';
							}
						} else {
							if( resp.data.page > 4 ) {
								var prev	= resp.data.page - 2;
								html += '<a href="#">1</a>';
								html += '<span>...</span>';
								if(resp.data.page < (resp.data.pages_max - 2)) {
									var last	=	parseInt(resp.data.page) +2;
								} else {
									var last	=	resp.data.pages_max;
								}								
								for($i = prev; $i <= last; $i++){
									if ($i == resp.data.page)
										html += '<span class="current">' + $i + '</span>';
									else 
										html += '<a href="#">' + $i + '</a>';
								}

							} else {
								for($i = 1; $i <= 4 + 1 ; $i++){
									if ($i == resp.data.page)
										html += '<span class="current">' + $i + '</span>';
									else 
										html += '<a href="#">' + $i + '</a>';
								}
							}

							if(resp.data.pages_max != resp.data.page &&  resp.data.pages_max > (parseInt(resp.data.page) +2) ) {
								html += '<span>...</span>';
								html += '<a href="#">' + resp.data.pages_max + '</a>';
								
							}
						}
						$('.indeed-controls .paginate').html(html);
					}
				}
			}
			return $.ajax(params)
		},

		blockImportedJobs : function(){
			this.blockUi.block($('#ijobs'));
		},
		unblockImportedJobs : function(){
			this.blockUi.unblock();
		},

		/**	Schedule **/
		openScheduleForm: function(e){
			e.preventDefault();
			$('#form-schedule').slideDown();
			$(e.currentTarget).parent().hide();
		},

		submitNewSchedule: function(e){
			e.preventDefault();
			var view = this
			// if (!view.loading) return false;

			var form 	= $(e.currentTarget),
				button 	= $('#submit_schedule'),
				data 	= form.serialize(),
				params 	= {
				url : je_indeed.ajax_url,
				type: 'post',
				data : {
					action : 'indeed-new-schedule',
					content : data
				},
				beforeSend: function(){
					view.loading = true;
					view.blockUi.block(button);
				},
				success : function(resp){
					view.loading = false;
					view.blockUi.unblock();
					if(resp.success){
						// build template and append it into table
						var template = _.template($('#schedule_row').html());
						$('#schedule_list').append($(template(resp.data.schedule)).hide().fadeIn());

						// clear form
						form.find('input[type=text]').val('');
						$('#form-schedule').slideUp();
						$('#add-indeed-schedule').parent().show();
					}else {
						alert(resp.msg);
					}
				}
			}
			$.ajax(params);
		},

		toggleSchedule: function(e){
			e.preventDefault();
			var id 		= $(e.currentTarget).attr('data-id'),
				params 	= {
					url : je_indeed.ajax_url,
					type: 'post',
					data : {
						action : 'indeed-toggle-schedule',
						content : {
							id : id
						}
					},
					beforeSend: function(){

					},
					success : function(resp){
						if(resp.success){
							var row = $(e.currentTarget).closest('tr');
							if (row.hasClass('off')) {
								row.removeClass('off');
								$(e.currentTarget).attr('title', 'Turn off this schedule');
							}
							else {
								row.addClass('off');
								$(e.currentTarget).attr('title', 'Turn on this schedule');
							}

						}else {
							alert(resp.msg);
						}
					}
				};
			$.ajax(params);
		},

		deleteSchedule: function(e){
			e.preventDefault();
			var id 		= $(e.currentTarget).attr('data-id'),
				params 	= {
					url : je_indeed.ajax_url,
					type: 'post',
					data : {
						action : 'indeed-delete-schedule',
						content : {
							id : id
						}
					},
					beforeSend: function(){

					},
					success : function(resp){
						if(resp.success){
							var row = $(e.currentTarget).closest('tr');
							row.fadeOut('normal', function(){ $(this).remove() });
						}else {
							alert(resp.msg);
						}
					}
				};
			$.ajax(params);
		},

	
		changeRecurrence : function(e){
			var recurrence = $(e.currentTarget).val();
			var blockUI = new JobEngine.Views.BlockUi();
			var	params 	= {
					url : je_indeed.ajax_url,
					type: 'post',
					data : {
						action : 'indeed-schedule-recurrence',
						content : {
							recurrence : recurrence
						}
					},
					beforeSend: function(){
						blockUI.block($(e.currentTarget));
					},
					success : function(resp){
						blockUI.unblock();
						if(resp.success){

						}else {
							alert(resp.msg);
						}
					}
				};
			$.ajax(params);
		},

		
	});

	function fillDataToTable(data){
		var table = $('#import_search_result .import-tb-container > table');

		// clear old data
		table.find('tr:not(:eq(0))').remove();
		var template = _.template($('#import_row_template').html());

		$.each(data, function(index, job){
			job.i = index;
			table.find('tbody').append(template(job));
		});
		
	}

	function fillImportedData(data){
		var table = $('#ijobs table');

		// clear old data
		table.find('tr:not(:eq(0))').remove();
		var template = _.template($('#imported_template').html());

		$.each(data, function(index, job){
			job.i = index;
			table.find('tbody').append(template(job));
		});
	}

	function on_menu_change(target){
		if ( target == 'import' ){
			view = new ET_Import ();
		}
	}
})(jQuery);