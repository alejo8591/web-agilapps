var deployed = 'no';

var changeColor = function(color, ratio, darker) {
	
	color = color.replace(/^\s*|\s*$/, '');

	color = color.replace(
		/^#?([a-f0-9])([a-f0-9])([a-f0-9])$/i,
		'#$1$1$2$2$3$3'
	);

	var difference = Math.round(ratio * 256) * (darker ? -1 : 1),
		// Determine if input is RGB(A)
		rgb = color.match(new RegExp('^rgba?\\(\\s*' +
			'(\\d|[1-9]\\d|1\\d{2}|2[0-4][0-9]|25[0-5])' +
			'\\s*,\\s*' +
			'(\\d|[1-9]\\d|1\\d{2}|2[0-4][0-9]|25[0-5])' +
			'\\s*,\\s*' +
			'(\\d|[1-9]\\d|1\\d{2}|2[0-4][0-9]|25[0-5])' +
			'(?:\\s*,\\s*' +
			'(0|1|0?\\.\\d+))?' +
			'\\s*\\)$'
		, 'i')),
		alpha = !!rgb && rgb[4] != null ? rgb[4] : null,

		decimal = !!rgb? [rgb[1], rgb[2], rgb[3]] : color.replace(
			/^#?([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])/i,
			function() {
				return parseInt(arguments[1], 16) + ',' +
					parseInt(arguments[2], 16) + ',' +
					parseInt(arguments[3], 16);
			}
		).split(/,/),
		returnValue;

	return !!rgb ?
		'rgb' + (alpha !== null ? 'a' : '') + '(' +
			Math[darker ? 'max' : 'min'](
				parseInt(decimal[0], 10) + difference, darker ? 0 : 255
			) + ', ' +
			Math[darker ? 'max' : 'min'](
				parseInt(decimal[1], 10) + difference, darker ? 0 : 255
			) + ', ' +
			Math[darker ? 'max' : 'min'](
				parseInt(decimal[2], 10) + difference, darker ? 0 : 255
			) +
			(alpha !== null ? ', ' + alpha : '') +
			')' :

		[
			'#',
			pad(Math[darker ? 'max' : 'min'](
				parseInt(decimal[0], 10) + difference, darker ? 0 : 255
			).toString(16), 2),
			pad(Math[darker ? 'max' : 'min'](
				parseInt(decimal[1], 10) + difference, darker ? 0 : 255
			).toString(16), 2),
			pad(Math[darker ? 'max' : 'min'](
				parseInt(decimal[2], 10) + difference, darker ? 0 : 255
			).toString(16), 2)
		].join('');
};
var lighterColor = function(color, ratio) {
	return changeColor(color, ratio, false);
};
var darkerColor = function(color, ratio) {
	return changeColor(color, ratio, true);
};
var pad = function(num, totalChars) {
	var pad = '0';
	num = num + '';
	while (num.length < totalChars) {
		num = pad + num;
	}
	return num;
};

(function($){
"use strict";

	$(document).ready(function(){

		$('#portal_settings').find('.color_pick[data-color="orange"]').addClass('activated');
		$('#portal_settings').find('#settings_light').addClass('activated');

		$('body').addClass('portal_settings_light');

		$(document).on('click', '#show_hide_settings', function(e) {
			e.preventDefault();
			if ( deployed == "no" ){
				$('#portal_settings').animate({'left':0}, 200);
				deployed = "yes";
			}
			else {
				$('#portal_settings').animate({'left':-230}, 200);
				deployed = "no";
			}
		});

		$(document).on('click', '.color_pick', function() {

			$(this).parent().children().removeClass('activated');
			$(this).addClass('activated');


			var color = $(this).css('background-color');
			var color_hover = darkerColor(color, .2);
			var only_rgb = color.substring(4);
			only_rgb = only_rgb.replace(')','');

			var text_color, headers_color, menu_border_color, pale_color, white_color, bg_white_color, bg_pale_color, bg_default_color, border_default_color, border_pale_color, page_background, pagination_background, footer_background, footer_text = '';
			
			if ( $('body').hasClass('portal_settings_light') ) {
				text_color = '#333333';
				headers_color = '#222222';
				menu_border_color = '#d9d9d9';
				pale_color = '#a0a0a0';
				white_color = '#ffffff';
				bg_white_color = '#ffffff';
				bg_pale_color = '#a0a0a0';
				bg_default_color = '#222222';
				border_default_color = '#222222';
				border_pale_color = '#dddddd';
				page_background = '#ffffff';
				pagination_background = '#eeeeee';
				footer_background = '#222222';
				footer_text = '#ffffff';
			}
			else {
				text_color = '#ffffff';
				headers_color = '#ffffff';
				menu_border_color = '#444444';
				pale_color = '#a0a0a0';
				white_color = '#ffffff';
				bg_white_color = '#333333';
				bg_pale_color = '#a0a0a0';
				bg_default_color = '#ffffff';
				border_default_color = '#222222';
				border_pale_color = '#dddddd';
				page_background = '#111111';
				pagination_background = '#333333';
				footer_background = '#222222';
				footer_text = '#ffffff';
			}

var style = 'a {color:'+color+'; transition:color 300ms;}a:hover {text-decoration: underline; color:'+color+'; transition:color 300ms;}a:focus {color:'+color+';}.header_separator_color {border-color:'+menu_border_color+';}.color_default, .blog_post_content h2,.blog_post_content h3,.huge_nav_wrapper .button_single:hover .headline, .huge_nav_wrapper .button_single:hover, a.color_default, .pagination_wrapper li a {color: '+bg_default_color+';}.color_main, a.color_main, a.accordion-toggle, .stars_wrapper i.rated {color:'+color+';}.chapters_sub >li>a:focus,.chapters_trigger:focus, .chapters_trigger:hover, .color_white {color: #fff;}.color_main_hover:hover, .huge_nav_wrapper .button_single:hover .text, .info_wall_item.hovered .header_link, .header_menu_default li.hovered > a {color:'+color+'; transition:color 300ms;}.color_pale {color: %4$s;}.color_white, .about-us-skill-list li i, .shopping_cart, .shopping_cart:hover, .share .portal_button:focus, .cart .minus, .cart .plus, .cart .text, .cart .single_add_to_cart_button, .pagination_wrapper li a:hover, .comment_form input[type="submit"] {color:%5$s;}.bg_color_white {background:'+bg_white_color+'; transition: background-color 300ms;}.bg_color_pale { background-color: %7$s; transition: background-color 300ms;}.color_white_hover:hover, .header_responsive.header_menu_default li > a:hover {color: #fff;}blockquote {background-color: #efefef !important;}.bg_color_default, body, .shopping_cart,  .header_search_form, .cart .minus, .cart .plus, .cart .text, .cart .single_add_to_cart_button, .info_wall_item .img_wrap, .portal_gallery_wrapper, .portal_gallery_wrapper .pog_text_overlay:before, .sliced_preview_content:before, .ots_small_wrapper, .our_team_slider_wrapper, .comment_form input[type="submit"] { background-color: #222; transition: background-color 300ms;}.bg_color_default_hover:hover { background-color: %9$s; transition: background-color 300ms;}.bg_color_main, .services-icon, .stylish-ul > li:after, .nav.nav-tabs > li.active > a, .progress-bar-danger, .header_responsive.header_menu_default li > a:hover, .shopping_cart:hover, .cart .minus:hover, .cart .plus:hover, .cart .text:hover, .cart .single_add_to_cart_button:hover, .swiper-scrollbar-drag, .about-us-skill-list li .icon_wrap, .comment_form input[type="submit"]:hover {background-color: '+color+'; transition:background-color 300ms;}.bg_color_main_hover:hover, .header_menu .header_submenu > li.hovered, .header_menu > li.hovered > a, .comments_bubble:hover, .pagination_wrapper li a:hover {background-color: '+color+'; transition:background-color 300ms; color:#ffffff;}.iScrollVerticalScrollbar {background: rgba(34,34,34,0.3);}.iScrollIndicator {background-color: '+color+' !important;}.bg_color_lighter_main_hover:hover {background-color: %2$s; transition:background-color 300ms; color:#ffffff;}.header_menu > li.hovered > a >.line, .bg_color_main_hover:hover .line {background-color:#ffffff;}.active > .bg_color_main_hover {background-color: '+color+'; transition:background-color 300ms; color:#ffffff;}.active > .bg_color_main_hover .line {background-color:#ffffff;}.header_menu_default .header_submenu {background-color:'+bg_white_color+'; }.border_color_default, .header_menu_default > li > .header_submenu.large-variant > li {border-color:#222; transition: border-color 300ms;}.border_color_pale, .accordion-group, .header_menu_default .header_submenu li, .pagination_wrapper li {border-color:#ddd !important; transition:border-color 300ms;}.border_color_main,.content, .nav.nav-tabs, blockquote, .header_menu_default .header_submenu {border-color:'+color+' !important; transition: border-color 300ms;}.border_color_hover_main:hover {border-color:'+color+' !important; transition: border-color 300ms;}.ots_small_item > * {color:#fff; border-color:#fff;}.info_wall_item .text_wrap .hover_arrow {border-color:#fff;}.comments_bubble:hover .arrow {border-left-color:'+color+' !important; transition: border-color 300ms;}.portal_parallax_image_wrapper, .inner_content, .content {background: #fff;}.tw_icon {color: #818181;}.stylish-ul {border-color:#a5a5a5;}.huge_nav_wrapper .button_single {border-color:#d4d4d6;}.huge_nav_wrapper {background-color:#ebecee;}.our_team_controls_wrap a, .our_team_slide .ots_slide_content, .our_team_controls_wrap-small a.ots_prev-small, .our_team_controls_wrap-small a.ots_next-small {background-color:rgba(255,255,255,0.8) !important;}.dark-gray-bg {background-color: #2e373c;} .retina_bg {background-color:#ccc;}.comment_form input[type="text"].input_field, .comment_form textarea.textarea_field{border-color:#888; transition:border-color 600ms;}.comment_form input[type="text"].input_field:focus, .comment_form textarea.textarea_field:focus{border-color:'+color+'; transition:border-color 600ms;}.tagcloud a {background:%8$s;}.tagcloud a:hover {background:'+color+';}.portal_parallax_image_wrapper, .inner_content, .content, .parallax_margin {background:'+page_background+';}.pagination_wrapper {background:'+pagination_background+'}.info_wall_item .text_wrap .hover_arrow {border-color:'+page_background+';}body{color:'+text_color+'!important;}h1,h2,h3,h4,h5,h6 {color:'+headers_color+'!important;}.footer_wrapper h5{color:#fff!important;} .line.bg_color_default{background:'+headers_color+'}';

			$('head #portal_styles').remove();
			$('head').append('<style id="portal_styles" type="text/css">'+style+'</style>');

		});

		$(document).on('click', '#settings_dark', function() {

			$(this).parent().children().removeClass('activated');
			$(this).addClass('activated');

			if ( $('body').hasClass('portal_settings_light') ) {
				$('body').removeClass('portal_settings_light').addClass('portal_settings_dark');
				
				var color = $('.color_pick.activated').css('background-color');
				var color_hover = darkerColor(color, .2);
				var only_rgb = color.substring(4);
				only_rgb = only_rgb.replace(')','');

				var text_color = '#ffffff';
				var headers_color = '#ffffff';
				var menu_border_color = '#444444';
				var pale_color = '#eeeeee';
				var white_color = '#777777';
				var bg_white_color = '#333333';
				var bg_pale_color = '#333333';
				var bg_default_color = '#ffffff';
				var border_default_color = '#111111';
				var border_pale_color = '#222222';
				var page_background = '#111111';
				var pagination_background = '#222222';
				var footer_background = '#222222';
				var footer_text = '#ffffff';


var style = 'a {color:'+color+'; transition:color 300ms;}a:hover {text-decoration: underline; color:'+color+'; transition:color 300ms;}a:focus {color:'+color+';}.header_separator_color {border-color:'+menu_border_color+';}.color_default, .blog_post_content h2,.blog_post_content h3,.huge_nav_wrapper .button_single:hover .headline, .huge_nav_wrapper .button_single:hover, a.color_default, .pagination_wrapper li a {color: '+bg_default_color+';}.color_main, a.color_main, a.accordion-toggle, .stars_wrapper i.rated {color:'+color+';}.chapters_sub >li>a:focus,.chapters_trigger:focus, .chapters_trigger:hover, .color_white {color: #fff;}.color_main_hover:hover, .huge_nav_wrapper .button_single:hover .text, .info_wall_item.hovered .header_link, .header_menu_default li.hovered > a {color:'+color+'; transition:color 300ms;}.color_pale {color: %4$s;}.color_white, .about-us-skill-list li i, .shopping_cart, .shopping_cart:hover, .share .portal_button:focus, .cart .minus, .cart .plus, .cart .text, .cart .single_add_to_cart_button, .pagination_wrapper li a:hover, .comment_form input[type="submit"] {color:%5$s;}.bg_color_white {background: '+bg_white_color+'; transition: background-color 300ms;}.bg_color_pale { background-color: %7$s; transition: background-color 300ms;}.color_white_hover:hover, .header_responsive.header_menu_default li > a:hover {color: #fff;}blockquote {background-color: #efefef !important;}.bg_color_default, body, .shopping_cart,  .header_search_form, .cart .minus, .cart .plus, .cart .text, .cart .single_add_to_cart_button, .info_wall_item .img_wrap, .portal_gallery_wrapper, .portal_gallery_wrapper .pog_text_overlay:before, .sliced_preview_content:before, .ots_small_wrapper, .our_team_slider_wrapper, .comment_form input[type="submit"] { background-color: #222; transition: background-color 300ms;}.bg_color_default_hover:hover { background-color: %9$s; transition: background-color 300ms;}.bg_color_main, .services-icon, .stylish-ul > li:after, .nav.nav-tabs > li.active > a, .progress-bar-danger, .header_responsive.header_menu_default li > a:hover, .shopping_cart:hover, .cart .minus:hover, .cart .plus:hover, .cart .text:hover, .cart .single_add_to_cart_button:hover, .swiper-scrollbar-drag, .about-us-skill-list li .icon_wrap, .comment_form input[type="submit"]:hover {background-color: '+color+'; transition:background-color 300ms;}.bg_color_main_hover:hover, .header_menu .header_submenu > li.hovered, .header_menu > li.hovered > a, .comments_bubble:hover, .pagination_wrapper li a:hover {background-color: '+color+'; transition:background-color 300ms; color:#ffffff;}.iScrollVerticalScrollbar {background: rgba(34,34,34,0.3);}.iScrollIndicator {background-color: '+color+' !important;}.bg_color_lighter_main_hover:hover {background-color: %2$s; transition:background-color 300ms; color:#ffffff;}.header_menu > li.hovered > a >.line, .bg_color_main_hover:hover .line {background-color:#ffffff;}.active > .bg_color_main_hover {background-color: '+color+'; transition:background-color 300ms; color:#ffffff;}.active > .bg_color_main_hover .line {background-color:#ffffff;}.header_menu_default .header_submenu {background-color:'+bg_white_color+'; }.border_color_default, .header_menu_default > li > .header_submenu.large-variant > li {border-color:#222; transition: border-color 300ms;}.border_color_pale, .accordion-group, .header_menu_default .header_submenu li, .pagination_wrapper li {border-color:#ddd !important; transition:border-color 300ms;}.border_color_main,.content, .nav.nav-tabs, blockquote, .header_menu_default .header_submenu {border-color:'+color+' !important; transition: border-color 300ms;}.border_color_hover_main:hover {border-color:'+color+' !important; transition: border-color 300ms;}.ots_small_item > * {color:#fff; border-color:#fff;}.info_wall_item .text_wrap .hover_arrow {border-color:#fff;}.comments_bubble:hover .arrow {border-left-color:'+color+' !important; transition: border-color 300ms;}.portal_parallax_image_wrapper, .inner_content, .content {background: #fff;}.tw_icon {color: #818181;}.stylish-ul {border-color:#a5a5a5;}.huge_nav_wrapper .button_single {border-color:#d4d4d6;}.huge_nav_wrapper {background-color:#ebecee;}.our_team_controls_wrap a, .our_team_slide .ots_slide_content, .our_team_controls_wrap-small a.ots_prev-small, .our_team_controls_wrap-small a.ots_next-small {background-color:rgba(255,255,255,0.8) !important;}.dark-gray-bg {background-color: #2e373c;} .retina_bg {background-color:#ccc;}.comment_form input[type="text"].input_field, .comment_form textarea.textarea_field{border-color:#888; transition:border-color 600ms;}.comment_form input[type="text"].input_field:focus, .comment_form textarea.textarea_field:focus{border-color:'+color+'; transition:border-color 600ms;}.tagcloud a {background:%8$s;}.tagcloud a:hover {background:'+color+';}.portal_parallax_image_wrapper, .inner_content, .content, .parallax_margin {background:'+page_background+';}.pagination_wrapper {background:'+pagination_background+'}.info_wall_item .text_wrap .hover_arrow {border-color:'+page_background+';}body{color:'+text_color+'!important;}h1,h2,h3,h4,h5,h6 {color:'+headers_color+'!important;} .footer_wrapper h5{color:#fff!important;} .line.bg_color_default{background:'+headers_color+';}';

			$('.header_menu .logo').attr('src', 'http://www.shindiristudio.com/portalwp/wp-content/themes/portal/settings/logolight.png');

			$('head #portal_styles').remove();
			$('head').append('<style id="portal_styles" type="text/css">'+style+'</style>');

				
			}
		});

		$(document).on('click', '#settings_light', function() {

			$(this).parent().children().removeClass('activated');
			$(this).addClass('activated');

			if ( $('body').hasClass('portal_settings_dark') ) {
				$('body').removeClass('portal_settings_dark').addClass('portal_settings_light');
				
				var color = $('.color_pick.activated').css('background-color');
				var color_hover = darkerColor(color, .2);
				var only_rgb = color.substring(4);
				only_rgb = only_rgb.replace(')','');

				var text_color = '#333333';
				var headers_color = '#222222';
				var menu_border_color = '#d9d9d9';
				var pale_color = '#a0a0a0';
				var white_color = '#ffffff';
				var bg_white_color = '#ffffff';
				var bg_pale_color = '#a0a0a0';
				var bg_default_color = '#222222';
				var border_default_color = '#222222';
				var border_pale_color = '#dddddd';
				var page_background = '#ffffff';
				var pagination_background = '#eeeeee';
				var footer_background = '#222222';
				var footer_text = '#ffffff';

var style = 'a {color:'+color+'; transition:color 300ms;}a:hover {text-decoration: underline; color:'+color+'; transition:color 300ms;}a:focus {color:'+color+';}.header_separator_color {border-color:'+menu_border_color+';}.color_default, .blog_post_content h2,.blog_post_content h3,.huge_nav_wrapper .button_single:hover .headline, .huge_nav_wrapper .button_single:hover, a.color_default, .pagination_wrapper li a {color: '+bg_default_color+';}.color_main, a.color_main, a.accordion-toggle, .stars_wrapper i.rated {color:'+color+';}.chapters_sub >li>a:focus,.chapters_trigger:focus, .chapters_trigger:hover, .color_white {color: #fff;}.color_main_hover:hover, .huge_nav_wrapper .button_single:hover .text, .info_wall_item.hovered .header_link, .header_menu_default li.hovered > a {color:'+color+'; transition:color 300ms;}.color_pale {color: %4$s;}.color_white, .about-us-skill-list li i, .shopping_cart, .shopping_cart:hover, .share .portal_button:focus, .cart .minus, .cart .plus, .cart .text, .cart .single_add_to_cart_button, .pagination_wrapper li a:hover, .comment_form input[type="submit"] {color:%5$s;}.bg_color_white {background:'+bg_white_color+'; transition: background-color 300ms;}.bg_color_pale { background-color: %7$s; transition: background-color 300ms;}.color_white_hover:hover, .header_responsive.header_menu_default li > a:hover {color: #fff;}blockquote {background-color: #efefef !important;}.bg_color_default, body, .shopping_cart,  .header_search_form, .cart .minus, .cart .plus, .cart .text, .cart .single_add_to_cart_button, .info_wall_item .img_wrap, .portal_gallery_wrapper, .portal_gallery_wrapper .pog_text_overlay:before, .sliced_preview_content:before, .ots_small_wrapper, .our_team_slider_wrapper, .comment_form input[type="submit"] { background-color: #222; transition: background-color 300ms;}.bg_color_default_hover:hover { background-color: %9$s; transition: background-color 300ms;}.bg_color_main, .services-icon, .stylish-ul > li:after, .nav.nav-tabs > li.active > a, .progress-bar-danger, .header_responsive.header_menu_default li > a:hover, .shopping_cart:hover, .cart .minus:hover, .cart .plus:hover, .cart .text:hover, .cart .single_add_to_cart_button:hover, .swiper-scrollbar-drag, .about-us-skill-list li .icon_wrap, .comment_form input[type="submit"]:hover {background-color: '+color+'; transition:background-color 300ms;}.bg_color_main_hover:hover, .header_menu .header_submenu > li.hovered, .header_menu > li.hovered > a, .comments_bubble:hover, .pagination_wrapper li a:hover {background-color: '+color+'; transition:background-color 300ms; color:#ffffff;}.iScrollVerticalScrollbar {background: rgba(34,34,34,0.3);}.iScrollIndicator {background-color: '+color+' !important;}.bg_color_lighter_main_hover:hover {background-color: %2$s; transition:background-color 300ms; color:#ffffff;}.header_menu > li.hovered > a >.line, .bg_color_main_hover:hover .line {background-color:#ffffff;}.active > .bg_color_main_hover {background-color: '+color+'; transition:background-color 300ms; color:#ffffff;}.active > .bg_color_main_hover .line {background-color:#ffffff;}.header_menu_default .header_submenu {background-color:'+bg_white_color+'; }.border_color_default, .header_menu_default > li > .header_submenu.large-variant > li {border-color:#222; transition: border-color 300ms;}.border_color_pale, .accordion-group, .header_menu_default .header_submenu li, .pagination_wrapper li {border-color:#ddd !important; transition:border-color 300ms;}.border_color_main,.content, .nav.nav-tabs, blockquote, .header_menu_default .header_submenu {border-color:'+color+' !important; transition: border-color 300ms;}.border_color_hover_main:hover {border-color:'+color+' !important; transition: border-color 300ms;}.ots_small_item > * {color:#fff; border-color:#fff;}.info_wall_item .text_wrap .hover_arrow {border-color:#fff;}.comments_bubble:hover .arrow {border-left-color:'+color+' !important; transition: border-color 300ms;}.portal_parallax_image_wrapper, .inner_content, .content {background: #fff;}.tw_icon {color: #818181;}.stylish-ul {border-color:#a5a5a5;}.huge_nav_wrapper .button_single {border-color:#d4d4d6;}.huge_nav_wrapper {background-color:#ebecee;}.our_team_controls_wrap a, .our_team_slide .ots_slide_content, .our_team_controls_wrap-small a.ots_prev-small, .our_team_controls_wrap-small a.ots_next-small {background-color:rgba(255,255,255,0.8) !important;}.dark-gray-bg {background-color: #2e373c;} .retina_bg {background-color:#ccc;}.comment_form input[type="text"].input_field, .comment_form textarea.textarea_field{border-color:#888; transition:border-color 600ms;}.comment_form input[type="text"].input_field:focus, .comment_form textarea.textarea_field:focus{border-color:'+color+'; transition:border-color 600ms;}.tagcloud a {background:%8$s;}.tagcloud a:hover {background:'+color+';}.portal_parallax_image_wrapper, .inner_content, .content, .parallax_margin {background:'+page_background+';}.pagination_wrapper {background:'+pagination_background+'}.info_wall_item .text_wrap .hover_arrow {border-color:'+page_background+';}body{color:'+text_color+'!important;}h1,h2,h3,h4,h5,h6 {color:'+headers_color+'!important;}.footer_wrapper h5{color:#fff!important;} .line.bg_color_default{background:'+headers_color+';}';

			$('.header_menu .logo').attr('src', 'http://www.shindiristudio.com/portalwp/wp-content/themes/portal/settings/logodark.png');

			$('head #portal_styles').remove();
			$('head').append('<style id="portal_styles" type="text/css">'+style+'</style>');
				
			}
		});

	});
})(jQuery);