
				var tpj=jQuery;
				//tpj.noConflict();
				
				tpj(document).ready(function() {
				
				/* Revolution Slider 
				------------------------------------------------------------------------------*/
				if (tpj.fn.cssOriginal!=undefined)
					tpj.fn.css = tpj.fn.cssOriginal;

					tpj('.fullwidthabnner').revolution(
						{	
							delay:9000,												
							startheight:500,							
							startwidth:960,
							
							hideThumbs:200,
							
							thumbWidth:100,							
							thumbHeight:50,
							thumbAmount:5,
							
							navigationType:"both",					
							navigationArrows:"verticalcentered",	
							navigationStyle:"round",				
							
							touchenabled:"on",						
							onHoverStop:"on",					
							
							navOffsetHorizontal:0,
							navOffsetVertical:20,
							
							shadow:0,							
							fullWidth:"on"						
														
					});
						
						
					/* Gallery tab
					------------------------------------------------------------------------------*/
				
						
					$('a.tabs_1').click(function(){
						$('a.tabs_1').css({'background-position':'0 0', 'color':'#fff'});
						$('a.tabs_2').css({'background-position':'-157px 0', 'color':'#454e5c'});
						$('a.tabs_3').css({'background-position':'-307px 0', 'color':'#454e5c'});					
					});
						
					$('a.tabs_2').bind("click",function(){
						$('a.tabs_1').css({'background-position':'0 -112px', 'color':'#454e5c'});
						$('a.tabs_2').css({'background-position':'-157px -56px', 'color':'#fff'});
						$('a.tabs_3').css({'background-position':'-307px 0', 'color':'#454e5c'});
					});
						
					$('a.tabs_3').click(function(){
						$('a.tabs_1').css({'background-position':'0 -112px', 'color':'#454e5c'});
						$('a.tabs_2').css({'background-position':'-157px -112px', 'color':'#454e5c'});
						$('a.tabs_3').css({'background-position':'-307px -113px', 'color':'#fff'});						
					});
					
					
					$('a.tabs_1_mob').click(function(){
						$('a.tabs_1_mob').css({'background-position':'0 0', 'color':'#fff'});
						$('a.tabs_2_mob').css({'background-position':'-106px 0', 'color':'#454e5c'});
						$('a.tabs_3_mob').css({'background-position':'-206px 0', 'color':'#454e5c'});					
					});
						
					$('a.tabs_2_mob').bind("click",function(){
						$('a.tabs_1_mob').css({'background-position':'0 -37px', 'color':'#454e5c'});
						$('a.tabs_2_mob').css({'background-position':'-106px -37px', 'color':'#fff'});
						$('a.tabs_3_mob').css({'background-position':'-206px 0', 'color':'#454e5c'});
					});
						
					$('a.tabs_3_mob').click(function(){
						$('a.tabs_1_mob').css({'background-position':'0 -37px', 'color':'#454e5c'});
						$('a.tabs_2_mob').css({'background-position':'-106px 0', 'color':'#454e5c'});
						$('a.tabs_3_mob').css({'background-position':'-206px -75px', 'color':'#fff'});						
					});
					
													
					
					$('#gallery_tabs1, #gallery_tabs2').each(function(){
						var $tabs = $(this);
						
						$tabs.find('.tab').hide().eq(0).show();
						$tabs.find('.tabs a, .tabs_mob a').on('click', function(e){
						var $self = $(this),
						idx = $self.index();
						$tabs.find('.tab').hide().eq( idx ).fadeIn();
						

						event.preventDefault();
						});
					});
							
								
						
					/* Gallery lightbox 
					------------------------------------------------------------------------------*/
					$('#gallery a.lightbox').lightBox({
						overlayOpacity: 0.8,
						imageBtnClose:'images/lightbox-btn-close.gif',
						imageBtnPrev:'images/lightbox-btn-prev.png',
						imageBtnNext:'images/lightbox-btn-next.png',
						imageLoading:'images/lightbox-ico-loading.gif',
						containerBorderSize:0,
						containerResizeSpeed:350,
						txtImage: 'Изображение',
						txtOf: 'из'
					});
						
					$('a.ico-zoom').click(function (event) {
						var evt = document.createEvent('MouseEvents');
						var $index = $('a.ico-zoom').index(this);
						evt.initMouseEvent('click', true, true, window, 1,
											0, 0, 0, 0, true, false,
											false, false, 0, null);
						$('#gallery a.lightbox')[$index].dispatchEvent(evt);
						return false; 
					});
						
					$('.mask').not('a.ico-zoom').click(function() {
						window.location.href = "gallery.htm";
					});
					
					$('.image_box .mask').click(function() {
					window.location.href = "gallery-single.htm";
					});
										
				});
				
				
				
				$(window).load(function() {
				
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
					
				
				/* FlexSlider 
				------------------------------------------------------------------------------*/	
					 $('.flexslider').flexslider({
						animation: "slide",
						start: function(slider){
						$('body').removeClass('loading');
						}
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
				
				
				/* Blog-single ul list
				------------------------------------------------------------------------------*/
				$('.response-list ul').each(function() {
					if ($(this).parent('li').children('ul').size() > 0) {
						$(this).css('border-bottom','1px solid #e8eaeb');
					}           
				});	
				
				
				/* Scroll body to 0px on click
				------------------------------------------------------------------------------*/
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