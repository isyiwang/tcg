				$(document).ready(function() {
				
					/* Gallery lightbox 
					------------------------------------------------------------------------------*/
					$('.mask').not('a.ico-zoom').click(function() {
						window.location.href = "gallery.htm";
					});
					
					$('.image_box .mask').click(function() {
					window.location.href = "gallery-single.htm";
					});
					
					
					/* Scroll body to 0px on click
					------------------------------------------------------------------------------*/
					var scrH = $(window).height();
					var scrHP = $("#gallery").height();
					$(window).scroll(function() {            
						var currentScroll = $(window).scrollTop();
						if (currentScroll >= 300) { 
							$('.gotop').css({
								display: 'block',
								position: 'fixed',
								bottom: '50',
								right: '15'
							});
						} else {                       
							$('.gotop').css({
								display: 'none'
								
							});
						}
						
						
					});
					
					$('.gotop').click(function () {
						$('body,html').animate({
							scrollTop: 0
						}, 1000);
						return false;
					});
					
					
					/* Mobile navigation 
					------------------------------------------------------------------------------*/	
					$('<div class="nav-overlay"/>').appendTo('body');
									
					$('.menu-trigger').on('click tap', function(){
						$('#menu-mobile').slideToggle('fast');
						$('.nav-overlay').fadeToggle('fast');
						return false;
					});
					
					$('.nav-overlay').on('click tap', function(){
						$('#menu-mobile').slideUp('fast');
						$('.nav-overlay').fadeOut('fast');
						return false;
					});
										
				});
				
			
				
				/* Accordion 
				------------------------------------------------------------------------------*/
				$('.accordion h6').on('click', function(e){
					var $li = $(this).closest('li');
							
					$li
						.toggleClass('exp').find('.acc-cnt').slideToggle().end()
						.siblings('.exp').removeClass('exp').find('.acc-cnt').slideUp();

						event.preventDefault();
				});
				
				
				/* Tabs 
				------------------------------------------------------------------------------*/
				$('.tabs').each(function(){
					var $tabs = $(this);
					// init the tabs
					$tabs.find('.tabs-nav a:eq(0)').addClass('active');
					$tabs.find('.tab').hide().eq(0).show();

					// actions
					$tabs.find('.tabs-nav a').on('click', function(e){
					var $self = $(this),
					idx = $self.index();

					$self.addClass('active').siblings('.active').removeClass('active');
					$tabs.find('.tab').hide().eq( idx ).fadeIn();

					event.preventDefault();
						})
				});
				
			
				
				/* Tablet combobox 
				------------------------------------------------------------------------------*/
				$('#menu_tab').change(function() {
					var url = $(this).val(); // get selected value
					if (url != '') { // require a URL
						window.location = url; // redirect
					}
					return false;
				});	