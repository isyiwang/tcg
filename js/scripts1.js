				
						
				$(document).ready(function() {
				
							
						
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
				
								
				
				/* Scroll body to 0px on click
				------------------------------------------------------------------------------*/
				var s = $("#sticker");
				var pos = s.position();  
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
				
				/* Sticker 
				------------------------------------------------------------------------------*/					
					var windowpos = $(window).scrollTop();
					if (windowpos >= pos.top) {
						s.addClass("stick");
					} else {
						s.removeClass("stick");
					}	
					
				});
				
				$('.gotop').click(function () {
					$('body,html').animate({
						scrollTop: 0
					}, 1000);
					return false;
				});