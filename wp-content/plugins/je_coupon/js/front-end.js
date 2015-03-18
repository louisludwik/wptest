(function ($) {
	$(document).ready(function () {
		new JobEngine.Views.JE_Coupon();
		$('button.select_plan').click (function () {
			$('.coupon-item').hide();
			$('.coupon-item').parents('li').addClass('hidecoupon');
		});
	});
	
	JobEngine.Views.JE_Coupon = Backbone.View.extend ({
		el : '#coupon_form',
		events : {
			'click div.coupon-bar' 		: 'showCouponInput',
			'change input#coupon_code'	: 'checkCouponCode'
		},
		initialize : function (){

		},

		showCouponInput : function (e) {
			e.preventDefault();
			var job			=	JobEngine.post_job.job,
				packageID	=	job.get('job_package'),
				plans		=	JSON.parse($('#package_plans').html()),
				job_package	=	plans[packageID];

			$('.coupon-item').toggle(200);
			$('.coupon-item').parents('li').toggleClass('hidecoupon');

			if(je_coupon.currency.align == 'left') {
				$('.job-price').html ('<sup>'+je_coupon.currency.icon+'</sup>'+ job_package.price);	
			} else {
				$('.job-price').html (job_package.price + '<sup>'+je_coupon.currency.icon+'</sup>');
			}
			$('.job-price').css('text-decoration' ,'none');
			
			$('.coupon-price').html('');
			$('#coupon_code').val('');
		},

		checkCouponCode : function (e) {
			e.preventDefault();
			var $target	=	$(e.currentTarget),
				blockUi	=	new JobEngine.Views.BlockUi(),
				code	=	$target.val(),
				job			=	JobEngine.post_job.job,
				packageID	=	job.get('job_package'),
				plans		=	JSON.parse($('#package_plans').html()),
				job_package	=	plans[packageID];

			$.ajax({
				type : 'POST',
				url : et_globals.ajaxURL,
				data : { coupon_code : code, action : 'je-check-coupon-code', packageID : packageID, price : job_package.price},
				beforeSend : function () {
					blockUi.block($target);
				},
				success : function (res) {
					blockUi.unblock();
					if(res.success) { // coupon code is valid, update new price
						$target.removeClass('error');

						if(je_coupon.currency.align == 'left')
							var coupon_price	=	'<sup>'+je_coupon.currency.icon+'</sup>' + res.coupon_price;
						else 
							var coupon_price	=	res.coupon_price + '<sup>'+je_coupon.currency.icon+'</sup>';

						$('.job-price').css('text-decoration' ,'line-through');
						$('.coupon-price').html(coupon_price);

					} else { // coupon code invalid, trigger a pubsub to show user the error message
						pubsub.trigger('je:notification',{
							msg	: res.msg,
							notice_type	: 'error'
						});
						$target.addClass('error');
					}
				}
			});
		}
	});
})(jQuery);