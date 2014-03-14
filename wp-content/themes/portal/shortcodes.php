<?php
/**
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

add_filter( 'widget_text', 'do_shortcode' );

global $portal_data, $fbuilder;
$counter = 0;

$portal_categories = get_categories(array('order'=>'desc'));
$portal_ready_categories = array( '-1' => __('All', 'portal') );

foreach ( $portal_categories as $category ) {
	$counter++;
	$portal_ready_categories = $portal_ready_categories + array($category->term_id=>$category->name);
}

$portal_ready_contacts = array();
$counter = 0;

if ( is_array( $portal_data['contact'] ) ) $portal_contacts = $portal_data['contact']; else return;
foreach ( $portal_contacts as $contact ) {
	$counter++;
	$portal_ready_contacts = $portal_ready_contacts+array($counter=>$contact['name']);
}

$portal_shortcodes = array (
	'portal_tabs' => array(
		'type' => 'draggable',
		'text' => __('Tabs','portal'),
		'icon' => get_template_directory_uri() . '/images/fbuilderportal.png',
		'function' => 'portal_tabs',
		'options' => array(
			'sortable' => array(
				'type' => 'sortable',
				'label' => __('Tab elements','portal'),
				'desc' => __('Elements are sortable','portal'),
				'item_name' => __('tab item','portal'),
				'std' => array(
					'items' => array(
						0 => array(
							'title' => 'Lorem ipsum',
							'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
							'active' => 'true'
						),
						1 => array(
							'title' => 'Lorem ipsum',
							'content' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.',
							'active' => 'false'
						),
						2 => array(
							'title' => 'Lorem ipsum',
							'content' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
							'active' => 'false'
						)
					),
					'order' => array(
						0 => 0,
						1 => 1,
						2 => 2
					)
				),
				'options'=> array(
					'title' => array(
						'type' => 'input',
						'label' => __('Title','portal')
					),
					'content' => array(
						'type' => 'textarea',
						'label' => __('Content','portal')
					),
					'active' => array(
						'type' => 'checkbox',
						'label' => __('Active','frontend-builder'),
						'desc' => __('Only one panel can be active at a time, so be sure to uncheck the others for it to work properly','frontend-builder')
					)
				)
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','portal'),
				'std' => 30,
				'unit' => 'px'
			)
		)
	),
	'portal_accordion' => array(
		'type' => 'draggable',
		'text' => __('Accordion','portal'),
		'icon' => get_template_directory_uri() . '/images/fbuilderportal.png',
		'function' => 'portal_accordion',
		'options' => array(
			'sortable' => array(
				'type' => 'sortable',
				'label' => __('Accordion elements','portal'),
				'desc' => __('Elements are sortable','portal'),
				'item_name' => __('tab item','portal'),
				'std' => array(
					'items' => array(
						0 => array(
							'title' => 'Lorem ipsum',
							'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
							'active' => 'true'
						),
						1 => array(
							'title' => 'Lorem ipsum',
							'content' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.',
							'active' => 'false'
						),
						2 => array(
							'title' => 'Lorem ipsum',
							'content' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
							'active' => 'false'
						)
					),
					'order' => array(
						0 => 0,
						1 => 1,
						2 => 2
					)
				),
				'options'=> array(
					'title' => array(
						'type' => 'input',
						'label' => __('Title','portal')
					),
					'content' => array(
						'type' => 'textarea',
						'label' => __('Content','portal')
					),
					'active' => array(
						'type' => 'checkbox',
						'label' => __('Active','frontend-builder'),
						'desc' => __('Only one panel can be active at a time, so be sure to uncheck the others for it to work properly','frontend-builder')
					)
				)
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','portal'),
				'std' => 30,
				'unit' => 'px'
			)
		)
	),
	'portal_bar' => array(
		'type' => 'draggable',
		'text' => __('Progress Bar','portal'),
		'icon' => get_template_directory_uri() . '/images/fbuilderportal.png',
		'function' => 'portal_bar',
		'options' => array(
			'title' => array(
				'type' => 'input',
				'label' => __('Title Text','portal'),
				'std' => 'Title'
				),
			'per_cent' => array(
				'type' => 'number',
				'label' => __('Hom much?','portal'),
				'std' => 50,
				'min' => 0,
				'max' => 100,
				'unit' => '%'
				),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','portal'),
				'std' => 30,
				'unit' => 'px'
			)
		)
	),
	'portal_slider' => array(
		'type' => 'draggable',
		'text' => __('Slider','portal'),
		'icon' => get_template_directory_uri() . '/images/fbuilderportal.png',
		'function' => 'portal_slider',
		'options' => array(
			'post_count' => array(
				'type' => 'number',
				'label' => __('Number of posts','portal'),
				'std' => '',
				'std' => 50,
				'min' => 1,
				'max' => 20
				),
			'category' => array(
				'type' => 'select',
				'label' => __('Select categories. Use CTRL+Click to select multiple categories.','portal'),
				'std' => '-1',
				'options' => $portal_ready_categories,
				'search' => 'true',
				'multiselect' => 'true'
				),
			'excerpt_lenght' => array(
				'type' => 'number',
				'min' => 0,
				'label' => __('Excerpt lenght','portal'),
				'max' => 999,
				'std' => 128,
				'unit' => ''
			),
			'orderby' => array(
				'type' => 'select',
				'label' => __('Sort Posts By','portal'),
				'std' => 'date',
				'options' => array (
					'comment_count'=> __('By comment count', 'portal'),
					'date'=> __('By date', 'portal'),
					'title'=> __('By Title', 'portal'),
					'rand'=> __('Random', 'portal')
					)
				),
			'order' => array(
				'type' => 'select',
				'label' => __('Ascendic / Descendic','portal'),
				'std' => 'DESC',
				'options' => array (
					'ASC'=> __('Ascendic', 'portal'),
					'DESC'=> __('Descendic', 'portal')
					)
				),
			'ignoresticky' => array(
				'type' => 'checkbox',
				'std' => 'true',
				'label' => __('Ignore Sticky Posts <br/><small> Please note that sticky posts are available when displaying All categories (All categories ID / -1).</small>','portal')
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','portal'),
				'std' => 30,
				'unit' => 'px'
			)
		)
	),
	'portal_contactform' => array(
		'type' => 'draggable',
		'text' => __('Contact Form','portal'),
		'icon' => get_template_directory_uri() . '/images/fbuilderportal.png',
		'function' => 'portal_contactform',
		'options' => array(
			'users' => array(
				'type' => 'select',
				'label' => __('Select contact options. Use CTRL+Click to select more than one option.','portal'),
				'options' => $portal_ready_contacts,
				'search' => 'true',
				'multiselect' => 'true',
				'std' => '1'
				),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','portal'),
				'std' => 30,
				'unit' => 'px'
				)
			)
		)

	);

if ( isset($fbuilder) ) { $fbuilder->add_new_shortcodes($portal_shortcodes); }

$revsliders = array();

if ( in_array( 'revslider/revslider.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	global $wpdb;
	$get_sliders = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'revslider_sliders');
	if( $get_sliders ) {
		$default = $get_sliders[0]->alias;
		foreach( $get_sliders as $slider ) {
			$revsliders[$slider->alias] = $slider->title;
		}
	}
else {
	$default = array( 1 => __('No sliders set.', 'portal') );
}

	$revolution_slider = array (
		'portal_revslider' => array(
			'type' => 'draggable',
			'text' => __('Revolution Slider','portal'),
			'icon' => get_template_directory_uri() . '/images/fbuilderportal.png',
			'function' => 'portal_revslider',
			'options' => array(
				'slider' => array(
					'type' => 'select',
					'label' => __('Select slider','portal'),
					'std' => $default,
					'options' => $revsliders
					)
				),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','portal'),
				'std' => 30,
				'unit' => 'px'
				)
			)
		);

	if ( isset($fbuilder) ) { $fbuilder->add_new_shortcodes($revolution_slider); }

}

// [portal_revslider]
function portal_revslider( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'slider' => '',
		'bot_margin' => 30
	), $atts ) );
	
	if ( $slider == '' ) echo 'Please set slider.';
	return do_shortcode('[rev_slider '.$slider.']' );
}

// [portal_tabs]
function portal_tabs( $atts, $content = null ) {
	extract (shortcode_atts( array(
		'title' => '',
		'active' => '',
		'bot_margin' => 30,
		'class' => '',
		'custom_id' => ''
	), $atts ));

	$title = explode('|', $title);
	$content = explode('|', $content);
	$active = explode('|', $active);
	$custom_id = explode('|', $custom_id);
	$randomId = rand();

	$bot_margin = (int)$bot_margin;
	$margin = ' style="margin-bottom:'.$bot_margin.'px"';

	$html = '';

	$html .= '<div class="tabs" '.$margin.'><ul class="nav nav-tabs text-center">';
	
	if(is_array($title) && is_array($content)){
		for($i=0; $i<count($title); $i++) {
			$html .='<li'.($active[$i] == 'true' ? ' class="active"' : '').'><a href="'.(isset($custom_id[$i]) && $custom_id[$i] != '' ? '#'.$custom_id[$i] : '#tab'.$randomId.'_'.$i).'" data-toggle="tab">'.$title[$i].'</a></li>';
			
		}
	}
			
	$html .='</ul><div class="tab-content">';
	
	if(is_array($title) && is_array($content)){
		for($i=0; $i<count($title); $i++) {
			$html .= '<div id="'.(isset($custom_id[$i]) && $custom_id[$i] != '' ? $custom_id[$i] : 'tab'.$randomId.'_'.$i).'" class="tab-pane'.($active[$i] == 'true' ? ' active' : '').'">'.$content[$i].'<div style="clear:both;"></div></div>';
		}
	}

	$html .='</div></div>';

	return $html;
}

// [portal_accordion]
function portal_accordion( $atts, $content = null ) {
	extract (shortcode_atts( array(
		'title' => '',
		'active' => '',
		'bot_margin' => 30,
		'class' => '',
		'custom_id' => ''
	), $atts ));

	$title = explode('|', $title);
	$content = explode('|', $content);
	$active = explode('|', $active);
	$custom_id = explode('|', $custom_id);
	$randomId = rand();

	$bot_margin = (int)$bot_margin;
	$margin = ' style="margin-bottom:'.$bot_margin.'px"';

	$html = '';
	
	$html .= '<div id="accordion_'.$randomId.'" class="panel-group accordion"'.$margin.'>';
	
	if(is_array($title) && is_array($content)){
		for($i=0; $i<count($title); $i++) {
			$html .= '<div class="panel panel-default accordion-group"><div class="panel-heading"><div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_'.$randomId.'" href="#collapse__'.$randomId.'_'.$i.'"><span class="acc-tri"></span>'.$title[$i].'</a></div></div><div id="collapse__'.$randomId.'_'.$i.'" class="panel-collapse'.($active[$i] == 'true' ? ' collapse in' : ' collapse').'"><div class="panel-body">'.$content[$i].'</div></div></div>';
			$html .= '<div style="clear:both;"></div>';
		}
	}

	$html .='</div>';

	return $html;
}


// [portal_bar]
function portal_bar( $atts, $content = null ) {
	extract (shortcode_atts( array(
		'title' => '',
		'per_cent' => 50,
		'bot_margin' => 30
	), $atts ));

	$bot_margin = (int)$bot_margin;
	$margin = ' style="margin-bottom:'.$bot_margin.'px"';

	$per_cent = (int)$per_cent;

	$html = '';
	
	$html .= '<div class="progers-bars-wrapper"'.$margin.'>
	<div><div class="pull-left">'.$title.'</div><div class="pull-right">'.$per_cent.'%</div><div class="clearfix"></div></div><div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$per_cent.'" aria-valuemin="0" aria-valuemax="100" data-width="'.$per_cent.'%"></div></div>
	</div>';

	return $html;
}


// [portal_slider]
function portal_slider( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'post_count' => '',
		'category' => "-1",
		'orderby' => 'date',
		'order' => 'DESC',
		'ignoresticky' => 1,
		'excerpt_lenght' => 128,
		'bot_margin' => 30
	), $atts ) );

	$html = '';
	$counter = 0;

	$bot_margin = (int)$bot_margin;
	$margin = ' style="margin-bottom:'.$bot_margin.'px"';
	$words = $excerpt_lenght;

	$query_string = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'orderby' => $orderby,
		'order' => $order,
		'ignore_sticky_posts' => $ignoresticky
		);
	if ( $category !== "-1" ){
		$query_string = $query_string + array(
			'cat' => $category
			);
	}
	if ( $post_count !== "" ){
		$query_string = $query_string + array(
			'posts_per_page' => $post_count
			);
	}

	$query_string_ajax = http_build_query($query_string);

	$portal_posts = new WP_Query( $query_string );

	if ( $portal_posts->have_posts() ) :

		$html .= "<div class='focused_swipe_slider swiper_layer_hover bg_color_white' data-string='{$query_string_ajax}'{$margin}><div class='portal-swiper-container bg_color_white'><div class='swiper-scrollbar'></div><div class='swiper-wrapper'>";
		
		while( $portal_posts->have_posts() ): $portal_posts->the_post();

			$counter++;

			$html .= '<div class="swiper-slide"><div class="focused_slider_image_wrap relative">';
			$html .= sprintf('<a href="%1$s" class="swiper_image_link_wrapper">%2$s</a>', get_permalink(), get_the_post_thumbnail( get_the_ID(), 'large', array('class' => 'block js_swipe_slider_image')) );
			$excerpt = get_the_excerpt();
			$html .= sprintf( '<div class="sliced_preview_content"><h3 class="margin-bottom10">%1$s</h3><div class="pop_ups"><span>%2$s</span><a href="%3$s" class="color_main block margin-top10">%4$s</a></div></div></div>', get_the_title(), portal_string_limit_words( $excerpt, $words ), get_permalink(), __('View Project &rarr;', 'portal') );

			$html .= '</div>';
		endwhile;
		
		$html .= "</div></div></div>";

	endif;
	wp_reset_query();
	return $html;
}

// [portal_contactform]
function portal_contactform( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'users' => '1',
		'bot_margin' => 30
	), $atts ) );

	$bot_margin = (int)$bot_margin;
	$margin = ' style="margin-bottom:'.$bot_margin.'px"';

	$out = '';
	$out .= portal_contact_form( $users, $margin );

	return $out;
}


// Init shortcodes
add_action( 'init', 'portal_shortcodes' );
function portal_shortcodes() {

	add_shortcode( 'portal_revslider', 'portal_revslider' );
	add_shortcode( 'portal_tabs', 'portal_tabs' );
	add_shortcode( 'portal_accordion', 'portal_accordion' );
	add_shortcode( 'portal_bar', 'portal_bar' );
	add_shortcode( 'portal_slider', 'portal_slider' );
	add_shortcode( 'portal_contactform', 'portal_contactform' );

}