(function($){ 
	// variables
	var $win = $(window),
		$doc = $(document);

	// document on ready
	$doc.on('ready', function(){
		if($win.actual('width') > 1024){
			toggle_lists($('.sub-navigation:not(.live-links) li a'));
		}else{
			toggle_lists_hover($('.sub-navigation:not(.live-links) li a'));
		}

		blink_field();
		custom_checkbox();
		box_expand();
		fullScreen($('.full-image'), $win);
		fullScreen($('.full-image-event'), $win);
		fullScreen($('.full-image-slider-home'), $win);
		fullScreen($('.full-image-slider-person'), $win);
		show_archive_months();
		click_startup_compaines();
		startups_hover();
		main_navigation();

		click_mobile_hidden_box();

		$('.no-scroll a').on('click', function() {
			return false;
		});

		event_tab_dimensions();
	});

	// window on load
	$win.on('load', function(){
		$.each($('.box-gray-two'), function() {
			var $holder = $(this).find('.top');
			if($holder.length) {
				var $image = $(this).find('.top img');
				$(this).find('.top img').css('margin-top', ($holder.actual('height') / 2) - ($image.actual('height') /2) );
			}
		});
		vertical_center();
		slider();
		slider_persons();
		slider_home();
		//hide_loading();
		//add_data_scroll();
		scroll_top();
		setTimeout(function() {
			$('.sub-navigation').fadeIn();
		}, 400);
		centerH();
		centerV();
		page_load();
	});

	// window on scroll
	$win.on('scroll', function(){
		infinite_scroll();
		//hide_hover_on_scroll();
	});

	// window on resize
	$win.on('resize', function(){
		fullScreen($('.full-image'), $('.heading-image'));
		fullScreen($('.full-image-event'), $('.event .image'));
		fullScreen($('.full-image-slider-home'), $('#slider-home'));
		fullScreen($('.full-image-slider-person'), $('.slider-persons .top'));
		centerH();
		centerV();
	});

	// document on orientation change
	$doc.on('orientationchange', function(){
		centerH();
		centerV();
	});

	function page_load(){
		$('body').delay(800).addClass('page-load');
	}

	function infinite_scroll() {

		if($win.width() >= 767){
			if($(window).scrollTop() == 0) {
				$('#header').removeClass('scrolling');
			} else {
				if( ! $('#header').hasClass('scrolling')) {
					$('#header').addClass('scrolling');
				}
			}
		}else{
			$('#header').removeClass('scrolling');
		}

		if ($('.more-posts').length) {
			var scroll_top = $(window).scrollTop()+$(window).height();

			if (scroll_top >= $('.more-posts a').offset().top) {
				var url = $('.more-posts a').attr('href');
				$('.more-posts').remove();

				$.ajax({
					url: url,
					cache: false,
					success: function(data) {

						var items = $();

						$(data).find('.list-date').each(function() {
							items = items.add($(this).find(' > li'));
						});
						$('.list-date').append(items);
					}
				});
			};
		};
	};

	function show_archive_months() {
		$('.year-item h6 a').click(function(e) {
			e.preventDefault();
			var current_list = $(this).closest('.year-item').find('ul');
			$('.year-item ul').not(current_list).fadeOut();
			$(this).closest('.year-item').find('ul').fadeToggle();

		})
	}

	function vertical_center() {
		$.each($('.image-col-four'), function () {
			var $holder = $(this).find('span');
			if($holder.length) {
				var $image = $(this).find('span img');
				$(this).find('span img').css('margin-top', parseInt($holder.actual('height') / 2) - ($image.actual('height') / 2));
			}
		});
	}

	// functions
	function blink_field(){

		$.each($('input[type=text], textarea'), function() {
			if($(this).val() != '') {
				$(this).parents('.label-in-field, .searchform').find('label').hide();
			}
		});

		$doc.on('focusin', 'input[type=text], textarea', function() {
			if(this.title==this.value) {
				this.value = '';
				$(this).parents('.label-in-field, .searchform').find('label').hide();
			}
		}).on('focusout', 'input[type=text], textarea', function(){
			if(this.value=='') {
				this.value = this.title;
				$(this).parents('.label-in-field, .searchform').find('label').show();
			}
		});	

		$doc.on('click', '.widget_search label', function(){
			$(this).parents('.searchform').find('input[type=text]').focus();
		});
	}

	function centerH(){
		var container = '.js-center';
		var trueWidth = 0;
	
		$(container).removeAttr('style');

		$(container).each(function(){
			trueWidth = $(this).actual('width') + 10;
	
			$(this).css({
				'float': 'none',
				'width': trueWidth
			});
		});
	}
	
	function centerV(){
		var container = $('.js-middle'),
			trueValue = 0;

		container.each(function(){
			trueValue = parseInt(($(this).parent().actual('height') - $(this).actual('height')) / 2);
			$(this).css({
				'padding-top' : trueValue
			});
		});
	}
	
	function custom_checkbox(){
		$('input[type=checkbox]').jCheckboxes();
	}

	function slider(){
		var container = $('.slider');
		if(container.length){
			container.each(function(){
				$(this).find('ul.slides').not('.not-slider').carouFredSel({
					circular: true,
					infinite: true,
					auto 	: 6000,
					responsive: true,
					items : {
						visible : 1,
						height : 'variable'
					},
					scroll : {
						items : 1
					},
					prev	: {	
						button	: $(this).find('.previous'),
						key		: 'left'
					},
					next	: { 
						button	: $(this).find('.next'),
						key		: 'right'
					}
				});

			});
		}
	}

	function slider_persons(){
		var container   = $('.slider-persons'),
			scroll_view = ($win.actual('width') < 767) ? false : 6000;
		if(container.length){
				container.find('ul.slides').carouFredSel({
					circular: true,
					infinite: true,
					auto 	: scroll_view,
					responsive: true,
					items : {
						visible : 1
					},
					scroll : {
						items : 1,
						onBefore : function(data){
							$(this).trigger('currentPosition', function(pos) {
								$('.slider-persons .bottom li').removeClass('active');
								$('.slider-persons .bottom li').eq(pos).addClass('active');
							});
						}
					},
					onCreate : function(){
						$doc.on('click', '.slider-persons .bottom li a', function(){
							var true_value = $(this).parent().index();

								$(this).parents('ul').find('li').removeClass('active');
								$(this).parent().addClass('active');

								container.find('ul.slides').trigger('slideTo', true_value);


							return false;
						});
					}
				});			
		}
	}

	function slider_home(){
		var container = $('#slider-home');
		if(container.length){
			container.find('ul.slides').carouFredSel({
				circular: true,
				infinite: true,
				auto 	: 7000,
				responsive: true,
				items : {
					visible : 1
				},
				scroll : {
					items : 1,
					fx : 'crossfade'
				}
			});			
		}
	}

	function fullScreen(image, container){
		
		if($win.width() < 1600){
			var containerW =  1600;
			var containerH =  container.height() + 700;
		}else{
			var containerW =  container.width();
			var containerH =  container.height();			
		}


		var image = image,
			imageW = parseInt(image.attr('width'), 10),
			imageH = parseInt(image.attr('height'), 10),
			cRatio = containerH/containerW,
			iRatio = imageH/imageW;
		image.css({
				'width': containerW,
				'height': containerW * iRatio
			});
		/*
		if (iRatio < cRatio) {
			image.css({
				'width': containerH/iRatio,
				'height': containerH
			});
		} else {
			image.css({
				'width': containerW,
				'height': containerW * iRatio
			});
		}
		*/
		image.css({
			//'top': (containerH - image.height())/2,
			'left': (containerW - image.actual('width'))/2
		});
	}

	function hide_loading(){
		if($('body.home').length){
			$('#loading').delay(600).fadeOut(600);
		}
	}

	function box_expand(){
		$doc.on('click', '.box-expand > h6, .box-expand > h5', function(){
			$(this).parent().toggleClass('open');
			return false;
		});
	}

	function toggle_lists($selector){
		$selector.on('click', function(){
			var list_id = $(this).data('list-id');
			$(this).parent().parent().find('li').removeClass('current-menu-item');
			$(this).parent().addClass('current-menu-item');

			if($('.page-template-template-portfolio_companies-php').length){

				$list_items = $('.partner-list ul li');
				$('.partner-list ul li').removeClass('active-item');

				$list_items.each(function() {
					var rgxp = new RegExp(list_id, "g");
					if($(this).data('categories').match(rgxp)) {
						$(this).addClass('active-item');
					}
				});

			} else {
				$('.partner-list').removeClass('visible');
				$('.partner-list#' + list_id).addClass('visible');
				event_tab_dimensions();
			}

			return false;
		});
	}

	function event_tab_dimensions() {
		if($('.event-tab.visible').length) {
			$('.event-tabs-wrapper').height($('.event-tab.visible').innerHeight());
		}
	}

	function toggle_lists_hover($selector){
		$selector.on('hover', function(){
			var list_id = $(this).data('list-id');
			$(this).parent().parent().find('li').removeClass('current-menu-item');
			$(this).parent().addClass('current-menu-item');

			if($('.page-template-template-portfolio_companies-php').length){

				$list_items = $('.partner-list ul li');
				$('.partner-list ul li').removeClass('active-item');

				$list_items.each(function() {
					var rgxp = new RegExp(list_id, "g");
					if($(this).data('categories').match(rgxp)) {
						$(this).addClass('active-item');
					}
				});

			} else {
				$('.partner-list').removeClass('visible');
				$('.partner-list#' + list_id).addClass('visible');
				event_tab_dimensions();
			}

			return false;
		});
	}

	function add_data_scroll(){

		if($win.actual('width') >= 767){
			 var container_one = $('.full-image-event, .full-image-slider-person, .full-image, .full-image-slider-home'),
				 _offset_top   = 0;

			container_one.each(function( i ){
				_offset_top = parseInt(($(this).offset().top) - $win.height());
				_offset_top = (_offset_top < 0) ? 0 : _offset_top;
				$(this).attr('data-' + _offset_top, 'top: 0px');
				//$(this).attr('data-' + (parseInt(_offset_top + $win.height())), 'top: -' +  parseInt($win.height() -  $(this).parent().innerHeight()) + 'px;');
				//$(this).attr('data-' + (parseInt(_offset_top + $win.height())), 'top: -' +  parseInt($win.height() -  $(this).parent().innerHeight()) + 'px;');
			});
			/*
			var s = skrollr.init({
				forceHeight: true,
				smoothScrollingDuration : 0
			});*/
		}
	}

	function scroll_top() {
		if($('.to-top').length) {
			$('.to-top').on('click', function() {
				$('body, html').animate({
					scrollTop: $('html').offset().top
				});
				return false;
			});
		}
	}

	function main_navigation(){
		$('#navigation ul > li').hover(function() { 
			$(this).addClass('hover');
		    $(this).find('> ul').stop(true).slideDown(400);
		}, function() { 
			var _this = $(this);
		    $(this).find('> ul').stop(true).slideUp(400, function(){
		    	_this.removeClass('hover');
		    });  
		});
	}

	function click_startup_compaines(){
		$doc.on('click', '.startups-companies .holder-view > a', function(){
			if($win.actual('width') <= 767){
				return false;
			}
		});
	}

	function startups_hover(){
		if($win.actual('width') <= 767){
			$doc.on('click', '.startups-companies .holder-view > a', function(){
				$(this).parents('.startups-companies').find('.holder-view').removeClass('hover');
				$(this).parents('.holder-view').addClass('hover');
				var setoffset = $(this).offset();
				$('html,body').delay(100).animate({scrollTop:setoffset.top}, 1000);	
				return false;
			});
			$doc.on('click', '.person', function(){
				if($(this).hasClass('hover')){
					$('.person').removeClass('hover');
				}else{
					$('.person').removeClass('hover');
					$(this).addClass('hover');
				}
				var setoffset = $(this).offset();
				$('html,body').delay(100).animate({scrollTop:setoffset.top}, 1000);	
				return false;
			});
		}else{
			$('.startups-companies .holder-view, .person').hover(function(){
				$(this).addClass('hover');
			}, function(){
				$(this).removeClass('hover');
			});
		}
	}

	function click_mobile_hidden_box(){
		$('.hidden-box').hover(function(){
			if($win.width() <= 767){
				$(this).stop(true, true).fadeOut(400);
			}
		});
	}

}(jQuery));