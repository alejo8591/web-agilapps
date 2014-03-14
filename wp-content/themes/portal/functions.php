<?php
/**
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

require_once ('admin/index.php');

function portal_setup_theme() {

	load_theme_textdomain( 'portal', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	register_nav_menu( 'primary', __( 'Primary Header Menu', 'portal' ) );

	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'custom-background');

	add_editor_style();

}
add_action( 'after_setup_theme', 'portal_setup_theme' );

if ( in_array( 'frontend_builder/frontend_builder.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { include_once ('shortcodes.php'); }

// TGM Plugin Activation

require_once dirname( __FILE__ ) . '/lib/tgm-plugin-activation/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'portal_register_required_plugins' );

function portal_register_required_plugins() {

	$plugins = array(
		array(
			'name'					=> 'Front-End Builder',
			'slug'					=> 'frontend_builder',
			'source'				=> get_template_directory() . '/lib/plugins/frontend_builder.zip',
			'required'				=> true,
			'version'				=> '1.53',
			'force_activation'		=> false,
			'force_deactivation'	=> false,
			'external_url'			=> 'http://www.shindiristudio.com/fbuilder/wp-admin/admin-ajax.php?action=fbuilder_edit&p=2'
		),
		array(
			'name'					=> 'Revolution Slider',
			'slug'					=> 'revslider',
			'source'				=> get_template_directory() . '/lib/plugins/revslider.zip',
			'required'				=> false,
			'version'				=> '4.1.4',
			'force_activation'		=> false,
			'force_deactivation'		=> false,
			'external_url'			=> 'http://www.themepunch.com/codecanyon/revolution_wp/',
		),
		array(
			'name'					=> 'WordPress Visual Icon Fonts',
			'slug'					=> 'wp-visual-icon-fonts',
			'required'				=> false,
			'version'				=> '0.5.7'
		),
		array(
			'name'					=> 'Video Embed & Thumbnail Generator',
			'slug'					=> 'video-embed-thumbnail-generator',
			'required'				=> true,
			'version'				=> '4.2.9'
		),
		array(
			'name'					=> 'Flickr Badges Widget',
			'slug'					=> 'flickr-badges-widget',
			'required'				=> false,
			'version'				=> '1.2.5'
		)

	);

	$theme_text_domain = 'portal';

	$config = array(
		'domain'			=> $theme_text_domain,
		'default_path'		=> '',
		'parent_menu_slug'	=> 'themes.php',
		'parent_url_slug'	=> 'themes.php',
		'menu'				=> 'install-required-plugins',
		'has_notices'		=> true,
		'is_automatic'		=> true,
		'message'			=> '',
		'strings'	=> array(
			'page_title' => __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title' => __( 'Install Plugins', $theme_text_domain ),
			'installing' => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops' => __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required' => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ),
			'notice_can_install_recommended'=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ),
			'notice_cannot_install' => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator 	of this site for help on getting the plugins installed.' ),
			'notice_can_activate_required'  => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
			'notice_can_activate_recommended'   => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ),
			'notice_cannot_activate'=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ),
			'notice_ask_to_update'  => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ),
			'notice_cannot_update'  => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ),
			'install_link' => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated' => __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete' => __( 'All plugins installed and activated successfully. %s', $theme_text_domain )
		)
	);

	tgmpa( $plugins, $config );

}

// Load Scripts

function portal_scripts() {
	global $portal_data;
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui' );
	wp_enqueue_script( 'jquery-effects-core' );
	wp_enqueue_script( 'portal-bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '3.0.3', true);
	wp_enqueue_script( 'portal-mCustomScrollbar-js', get_template_directory_uri() . '/js/jquery.mCustomScrollbar.concat.min.js', array( 'jquery' ), '1.0', true);
	wp_enqueue_script( 'portal-mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.js', array( 'jquery' ), '1.0', true);
	wp_enqueue_script( 'portal-cssplugin', 'http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/CSSPlugin.min.js', array( 'jquery' ), '1.0', true);
	wp_enqueue_script( 'portal-easepack', 'http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/easing/EasePack.min.js', array( 'jquery' ), '1.0', true);
	wp_enqueue_script( 'portal-tweenlite', 'http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenLite.min.js', array( 'jquery' ), '1.0', true);
	wp_enqueue_script( 'portal-scrollbr0', get_template_directory_uri() . '/js/scroll_br0.js', array( 'jquery' ), '1.0', true);

	wp_enqueue_script( 'portal-main-js', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '1.0', true);

	$font = str_replace(" ", " ", $portal_data['font']);
	$url_font = 'http://fonts.googleapis.com/css?family='.$font.':200,300,300italic,400,400italic,500,600,700,700italic&subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese';

	wp_localize_script( 'portal-main-js', 'portal', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'fonturl'  => $url_font, 'directory' => get_template_directory_uri(), 'logourl' => $portal_data['logo'],  'url' => get_home_url() ) );

	wp_deregister_script( 'fbuilder_swiper_js' );
	wp_enqueue_script( 'fbuilder_swiper_js', get_template_directory_uri() . '/js/idangerous.swiper-2.1.min.js', array( 'jquery' ), '1.0', true);
	wp_enqueue_script( 'portal-idangerous-swiper', get_template_directory_uri() . '/js/idangerous.swiper.scrollbar-2.1.js', array( 'jquery' ), '1.0', true);

	if ( !is_page_template() ) {
		wp_enqueue_script( 'portal-swiper-init', get_template_directory_uri() . '/js/swiper_init.js', array( 'jquery' ), '1.0', true);
	}

	wp_enqueue_script( 'portal-waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array( 'jquery' ), '1.0', true);
	wp_enqueue_script( 'portal-waypoint', get_template_directory_uri() . '/js/waypoint.ini.js', array( 'jquery' ), '1.0', true);
	wp_enqueue_script( 'portal-fbuilder', get_template_directory_uri() . '/js/frb_event.js', array( 'jquery' ), '1.0', true);

	if ( is_page_template('gallery-template.php') ) :
		wp_enqueue_script( 'portal-lightbox', get_template_directory_uri() . '/js/lightbox-2.6.min.js', array( 'jquery' ), '1.0', true);
		wp_enqueue_script( 'portal-pog', get_template_directory_uri() . '/js/pog.js', array( 'jquery' ), '1.0', true);
		wp_localize_script( 'portal-pog', 'portal', array( 'directory' => get_template_directory_uri() ) );
		wp_enqueue_script( 'portal-main-extra-js', get_template_directory_uri() . '/js/main_extra.js', array( 'jquery' ), '1.0', true);
	endif;

	if ( is_page_template('portfolio-template.php') ) :
		wp_enqueue_script( 'portal-portfolio', get_template_directory_uri() . '/js/port_fws.js', array( 'jquery' ), '1.0', true);
	endif;

	if ( is_page_template('team-template.php') ) :
		wp_enqueue_script( 'portal-team', get_template_directory_uri() . '/js/our_team_slider.js', array( 'jquery' ), '1.0', true);
		wp_localize_script( 'portal-team', 'portal', array( 'directory' => get_template_directory_uri() ) );
	endif;

	if ( is_page_template('smallteam-template.php') ) :
		wp_enqueue_script( 'portal-team-small', get_template_directory_uri() . '/js/our_team_slider_small.js', array( 'jquery' ), '1.0', true);
	endif;

	wp_enqueue_script( 'portal-main-extra-js', get_template_directory_uri() . '/js/main_extra.js', array( 'jquery' ), '1.0', true);


	if ( $portal_data['service_mode'] == '1' ) {
		wp_enqueue_script( 'portal-service', get_template_directory_uri() . '/settings/settings.js', array( 'jquery' ), '1.0', true);
	}

}

add_action( 'wp_enqueue_scripts', 'portal_scripts' );


// Portal CSS

function portal_styles_css() {
	global $portal_data;
 
	if ( ! isset( $content_width ) )
		$content_width = $portal_data['content_width'];

	wp_enqueue_style( 'portal-bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css' );
	wp_enqueue_style( 'portal-lightbox', get_template_directory_uri() . '/css/lightbox.css' );
	wp_enqueue_style( 'portal-mCustomScrollbar', get_template_directory_uri() . '/css/jquery.mCustomScrollbar.css' );
	wp_enqueue_style( 'portal-idangerous-scrollbar', get_template_directory_uri() . '/css/idangerous.swiper.scrollbar.css' );
	wp_enqueue_style( 'portal-idangerous', get_template_directory_uri() . '/css/idangerous.swiper.css' );
	wp_enqueue_style( 'portal-scrollbr0', get_template_directory_uri() . '/css/scroll_br0.css' );
	wp_enqueue_style( 'portal-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'portal-style-extras', get_template_directory_uri() . '/style-extras.css' );

	if ( $portal_data['service_mode'] == '1' ) { wp_enqueue_style( 'portal-service', get_template_directory_uri() . '/settings/settings.css' ); }

}
add_action( 'wp_enqueue_scripts', 'portal_styles_css' );


// Portal CUSTOM

function portal_styles() {
	global $portal_data;

	echo "<style id='portal_styles' type='text/css'>\n";

	printf('
a {color:%1$s; transition:color 300ms;}
a:hover {text-decoration: underline; color:%1$s; transition:color 300ms;}
a:focus {color:%1$s;}
.header_separator_color {border-color:%3$s;}
.color_default, .blog_post_content h2,.blog_post_content h3,.huge_nav_wrapper .button_single:hover .headline, .huge_nav_wrapper .button_single:hover, a.color_default, .pagination_wrapper li a {color: #222222;}
.color_main, a.color_main, a.accordion-toggle, .stars_wrapper i.rated {color:%1$s;}
.chapters_sub >li>a:focus,.chapters_trigger:focus, .chapters_trigger:hover, .color_white {color: #fff;}
.color_main_hover:hover, .huge_nav_wrapper .button_single:hover .text, .info_wall_item.hovered .header_link, .header_menu_default li.hovered > a {color:%1$s; transition:color 300ms;}
.color_pale {color: %4$s;}
.color_white, .about-us-skill-list li i, .shopping_cart, .shopping_cart:hover, .share .portal_button:focus, .cart .minus, .cart .plus, .cart .text, .cart .single_add_to_cart_button, .pagination_wrapper li a:hover, .comment_form input[type="submit"] {color:%5$s;}
.bg_color_white {background: %6$s; transition: background-color 300ms;}
.bg_color_pale { background-color: %7$s; transition: background-color 300ms;}
.color_white_hover:hover, .header_responsive.header_menu_default li > a:hover {color: #fff;}
blockquote {background-color: #efefef !important;}	
.bg_color_default, body, .shopping_cart,  .header_search_form, .cart .minus, .cart .plus, .cart .text, .cart .single_add_to_cart_button, .info_wall_item .img_wrap, .portal_gallery_wrapper, .portal_gallery_wrapper .pog_text_overlay:before, .sliced_preview_content:before, .ots_small_wrapper, .our_team_slider_wrapper, .comment_form input[type="submit"] { background-color: %8$s; transition: background-color 300ms;}
.bg_color_default_hover:hover { background-color: %9$s; transition: background-color 300ms;}
.bg_color_main, .services-icon, .stylish-ul > li:after, .nav.nav-tabs > li.active > a, .progress-bar-danger, .header_responsive.header_menu_default li > a:hover, .shopping_cart:hover, .cart .minus:hover, .cart .plus:hover, .cart .text:hover, .cart .single_add_to_cart_button:hover, .swiper-scrollbar-drag, .about-us-skill-list li .icon_wrap, .comment_form input[type="submit"]:hover {background-color: %1$s; transition:background-color 300ms;}
.bg_color_main_hover:hover, .header_menu .header_submenu > li.hovered, .header_menu > li.hovered > a, .comments_bubble:hover, .pagination_wrapper li a:hover {background-color: %1$s; transition:background-color 300ms; color:#ffffff;}
.bg_color_lighter_main_hover:hover {background-color: %2$s; transition:background-color 300ms; color:#ffffff;}
.header_menu > li.hovered > a >.line, .bg_color_main_hover:hover .line {background-color:#ffffff;}
.active > .bg_color_main_hover {background-color: %1$s; transition:background-color 300ms; color:#ffffff;}
.active > .bg_color_main_hover .line {background-color:#ffffff;}
.border_color_default, .header_menu_default > li > .header_submenu.large-variant > li {border-color:#222; transition: border-color 300ms;}
.border_color_pale, .accordion-group, .header_menu_default .header_submenu li, .pagination_wrapper li {border-color:#ddd !important; transition:border-color 300ms;}
.border_color_main,.content, .nav.nav-tabs, blockquote, .header_menu_default .header_submenu {border-color:%1$s !important; transition: border-color 300ms;}
.border_color_hover_main:hover {border-color:%1$s !important; transition: border-color 300ms;}
.ots_small_item > * {color:#fff; border-color:#fff;}
.info_wall_item .text_wrap .hover_arrow {border-color:#fff;}
.comments_bubble:hover .arrow {border-left-color:%1$s !important; transition: border-color 300ms;}
.portal_parallax_image_wrapper, .inner_content, .content {background: #fff;}
.tw_icon {color: #818181;}
.stylish-ul {border-color:#a5a5a5;}
.huge_nav_wrapper .button_single {border-color:#d4d4d6;}
.huge_nav_wrapper {background-color:#ebecee;}
.our_team_controls_wrap a, .our_team_slide .ots_slide_content, .our_team_controls_wrap-small a.ots_prev-small, .our_team_controls_wrap-small a.ots_next-small {background-color:rgba(255,255,255,0.8) !important;}
.dark-gray-bg {background-color: #2e373c;}
 .retina_bg {background-color:#ccc;}
.comment_form input[type="text"].input_field, .comment_form textarea.textarea_field{border-color:#888; transition:border-color 600ms;}
.comment_form input[type="text"].input_field:focus, .comment_form textarea.textarea_field:focus{border-color:%1$s; transition:border-color 600ms;}
.tagcloud a {background:%8$s;}
.tagcloud a:hover {background:%1$s;}
.portal_parallax_image_wrapper, .inner_content, .content, .parallax_margin  {background:%11$s;}
.pagination_wrapper {background:%12$s;}
.info_wall_item .text_wrap .hover_arrow {border-color:%11$s;}
.footer_wrapper.bg_color_default {background:%13$s;}
.footer_wrapper {color:%14$s;}
.footer_lines .line {background:%5$s;}
.header_menu_default > li.menu-item-has-children.hovered > a:after, .header_menu_default > li.has_sidebar.hovered > a:after {border-bottom-color:%1$s;}
.pagination_wrapper  li.current a {background:%1$s;}
.header_responsive a:hover, .header_menu_wrapper li.menu-item.has_sidebar ul.navmenu_fullwidth aside.widget_nav_menu a:hover, .header_menu_wrapper li.menu-item.hasno_sidebar ul.navmenu_fullwidth a:hover {color:%1$s !important;background:transparent !important;}
.scb_handle {background-color:%1$s;}
	', $portal_data['theme_color'], $portal_data['theme_color_light'], $portal_data['menu_border_color'], $portal_data['pale_color'], $portal_data['white_color'], $portal_data['bg_white_color'], $portal_data['bg_pale_color'], $portal_data['bg_default_color'], $portal_data['border_default_color'], $portal_data['border_pale_color'], $portal_data['page_background'], $portal_data['pagination_background'], $portal_data['footer_background'], $portal_data['footer_text'] );
	echo "</style>\n";

	if( $portal_data['custom-css'] !== '' ) :
		echo "<style type='text/css'>".$portal_data['custom-css']."</style>";
	endif;
}
add_action( 'wp_head', 'portal_styles' );


// Google Fonts

function portal_fonts() {
	global $portal_data;

	$font = str_replace(" ", " ", $portal_data['font']);
	$font_header = str_replace(" ", " ", $portal_data['font_header']);
	$url_font = 'http://fonts.googleapis.com/css?family='.$font.':200,300,300italic,400,400italic,500,600,700,700italic&subset=all';
	$url_header = 'http://fonts.googleapis.com/css?family='.$font_header.':200,300,300italic,400,400italic,500,600,700,700italic&subset=all';

	echo "<style type='text/css'>\n";
	printf( '@import url("%3$s");
	@import url("%4$s");

	body {font-family:"%1$s", serif;}
	h1,h2,h3,h4,h5,h6 {font-family:"%2$s", serif !important}
	', $font, $font_header, $url_font, $url_header);

	echo "</style>\n";

}
add_action( 'wp_print_styles', 'portal_fonts' );

// 
/*
 * Widgets Init
*/
function portal_widgets_init() {

	global $portal_data, $portal_layout;

	register_sidebar( array (
		'name' => __( 'Single Posts Sidebar', 'portal' ),
		'id' => 'sidebar-single',
		'before_widget' => '<aside id="%1$s" class="widget margin-bottom40 %2$s">',
		'after_widget' => '</aside><div class="separator bg_color_default margin-bottom40 clear"></div>',
		'before_title' => '<h5 class="margin-bottom20">',
		'after_title' => '</h5>',
		'description' => __( 'This sidebar appears on Single Posts.', 'portal' )
	) );

	register_sidebar( array (
		'name' => __( 'Footer 1', 'portal' ),
		'id' => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s margin-bottom20">',
		'after_widget' => "</aside>",
		'before_title' => '<h5 class="margin-bottom20">',
		'after_title' => '</h5>',
	) );

	register_sidebar( array (
		'name' => __( 'Footer 2', 'portal' ),
		'id' => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s margin-bottom20">',
		'after_widget' => "</aside>",
		'before_title' => '<h5 class="margin-bottom20">',
		'after_title' => '</h5>',
	) );

	register_sidebar( array (
		'name' => __( 'Footer 3', 'portal' ),
		'id' => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s margin-bottom20">',
		'after_widget' => "</aside>",
		'before_title' => '<h5 class="margin-bottom20">',
		'after_title' => '</h5>',
	) );

	register_sidebar( array (
		'name' => __( 'Footer 4', 'portal' ),
		'id' => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s margin-bottom20">',
		'after_widget' => "</aside>",
		'before_title' => '<h5 class="margin-bottom20">',
		'after_title' => '</h5>',
	) );

	$sidebars = $portal_data['sidebar'];
	if ( !isset($sidebars) ) return;
	foreach ( $sidebars as $sidebar ) {
		$title = sanitize_title( $sidebar['title'] );
		register_sidebar( array (
			'name' => $sidebar['title'] ,
			'id' => $title,
			'before_widget' => '<aside id="%1$s" class="widget %2$s margin-bottom20">',
			'after_widget' => "</aside>",
		'before_title' => '<h5 class="margin-bottom20">',
		'after_title' => '</h5>',
		) );
	}

}
add_action( 'widgets_init', 'portal_widgets_init' );

// Theme Options link
function portal_add_options_link() {
	global $wp_admin_bar;
	$wp_admin_bar -> add_menu( array(
		'parent' => 'site-name',
		'id' => 'portal_options',
		'title' => __('Theme Options', 'portal'),
		'href' => admin_url( 'themes.php?page=optionsframework' ),
		'meta' => false
	));
}
add_action( 'wp_before_admin_bar_render', 'portal_add_options_link' );


// Breadcrumbs
function portal_breadcrumbs() {
	// if ( is_front_page() ) return;
	$showOnHome = 0;
	$delimiter = '<i class="fa fa-angle-right"></i>';
	$homeLink = home_url( '/' );
	$home = '<i class="fa fa-home"></i>';
	$showCurrent = 1;
	$before = '<span>';
	$after = '</span>';
	$blog_string = __('Article', 'portal');
	global $post;

	echo '<div class="breadcrumps float_left color_white uppercase"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

	if ( is_front_page() ) {
		echo __('HOME', 'portal');
	}
	elseif ( is_single() && $post->post_type == 'post' ) {
		if ( !$post->post_parent ) {
			if ( $showCurrent == 1 ) echo $before . get_the_title() . $after;
		} elseif ( $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ( $parent_id ) {
			$page = get_page( $parent_id );
			$breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
			$parent_id  = $page->post_parent;
		}
		$breadcrumbs = array_reverse( $breadcrumbs );
		for ( $i = 0; $i < count($breadcrumbs); $i++ ) {
			echo $breadcrumbs[$i];
			if ( $i != count( $breadcrumbs ) - 1 ) echo ' ' . $delimiter . ' ';
		}
		if ( $showCurrent == 1 ) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
		}
	}
	elseif ( is_category() OR is_tag() ) {
		echo __('Category', 'portal') . ' ' . $delimiter . ' ' . single_cat_title( '', false );	
	}
	elseif ( is_month() ) {
		echo __('Month', 'portal') . ' ' . $delimiter . ' ' . get_the_date('F');
	}
	elseif ( is_year() ) {
		echo __('Year', 'portal') . ' ' . $delimiter . ' ' . get_the_date('Y');
	}
	elseif ( is_date() ) {
		echo __('Day', 'portal') . ' ' . $delimiter . ' ' . get_the_date('l');
	}
	elseif ( is_search() ) {
		global $wp_query;
		$number_of_posts = $wp_query -> found_posts;
		printf( '%1$s %4$s %5$s %2$s %3$s', __('Search', 'portal'), $delimiter, get_search_query(), $number_of_posts, __('posts found', 'portal') );
	}
	elseif ( ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_product()) ) {
		echo '<a href="'. get_permalink( woocommerce_get_page_id( 'shop' ) ).'">' . __('Shop', 'portal') . '</a> ' . $delimiter . ' ' . get_the_title();	
	}
	elseif ( ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_shop()) ) {
		$_name = woocommerce_get_page_id( 'shop' ) ? get_the_title( woocommerce_get_page_id( 'shop' ) ) : '';
		echo $_name;
	}
	elseif ( ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && ( is_product_category() or is_product_tag() ) ) ) {
		$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		echo $current_term->name;
	}
	elseif ( is_single() ) {
		if ( !$post->post_parent ) {
			if ( $post->post_type == 'post' ) echo $blog_string . ' ' . $delimiter . ' ';
			if ( $showCurrent == 1 ) echo $before . get_the_title() . $after;
		} elseif ( $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ( $parent_id ) {
			$page = get_page( $parent_id );
			$breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
			$parent_id  = $page->post_parent;
		}
		$breadcrumbs = array_reverse( $breadcrumbs );
		for ( $i = 0; $i < count($breadcrumbs); $i++ ) {
			echo $breadcrumbs[$i];
			if ( $i != count( $breadcrumbs ) - 1 ) echo ' ' . $delimiter . ' ';
		}
		if ( $showCurrent == 1 ) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
		}
	}
	elseif ( is_404() ) {
		echo __('404 Page', 'portal');	
	}
	elseif ( is_page() ) {
		echo get_the_title();
	}
	else {
		echo $blog_string;	
	}
	echo '</div>';
}

// Is_Blog
function is_blog () {
	global  $post;
	$posttype = get_post_type($post );
	return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
}


// String limit by char
if ( ! function_exists('portal_string_limit_words'))
{
	function portal_string_limit_words($str, $n = 500, $end_char = '...')
	{
		if ( $n == 0 ) return;
		if (strlen($str) < $n)
		{
			return $str;
		}

		$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

		if (strlen($str) <= $n)
		{
			return $str;
		}

		$out = "";
		foreach (explode(' ', trim($str)) as $val)
		{
			$out .= $val.' ';

			if (strlen($out) >= $n)
			{
				$out = trim($out);
				return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
			}
		}
	}
}

// Template for comments and pingbacks
if ( !function_exists( 'portal_comment' ) ) :
function portal_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
	
		case '' : ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>" class="single_comment margin-bottom40">
		<div class="separator margin-bottom40 bg_color_pale"></div>
		<div class="image_wrapper float_left"><?php echo get_avatar( $comment, 80 ); ?></div>
			<div class="comment_text">
				<div class="author"><?php echo get_comment_author_link(); ?></div>
				<div class="date color_pale margin-bottom15"><?php echo get_comment_date(); ?></div>
				<div class="text color_pale margin-bottom15">
					<?php
						comment_text();
						if ( $comment->comment_approved == '0' ) :
					?>
					<p class="moderation">
						<?php _e( 'Your comment is awaiting moderation.', 'portal' ); ?>
					</p>
					<?php endif; ?>
				</div>
				<?php
					comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
					edit_comment_link( __( 'Edit', 'portal' ), ' ' );
				?>
			</div><!-- comment_text -->
			<div class="clearfix"></div>
	</div>
	<?php
		break;
		case 'pingback'  :
	?>
<li class="post pingback">
	<p>
	<?php 
		_e( 'Pingback:', 'portal' );
		comment_author_link();
		edit_comment_link( __('(Edit)', 'portal'), ' ' );
	?>
	</p>
	<?php
		break;
		case 'trackback' :
	?>
<li class="post pingback">
	<p>
	<?php 
		_e( 'Pingback:', 'portal' );
		comment_author_link();
		edit_comment_link( __('(Edit)', 'portal'), ' ' );
	?>
	</p>
	<?php
		break;
		endswitch;
	}
endif;

// Portal Post Metaboxes
add_action( 'load-post.php', 'portal_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'portal_post_meta_boxes_setup' );
function portal_post_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'portal_add_post_meta_boxes' );
	add_action( 'save_post', 'portal_save_post_meta_boxes', 10, 2 );
}
function portal_add_post_meta_boxes() {

	add_meta_box(
		'portal-post-style',
		esc_html__( 'Portal Post Style', 'portal' ),
		'portal_post_type',
		'post',
		'side',
		'default'
	);

	add_meta_box(
		'portal-post-sidebar',
		esc_html__( 'Portal Post Sidebar', 'portal' ),
		'portal_post_sidebar',
		'post',
		'side',
		'default'
	);

	add_meta_box(
		'portal-page-options',
		esc_html__( 'Portal Page Options', 'portal' ),
		'portal_page_options',
		'page',
		'side',
		'default'
	);

	add_meta_box(
		'portal-page-templates',
		esc_html__( 'Portal Blog/Portfolio Template', 'portal' ),
		'portal_page_templates',
		'page',
		'side',
		'default'
	);

	add_meta_box(
		'portal-page-gallery',
		esc_html__( 'Portal Page Gallery Template', 'portal' ),
		'portal_page_gallery',
		'page',
		'side',
		'default'
	);

	add_meta_box(
		'portal-revolution',
		esc_html__( 'Full Width Revolution Slider', 'portal' ),
		'portal_revolution',
		'page',
		'normal',
		'default'
	);

}

function portal_page_options( $object, $box ) { ?>
	<p>
		<label for="portal-page-padding"><input value="" type="checkbox" name="portal-page-padding" id="portal-page-padding" <?php if ( 1 == get_post_meta( $object->ID, 'portal_page_padding', true ) ) echo 'checked="checked"'; ?>> <?php _e( "Remove page padding", 'portal' ); ?></label>
	</p>
	<p>
		<label for="portal-content-width"><?php _e( "Set page content width (e.g. 1200)", 'portal' ); ?></label>
		<br />
		<input class="widefat" type="text" name="portal-content-width" id="portal-content-width" value="<?php echo esc_attr( get_post_meta( $object->ID, 'portal_content_width', true ) ); ?>" />
	</p>
<?php
}

function portal_post_type( $object, $box ) { ?>
	<?php wp_nonce_field( basename( __FILE__ ), 'portal_post_text_nonce' ); ?>
	<p>
		<label for="portal-featured-area"><?php _e( "Select featured area content", 'portal' ); ?> :</label>
		<br />
		<?php
			$feat_areas = array (
					'none' => __('None', 'portal'),
					'image' => __('Featured image parallax', 'portal'),
					'paralax' => __('Featured image parallax with title', 'portal'),
					'gallery' => __('Featured image/video on left', 'portal'),
					'video' => __('Video', 'portal'),
					'videolax' => __('Parallax Video', 'portal')
				);
			$current = get_post_meta( $object->ID, 'portal_post_type', true );
			if ( $current == '' ) {
				$current = 'none';
			}
			foreach ( $feat_areas as $s => $v ) :
		?>
		<br />
		<input type="radio" name="portal-post-style" id="portal-post-style" value="<?php echo $s; ?>" <?php echo ( ( $s == $current ) ? 'checked' : '' ); ?>/> <?php echo $v; ?>
		<?php endforeach; ?>
	</p>
	<p>
		<label for="portal-video-override"><?php _e( "Set featured area video embed (MP4).", 'portal' ); ?></label>
		<br />
		<textarea class="widefat" type="text" name="portal-video-override" id="portal-video-override"><?php echo esc_attr( get_post_meta( $object->ID, 'portal_video_override', true ) ); ?></textarea>
	</p>
	<p>
		<label for="portal-video-override"><?php _e( "Set featured area video embed (OGG).", 'portal' ); ?></label>
		<br />
		<textarea class="widefat" type="text" name="portal-video-override-ogg" id="portal-video-override-ogg"><?php echo esc_attr( get_post_meta( $object->ID, 'portal_video_override_ogg', true ) ); ?></textarea>
	</p>
	<p>
		<label for="portal-show-title"><input value="" type="checkbox" name="portal-show-title" id="portal-show-title" <?php if ( 1 == get_post_meta( $object->ID, 'portal_show_title', true ) ) echo 'checked="checked"'; ?>> <?php _e( "Hide post title", 'portal' ); ?></label>
	</p>
	<p>
		<label for="portal-show-meta"><input value="" type="checkbox" name="portal-show-meta" id="portal-show-meta" <?php if ( 1 == get_post_meta( $object->ID, 'portal_show_meta', true ) ) echo 'checked="checked"'; ?>> <?php _e( "Hide post meta", 'portal' ); ?></label>
	</p>
	<p>
		<label for="portal-show-tags"><input value="" type="checkbox" name="portal-show-tags" id="portal-show-tags" <?php if ( 1 == get_post_meta( $object->ID, 'portal_show_tags', true ) ) echo 'checked="checked"'; ?>> <?php _e( "Hide post tags", 'portal' ); ?></label>
	</p>
	<p>
		<label for="portal-fullscreen"><input value="" type="checkbox" name="portal-fullscreen" id="portal-fullscreen" <?php if ( 1 == get_post_meta( $object->ID, 'portal_fullscreen', true ) ) echo 'checked="checked"'; ?>> <?php _e( "Remove padding", 'portal' ); ?></label>
	</p>
	<p>
		<label for="portal-content-width"><?php _e( "Set page content width (e.g. 1200)", 'portal' ); ?></label>
		<br />
		<input class="widefat" type="text" name="portal-content-width" id="portal-content-width" value="<?php echo esc_attr( get_post_meta( $object->ID, 'portal_content_width', true ) ); ?>" />
<?php }

function portal_post_sidebar( $object, $box ) { ?>
	<p>
		<label for="portal-post-sidebar"><?php _e( "Select sidebar to use with this post. You can create additional sidebars in Appearance > Theme Options", 'portal' ); ?></label>
		<br /><br />
		<select name="portal-post-sidebar" id="portal-post-sidebar">
		<?php
			$current = get_post_meta( $object->ID, 'portal_post_sidebar', true );

			global $portal_data;
			$sidebars = array();
			$sidebar = $portal_data['sidebar'];

			$sidebars[] = 'none';
			foreach ( $sidebar as $single_sidebar ) {
				$title = sanitize_title( $single_sidebar['title'] );
				if ( $title !== '' ) $sidebars[] = $title;
			}

			foreach ( $sidebars as $sidebar ) :
				printf( '<option value="%1$s" %2$s>%1$s</option>', $sidebar, ( ( $sidebar == $current ) ? 'selected' : '' ) );
			endforeach;
		?>
		</select>
	</p>

<?php }

function portal_page_templates( $object, $box ) { ?>
	<?php wp_nonce_field( basename( __FILE__ ), 'portal_post_text_nonce' ); ?>
	<p>
		<label for="portal-selected-category"><?php _e( "Select category for Blog/Portfolio page templates", 'portal' ); ?> :</label>
		<br /><br />
<?php
	$args = array(
		'selected' => get_post_meta( $object->ID, 'portal_selected_category', true ),
		'name' => 'portal-selected-category',
		'id' => 'portal-selected-category',
		'class' => 'widefat',
	);
	wp_dropdown_categories( $args );
?>
	</p>
<?php }

function portal_page_gallery( $object, $box ) { ?>
	<p>
		<label for="portal-featured-area"><?php _e( "Select page gallery template background content", 'portal' ); ?> :</label>
		<br />
		<?php
			$feat_areas = array (
					'none' => __('None', 'portal'),
					'image' => __('Featured Image', 'portal'),
					'video' => __('Video', 'portal'),
				);
			$current = get_post_meta( $object->ID, 'portal_post_type', true );
			if ( $current == '' ) {
				$current = 'none';
			}
			foreach ( $feat_areas as $s => $v ) :
		?>
		<br />
		<input type="radio" name="portal-post-style" id="portal-post-style" value="<?php echo $s; ?>" <?php echo ( ( $s == $current ) ? 'checked' : '' ); ?>/> <?php echo $v; ?>
		<?php endforeach; ?>
	</p>
	<p>
		<label for="portal-video-override"><?php _e( "Override featured image with a video. Enter video URL (MP4).", 'portal' ); ?></label>
		<br />
		<textarea class="widefat" type="text" name="portal-video-override" id="portal-video-override"><?php echo esc_attr( get_post_meta( $object->ID, 'portal_video_override', true ) ); ?></textarea>
	</p>
	<p>
		<label for="portal-video-override-ogg"><?php _e( "Override featured image with a video. Enter video URL (OGG).", 'portal' ); ?></label>
		<br />
		<textarea class="widefat" type="text" name="portal-video-override-ogg" id="portal-video-override-ogg"><?php echo esc_attr( get_post_meta( $object->ID, 'portal_video_override_ogg', true ) ); ?></textarea>
	</p>
<?php }

function portal_revolution( $object, $box ) { ?>
	<?php wp_nonce_field( basename( __FILE__ ), 'portal_revolution_nonce' ); ?>
	<?php
		if ( in_array( 'revslider/revslider.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			global $wpdb;
			$revsliders = array();
			$revsliders[] = 'none';
			$current = get_post_meta( $object->ID, 'portal_revolution', true );
			if ( $current == '' ) {
				$current = 'none';
			}
			$get_sliders = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'revslider_sliders');
			if($get_sliders) {
				foreach($get_sliders as $slider) {
					$revsliders[$slider->alias] = $slider->alias;
				}
			}
			else {
				$revsliders = array ( 'none' => 'none' );
			}
		}
		else {
			$revsliders = array ( 'none' => 'none' );
		}
	?>
	<p>
		<label for="portal-revolution"><?php _e( "Select Revolution Slider template to use one this page. This slider will be shown just bellow main navigation in full width.", 'portal' ); ?></label>
		<br /><br />
		<select name="portal-revolution" id="portal-revolution">
		<?php
			foreach ( $revsliders as $slider ) :
				printf( '<option value="%1$s" %2$s>%1$s</option>', $slider, ( ( $slider == $current ) ? 'selected' : '' ) );
			endforeach;
		?>
		</select>
	</p>
<?php }

function portal_save_post_meta_boxes( $post_id, $post ) {

	if ( !isset( $_POST['portal_post_text_nonce'] ) || !wp_verify_nonce( $_POST['portal_post_text_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );

	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	$new_meta_values = array();
	
	$new_meta_values[] = ( isset( $_POST['portal-post-style'] ) ? $_POST['portal-post-style'] : '' );
	$new_meta_values[] = ( isset( $_POST['portal-post-sidebar'] ) ? $_POST['portal-post-sidebar'] : '' );
	$new_meta_values[] = ( isset( $_POST['portal-show-title'] ) ? 1 : 0 );
	$new_meta_values[] = ( isset( $_POST['portal-show-meta'] ) ? 1 : 0 );
	$new_meta_values[] = ( isset( $_POST['portal-show-tags'] ) ? 1 : 0 );
	$new_meta_values[] = ( isset( $_POST['portal-fullscreen'] ) ? 1 : 0 );
	$new_meta_values[] = ( isset( $_POST['portal-video-override'] ) ? $_POST['portal-video-override'] : '' );
	$new_meta_values[] = ( isset( $_POST['portal-video-override-ogg'] ) ? $_POST['portal-video-override-ogg'] : '' );
	$new_meta_values[] = ( isset( $_POST['portal-selected-category'] ) ? $_POST['portal-selected-category'] : '' );
	$new_meta_values[] = ( isset( $_POST['portal-revolution'] ) ? $_POST['portal-revolution'] : '' );
	$new_meta_values[] = ( isset( $_POST['portal-page-padding'] ) ? 1 : 0 );
	$new_meta_values[] = ( isset( $_POST['portal-content-width'] ) ? $_POST['portal-content-width'] : '' );



	$meta_keys = array();
	$meta_keys[] = 'portal_post_type';
	$meta_keys[] = 'portal_post_sidebar';
	$meta_keys[] = 'portal_show_title';
	$meta_keys[] = 'portal_show_meta';
	$meta_keys[] = 'portal_show_tags';
	$meta_keys[] = 'portal_fullscreen';
	$meta_keys[] = 'portal_video_override';
	$meta_keys[] = 'portal_video_override_ogg';
	$meta_keys[] = 'portal_selected_category';
	$meta_keys[] = 'portal_revolution';
	$meta_keys[] = 'portal_page_padding';
	$meta_keys[] = 'portal_content_width';

	$meta_values = array();
	
	$i = 0;
	
	foreach ( $meta_keys as $meta_key ) {
		
		$meta_value = get_post_meta( $post_id, $meta_key, true );	
		
		if ( $new_meta_values[$i] && '' == $meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_values[$i], true );

		elseif ( $new_meta_values[$i] && $new_meta_values[$i] != $meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_values[$i] );

		elseif ( '' == $new_meta_values[$i] && $meta_value )
			delete_post_meta( $post_id, $meta_key, $meta_value );

		$i++;

	}

}

// Portal Pagination
function portal_pagination($pages = '', $page = '', $range = 2) {
	if ( $page == '' ) {
		global $paged;
		if ( empty( $paged ) ) $paged = 1;
	}
	else {
	$paged = $page;
	}
	$next_page = $paged + 1;
	$prev_page = $paged - 1;
	$showitems = 5;  
	$out = '';

	if ( $pages == '' ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if ( !$pages ) {
			$pages = 1;
		}
	}

	if ( 1 != $pages ) {
		$out .= "<nav class='pagination_wrapper text-center fullwidth'><div class='inline-block'><ul>";

		for ( $i = 1; $i <= $pages; $i++ ) {
			if ( 1 != $pages && ( !( $i >= $paged + 2 || $i <= $paged - 2) || $pages <= $showitems ) ) {
				$out .= ( $paged == $i ) ? "<li class=\"current\"><a>" . $i . "</a></li>" : "<li class=\"inactive\"><a title='" . __( 'View page number', 'portal' ) . " " . $i . "' href='" . get_pagenum_link( $i ) . "'>" . $i . "</a></li>";
			}
			elseif ( $i == $paged + 2 ) {
				$out .= '<li class="p_disabled"><a>...</a></li>';
			}
			elseif ( $i == $paged - 2 ) {
				$out .= '<li class="p_disabled"><a>...</a></li>';
			}

		}

		if ( $paged > 1 ) $out .= "<li class=\"previous\"><a title=\"" . __( 'View earlier posts', 'portal' ) . "\" href=\"" . get_pagenum_link( $paged - 1 ) . "\"  hover-background-color-main background-color-passive\" >&lt; ".__('previous posts', 'portal')."</a></li>";
		if ( $paged < $pages ) $out .= "<li class=\"next\"><a title=\"" . __( 'View newer posts', 'portal' ) . "\" href='".get_pagenum_link( $paged + 1 )."' >".__('next posts', 'portal')." &gt;</a></li>";
		$out .= "</ul><div class=\"clearfix\"></div></div></nav>";
	}
	return $out;
}

// Twitter OAuth
include_once('lib/twitteroauth/twitteroauth.php');

// Twitter OAuth helper function
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
	$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	return $connection;
}

// Twitted Feed
function portal_twitter_feed($user = 'twitter', $count = '5'){
	$transient_key = $user . "_twitter_" . $count;
	$cached = get_transient( $transient_key );

	if ( false !== $cached ) {
		return $cached .= "\n" . '<!-- Returned from cache -->';
	}

	global $portal_data;
	$output = '';
	$i = 1;

	$twitteruser = $user;
	$notweets = $count;

	$consumerkey = $portal_data['twitter_ck'];
	$consumersecret = $portal_data['twitter_cs'];
	$accesstoken = $portal_data['twitter_at'];
	$accesstokensecret = $portal_data['twitter_ats'];

	$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
	$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
	$data = json_decode( json_encode($tweets) );
	if ( is_array( $data ) ) :
	$output .= '<ul class="tweets-list list_null">';
	while ( $i <= $count ) {
		if( isset( $data[$i-1] ) ) {
			$feed = $data[( $i - 1 )]->text;
			$feed = str_pad( $feed, 3, ' ', STR_PAD_LEFT );
			$startat = stripos( $feed, '@' );
			$numat = substr_count( $feed, '@' );
			$numhash = substr_count( $feed, '#' );
			$numhttp = substr_count( $feed, 'http' );
			$feed = preg_replace( "#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $feed );
			$feed = preg_replace( "#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $feed );
			$feed = preg_replace( "/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $feed );
			$feed = preg_replace( "/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $feed );
			$output .= sprintf('
			<li class="relative"><a href="http://www.twitter.com/%3$s" title="%4$s"><i class="tw_icon fa fa-twitter"></i></a><div class="tweet-post padding-left48">%1$s</div>%2$s</li>', $feed, portal_time_ago( strtotime( $data[($i-1)]->created_at ) ), $user, __('Visit us on twitter.com', 'portal') );
		}
		$i++;
	}
	$output .= '</ul>';
	set_transient( $transient_key, $output, 1800 );
	set_transient( $transient_key.'_backup', $output );
	return $output;
	else :
	$cached = get_transient( $transient_key.'_backup' );
	if ( false !== $cached ) {
		return $cached .= "\n" . '<!-- Returned from backup cache -->';
	}
	else {
		return __('Twitter unaviable', 'portal');	
	}
	endif;
}

// Time ago Portal
function portal_time_ago($date) {
	$chunks = array(
		array( 60 * 60 * 24 * 365 , __( 'year', 'portal' ), __( 'years', 'portal' ) ),
		array( 60 * 60 * 24 * 30 , __( 'month', 'portal' ), __( 'months', 'portal' ) ),
		array( 60 * 60 * 24 * 7, __( 'week', 'portal' ), __( 'weeks', 'portal' ) ),
		array( 60 * 60 * 24 , __( 'day', 'portal' ), __( 'days', 'portal' ) ),
		array( 60 * 60 , __( 'hour', 'portal' ), __( 'hours', 'portal' ) ),
		array( 60 , __( 'minute', 'portal' ), __( 'minutes', 'portal' ) ),
		array( 1, __( 'second', 'portal' ), __( 'seconds', 'portal' ) )
	);
	if ( !is_numeric( $date ) ) {
		$time_chunks = explode( ':', str_replace( ' ', ':', $date ) );
		$date_chunks = explode( '-', str_replace( ' ', '-', $date ) );
		$date = gmmktime( (int)$time_chunks[1], (int)$time_chunks[2], (int)$time_chunks[3], (int)$date_chunks[1], (int)$date_chunks[2], (int)$date_chunks[0] );
	}
	$current_time = current_time( 'mysql', $gmt = 0 );
	$newer_date = strtotime( $current_time );
	$since = $newer_date - $date;
	if ( 0 > $since )
		return __( 'sometime', 'portal' );
	for ( $i = 0, $j = count($chunks); $i < $j; $i++) {
		$seconds = $chunks[$i][0];
		if ( ( $count = floor($since / $seconds) ) != 0 )
			break;
	}
	$output = '<div class="time-ago">';
	$output .= ( 1 == $count ) ? '1 <span class="text-ago">'. $chunks[$i][1] : $count . ' <span class="text-ago">' . $chunks[$i][2];

	$output .= ' '.__('ago', 'portal').'</span></div>';
	return $output;
}

// Tweeter Widget
class Portal_Twitter_Widget extends WP_Widget {
	function Portal_Twitter_Widget() {
		$widget_ops = array(
			'classname' => 'widget-portal-twitter twitter_module',
			'description' => __( 'Show your twitter feeds', 'portal' )
		);
		$this->WP_Widget( 'portal_twitter', '+ Portal Twitter', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$user = empty($instance['user']) ? '' : apply_filters( 'widget_user', $instance['user'] );
		$count = empty($instance['count']) ? '' : apply_filters( 'widget_count', $instance['count'] );
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } else { echo $before_title . __('Twitter Feed', 'portal') . $after_title; }

		echo portal_twitter_feed( $user, $count );
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['user'] = strip_tags( $new_instance['user'] );
		$instance['count'] = strip_tags( $new_instance['count'] );
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args(
		(array) $instance, array( 
			'title' => '',
			'user' => '',
			'count' => 5
		) );
		$title = strip_tags( $instance['title'] );
		$user = strip_tags( $instance['user'] );
		$count = strip_tags( $instance['count'] );
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'portal' ); ?> :</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id( 'user' ); ?>"><?php _e( 'User', 'portal' ); ?> :</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'user' ); ?>" name="<?php echo $this->get_field_name( 'user' ); ?>" type="text" value="<?php echo esc_attr( $user ); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Count', 'portal' ); ?> :</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" /></p>
<?php }
}
add_action( 'widgets_init', create_function('', 'return register_widget("Portal_Twitter_Widget");' ) );

// Portal Contact form
function portal_contact_form( $users = '1', $margin = ' style="margin-bottom:20px"' ) {
	global $portal_data, $portal_contact_form_id;

	if ( isset( $portal_data['contact'] ) ) $contact_options = $portal_data['contact'];
	if ( isset ( $portal_contact_form_id ) == false ) { global $portal_contact_form_id; $portal_contact_form_id = 1; }
	if( isset( $_POST['submitted-' . $portal_contact_form_id] ) ) {
		if( trim( $_POST['contactName'] ) === '' ) {
			$nameError = '<small>' . __( 'Please enter your name', 'portal' ) . '</small>';
			$hasError = true;
		} else {
			$name = trim( $_POST['contactName'] );
		}
		if( trim( $_POST['contactEmail'] ) === '' ) {
			$emailError = '<small>' . __( 'Please enter your email address', 'portal' ) . '</small>';
			$hasError = true;
		} else if ( !preg_match( "/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim( $_POST['contactEmail'] ) ) ) {
			$emailError = '<small>' . __('You entered an invalid email address', 'portal') . '</small>';
			$hasError = true;
		} else {
			$email = trim( $_POST['contactEmail'] );
		}
		if( trim( $_POST['contactWebsite'] ) !== '' ) {
			$website = trim( $_POST['contactWebsite'] );
		}
		if( trim( $_POST['commentsText'] ) === '' ) {
			$commentError = '<small>' . __( 'Please enter a message', 'portal' ) . '</small>';
			$hasError = true;
		} else {
			if ( function_exists( 'stripslashes' ) ) {
				$comments = stripslashes( trim( $_POST['commentsText'] ) );
			} else {
				$comments = trim( $_POST['commentsText'] );
			}
		}
		if ( !isset( $hasError ) ) {
		if ( $_POST['contactEmailSend'] == 'main' ) : $emailTo = $portal_data['main_contact']['email']; else : $emailTo = $contact_options[$_POST['contactEmailSend']]['email']; endif;
			$subject = get_bloginfo('name').' / From ' . $name;
			$body = "Name: $name \n\nEmail: $email \n\nWebsite: $website \n\nComments: $comments";
			$headers = 'From: ' . $name . ' <' . $emailTo . '>' . "\r\n" . 'Reply-To: ' . $email;
			wp_mail( $emailTo, $subject, $body, $headers );
			$emailSent = true;
		}
	}
	$output = '';
	$contactName = '';
	$contactEmail = '';
	$contactWebsite = '';
	$commentsText = '';

	$output .= sprintf( '<div class="contact_form_wrapper"%1$s>', $margin );
	if( isset( $emailSent ) && $emailSent == true ) {
		if ( $portal_data['contactform_message'] == '' ) {
			$output .= '<div class="success"><div class="margin-bottom20"><img src="'.$portal_data['logo'].'"/></div><i class="fa fa-thumbs-up"></i> '. __( 'Thanks, your email was sent successfully!', 'portal' ).'</div>';
		}
		else $output .= $portal_data['contactform_message'];
	}
	else {

		$permlink = get_permalink(get_the_ID());
		$output .= sprintf( '<form action="%1$s" class="comment_form contact_form" method="post">', $permlink );


		$output .= '<div class="input_wrapper_select margin-bottom20"><div>';
		if( isset( $hasError ) || isset( $captchaError ) ) {
			$output .= '<span class="error send block"><i class="fa fa-exclamation color-red"></i> '.__( 'Sorry, an error occured', 'portal' ).'</span>';
		}
		$output .= '<select name="contactEmailSend" class="input_field_select block" >';
		if ( $portal_data['contact'] ) :
			$i = 1;
			$users_array = explode( ',', $users );
			if ( !is_array ( $users_array ) ) { $users_array[] = $users; }			
			foreach ( $contact_options as $option ) {
				if ( in_array ( $i, $users_array ) ) { $output .= '<option value="'. $i .'">'. $option['name'] .'</option>'; }
				$i++;
			}
		endif;
		$output .= '</select>';
		$output .= '</div></div>';

		if ( isset( $_POST['contactEmail'] ) ) $contactEmail = $_POST['contactEmail'];

		$output .= '<div class="input_wrapper">';
		if( isset( $emailError ) ) {
			$output .= '<span class="error block"><i class="fa fa-exclamation color-red"></i> '. $emailError .'</span>';
		}
		$output .= sprintf('<input type="text" name="contactEmail" class="input_field block margin-bottom20" value="%1$s" placeholder="%2$s"/>', $contactEmail, __('EMAIL ADDRESS', 'portal') );

		$output .= '</div>';

		if ( isset( $_POST['contactName'] ) ) $contactName = $_POST['contactName'];

		$output .= '<div class="input_wrapper">';
		if( isset( $nameError ) ) {
			$output .= '<span class="error block"><i class="fa fa-exclamation color-red"></i> '. $nameError .'</span>';
		}
		$output .= sprintf('<input type="text" name="contactName" class="input_field block margin-bottom20" value="%1$s" placeholder="%2$s"/>', $contactName, __('NAME', 'portal') );

		$output .= '</div>';

		if ( isset( $_POST['contactEmail'] ) )  $contactEmail = $_POST['contactEmail'];

		$output .= '<div class="input_wrapper">';
		if( isset( $nameError ) ) {
			$output .= '<span class="error block"><i class="fa fa-blank"></i></span>';
		}
		$output .= sprintf('<input type="text" name="contactWebsite" class="input_field block margin-bottom20" value="%1$s" placeholder="%2$s"/>', $contactWebsite, __('WEBSITE', 'portal') );
		$output .= '</div>';

		if( isset( $_POST['commentsText'] ) ) { if ( function_exists( 'stripslashes' ) ) { $commentsText = stripslashes( $_POST['commentsText'] ); } else { $commentsText = $_POST['commentsText']; } }

		$output .= '<textarea name="commentsText" class="textarea_field block margin-bottom20"  placeholder="'.__('MESSAGE GOES HERE (MAX 300 CHARS)', 'portal').'">'. $commentsText .'</textarea>';
		if( isset( $commentError ) ) {
			$output .= '<span class="error block"><i class="fa fa-exclamation color-red"></i> '. $commentError .'</span>';
		}



		$output .= '<input type="hidden" name="submitted-'. $portal_contact_form_id .'" value="true" /><input class="portal_button block bg_color_default bg_color_main_hover color_white float_right" type="submit" value="'.__('Send Email', 'portal').'" />';
		$output .= '<div class="clearfix"></div>';
		$output .= '</form>';
	}
	$output .= '</div>';
	$portal_contact_form_id++;	
	return $output;		
}


include_once('portal-fbuilder.php');


// Custom widget walker frontend

class Walker_Nav_Menu_Widgets extends Walker {

	var $tree_type = array( 'post_type', 'taxonomy', 'custom' );

	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	function start_lvl( &$output, $depth = 0, $args = array() ) {

		global $current_menu_id;
		if ( $current_menu_id['sidebar'] !== 'none' ) {
			return;
		}
		if ( ( $depth > 1 && $current_menu_id['fullwidth'] == 'fullwidth' ) ) {
			return;
		}

		$indent = str_repeat("\t", $depth);
		if ( $depth == 0 ) {
		$output .= sprintf('%1$s<ul class="sub-menu navmenu_%2$s navmenu_columns_%3$s">', $indent, $current_menu_id['fullwidth'], $current_menu_id['columns'] );
		}
		else {
			$output .= "\n$indent<ul class=\"sub-menu\">\n";
		}

	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {

		global $current_menu_id;
		if ( $current_menu_id['sidebar'] !== 'none' ) {
			return;
		}

		if ( ( $depth > 1 && $current_menu_id['fullwidth'] == 'fullwidth' ) ) {
			return;
		}
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		global $current_menu_id;
		if ( $depth > 0 && $current_menu_id['sidebar'] !== 'none' ) {
			return;
		}
		if ( ( $depth > 2 && $current_menu_id['fullwidth'] == 'fullwidth' ) ) {
			return;
		}

		if ( $depth == 0 ) {
			$current_menu_id['id'] = $item->ID;
			$current_menu_id['fullwidth'] = ( isset($item->fullwidth) ? $item->fullwidth : 'nofullwidth' );
			$current_menu_id['columns'] = ( isset($item->columns) ? $item->columns : 'none' );
			$current_menu_id['sidebar'] = ( isset($item->sidebar) ? $item->sidebar : 'none' );
		}

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		if ( $depth == 0 && $current_menu_id['sidebar'] !== 'none' ) {
			$classes[] = 'has_sidebar';
		}
		else {
			$classes[] = 'hasno_sidebar';
		}
		if ( $depth == 0 && $current_menu_id['fullwidth'] == 'fullwidth' ) {
			$classes[] = 'is_fullwidth';
			$classes[] = 'is_columns-'.$current_menu_id['columns'];
		}
		else {
			$classes[] = 'hasno_fullwidth';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		if ( $current_menu_id['sidebar'] == 'none' ) :

			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;
		elseif ( $depth == 0 && $current_menu_id['sidebar'] !== 'none' ) :
			ob_start();
			dynamic_sidebar( $current_menu_id['sidebar'] );
			$sidebar = ob_get_contents();
			ob_end_clean();
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= sprintf( '<ul class="sub-menu navmenu_sidebar navmenu_columns_%3$s navmenu_%2$s%4$s"><li class="sidebar_holder"><div class="row">%1$s<div class="clearfix"></div></div></li>', $sidebar, $current_menu_id['fullwidth'], $current_menu_id['columns'], ( $current_menu_id['fullwidth'] == 'fullwidth' ? ' large-variant' : '' ) );

			if ( $current_menu_id['columns'] !== 'none') {
				switch ($current_menu_id['columns']) :
				case '1':
				$bootstrap_cols = '12';
				break;
				case '2':
				$bootstrap_cols = '6';
				break;
				case '3':
				$bootstrap_cols = '4';
				break;
				case '4':
				$bootstrap_cols = '3';
				break;
				case '5':
				$bootstrap_cols = '5-5';
				break;
				endswitch;
				$item_output .= '<div class="footer_lines"><div class="row">';
				for ($i = 1; $i <= $current_menu_id['columns']; $i++){
					$item_output .= sprintf( '<div class="col-md-%1$s"><div class="line margin-top20 margin-bottom10"></div></div>', $bootstrap_cols );
				}
				$item_output .= '</div></div>';
			}

			
			$item_output .= '</ul>';
			$item_output .= $args->after;
		else :
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

		endif;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		global $current_menu_id;
		if ( $depth > 0 && $current_menu_id['sidebar'] !== 'none' ) {
			return;
		}
		if ( ( $depth > 2 && $current_menu_id['fullwidth'] == 'fullwidth' ) ) {
			return;
		}
		$output .= "</li>\n";
	}
}

// Save nav-menu fields

add_action('wp_update_nav_menu_item', 'portal_custom_nav_update',10, 3);
function portal_custom_nav_update($menu_id, $menu_item_db_id, $args ) {

	if ($args['menu-item-parent-id'] == 0 ){

		if ( isset($_REQUEST['menu-item-fullwidth']) && is_array($_REQUEST['menu-item-fullwidth']) && array_key_exists( $menu_item_db_id, $_REQUEST['menu-item-fullwidth']) ) {
			$custom_value = $_REQUEST['menu-item-fullwidth'][$menu_item_db_id];
			update_post_meta( $menu_item_db_id, '_menu_item_fullwidth', $custom_value );
		}
		else {
			update_post_meta( $menu_item_db_id, '_menu_item_fullwidth', '0' );
		}

		if ( isset($_REQUEST['menu-item-columns']) && is_array($_REQUEST['menu-item-columns']) ) {
			$custom_value = $_REQUEST['menu-item-columns'][$menu_item_db_id];
			update_post_meta( $menu_item_db_id, '_menu_item_columns', $custom_value );
		}

		if ( isset($_REQUEST['menu-item-sidebar']) && is_array($_REQUEST['menu-item-sidebar']) ) {
			$custom_value = $_REQUEST['menu-item-sidebar'][$menu_item_db_id];
			update_post_meta( $menu_item_db_id, '_menu_item_sidebar', $custom_value );
		}
	}

}

// Add nav-menu fields

add_filter( 'wp_setup_nav_menu_item','portal_custom_nav_item' );
function portal_custom_nav_item($menu_item) {
	$menu_item->fullwidth = get_post_meta( $menu_item->ID, '_menu_item_fullwidth', true );
	$menu_item->columns = get_post_meta( $menu_item->ID, '_menu_item_columns', true );
	$menu_item->sidebar = get_post_meta( $menu_item->ID, '_menu_item_sidebar', true );

	return $menu_item;
}

// Custom edit walker

add_filter( 'wp_edit_nav_menu_walker', 'portal_custom_nav_edit_walker',10,2 );
function portal_custom_nav_edit_walker($walker,$menu_id) {
	return 'Walker_Nav_Menu_Edit_Custom';
}

// Custom widget walker backend

class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {

function start_lvl( &$output, $depth = 0, $args = array() ) {}

function end_lvl( &$output, $depth = 0, $args = array() ) {}

function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

	global $_wp_nav_menu_max_depth;
	$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

	$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    ob_start();
    $item_id = esc_attr( $item->ID );
    $removed_args = array(
        'action',
        'customlink-tab',
        'edit-menu-item',
        'menu-item',
        'page-tab',
        '_wpnonce',
    );

    $original_title = '';
    if ( 'taxonomy' == $item->type ) {
        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
        if ( is_wp_error( $original_title ) )
            $original_title = false;
    } elseif ( 'post_type' == $item->type ) {
        $original_object = get_post( $item->object_id );
        $original_title = $original_object->post_title;
    }

    $classes = array(
        'menu-item menu-item-depth-' . $depth,
        'menu-item-' . esc_attr( $item->object ),
        'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
    );

    $title = $item->title;

    if ( ! empty( $item->_invalid ) ) {
        $classes[] = 'menu-item-invalid';
        /* translators: %s: title of menu item which is invalid */
        $title = sprintf( __( '%s (Invalid)' ), $item->title );
    } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
        $classes[] = 'pending';
        /* translators: %s: title of menu item in draft status */
        $title = sprintf( __('%s (Pending)'), $item->title );
    }

    $title = empty( $item->label ) ? $title : $item->label;

    ?>
    <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
        <dl class="menu-item-bar">
            <dt class="menu-item-handle">
                <span class="item-title"><?php echo esc_html( $title ); ?></span>
                <span class="item-controls">
                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                    <span class="item-order hide-if-js">
                        <a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-up-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                        ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
                        |
                        <a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-down-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                        ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
                    </span>
                    <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                    ?>"><?php _e( 'Edit Menu Item' ); ?></a>
                </span>
            </dt>
        </dl>

        <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
            <?php if( 'custom' == $item->type ) : ?>
                <p class="field-url description description-wide">
                    <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                        <?php _e( 'URL' ); ?><br />
                        <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                    </label>
                </p>
            <?php endif; ?>
            <p class="description description-thin">
                <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                    <?php _e( 'Navigation Label' ); ?><br />
                    <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                </label>
            </p>
            <p class="description description-thin">
                <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                    <?php _e( 'Title Attribute' ); ?><br />
                    <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                </label>
            </p>
            <p class="field-link-target description">
                <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                    <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
                    <?php _e( 'Open link in a new window/tab' ); ?>
                </label>
            </p>
            <p class="field-css-classes description description-thin">
                <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                    <?php _e( 'CSS Classes (optional)' ); ?><br />
                    <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                </label>
            </p>
            <p class="field-xfn description description-thin">
                <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                    <?php _e( 'Link Relationship (XFN)' ); ?><br />
                    <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                </label>
            </p>
            <p class="field-description description description-wide">
                <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                    <?php _e( 'Description' ); ?><br />
                    <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                    <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.'); ?></span>
                </label>
            </p>
			<?php if ($depth == 0) : ?>

			<p class="field-custom fullwidth_checkbox">
				<label for="edit-menu-item-fullwidth-<?php echo $item_id; ?>">
					<input type="checkbox" id="edit-menu-item-fullwidth-<?php echo $item_id; ?>" value="fullwidth" name="menu-item-fullwidth[<?php echo $item_id; ?>]"<?php checked( $item->fullwidth, 'fullwidth' ); ?> />
					<?php _e( 'Mega menu container<br/><small>Makes a mega menu container. Choose up to 5 columns. Add widgets by inserting sidebar or instead use plain menu items.</small>', 'portal' ); ?>
				</label>
			</p>
			<?php $current = esc_attr( $item->columns ); ?>
			<p class="field-custom columns_number">
			<label for="edit-menu-item-columns-<?php echo $item_id; ?>">
				<?php _e( 'Columns', 'portal' ); ?>
				<select name="menu-item-columns[<?php echo $item_id; ?>]" id="edit-menu-item-columns-<?php echo $item_id; ?>"  class="widefat code edit-menu-item-columns">
				<?php
					for ($i = 1; $i <= 5; $i++) :
						printf('<option value="%1$s"%2$s>%1$s</option>', $i, ( ( $i == $current ) ? ' selected' : '' ) );
					endfor;
				?>
				</select>
			</label>
			</p>
			<p class="field-custom sidebar">
			<label for="edit-menu-item-sidebar-<?php echo $item_id; ?>">
				<?php _e( 'Sidebar', 'portal' ); ?><br />
				<select name="menu-item-sidebar[<?php echo $item_id; ?>]" id="edit-menu-item-sidebar-<?php echo $item_id; ?>"  class="widefat code edit-menu-item-sidebar">
				<?php
					$current = esc_attr( $item->sidebar );

					global $portal_data;
					$sidebars = array();
					$sidebar = $portal_data['sidebar'];

					$sidebars[] = 'none';
					foreach ( $sidebar as $single_sidebar ) {
						$title = sanitize_title( $single_sidebar['title'] );
						if ( $title !== '' ) $sidebars[] = $title;
					}

					foreach ( $sidebars as $sidebar ) :
						printf( '<option value="%1$s" %2$s>%1$s</option>', $sidebar, ( ( $sidebar == $current ) ? 'selected' : '' ) );
					endforeach;
				?>
				</select>
			</label>
			</p>
			<?php endif; ?>
            <div class="menu-item-actions description-wide submitbox">
                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                    <p class="link-to-original">
                        <?php printf( __('Original: %s'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                    </p>
                <?php endif; ?>
                <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                echo wp_nonce_url(
                    add_query_arg(
                        array(
                            'action' => 'delete-menu-item',
                            'menu-item' => $item_id,
                        ),
                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                    ),
                    'delete-menu_item_' . $item_id
                ); ?>"><?php _e('Remove'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                    ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel'); ?></a>
            </div>

            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
        </div><!-- .menu-item-settings-->
        <ul class="menu-item-transport"></ul>
    <?php

	$output .= ob_get_clean();
	}
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

}

// Add nav-menus css 

add_action( "admin_print_styles", 'portal_menus' );
function  portal_menus() {
	global $pagenow;

	if ( $pagenow != 'nav-menus.php' )
		return;
	wp_enqueue_style('nav-menu', get_template_directory_uri() . '/css/nav-menus.css');

}

// Portal List Pages
function portal_list_pages(){
	global $portal_data;
	echo '<ul class="'.( $portal_data['header_menu'] == 'portal_menu' ? 'header_menu' : 'header_menu_default' ).'">';
	wp_list_pages( array( 'title_li' => '', 'depth' => '1' ));
	echo '</ul>';
	return;
}

?>