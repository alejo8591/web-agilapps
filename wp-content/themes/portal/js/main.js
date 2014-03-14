(function($){
	
var fonturl = portal.fonturl;
var logoUrlVar = portal.logourl;

				
var asideWrpLiImg = $('.aside_image .portal_aside_image_wrapper li img'),
	asideWrpLiVideo = $('.aside_image .portal_aside_image_wrapper li video'),
	headerChildNum,	$footerRefElement, slicedHoverEnable = 0, elOffset = new Array(), nextElOffset = new Array(), focusElHeight = new Array(), headerResFlag = false, headerRespTimeout, headMaxWidth, endVal, infoWallItems = new Array(), cont, $scrlThis = 0, focusedElIndexOld = 0;
	
	
	
$(document).ready(function(){
	
	if ('ontouchstart' in window) {
		$('body').addClass('touch-device');
	}
	
	if($('.portal_parallax_image_wrapper video').length > 0 && ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i)))) {
		$('.portal_parallax_image_wrapper').append('<img alt="" />').find('img').attr('src', $('.portal_parallax_image_wrapper video').attr('data-image-replacement')).parent().find('video').remove();
	}
	
	 $('html').height($(window).height()-parseInt($('html').css('margin-top')));
	
	$('<div class="footer_placeholder"></div><div class="footer_placeholder2"></div>').insertAfter('.footer_outer_wrapper');
	if (!$('.header_wrapper').hasClass('hpintr')){
		$('<div class="header_placeholder"></div>').insertAfter('.header_wrapper');	
	}

//		scroll

					
		$('#wrapper').scrollBro(); 
	
	
	
	if ($(window).width() <= 979) {
		$('.footer_outer_wrapper').css({'position' : 'static', 'bottom' : 'auto', 'left' : 'auto'});
		$('.footer_placeholder').css({'height' : 0});
	}else {
		$('.footer_outer_wrapper').css({'position' : 'fixed', 'bottom' : 0, 'left' : 0});
		$('.footer_placeholder').css({'height' : $('.footer_outer_wrapper').height()});
	}
	 $('#wrapper').scrollBro('refresh');
	
	

	// 		portfolio
	$(document).on('mouseenter', '.sliced_preview_container .swiper-slide', function(){
		if (slicedHoverEnable == 1) {
			$(this).find('.sliced_preview_image').stop(true).animate({opacity :1}, 300);
		}
	});
	
	$(document).on('mouseleave', '.sliced_preview_container .swiper-slide', function(){
		if (slicedHoverEnable == 1) {
			$(this).find('.sliced_preview_image').stop(true).animate({opacity :0.8}, 200);
		}
	});
	
//			chapters
	chaptersInit();
	
	$('.chapters_sub li a').each(function() {
		$(this).attr({'data-offset': $(this.hash).offset().top + $('#wrapper').scrollBro('scrollTop')});
	});
	
	var chControl = 0;
	$('.chapters_headline_wrapper').css('width', 43);
	
	$('.chapters_wrapper').hover(function(){
		if (chControl==0){
		chaptersOpen();
		}
	}, function(){
		if (chControl==0){
		chaptersClose();
		}
	});
	
	$('.chapters_sub li a').eq(0).addClass('focused bg_color_main');
	
	$('.chapters_sub li a').click(function(e){
		e.preventDefault();
		if($('.blog_header_overlay_parallax').length > 0){		
			anchorToTarget($(this), 100, 500);	
		} else {	
			anchorToTarget($(this), 100, 500);			
		}

		$('.chapters_trigger').trigger('click');
		
		
	});
	
	$('.chapters_headline').click(function(){
		$('.chapters_trigger').trigger('click');
	});
	
	$('.chapters_trigger').click(function(e){
		$('.chapters_sub').css({ width : $('.chapters_headline').outerWidth(true)+ $('.chapters_trigger').outerWidth(true) + 10});
		e.preventDefault();
		if (chControl==0){
			$('.chapters_sub').stop(true).slideDown(150);
			chControl++;
			$(this).addClass('bg_color_main');
		} else {
			$('.chapters_sub').stop(true, true).slideUp(150);
			chControl--;
			$(this).removeClass('bg_color_main');
		}
	});
	
	$('.comments_bubble').click(function(e){
		e.preventDefault();
		anchorToTarget($(this), 100, 1000);	
	});
		
	if(window.location.hash != '' && window.location.hash != undefined){
		anchorToTarget(window.location, 100, 500, true);
	}
	
//		header nav

$('.header_menu ul.sub-menu, .header_menu_default ul.sub-menu').each(function(){
		$(this).addClass('header_submenu');
	});
	if($('.header_menu').length > 0) {
		$('.header_menu > li').addClass('header_separator_color').children('a').addClass('color_default bg_color_main_hover');
		$('.header_menu > li > a').wrapInner('<span class="header_item_wrap" />').append('<span class="line bg_color_default"></span>');
		$('.header_menu > li li > a').addClass('bg_color_main_hover color_white');

		$('.header_menu').prepend('<li class="header_separator_color"><a class="color_default bg_color_main_hover logo_holder" href="'+portal.url+'"><span class="header_item_wrap"><img src="'+logoUrlVar+'" class="logo block" /></span></a></li>');
		
		$('.header_menu .logo_holder').attr({'href' : $('.logo_wrapper').attr('href')}).find('.logo').attr({'src':$('.logo_wrapper img').attr('src')});
		$('.logo_wrapper').remove();
		$('.header_menu').append('<li class="clear"></li>');
	}
	
	if($('.header_menu_default').length > 0) {
		$('.header_menu_default > li a').addClass('color_default color_main_hover');
		$('.logo_wrapper').wrap('<div />').parent().wrap('<div />').parent().wrap('<div class="centering_system" />').parent().css({'height' : 61, 'float' : 'left'});
	}
	
	if ($('.header_submenu.large-variant').length > 0){
		var headerLargest = 0;
		$('.header_submenu.large-variant').each(function(){
			$(this).children('li').each(function(){
				var headerItemHeight = $(this).height();
				$(this).attr('data-height', headerItemHeight);
				if(headerLargest < headerItemHeight) {
					headerLargest = headerItemHeight;
				}	
			});	
			$(this).children('li').each(function(){
				$(this).css('height', headerLargest);
			});
			$(this).hide();
			var headerCalcWidth  = $('.header_submenu.large-variant > li').length*220 + 40;
			if(headerCalcWidth > 900) {
				headerCalcWidth = 900;
			}
			$(this).css({'width' : headerCalcWidth});
		});
	}
	
	if($('.header_menu_default').length > 0) {
		headMaxWidth = 992;
		if ($('.header_menu_default').width() + 250 > 992){
			headMaxWidth = $('.header_menu_default').width() + 250;
		}
	}
	
	if ($('.responsive_menu_button').length < 1) {
		$('.header_wrapper').prepend('<div class="responsive_menu_button bg_color_main"><img src="'+logoUrlVar+'" alt="" class="logo" /><img src="'+portal.directory+'/images/res_menu_icon.png" alt="Menu" class="menu_icon" /></div>');
		$('.responsive_menu_button .logo').wrap('<div class="logo_wrap" />').parent().wrap('<div />').parent().wrap('<div />').parent().wrap('<div class="centering_system" />').parent().css({'height' : 40, 'float' : 'left'});
	}
	
	if($('.header_menu').length > 0) {

		headerChildNum = $(".header_menu").children().not(".clear").length;	
		var headMaxTextCount = 0;
		var headMinTextWidth = $('.header_item_wrap:first').width();
		while ($(".header_menu > *").length > headMaxTextCount) {		
			headMaxTextWidth = Math.max(headMinTextWidth, $('.header_item_wrap').eq(headMaxTextCount).width());
			headMaxTextCount++;
		}
		headMaxWidth = (headMaxTextWidth+42)*headerChildNum;	
	}
	
	if($(window).width() < headMaxWidth) {
		headerResFlag = true;
	} else {
		headerResFlag = false;
	}
	
	if($(window).width() < 767*window.devicePixelRatio) {
		headerResFlag = true;
	}
	
	if (!$('.header_wrapper').hasClass('hpintr')){
		$('.header_wrapper').addClass('hpintr');
	}
	
	headerResponsive();

	$('.header_menu > li:not(.logo_holder):not(.clear)').each(function(ind){
		if($('.header_menu > li:not(.logo_holder):not(.clear)').length == ind+1) {
			$(this).find('.header_submenu > li .header_submenu').css({'left': '-100%'});
		}
		if($(this).find('.header_submenu > li > .header_submenu > li > .header_submenu').length > 0 && $('.header_menu > li:not(.logo_holder):not(.clear)').length-1 == ind+1) {
			$(this).find('.header_submenu > li .header_submenu').css({'left': '-100%'});
		}
	});
	
	$('.header_menu > li').hover(function(){
			if (!$('.header_menu').hasClass('header_responsive')){
				if(!$(this).children('a').hasClass('logo_holder')){
					$(this).children('a').stop(true).animate({height : 101, 'margin-bottom' : '-40px'},150);
					$(this).children('a').find('.line').stop(true).animate({'margin-top':50},150);
					$(this).children('.header_submenu').stop(true,true).delay(100).slideDown(150);	
					$(this).addClass('hovered');
				}
			}
	}, function(){
		if (!$('.header_menu').hasClass('header_responsive')){
			if(!$(this).children('a').hasClass('logo_holder')){		
				$(this).children('a').stop(true).animate({height : 61, 'margin-bottom' : '0px'},150);
				$(this).children('a').find('.line').stop(true).animate({'margin-top':10},150);	
				$(this).children('.header_submenu').stop(true).slideUp(150);	
				$(this).removeClass('hovered');
			}
		}	
	});
	
	$('.header_menu_default > li').hover(function(){
			if (!$('.header_menu_default').hasClass('header_responsive')){
				$(this).children('.header_submenu').stop(true,true).slideDown(150);	
				$(this).addClass('hovered');
			}
	}, function(){
		if (!$('.header_menu_default').hasClass('header_responsive')){
				$(this).children('.header_submenu').stop(true).slideUp(150);	
				$(this).removeClass('hovered');
			}
			
	});
	
	$('.header_submenu:not(.navmenu_fullwidth) > li').hover(function(){
		if (!$('.header_menu').hasClass('header_responsive') && !$('.header_menu_default').hasClass('header_responsive') && $(this).parents('.large-variant').length <= 0){
			if($(this).children('.header_submenu').length >0) {
				$(this).addClass('hovered').children('.header_submenu').stop(true,true).slideDown(150);
			}
		}
	}, function(){
		if (!$('.header_menu').hasClass('header_responsive') && !$('.header_menu_default').hasClass('header_responsive') && $(this).parents('.large-variant').length <= 0){
			if($(this).children('.header_submenu').length >0) {
				$(this).removeClass('hovered').children('.header_submenu').stop(true).slideUp(150);
			}
		}
	});
	
	$(document).on('click', '.responsive_menu_button', function(){
		if(!$(this).hasClass('clicked')){
			TweenLite.to($(".header_menu_wrapper")[0], 0.3, {'height' : $(window).height()-50});
			$('#wrapper').scrollBro('disable');	
			$(this).addClass('clicked');
		} else {
			TweenLite.to($(".header_menu_wrapper")[0], 0.3, {'height' : 0});
			$('#wrapper').scrollBro('enable');
			$(this).removeClass('clicked');
		}
	});
	
	$('.header_search_form').hover(function(){
		$(this).data('hover', 'on');
	}, function(){
		$(this).data('hover', 'off');
	}); 
	
	$('.search_submit').click(function(e){
		e.preventDefault();
		if($(this).hasClass('form_closed')) {
			$(this).removeClass('form_closed');
			$(this).closest('.header_search_form').stop(true).animate({'width' : parseInt($(this).closest('.header_search_form').attr('data-width'))}, 200);
		} else {
			if($(this).parent().children('input:first').val() != '')
				$(this).parent().submit();
		}
	});
	
	$('body').click(function(){
		if($('.header_search_form').length > 0){
			if(!$('.header_search_form').find('.search_submit').hasClass('form_closed') && $('.header_search_form').data('hover') == 'off' && headerResFlag){
				$('.header_search_form').find('.search_submit').addClass('form_closed');
				$('.header_search_form').stop(true).animate({'width' : 40}, 200);
			}
		}
	});
	
	$('.header_wrapper').load(fonturl, function(){
		if(!headerResFlag){
			if($('.header_menu_default').length > 0) {
				headMaxWidth = 992;
				if ($('.header_menu_default').width() + 250 > 992){
					headMaxWidth = $('.header_menu_default').width() + 250;
				}
			}
		
			if($('.header_menu').length > 0) {

				headerChildNum = $(".header_menu").children().not(".clear").length;	
				var headMaxTextCount = 0;
				var headMinTextWidth = $('.header_item_wrap:first').width();
				while ($(".header_menu > *").length > headMaxTextCount) {		
					headMaxTextWidth = Math.max(headMinTextWidth, $('.header_item_wrap').eq(headMaxTextCount).width());
					headMaxTextCount++;
				}
				headMaxWidth = (headMaxTextWidth+42)*headerChildNum;	
			}
			if($(window).width() < headMaxWidth) {
			headerResFlag = true;
			} else {
				headerResFlag = false;
			}
			headerResponsive();
		}
	});
	
	if ($('.portal_parallax_image_wrapper').length > 0 && $('.portal_parallax_image_wrapper').height()-$('.header_placeholder').height() > $(window).height()) {
		$('.portal_parallax_image_wrapper').height($(window).height() - $('.header_placeholder').height()+2);
	}
	
	$('.parallax_placeholder').css('height', $('.portal_parallax_image_wrapper').height());
	$('.parallax_placeholder').attr({'data-default' : $('.parallax_placeholder').height()});
	
	$('.page_preload_placeholder').hide();

	
	$('.share').hover(function(){
		if($(window).width() > 767*window.devicePixelRatio) {
			$(this).find('.social-buttons').stop(true,true).slideDown(200);
		}
		$(this).find('.portal_button').addClass('bg_color_main');
	}, function(){
		if($(window).width() > 767*window.devicePixelRatio) {
			$(this).find('.social-buttons').stop(true).slideUp(200);
		}
		$(this).find('.portal_button').removeClass('bg_color_main');
	});
	
	$('.share > a').click(function(e){
		e.preventDefault();
		if($(window).width() <= 767*window.devicePixelRatio) {
			if(!$(this).hasClass('opened')) {
				$(this).addClass('opened');
				$(this).parent().find('.social-buttons').stop(true,true).slideDown(200);
			} else {
				$(this).removeClass('opened');
				$(this).parent().find('.social-buttons').stop(true).slideUp(200);
			}
		}
	});

	$('input.input_field').focus(function(){
		if (!$(this).hasClass('collected')) {
			$(this).attr('data-val', $(this).val());
			$(this).addClass('collected');
			$(this).val('');
		} else {
			if ($(this).val() == $(this).attr('data-val')) {
			$(this).val('');
			}
		}
	});
	$('input.input_field').focusout(function(){
		if ($(this).val() == '') {
			$(this).val($(this).attr('data-val'));
		}
	
	});

 	$('textarea.textarea_field').focus(function(){
		if (!$(this).hasClass('collected')) {
			$(this).attr('data-val', $(this).html());
			$(this).addClass('collected');
			$(this).html('');
		} else {
			if ($(this).html() == $(this).attr('data-val')) {
				$(this).html('');
			}
		}
	});
	$('textarea.textarea_field').focusout(function() {
		if ($(this).html() == '') {
			$(this).html($(this).attr('data-val'));
			}	
	});

	$('.comment_form:not(.contact_form)').each(function(){
		if($(this).outerWidth()< 800){
			$(this).find('input[type="text"].input_field').css({'width' : '100%', 'margin-left' : 0, 'margin-right' : 0});
		}else {
			$(this).find('input[type="text"].input_field').css({'width' : '32%'}).eq(1).css({'margin-left' : '2%', 'margin-right' : '2%'});
		}
	});

	$('.info_wall_init_wrapper').each(function(){
		infoWallSorter($(this));
	});
	
	$('.info_wall_wrapper').each(function(){
		if(navigator.userAgent.indexOf("MSIE")<0){
			$(this).find('.info_wall_item .img_wrap img').load(function(){
				var topVal;
				if (($(this).closest('.img_wrap').height()-$(this).height())/2 < 0){
					topVal = ($(this).closest('.img_wrap').height()-$(this).height())/2
					} else{
					topVal = 0;
					}
					
				if (($(this).closest('.img_wrap').width()-$(this).width())/2 < 0){
					leftVal = ($(this).closest('.img_wrap').width()-$(this).width())/2
				} else{
					leftVal = 0;
				}
					
				$(this).css({'top' : topVal, 'left' : leftVal}).animate({opacity : 1},400);
			});
		}
		
		$(this).find('.info_wall_item').each(function(){
			$(this).find('.text_wrap').append('<div class="hover_arrow"></div>');
		});
	});
	
	$('.stars_wrapper').each(function(){
		var score = parseInt($(this).attr('data-score'));
		if (score > 5){score = 5;}
		if (score < 0){score = 0;}
		$(this).append('<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>');
		$(this).children('i').each(function(ind){
			if (ind < score){
				$(this).addClass('rated'); 
			} else {
				return false;
			}
		});
	});
	
	$(document).on('mouseenter', '.info_wall_wrapper.shop_wall .info_wall_item', function(){
		$(this).find('.img_wrap .shop_cart').stop(true).animate({opacity:1},300);
	});
	
	$(document).on('mouseleave', '.info_wall_wrapper.shop_wall .info_wall_item', function(){
		$(this).find('.img_wrap .shop_cart').stop(true).animate({opacity:0},300);
	});
	
	$(document).on('mouseenter', '.info_wall_item', function(){
	$(this).addClass('hovered');
	if (!$(this).hasClass('reverse')){
		$(this).find('.hover_arrow').stop(true).animate({left:-15}, 300);
	} else {
		$(this).find('.hover_arrow').stop(true).animate({right:-15}, 300);
	}
	});

	$(document).on('mouseleave', '.info_wall_item', function(){
		$(this).removeClass('hovered');	
		if (!$(this).hasClass('reverse')){
			$(this).find('.hover_arrow').stop(true).animate({left:0}, 300);
		} else {
			$(this).find('.hover_arrow').stop(true).animate({right:0}, 300);
		}
	});
	
	$(document).on('mouseenter', '.sliced_preview_container .sliced_single_item', function(){
		if(!$('body').hasClass('touch-device')) {
			portfolioPageContentAnimate($(this));
		}
	});
	
	$(document).on('mouseenter', '.swiper_layer_hover .swiper-slide', function(){
		if(!$('body').hasClass('touch-device')) {
			portfolioPageContentAnimate($(this));
		}
	});
	
	$(document).on('mouseleave', '.sliced_preview_container .sliced_single_item', function(){
		if(!$('body').hasClass('touch-device')) {
			portfolioPageContentReset($(this));
		}
	});
	
	$(document).on('mouseleave', '.swiper_layer_hover .swiper-slide', function(){
		if(!$('body').hasClass('touch-device')) {
			portfolioPageContentReset($(this));
		}
	});
	
	$(document).on('click', '.sliced_preview_container .sliced_single_item', function(e){
//		e.preventDefault();
		if($('body').hasClass('touch-device')) {
			if(!$(this).hasClass('clicked')) {
				e.preventDefault();
				portfolioPageContentAnimate($(this));
				$(this).addClass('clicked');
			} else {
				portfolioPageContentReset($(this));
				$(this).removeClass('clicked');
			}
		}
	});
	
	$(document).on('click', '.swiper_layer_hover .swiper-slide', function(e){
//		e.preventDefault();
		if($('body').hasClass('touch-device')) {
			if(!$(this).hasClass('clicked')) {
				e.preventDefault();
				portfolioPageContentAnimate($(this));
				$(this).addClass('clicked');
				
			} else {
				portfolioPageContentReset($(this));
				$(this).removeClass('clicked');
			}
		}
	});
	
	scrollbarHeight();
	
	
	//videoPlayback();
	

$(window).load(function(){
	if ($(window).width() <= 979) {
		$('.footer_outer_wrapper').css({'position' : 'static', 'bottom' : 'auto', 'left' : 'auto'});
		$('.footer_placeholder').css({'height' : 0});
	}else {
		$('.footer_outer_wrapper').css({'position' : 'fixed', 'bottom' : 0, 'left' : 0});
		$('.footer_placeholder').css({'height' : $('.footer_outer_wrapper').height()});
	}
	
	
	
	slicedHoverEnable = 1;
	
	if(!headerResFlag){
		if($('.header_menu_default').length > 0) {
			headMaxWidth = 992;
			if ($('.header_menu_default').width() + 250 > 992){
				headMaxWidth = $('.header_menu_default').width() + 250;
			}
		}
	
		if($('.header_menu').length > 0) {

			headerChildNum = $(".header_menu").children().not(".clear").length;	
			var headMaxTextCount = 0;
			var headMinTextWidth = $('.header_item_wrap:first').width();
			while ($(".header_menu > *").length > headMaxTextCount) {		
				headMaxTextWidth = Math.max(headMinTextWidth, $('.header_item_wrap').eq(headMaxTextCount).width());
				headMaxTextCount++;
			}
			headMaxWidth = (headMaxTextWidth+42)*headerChildNum;	
		}
		if($(window).width() < headMaxWidth) {
		headerResFlag = true;
		} else {
			headerResFlag = false;
		}
		headerResponsive();
	}
	
	var myLayers = $('#wrapper').scrollBro('option', 'parallaxLayers');
		$('.portal_parallax_image_wrapper').each(function(){
			var $this = $(this);
			var imgLeftSetting = -(parseInt($this.find('img, video').width())-$(window).width())/2;
			$this.find('img').css({left : imgLeftSetting});
			var parImgHeightMod = ($this.find('img, video').height()- $this.height())/2;
			
			if(!$('body').hasClass('blog_header_overlay_parallax')) {	
				if($this.hasClass('large_parallax')) {
						var attributes = {
						element : $(this).find('img, video'),
						property : 'top',
						multiplier : 0.5,
						addition : -parImgHeightMod,
						scrollLimitMax : 600
					}
					myLayers.push(attributes);
				} else {
					var attributes = {
						element : $(this).find('img, video'),
						property : 'top',
						multiplier : 0.5,
						addition : -parImgHeightMod,
						scrollLimitMax : 450
					}
					myLayers.push(attributes);
				}
			} else if ($('body').hasClass('blog_header_overlay_parallax')) {
				var attributes = {
					element : $(this).find('img, video'),
					property : 'top',
					multiplier : 0.5,
					addition : -parImgHeightMod,
					scrollLimitMax : 700
				}
				myLayers.push(attributes);
				
			}
		});
		
		myLayers = asideImageParallaxSetup(myLayers);
		
		
		if ($('.portal_aside_image_wrapper li').length > 0 && $(window).width() > 992) {
			asideImageScaling();
		}
	
		
	
	$('#wrapper').scrollBro('option', 'parallaxLayers', myLayers);
	$('#wrapper').scrollBro('refresh');
	$('.portal_parallax_image_wrapper:first img').animate({opacity : 1}, 300);
	
	if(navigator.userAgent.indexOf("MSIE")>=0){
		$('.info_wall_wrapper').each(function(){
			$(this).find('.info_wall_item .img_wrap img').each(function(){
				var topVal;
				if (($(this).closest('.img_wrap').height()-$(this).height())/2 < 0){
					topVal = ($(this).closest('.img_wrap').height()-$(this).height())/2
					} else{
					topVal = 0;
					}
				$(this).css({'top' : topVal}).animate({opacity : 1},400);
			});
		});
	}
	
	$('.sliced_preview_content h3').each(function(){
		var $this = $(this);
		$this.css({'bottom' : $this.height()- $this.parent().height()});
		$this.siblings('.pop_ups').children().css({'bottom': -$this.parent().height()});
	});
	
	$('.sliced_preview_content').stop(true).animate({opacity : 1}, 200);
	
	scrollbarHeight();
});


      

$(window).resize(function(){
	 $('html').height($(window).height()-parseInt($('html').css('margin-top')));
	
	
	if ($(window).width() <= 979) {
		$('.footer_outer_wrapper').css({'position' : 'static', 'bottom' : 'auto', 'left' : 'auto'});
		$('.footer_placeholder').css({'height' : 0});
	}else {
		$('.footer_outer_wrapper').css({'position' : 'fixed', 'bottom' : 0, 'left' : 0});
		$('.footer_placeholder').css({'height' : $('.footer_outer_wrapper').height()});
	}
	
	$('#wrapper').scrollBro('refresh');
	
	$('.comment_form:not(.contact_form)').each(function(){
		if($(this).outerWidth()< 800){
			$(this).find('input[type="text"].input_field').css({'width' : '100%', 'margin-left' : 0, 'margin-right' : 0});
		}else {
			$(this).find('input[type="text"].input_field').css({'width' : '32%'}).eq(1).css({'margin-left' : '2%', 'margin-right' : '2%'});
		}
	});
	
	if ($('.aside_image').length >0 && $(window).width() < 992){
		$('.aside_image .portal_aside_image_wrapper ul').css({'position': 'static', 'padding-top':0, 'left':'auto', 'top':'auto', 'width':'100%'});
		asideWrpLiImg.css({opacity:1, 'max-width':'100%', 'left':'auto'});
		$('.aside_image .portal_aside_image_wrapper li video').css({opacity:1, 'max-width':'100%', 'left':'auto'});
		$('.aside_image .inner_content').css({'width': '100%', 'float': 'left'});
		$('.aside_image .portal_aside_image_wrapper').css({'width':'100%', 'height' : $('.aside_image .portal_aside_image_wrapper').children('ul').css('height')});
		
	} else {
		if($('.aside_image').length >0) {
			$('.aside_image .portal_aside_image_wrapper ul').css({'position': 'absolute', 'padding-top':0, 'left':0, 'top':0, 'width':'auto'});
			asideWrpLiImg.css({opacity:0, 'max-width':'auto', 'left' : -(asideWrpLiImg.width() - $('.portal_aside_image_wrapper').width())/2 });
			$('.aside_image .portal_aside_image_wrapper li video').css({opacity:0, 'max-width':'auto', 'left' : -(asideWrpLiVideo - $('.portal_aside_image_wrapper').width())/2 });
			$('.aside_image .inner_content').css({'width': '66.6666%', 'float': 'left'});
			$('.aside_image .portal_aside_image_wrapper').css({'width':'33.3333%', 'height' : $('.aside_image .portal_aside_image_wrapper').children('ul').css('height')});
		}
	}
	
	$('.chapters_sub li a').each(function() {
		$(this).attr({'data-offset': $(this.hash).offset().top});
	});
	if($('.blog_header_overlay_parallax').length > 0){
			chaptersScrolling(100);	
		} else {
			chaptersScrolling(100);			
		}	
		
	if($(window).width() < headMaxWidth*window.devicePixelRatio) {
		headerResFlag = true;
	} else {
		headerResFlag = false;
	}
	
	if($(window).width() < 767*window.devicePixelRatio) {
		headerResFlag = true;
	}
	
	clearTimeout(headerRespTimeout);
	headerRespTimeout = setTimeout(function(){
		headerResponsive();
		scrollbarHeight();
		var myLayers = $('#wrapper').scrollBro('option', 'parallaxLayers');
		asideImageParallaxSetup(myLayers);
	}, 200);
	
	$('.portal_parallax_image_wrapper').each(function(){
		if(!$('body').hasClass('blog_header_overlay_parallax')) {
			$(this).find('img').attr('data-width', $(this).find('img').width());
			$(this).find('img').css({left : -(parseInt($(this).find('img').attr('data-width'))-$(window).width())/2});
		}
		if(!$('body').hasClass('blog_header_overlay_parallax')) {
			if($(this).find('video').length > 0 && $(this).find('video').height() < $(this).height() ) {
				$(this).css({'height' : $(this).find('video').height()});
				$('.parallax_placeholder').hide();
				
			} else {
				$(this).css({'height' : 350});
				$('.parallax_placeholder').show();
			}
			
			if(parseInt($('.parallax_placeholder').attr('data-default')) > $('.parallax_placeholder').height()) {
				$(this).css({'height' : $(this).find('video').height()});
				$('.parallax_placeholder').css({'height' : $(this).find('video').height()});
			}
		}
		
		if($('body').hasClass('blog_header_overlay_parallax')) {
			$(this).find('img').attr('data-width', $(this).find('img').width());
			$(this).find('img').css({left : -(parseInt($(this).find('img').attr('data-width'))-$(window).width())/2});
		}
		
	});
	
	if ($('.portal_aside_image_wrapper li').length > 0 && $(window).width() > 992) {
		asideImageScaling();
	} 
	
	infoWallSorter();
	$('.info_wall_wrapper').each(function(){
		$(this).find('.info_wall_item .img_wrap img').each(function(){
			var topVal;
			if (($(this).closest('.img_wrap').height()-$(this).height())/2 < 0){
				topVal = ($(this).closest('.img_wrap').height()-$(this).height())/2
			} else{
				topVal = 0;
			}
				
			if (($(this).closest('.img_wrap').width()-$(this).width())/2 < 0){
					leftVal = ($(this).closest('.img_wrap').width()-$(this).width())/2
			} else{
					leftVal = 0;
			}
			
			$(this).css({'top' : topVal, 'left' : leftVal}).animate({opacity : 1},400);
		});
		$(this).find('.info_wall_item').each(function(){
			$(this).find('.text_wrap').append('<div class="hover_arrow"></div>');
		});
	});
	
	
		$('.content').css({'min-height' : $(window).height() - $('.header_placeholder').outerHeight() - $('.footer_placeholder').height()});
	
	setTimeout(function(){
		$('.sliced_preview_container .sliced_single_item .sliced_preview_content h3').each(function(){
		
		var $this = $(this);
		$this.css({'bottom' : $this.height()- $this.parent().height()});
		$this.siblings('.pop_ups').children().css({'bottom': -$this.parent().height()});
	});
	
	$('.sliced_preview_container .sliced_single_item .sliced_preview_content').stop(true).animate({opacity : 1}, 200);
	}, 400);
	
	
	
});

$('#wrapper').scroll(function(){
	chaptersScrolling(130);
	
	if ($('#wrapper').scrollBro('scrollTop') <= $('.portal_aside_image_wrapper').children('ul').outerHeight()-$(window).height()+$('.header_placeholder:first').height()) {
		$('.portal_aside_image_wrapper > ul').css('top', 0);
	}
});

function chaptersInit() {
	$('[data-chapter]').each(function(){
		var formatedId = '';
		var dataRawStr = $(this).attr('data-chapter');
		var chSortArray = new Array();
		chSortArray = dataRawStr.split(' ');
		var i=0;
		while(chSortArray[i] != undefined) {
			formatedId += (chSortArray[i]+'_');
			i++;
		}
		$(this).attr({'id' : formatedId});
		$('.chapters_sub').append('<li><a href="#'+formatedId+'" class="bg_color_main_hover color_white">'+$(this).attr('data-chapter')+'</a></li>');
	});
	
	if($('.chapters_sub').find('li').length == 0){$('.chapters_sub').closest('.chapters_wrapper').hide();}
}
 
function chaptersScrolling(viewOffset) {
	var focusedElIndex = 0;
	$('.chapters_sub li a').each(function(ind){
		if($(this.hash).offset().top - viewOffset <= 0) {
			focusedElIndex = ind;
		} 
	});
	
	if (focusedElIndex != focusedElIndexOld) {
		$('.chapters_sub li a').removeClass('focused bg_color_main').eq(focusedElIndex).addClass('focused bg_color_main');
		focusedElIndexOld = focusedElIndex;
	}
}

function chaptersOpen() {
	var $chapterHeadline = $('.chapters_headline');
	$('.chapters_headline_wrapper').stop(true).animate({width: $chapterHeadline.outerWidth(true) + 53}, 150, function(){
		$chapterHeadline.animate({opacity : 1}, 200);
	});
}

function chaptersClose() {
	$('.chapters_headline').animate({opacity : 0}, 150, function(){
		$('.chapters_headline_wrapper').stop(true).animate({width:43}, 200);
	});
	$('.chapters_trigger').removeClass('bg_color_main');
}

function anchorToTarget(AttTarget, ElementOffset, animSpeed, iFlag) {
		$(AttTarget).each(function () {
				var result = $(this.hash).offset().top - ElementOffset;
				$('#wrapper').scrollBro('scrollTop', $('#wrapper').scrollBro('scrollTop') +result, animSpeed);
		   
		});
}

function headerResponsive () {
	if (headerResFlag){
		if ($(".header_menu").length > 0){
			$(".header_menu").addClass('header_responsive').removeClass('no_header_responsive');
			$('.header_menu > li > a').stop(true).css({height : 'auto'});
			$(".header_menu").children().not('[class*="clear"]').css("width", "100%");
			$('.header_menu > li > a.logo_holder img').css({'max-height' : $(".header_menu > li > a").not('.logo_holder').find('.header_item_wrap').height() + 18 });
			$('.header_menu .header_submenu > li > a').addClass('bg_color_white color_white_hover color_default').removeClass('color_white');
			
		}
		
		if ($(".header_menu_default").length > 0){	
			$(".header_menu_default").addClass('header_responsive').removeClass('no_header_responsive');
			$('.logo_wrapper').hide();
		}
		
		$(".header_menu_wrapper").css({'overflow' : 'scroll', 'height' : 0, 'margin-top': 50});
		$('.responsive_menu_button').show();
		$('.mCustomScrollBox').css({'overflow' : 'hidden'});
		$('.mCSB_container').css({'overflow' : 'hidden'}); 
			$('.header_search_form').each(function(){
				$(this).attr('data-width', 280).css({'overflow' : 'hidden', 'width' : 40, 'position' : 'absolute', 'top' :0, 'right' : 0});
				$(this).find('.search_submit').addClass('form_closed');
			});	
			
			$('.header_placeholder').css({'height' : $('.header_wrapper').height()});
			if($('.portal_parallax_image_wrapper.header_overlay_parallax').length > 0){
				$('.parallax_margin').css({'top' : $('.header_wrapper').height()+150});
			}

	} else {
		if ($(".header_menu").length > 0){
			$(".header_menu").removeClass('header_responsive').addClass('no_header_responsive');
			$('.header_menu > li > a').stop(true).css({height : 61});
			$(".header_menu").children().not('[class*="clear"]').css("width", 100 / headerChildNum + "%");
			$('.header_menu > li > a.logo_holder img').css({'max-height' : 'none', 'margin-top' : ($('.header_menu > li > a.logo_holder').height() - $('.header_menu > li > a.logo_holder img').height())/2});
			$('.header_menu .header_submenu > li > a').removeClass('bg_color_white color_white_hover color_default').addClass('color_white');	
		}	
		
		if ($(".header_menu_default").length > 0){	
			$(".header_menu_default").removeClass('header_responsive').addClass('no_header_responsive');
			$('.logo_wrapper').show();
		}
		
		$(".header_menu_wrapper").css({'overflow' : 'visible', 'height': '61px', 'margin-top': 0});
		$('.responsive_menu_button').hide();
		$('.mCustomScrollBox').css({'overflow' : 'visible'});
		$('.mCSB_container').css({'overflow' : 'visible', 'top':'0 !important'}); 
		$('.header_search_form').each(function(){
			$(this).attr('data-width', 280).css({'overflow' : 'hidden', 'width' : 280, 'position' : 'static', 'top' :'auto', 'right' : 'auto'});
			$(this).find('.search_submit').removeClass('form_closed');
		});
		
		$('.header_placeholder').css({'height' : $('.header_wrapper').height()});
		if($('.portal_parallax_image_wrapper.header_overlay_parallax').length > 0){
			$('.parallax_margin').css({'top' : $('.header_wrapper').height()+150});
		}

	}	
}

function asideImageScaling() {	
	var leastWidth = $('.portal_aside_image_wrapper li').eq(0).find('*').width();
	$('.portal_aside_image_wrapper li').each(function(){
		if ($(this).find('*').width() < leastWidth) {
			leastWidth = $(this).find('*').width();
		}
	});		
	if ($('.portal_aside_image_wrapper').width() > leastWidth) {
		$('.portal_aside_image_wrapper').css('width', leastWidth);
		$('.aside_image .inner_content.blog_post_content').css({'width': $(window).width()-leastWidth});
	}
	var offsetLeft = 0;	

	$('.portal_aside_image_wrapper li *').each(function(ind) {
		if ($(window).width() < 992*window.devicePixelRatio) {
			offsetLeft = 'auto';
		} else {
			offsetLeft = -($(this).width() - $('.portal_aside_image_wrapper').width())/2;
		}
		$(this).css({'left' : offsetLeft}).delay(ind*100).animate({opacity : 1}, 500);
	});	
}

function asideImageParallaxSetup(myLayers) {
	$('.portal_aside_image_wrapper').each(function(){
			var $this = $(this);
			$this.height($this.parent().height());
			
			if ($(window).width() < 992*window.devicePixelRatio){
				$this.css({'height' : $this.children('ul').height()})
			}
			
			var attributes = {
					element : $this.children('ul'),
					property : 'top',
					multiplier : 1,
					addition : -$this.children('ul').outerHeight()+$(window).height()-$('.header_placeholder:first').height(),
					scrollLimitMin : $this.children('ul').outerHeight()-$(window).height(),
					scrollLimitMax : $('.footer_placeholder:first').position().top-$(window).height()-1
				}
				myLayers.push(attributes);
				
				
			var attributes = {
					element : $this.children('ul'),
					property : 'top',
					multiplier :0,
					addition : $('.footer_placeholder:first').position().top -$this.children('ul').height()-$('.header_placeholder:first').height(),
					scrollLimitMin : $('.footer_placeholder:first').position().top-$(window).height(),
					scrollLimitMax : $('.footer_placeholder:first').position().top + $('.footer_placeholder:first').height()
				}
				myLayers.push(attributes);
				
				
			
		});
		
		return myLayers;	
		$('#wrapper').scrollBro('refresh');
}

function scrollbarHeight() {
	$('.scb_scrollbar').css({'height' : $(window).height()-$('.header_placeholder').height(), 'margin-top' : $('.header_placeholder').height()});
	$('#wrapper').scrollBro('refresh');
}

function infoWallSorter($this){
	if (typeof $this != 'undefined' && $this.length > 0){
		$('<div class="info_wall_wrapper"></div>').insertAfter($this);
		$this.find('.info_wall_item').each(function(ind){
			infoWallItems[ind] = $(this).clone();
		});
		if($this.hasClass('shop_wall')){
			$('.info_wall_wrapper').addClass('shop_wall');
		}
		$this.remove();
	}
	
	if ($(window).width() > 1050){
		$('.info_wall_wrapper').html('').append('<div class="info_wall_column"></div><div class="info_wall_column"></div><div class="clearfix"></div>');
		$('.info_wall_column').css('width', '50%');
		var sel = 0;
		for(i=0; i<$('.info_wall_column').length; i++) {
			$('.info_wall_column').eq(sel).append(infoWallItems[i]);
			if (sel == 0){sel = 1;} else {sel = 0;}
		}
		
		cont = $('.info_wall_column').length;
		var sel = 0;
		var infoWallTarget = 0;
		while(typeof infoWallItems[cont] != 'undefined') {
			infoWallTarget = infoWallminCol();
			$('.info_wall_column').eq(infoWallTarget).append(infoWallItems[cont].clone());
			if ($('.info_wall_column').eq(infoWallTarget).find('.info_wall_item').length % 2 == 0) {			
				$('.info_wall_column').eq(infoWallTarget).find('.info_wall_item:last').addClass('reverse');
			}
			cont++;
		}
		
		
		$('.info_wall_item').addClass('transition');
		
	} else {
		$('.info_wall_wrapper').html('').append('<div class="info_wall_column"></div><div class="clearfix"></div>');
		$('.info_wall_column').css('width', '100%');
		cont = 0;
		
		while(typeof infoWallItems[cont] != 'undefined') {
			$('.info_wall_column').append(infoWallItems[cont].clone());
			if ($('.info_wall_column').eq(infoWallTarget).find('.info_wall_item').length % 2 == 0) {
				$('.info_wall_item:odd').addClass('reverse');	
			}
			cont++;
		}
		
		
		$('.info_wall_item').removeClass('transition');
		
		 if($(window).width() < 500) {
		 	$('.info_wall_item').each(function(){
				$(this).find('.text_wrap').css({'margin-top' : '250px', 'width' : '100%'});
				$(this).find('.img_wrap').css({'width' : '100%', 'height' : '250px'});
			});
		 } else {
		 	$('.info_wall_item').each(function(){
				$(this).find('.text_wrap').css({'margin-top' : 0, 'width' : '50%'});
				$(this).find('.img_wrap').css({'width' : '50%', 'height' : '100%'});
			});
		 }
	}
}	

function infoWallminCol() {
	var result = 0;
	for (i=0; i<$('.info_wall_column').length; i++) {
		if ($('.info_wall_column').eq(i).outerHeight() < $('.info_wall_column').eq(result).outerHeight()){
			result = i;
		}
	}
	return result;
}
	
function portfolioPageContentAnimate($this){
	$this.find('.sliced_preview_content h3').stop(true).animate({'bottom' : 0}, 450);
	$this.find('.sliced_preview_content h3').siblings('.pop_ups').children().each(function(ind){
		$(this).stop(true).delay(ind*50).animate({'bottom' : 0, opacity: 1}, 450 );	
	});
}

function portfolioPageContentReset($this) {
	var $sel = $this.find('.sliced_preview_content h3');
	var pos = $sel.height()- $sel.parent().height();
	var delay = 0;

	$sel.siblings('.pop_ups').children().each(function(ind){
			delay = $(this).siblings().length;
			$(this).stop(true).delay(($(this).siblings().length-ind)*50).animate({'bottom' : -$sel.parent().height(), opacity : 0}, 400 );	
		});
	$sel.stop(true).delay(delay*50).animate({'bottom' : pos}, 400 );

}

function videoPlayback() {
	if ( $('.portal_parallax_image_wrapper video').length > 0 ) {
		var video = $('.portal_parallax_image_wrapper video').get(0).play();

		video.addEventListener('video', function(){
			video.play();
		});

		video.addEventListener("domready", function(){
			video.play();
		});
	}
}

});	
})(jQuery);