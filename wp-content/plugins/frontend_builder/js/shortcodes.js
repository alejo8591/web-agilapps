(function($){
	$.fn.frb_refresh = function(){
		$(this).find('.frb_accordion').each(function(){
			var collapse = true;
			var collapseInd = false;
			if($(this).attr('data-fixedheight') != 'true')
				var heightStyle = 'content';
			else
				var heightStyle = 'auto';
				
			$(this).find('h3').each(function(index){
				if($(this).hasClass('ui-state-active')) {
					collapse = false;
					collapseInd = index;
					return false;
				}
			});
			$(this).accordion({
				collapsible : collapse,
				active : collapseInd,
				heightStyle : heightStyle
			});
		});
		$(this).find('.frb_tabs').each(function(){
			var hashtag = window.location.hash;
			if(hashtag != '' && $(this).find(hashtag).length > 0) {
				$(this).find('ul a.active').removeClass('active');
				$(this).find('ul a[href='+hashtag+']').trigger('click');
			}
			else if($(this).find('ul .active').length>0) {
				$(this).find('ul a.active').removeClass('active').trigger('click');
			}
			else {
				$(this).find("ul a:first").trigger("click");
			}
		});
	  
		$(this).find('.frb-swiper-container').each(function(){
			var modid = $(this).closest('.fbuilder_module').attr('data-modid');
			var options = {
		    	pagination: '[data-modid="'+modid+'"] .frb-swiper-pagination',
		   		loop:true,
		    	grabCursor: true,
		    	paginationClickable: true,
				calculateHeight:true
			}
			if($(this).attr('data-autoplay') != '') options['autoplay'] = parseInt($(this).attr('data-autoplay'));
			if($(this).attr('data-slidesPerView') != '1') {
				options['slidesPerView'] = parseInt($(this).attr('data-slidesPerView'));
				var height = 0;
				$(this).find('.swiper-slide').each(function(){
					$(this).css('width',(100/options['slidesPerView'])+'%');
					if($(this).height() > height) height = $(this).height();
				});
				$(this).css('height', height+'px');
				options['calculateHeight'] = false;
			}
			if($(this).attr('data-mode') != 'horizontal') {
				options['mode'] = parseInt($(this).attr('data-mode'));
			}
			
			var mySwiper = new Swiper('[data-modid = "'+modid+'"] .frb-swiper-container', options);
		});
		$(this).find('a[rel="prettyphoto"]').prettyPhoto();
	 	frbScrollAnimations();
	}


	/* DOCUMENT READY */

	var parallaxTimeout;	
	$(document).ready(function(){
		$('.fbuilder_module').frb_refresh();
		if(window.location.hash != '')
			window.location.hash = window.location.hash;
		//frbParallax();
	});
	
	
	/* MODULE REFRESH */
	
	$(document).on('refresh','.fbuilder_module', function(){
		$(this).frb_refresh();
	});
	
	
	/* PORTAL SCROLL */
	/*
	var parallaxSet = false;
	function frbParallax() {
		if(typeof window.myScroll != 'undefined' && !parallaxSet) {	
			window.myScroll.on('scroll', function(){
				frbParallaxEvent();
				frbScrollAnimations();
			});	
			window.myScroll.on('scrollEnd', function(){
				frbParallaxEvent();
				frbScrollAnimations();
			});
			parallaxSet = true;
		}
		else 
		if($.fn.scrollBro != 'undefined' && !parallaxSet) {
			$('.scb_main_wrap').on('scroll', function(){
				frbScrollAnimations();
			});	
			parallaxSet = true;
		}
		else {
			parallaxTimeout = setTimeout(function(){frbParallax()},100);
		}
	}
	
	$(window).load(function(){
		if(typeof window.myScroll != 'undefined' && !parallaxSet) {	
			window.myScroll.on('scroll', function(){
				frbParallaxEvent();
				frbScrollAnimations();
			});	
			window.myScroll.on('scrollEnd', function(){
				frbParallaxEvent();
				frbScrollAnimations();
			});
			parallaxSet = true;
		}
		else 
		if($.fn.scrollBro != 'undefined' && !parallaxSet) {
			$('.scb_main_wrap').on('scroll', function(){
				frbScrollAnimations();
			});	
			parallaxSet = true;
		}
		else {
		}
		clearTimeout(parallaxTimeout);
	});*/

	$(window).scroll(function(){
		frbScrollAnimations();
	});

	function frbScrollAnimations() {
		$('.frb_animated').each(function(){
			if(!$(this).hasClass('frb_onScreen') && isScrolledIntoView(this)) {
				if(typeof $(this).attr('data-agroup') != 'undefined') {
					$('[data-agroup=' + $(this).attr('data-agroup') + ']').each(function(){
						if(typeof $(this).attr('data-adelay') != 'undefined' && parseInt($(this).attr('data-adelay')) != 0) {
							if(!$(this).hasClass('frb_onScreenDelay')) {
								$(this).addClass('frb_onScreenDelay');
								var $this = $(this);
								setTimeout(function(){
									$this.addClass('frb_onScreen');
								}, parseInt($(this).attr('data-adelay')));
							}
						}
						else {
							$(this).addClass('frb_onScreen');
						}
					});
				}
				else {	
					if(typeof $(this).attr('data-adelay') != 'undefined' && parseInt($(this).attr('data-adelay')) != 0) {
						if(!$(this).hasClass('frb_onScreenDelay')) {
							$(this).addClass('frb_onScreenDelay');
							var $this = $(this);
							setTimeout(function(){
								$this.addClass('frb_onScreen');
							}, parseInt($(this).attr('data-adelay')))
						}
					}
					else {
						$(this).addClass('frb_onScreen');
					}
					
				}
			}
			
		})
	}
	function isScrolledIntoView(elem){
		if($.fn.scrollBro != 'undefined' && $('.scb_main_wrap').length > 0) {
			var $wrap = $('.scb_main_wrap');
			var docViewTop = $wrap.scrollBro('scrollTop');
		    var docViewLimit = $(window).height()/1.7;
			
			var wrapTop = $wrap.offset().top;
		    var elemTop = $(elem).offset().top;
			
		    return ((elemTop <= docViewLimit+wrapTop) && (elemTop >= wrapTop));
		}
		else {
		    var docViewTop = $(window).scrollTop();
		    var docViewLimit = docViewTop + $(window).height()/1.7;

		    var elemTop = $(elem).offset().top;
		    var elemBottom = elemTop + $(elem).height();

		    return ((elemTop <= docViewLimit) && (elemTop >= docViewTop));
		}
	}
		
	function frbParallaxEvent(){
		$('.fbuilder_row_parallax').each(function(){
			if(typeof $(this).data('backH') == 'undefined') {
				var imageSrc = $(this).css('background-image').replace(/url\((['"])?(.*?)\1\)/gi, '$2').split(',')[0];
			    var image = new Image();
			    image.src = imageSrc;
			    $(this).data('backH', image.height);
			}
			var parallaxPos = (window.myScroll.y/($(this).data('backH') - $(window).height() ))*100 + 50;
			$(this).css('background-position', '50% '+parallaxPos+'%');
		});
	}


	/* TABS */
	
	$(document).on('click','.frb_tabs ul a', function(e){
		e.preventDefault();
		if(!$(this).hasClass('active')) {
			$(this).parent().parent().find('a').removeClass("active");
			$(this).addClass('active');
			
			var $containter = $(this).closest('.frb_tabs'),
				tabId = $(this).attr('href');
			$containter.children('.frb_tabs-content').stop(true, true).hide();
			$containter.find(tabId).fadeIn();
		}
	});

	/* BUTTONS */

	$(document).on('mouseenter','.frb_button', function(){
		var backcolor = $(this).attr('data-hoverbackcolor'); if(backcolor == '') backcolor = 'transparent';
		var textcolor = $(this).attr('data-hovertextcolor'); if(textcolor == '') textcolor = 'transparent';
		if(!$(this).hasClass('frb_nofill')) 
			$(this).stop(true).animate({backgroundColor: backcolor, color: textcolor},300);
		else
			$(this).stop(true).animate({borderColor: backcolor, color: textcolor},300);
	});
	$(document).on('mouseleave','.frb_button', function(){
		var backcolor = $(this).attr('data-backcolor'); if(backcolor == '') backcolor = 'transparent';
		var textcolor = $(this).attr('data-textcolor'); if(textcolor == '') textcolor = 'transparent';
		if(!$(this).hasClass('frb_nofill')) 
			$(this).stop(true).animate({backgroundColor: backcolor, color: textcolor},300);
		else
			$(this).stop(true).animate({borderColor: backcolor, color: textcolor},300);
	});
	
	
	/* FEATURES */
	
	$(document).on('mouseenter','.frb_features', function(){
		var backColor = $(this).attr('data-hovercolor'); if(backColor == '') backColor = 'transparent';
		var titleColor = $(this).find('.frb_features_title').attr('data-hovercolor'); if(titleColor == '') titleColor = 'transparent';
		var iconColor = $(this).find('.frb_features_icon').attr('data-hovercolor'); if(iconColor == '') iconColor = 'transparent';
		var textColor = $(this).find('.frb_features_content').attr('data-hovercolor'); if(textColor == '') textColor = 'transparent';
		
		$(this).find('.frb_features_title').stop(true).animate({color: titleColor},300);
		$(this).find('.frb_features_icon').stop(true).animate({color: iconColor},300);
		$(this).find('.frb_features_content').stop(true).animate({color: textColor},300);
		if(!$(this).hasClass('frb_features_clean')) 
			$(this).stop(true).animate({backgroundColor: backColor},300);
	});
	
	
	/* ICON MENU */
	
	$(document).on('mouseenter','.frb_iconmenu_link', function(){
		var backColor = $(this).attr('data-backhover'); if(backColor == '') backColor = 'transparent';
		var iconColor = $(this).find('i').attr('data-hovercolor'); if(iconColor == '') iconColor = 'transparent';
		$(this).find('i').stop(true).animate({color: iconColor},300);
		$(this).stop(true).animate({backgroundColor: backColor},300);
	});
	$(document).on('mouseleave','.frb_iconmenu_link', function(){
		var backColor = $(this).attr('data-backcolor'); if(backColor == '') backColor = 'transparent';
		var iconColor = $(this).find('i').attr('data-color'); if(iconColor == '') iconColor = 'transparent';
		$(this).find('i').stop(true).animate({color: iconColor},300);
		$(this).stop(true).animate({backgroundColor: backColor},300);
	});
	
	
	/* SEARCHFORM */
	
	$(document).on('focus','.frb_searchform input', function(){
		if($(this).val() == $(this).attr('data-value')) $(this).val('');
	
		$this = $(this).parent().parent().parent();
		var backColor = $this.attr('data-backfocus'); if(backColor == '') backColor = 'transparent';
		var borderColor = $this.attr('data-borderfocus'); if(borderColor == '') borderColor = 'transparent';
		var textColor = $(this).attr('data-focuscolor'); if(textColor == '') textColor = 'transparent';
		
		$this.find('i').stop(true).animate({color: textColor},300);
		$this.stop(true).animate({backgroundColor: backColor, borderColor : borderColor},300);
		$(this).stop(true).animate({color: textColor},300);
	});
	$(document).on('blur','.frb_searchform input', function(){
		if($(this).val() == '') $(this).val($(this).attr('data-value'));
		
		$this = $(this).parent().parent().parent();
		var backColor = $this.attr('data-backcolor'); if(backColor == '') backColor = 'transparent';
		var borderColor = $this.attr('data-bordercolor'); if(borderColor == '') borderColor = 'transparent';
		var textColor = $(this).attr('data-color'); if(textColor == '') textColor = 'transparent';
		
		$this.find('i').stop(true).animate({color: textColor},300);
		$this.stop(true).animate({backgroundColor: backColor, borderColor : borderColor},300);
		$(this).stop(true).animate({color: textColor},300);
	});
	$(document).on('click', '.frb_searchform .frb_searchright', function(){
		var $input = $(this).parent().find('input');
		if($input.val() != $input.attr('data-value') && $input.val() != ''){
			$(this).parent().submit();
		}
		
	});
	
	
	/* IMAGE */
	
	$(document).on('mouseenter','.frb_image a', function(){
		$(this).find('.frb_image_hover').stop(true).animate({opacity:0.4},300);
		$(this).find('i.fawesome').stop(true).animate({opacity:1},300);
		$this = $(this).parent();
		
		var borderColor = $this.attr('data-borderhover'); if(borderColor == '') borderColor = 'transparent';
		$this.stop(true).animate({borderColor:borderColor},300);
		
		if($this.find('.frb_image_desc').length >0) {
			var backColor = $this.find('.frb_image_desc').attr('data-backhover'); if(backColor == '') backColor = 'transparent';
			var descColor = $this.find('.frb_image_desc').attr('data-hovercolor'); if(descColor == '') descColor = 'transparent';
			$this.find('.frb_image_desc').stop(true).animate({backgroundColor:backColor, color:descColor},300);
		}
		
	});
	$(document).on('mouseleave','.frb_image a', function(){
		$(this).find('.frb_image_hover, i.fawesome').stop(true).animate({opacity:0},300);
		var borderColor = $this.attr('data-bordercolor'); if(borderColor == '') borderColor = 'transparent';
		$this.stop(true).animate({borderColor:borderColor},300);
		
		if($this.find('.frb_image_desc').length >0) {
			var descColor = $this.find('.frb_image_desc').attr('data-color'); if(descColor == '') descColor = 'transparent';
			var backColor = $this.find('.frb_image_desc').attr('data-backcolor'); if(backColor == '') backColor = 'transparent';
			$this.find('.frb_image_desc').stop(true).animate({backgroundColor:backColor,color:descColor},300);
		}
	});
	
	
	/* NAV MENU */
	
	$(document).on('mouseenter','.frb_menu li', function(){
		var $mainlist = $(this);
		var submenu = false;
		while(!$mainlist.hasClass('frb_menu')) {
			if($mainlist.hasClass('sub-menu')) submenu = true;
			$mainlist = $mainlist.parent();
		}
		var textColor = $mainlist.attr('data-textcolor'); if(textColor == '') textColor = 'transparent';
		var subTextColor = $mainlist.attr('data-subtextcolor'); if(subTextColor == '') subTextColor = 'transparent';
		var hoverColor = $mainlist.attr('data-hovercolor'); if(hoverColor == '') hoverColor = 'transparent';
		var hoverTextColor = $mainlist.attr('data-hovertextcolor'); if(hoverTextColor == '') hoverTextColor = 'transparent';
			
		if($mainlist.hasClass('frb_menu_horizontal-clean') || $mainlist.hasClass('frb_menu_horizontal-squared') || $mainlist.hasClass('frb_menu_horizontal-rounded')) {	
			if(submenu) $(this).children('a').stop(true).animate({color : hoverColor}, 300);
			else $(this).children('a').stop(true).animate({color : hoverTextColor, backgroundColor: hoverColor}, 300);
			
			if($(this).children('ul').length > 0) {
				$(this).children('ul').stop(true).show().animate({marginTop:'10px', opacity:1}, 300);
			}
		}
		else if($mainlist.hasClass('frb_menu_vertical-clean') || $mainlist.hasClass('frb_menu_vertical-squared') || $mainlist.hasClass('frb_menu_vertical-rounded')) {
			if(submenu) {
				$(this).children('a').stop(true).animate({color : textColor}, 300);
			}
			else {
				$(this).stop(true).animate({backgroundColor: hoverColor}, 300);
				$(this).children('a').stop(true).animate({color : hoverTextColor}, 300);
				$(this).find('ul a').stop(true).animate({color : hoverTextColor}, 300);
			}
		}
		else {
			$(this).children('a').stop(true).animate({color : hoverTextColor, backgroundColor: hoverColor}, 300);
		}
	});
	$(document).on('mouseleave','.frb_menu li', function(){
		var $mainlist = $(this);
		var submenu = false;
		while(!$mainlist.hasClass('frb_menu')) {
			if($mainlist.hasClass('sub-menu')) submenu = true;
			$mainlist = $mainlist.parent();
		}
		var textColor = $mainlist.attr('data-textcolor'); if(textColor == '') textColor = 'transparent';
		var subTextColor = $mainlist.attr('data-subtextcolor'); if(subTextColor == '') subTextColor = 'transparent';
		var hoverColor = $mainlist.attr('data-hovercolor'); if(hoverColor == '') hoverColor = 'transparent';
		var hoverTextColor = $mainlist.attr('data-hovertextcolor'); if(hoverTextColor == '') hoverTextColor = 'transparent';
		
		if($mainlist.hasClass('frb_menu_horizontal-clean') || $mainlist.hasClass('frb_menu_horizontal-squared') || $mainlist.hasClass('frb_menu_horizontal-rounded')) {	
			if(submenu) $(this).children('a').stop(true).animate({color : subTextColor}, 300);
			else $(this).children('a').stop(true).animate({color : textColor, backgroundColor: 'transparent'}, 300);
			
			if($(this).children('ul').length > 0) {
				$(this).children('ul').stop(true).animate({marginTop:'0px', opacity:0}, 300, function(){ $(this).hide(); });
			}
		}
		else if($mainlist.hasClass('frb_menu_vertical-clean') || $mainlist.hasClass('frb_menu_vertical-squared') || $mainlist.hasClass('frb_menu_vertical-rounded')) {
			if(submenu) {
				$(this).children('a').stop(true).animate({color : hoverTextColor}, 300);
			}
			else {
				$(this).stop(true).animate({backgroundColor: 'transparent'}, 300);
				$(this).find('a').stop(true).animate({color : subTextColor}, 300);
			}
		}
		else {
			$(this).children('a').stop(true).animate({color : subTextColor, backgroundColor: 'transparent'}, 300);
		}
	});
	
	$(document).on('click','.frb_menu_container[class*="dropdown"] .frb_menu_header', function(){
		if(!$(this).hasClass('active')) {
			$(this).addClass('active');
			$(this).parent().find('ul.frb_menu').stop(true).show().animate({marginTop:'10px', opacity:1}, 300);
		}
		else {
			$(this).removeClass('active');
			$(this).parent().find('ul.frb_menu').stop(true).animate({marginTop:'0px', opacity:0}, 300, function(){ $(this).hide(); });
		}
	});
	
	
	/* PRICING TABLE */
	
	$(document).on('click','.frb_pricing_controls a', function(e){
		e.preventDefault();
		var $cont = $(this).closest('.frb_pricing_container');
		var $ctrl = $(this).closest('.frb_pricing_controls');
		if(typeof $cont.data('slide') == 'undefined') $cont.data('slide',0);
		if($(this).hasClass('frb_pricing_left') && $cont.data('slide') !=0 ) {
			$cont.data('slide',$cont.data('slide')-1);
			$cont.find('table').stop(true).animate({'margin-left':(-$cont.data('slide')*100)+'%'},300);
		}
		else if($(this).hasClass('frb_pricing_right') && $cont.data('slide') != parseInt($cont.attr('data-colnum'))-1 ) {
			$cont.data('slide',$cont.data('slide')+1);
			$cont.find('table').stop(true).animate({'margin-left':(-$cont.data('slide')*100)+'%'},300);
		}
	});
	$(window).resize(function(){
		$('.frb_pricing_container').data('slide',0).find('table').css('margin-left',0);
	});
	
	
	
})(jQuery);