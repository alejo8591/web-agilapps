<?php
/* Gather wordpress menus */

$nav_menus = get_terms( 'nav_menu', array( 'hide_empty' => true ));
$fbuilder_menus = array();
$fbuilder_menu_std = '';
if(is_array($nav_menus)) 
	foreach($nav_menus as $menu) {
		if($fbuilder_menu_std == '') $fbuilder_menu_std = $menu->slug;
		$fbuilder_menus[$menu->slug] = $menu->name; 
	}

/* Gather wordpress sidebars (Must be done from the wp_head)

$fbuilder_sidebars = array();
$fbuilder_sidebar_std = '';
foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
	if($fbuilder_sidebar_std == '') $fbuilder_sidebar_std = $sidebar['id'];
	$fbuilder_sidebars[$sidebar['id']] = ucwords( $sidebar['name'] );
} 
*/

/* Gather wordpress posts */

global $wpdb;

 $querystr = "
    SELECT $wpdb->posts.ID, $wpdb->posts.post_title
    FROM $wpdb->posts
	WHERE $wpdb->posts.post_status = 'publish'
	AND $wpdb->posts.post_type = 'post'
    ORDER BY $wpdb->posts.post_date DESC
 ";
$posts_array = $wpdb->get_results($querystr, OBJECT);

$fbuilder_wp_posts = array();
$first_post = '';
foreach($posts_array as $key => $obj) {
	if($first_post == '') $first_post = $key;
	$fbuilder_wp_posts[$obj->ID] = $obj->post_title;
}
$admin_optionsDB = $this->option();
$opts = array();
foreach($admin_optionsDB as $opt) {
	if(isset($opt->name) && isset($opt->value))
		$opts[$opt->name] = $opt->value;
}


$fbuilder_shortcodes = array(
	'heading' => array(
		'type' => 'draggable',
		'text' => __('Heading','frontend-builder'),
		'icon' => $this->url.'images/icons/1.png',
		'function' => 'fbuilder_h',
		'options' => array(
			'type' => array(
				'type' => 'select',
				'label' => 'Type',
				'std' => 'h1',
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6'
				)
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			'content' => array(
				'type' => 'textarea',
				'label' => 'Text',
				'std' => 'Lorem ipsum'
			),
			'align' => array(
				'type' => 'select',
				'label' => __('Text alignment','frontend-builder'),
				'options' => array(
					'left' => 'Left',
					'right' => 'Right',
					'center' => 'Center'
				),
				'std' => 'left'
			),
			'text_color' => array(
				'type' => 'color',
				'label' => __('Text color','frontend-builder'),
				'std' => $opts['title_color'],
			)
		)
	),
	'text' => array(
		'type' => 'draggable',
		'text' => __('Text / HTML','frontend-builder'),
		'icon' => $this->url.'images/icons/2.png',
		'function' => 'fbuilder_text',
		'options' => array(
			'content' => array(
				'type' => 'textarea',
				'label' => __('Content','frontend-builder'),
				'desc' => 'You can use text, html and/or wordpress shortcodes',
				'std' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
			),
			'autop' => array(
				'type' => 'checkbox',
				'label' => __('Format new lines','frontend-builder'),
				'std' => 'true',
				'desc' => '"Enter" key is a new line'
			),
			'align' => array(
				'type' => 'select',
				'label' => __('Text alignment','frontend-builder'),
				'options' => array(
					'left' => __('Left','frontend-builder'),
					'right' => __('Right','frontend-builder'),
					'center' => __('Center','frontend-builder')
				),
				'std' => 'left'
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			)
		)
	),
	
	'separator' => array(
		'type' => 'draggable',
		'text' => __('Separator','frontend-builder'),
		'icon' => $this->url.'images/icons/3.png',
		'function' => 'fbuilder_separator',
		'options' => array(
			'width' => array(
				'type' => 'number',
				'label' => __('Width','frontend-builder'),
				'std' => 1,
				'max' => 20,
				'unit' => 'px',
			),
			'style' => array(
				'type' => 'select',
				'label' => __('Style','frontend-builder'),
				'options' => array(
					'solid' => __('Solid','frontend-builder'),
					'dashed' => __('Dashed','frontend-builder'),
					'dotted' => __('Dotted','frontend-builder'),
					'double' => __('Double','frontend-builder')
				)
			),
			'color' => array(
				'type' => 'color',
				'label' => __('Color','frontend-builder'),
				'std' => $opts['main_color']
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			)
		)
	),
	
	'button' => array(
		'type' => 'draggable',
		'text' => __('Button','frontend-builder'),
		'icon' => $this->url.'images/icons/4.png',
		'function' => 'fbuilder_button',
		'options' => array(
			'text' => array(
				'type' => 'input',
				'label' => __('Text','frontend-builder'),
				'std' => __('Read more','frontend-builder')
			),
			'url' => array(
				'type' => 'input',
				'label' => __('URL','frontend-builder'),
				'desc' => __('ex. http://yoursite.com/','frontend-builder'),
				'std' => ''
			),
			'type' => array(
				'type' => 'select',
				'label' => __('Link type','frontend-builder'),
				'std' => 'standard',
				'desc' => __('open in new tab or lightbox','frontend-builder'),
				'options' => array(
					'standard' => __('Standard','frontend-builder'),
					'new-tab' => __('Open in new tab','frontend-builder'),
					'lightbox-image' => __('Lightbox image','frontend-builder'),
					'lightbox-iframe' => __('Lightbox iframe','frontend-builder')
				)
			),
			'iframe_width' => array(
				'type' => 'number',
				'label' => __('Lightbox iframe width','frontend-builder'),
				'std' => 600,
				'min' => 0,
				'max' => 1200,
				'unit' => 'px',
				'hide_if' => array(
					'type' => array('standard', 'new-tab', 'lightbx-image')
				)
			),
			'iframe_height' => array(
				'type' => 'number',
				'label' => __('Lightbox iframe height','frontend-builder'),
				'std' => 300,
				'min' => 0,
				'max' => 1200,
				'unit' => 'px',
				'hide_if' => array(
					'type' => array('standard', 'new-tab', 'lightbx-image')
				)
			),
			'font_size' => array(
				'type' => 'number',
				'label' => __('Font size','frontend-builder'),
				'std' => 16,
				'unit' => 'px'
			),
			'text_align' => array(
				'type' => 'select',
				'label' => __('Text alignment','frontend-builder'),
				'std' => 'left',
				'options' => array(
					'left' => __('Left','frontend-builder'),
					'center' => __('Centered','frontend-builder'),
					'right' => __('Right','frontend-builder')
				)
			),
			'text_color' => array(
				'type' => 'color',
				'label' => __('Text color','frontend-builder'),
				'std' => $opts['main_back_text_color']
			),
			'hover_text_color' => array(
				'type' => 'color',
				'label' => __('Text hover color','frontend-builder'),
				'std' => $opts['main_back_text_color']
			),
			'icon' => array(
				'type' => 'icon',
				'label' => __('Icon','frontend-builder'),
				'notNull' => false,
				'std' => 'icon-beaker'
			),
			
			'icon_size' => array(
				'type' => 'number',
				'label' => __('Icon size','frontend-builder'),
				'std' => 16,
				'unit' => 'px'
			),
			
			'icon_align' => array(
				'type' => 'select',
				'label' => __('Icon alignment','frontend-builder'),
				'std' => 'left',
				'options' => array(
					'left' => __('Left','frontend-builder'),
					'right' => __('Right','frontend-builder'),
					'inline' => __('Inline','frontend-builder')
				)
			),
			'h_padding' => array(
				'type' => 'number',
				'label' => __('Horizontal padding','frontend-builder'),
				'std' => 10,
				'unit' => 'px'
			),
			'v_padding' => array(
				'type' => 'number',
				'label' => __('Vertical padding','frontend-builder'),
				'std' => 10,
				'unit' => 'px'
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			
			'fullwidth' => array(
				'type' => 'checkbox',
				'label' => __('Full width','frontend-builder'),
				'std' => 'false'
			),
			
			'round' => array(
				'type' => 'checkbox',
				'label' => 'Round',
				'std' => 'false'
			),
			'fill' => array(
				'type' => 'checkbox',
				'label' => __('Fill','frontend-builder'),
				'std' => 'true',
				'desc' => __('turn off to get a button with border','frontend-builder')
			),
			'back_color' => array(
				'type' => 'color',
				'label' => __('Background color','frontend-builder'),
				'std' => $opts['main_color']
			),
			'hover_back_color' => array(
				'type' => 'color',
				'label' => __('Background hover color','frontend-builder'),
				'std' => $opts['light_main_color']
			)
			
		),
	),
	'image' => array(
		'type' => 'draggable',
		'text' => __('Image','frontend-builder'),
		'icon' => $this->url.'images/icons/5.png',
		'function' => 'fbuilder_image',
		'options' => array(
			'content' => array(
				'type' => 'image',
				'label' => __('Image','frontend-builder'),
				'std' => 'http://wscont2.apps.microsoft.com/winstore/1x/65e960ea-2698-4a8f-90e2-552f3a832367/Screenshot.2056.1000000.jpg'
			),
			'desc' => array(
				'type' => 'textarea',
				'label' => __('Image description','frontend-builder'),
				'std' => ''
			),
			'text_align' => array(
				'type' => 'select',
				'label' => __('Text alignment','frontend-builder'),
				'std' => 'left',
				'options' => array(
					'left' => __('Left','frontend-builder'),
					'center' => __('Center','frontend-builder'),
					'right' => __('Right','frontend-builder')
				)
			),
			'link' => array(
				'type' => 'input',
				'label' => __('Link URL','frontend-builder'),
				'std' => ''
			),
			'link_type' => array(
				'type' => 'select',
				'label' => __('Link type','frontend-builder'),
				'std' => 'lightbox-image',
				'desc' => __('open in new tab or lightbox','frontend-builder'),
				'options' => array(
					'standard' => __('Standard','frontend-builder'),
					'new-tab' => __('Open in new tab','frontend-builder'),
					'lightbox-image' => __('Lightbox image','frontend-builder'),
					'lightbox-iframe' => __('Lightbox iframe','frontend-builder')
				),
				'hide_if' => array(
					'link' => array('')
				)
			),
			'iframe_width' => array(
				'type' => 'number',
				'label' => __('Lightbox iframe width','frontend-builder'),
				'std' => 600,
				'min' => 0,
				'max' => 1200,
				'unit' => 'px',
				'hide_if' => array(
					'link' => array(''),
					'link_type' => array('standard', 'new-tab', 'lightbx-image')
				)
			),
			'iframe_height' => array(
				'type' => 'number',
				'label' => __('Lightbox iframe height','frontend-builder'),
				'std' => 300,
				'min' => 0,
				'max' => 1200,
				'unit' => 'px',
				'hide_if' => array(
					'link' => array(''),
					'link_type' => array('standard', 'new-tab', 'lightbx-image')
				)
			),
			'hover_icon' => array(
				'type' => 'icon',
				'label' => __('Hover icon','frontend-builder'),
				'std' => 'icon-search',
				'hide_if' => array(
					'link' => array('')
				)
			),
			'hover_icon_size' => array(
				'type' => 'number',
				'label' => __('Hover icon size','frontend-builder'),
				'std' => '30',
				'unit' => 'px',
				'hide_if' => array(
					'link' => array('')
				)
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			'round' => array(
				'type' => 'checkbox',
				'label' => __('Round edges','frontend-builder'),
				'std' => 'false'
			),
			'border' => array(
				'type' => 'checkbox',
				'label' => __('Add bottom border','frontend-builder'),
				'std' => 'false'
			),
			'border_color' => array(
				'type' => 'color',
				'label' => __('Border color','frontend-builder'),
				'std' => $opts['dark_border_color'],
				'hide_if' => array(
					'border' => array('false')
				)
			),
			'desc_color' => array(
				'type' => 'color',
				'label' => __('Description text color','frontend-builder'),
				'std' => $opts['text_color'],
				'hide_if' => array(
					'desc' => array('')
				)
			),
			'back_color' => array(
				'type' => 'color',
				'label' => __('Description background color','frontend-builder'),
				'std' => $opts['light_back_color'],
				'hide_if' => array(
					'desc' => array('')
				)
			),
			'border_hover_color' => array(
				'type' => 'color',
				'label' => __('Border hover color','frontend-builder'),
				'std' => $opts['main_color'],
				'hide_if' => array(
					'border' => array('false'),
					'link' => array('')
				)
			),
			'desc_hover_color' => array(
				'type' => 'color',
				'label' => __('Description text hover color','frontend-builder'),
				'std' => $opts['text_color'],
				'hide_if' => array(
					'desc' => array(''),
					'link' => array('')
				)
			),
			'back_hover_color' => array(
				'type' => 'color',
				'label' => __('Description background hover color','frontend-builder'),
				'std' => $opts['light_back_color'],
				'hide_if' => array(
					'desc' => array(''),
					'link' => array('')
				)
			)
		)
	
	),
	
	'video' => array(
		'type' => 'draggable',
		'text' => __('Video','frontend-builder'),
		'icon' => $this->url.'images/icons/6.png',
		'function' => 'fbuilder_video',
		'options' => array(
			'url' => array(
				'type' => 'input',
				'label' => __('Video URL','frontend-builder'),
				'std' => 'http://www.youtube.com/watch?v=YE7VzlLtp-4'
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			'auto_width' => array(
				'type' => 'checkbox',
				'label' => __('Auto width','frontend-builder'),
				'desc' => __('Use the width of the column','frontend-builder'),
				'std' => 'true'
				
			),
			'width' => array(
				'type' => 'number',
				'label' => __('Width','frontend-builder'),
				'min' => 100,
				'max' => 1200,
				'std' => 620,
				'unit' => 'px',
				'hide_if' => array(
					'auto_width' => array('true')
				)
			),
			'height' => array(
				'type' => 'number',
				'label' => __('Height','frontend-builder'),
				'min' => 100,
				'max' => 1200,
				'std' => 310,
				'unit' => 'px'
			)
		)
	
	),
	
	
	'slider' => array(
		'type' => 'draggable',
		'text' => __('Slider','frontend-builder'),
		'icon' => $this->url.'images/icons/17.png',
		'function' => 'fbuilder_slider',
		'options' => array(
			'sortable' => array(
				'type' => 'sortable',
				'label' => __('Tab elements','frontend-builder'),
				'desc' => __('Elements are sortable','frontend-builder'),
				'item_name' => __('slide','frontend-builder'),
				'std' => array(
					'items' => array(
						0 => array(
							'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
							'image' => '',
							'ctype' => 'html',
							'back_color' => '#000000',
							'text_color' => '#ffffff',
							'image_link' => '',
							'image_link_type' => 'standard'
						),
						1 => array(
							'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
							'image' => '',
							'ctype' => 'html',
							'back_color' => 'gray',
							'text_color' => '#ffffff',
							'image_link' => '',
							'image_link_type' => 'standard'
						),
						2 => array(
							'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
							'image' => '',
							'ctype' => 'html',
							'back_color' => '#000000',
							'text_color' => '#ffffff',
							'image_link' => '',
							'image_link_type' => 'standard'
						)
					),
					'order' => array(
						0 => 0,
						1 => 1,
						2 => 2
					)
				),
				
				'options'=> array(
					'ctype' => array(
						'type' => 'select',
						'label' => __('Content type','frontend-builder'),
						'std' => 'image',
						'options' => array(
							'image' => __('Image','frontend-builder'),
							'html' => __('Text / Html','frontend-builder')
						)
					),
					'image' => array(
						'type' => 'image',
						'label' => __('Image','frontend-builder'),
						'desc' => __('Add an image to tab content','frontend-builder'),
						'hide_if' => array(
							'sortable' => array(
								'ctype' => array('html')
							)
						)
					),
					'image_link' => array(
						'type' => 'input',
						'label' => __('Link','frontend-builder'),
						'hide_if' => array(
							'sortable' => array(
								'ctype' => array('html')
							)
						)
					),
					'image_link_type' => array(
						'type' => 'select',
						'label' => __('Link type','frontend-builder'),
						'std' => 'standard',
						'desc' => __('open in new tab or lightbox','frontend-builder'),
						'options' => array(
							'standard' => __('Standard','frontend-builder'),
							'new-tab' => __('Open in new tab','frontend-builder'),
							'lightbox-image' => __('Lightbox image','frontend-builder'),
							'lightbox-iframe' => __('Lightbox iframe','frontend-builder')
						),
						'hide_if' => array(
							'sortable' => array(
								'ctype' => array('html')
							)
						)
					),
					'iframe_width' => array(
						'type' => 'number',
						'label' => __('Lightbox iframe width','frontend-builder'),
						'std' => 600,
						'min' => 0,
						'max' => 1200,
						'unit' => 'px',
						'hide_if' => array(
							'sortable' => array(
								'ctype' => array('html'),
								'image_link_type' => array('standard', 'new-tab', 'lightbx-image')
							)
						)
					),
					'iframe_height' => array(
						'type' => 'number',
						'label' => __('Lightbox iframe height','frontend-builder'),
						'std' => 300,
						'min' => 0,
						'max' => 1200,
						'unit' => 'px',
						'hide_if' => array(
							'sortable' => array(
								'ctype' => array('html'),
								'image_link_type' => array('standard', 'new-tab', 'lightbx-image')
							)
						)
					),
					'content' => array(
						'type' => 'textarea',
						'label' => __('Content','frontend-builder'),
						'hide_if' => array(
							'sortable' => array(
								'ctype' => array('image')
							)
						)
					),
					'text_align' => array(
						'type' => 'select',
						'label' => __('Text alignment','frontend-builder'),
						'std' => 'left',
						'options' => array(
							'left' => __('Left','frontend-builder'),
							'center' => __('Center','frontend-builder'),
							'right' => __('Right','frontend-builder')
						),
						'hide_if' => array(
							'sortable' => array(
								'ctype' => array('image')
							)
						)
					),
					'back_color' => array(
						'type' => 'color',
						'label' => __('Background color','frontend-builder'),
						'std' => $opts['light_back_color'],
						'hide_if' => array(
							'sortable' => array(
								'ctype' => array('image')
							)
						)
					),
					'text_color' => array(
						'type' => 'color',
						'label' => __('Text color','frontend-builder'),
						'std' => $opts['text_color'],
						'hide_if' => array(
							'sortable' => array(
								'ctype' => array('image')
							)
						)
					)
				)
			),
			'mode' => array(
				'type' => 'select',
				'label' => __('Mode','frontend-builder'),
				'std' => 'horizontal',
				'options' => array(
					'horizontal' => __('Hortizontal','frontend-builder'),
					'vertical' => __('Vertical','frontend-builder'),
				)
			),
			'pagination' => array(
				'type' => 'checkbox',
				'std' => 'true',
				'label' => __('Show pagination','frontend-builder')
			),
			'slides_per_view' => array(
				'type' => 'number',
				'min' => 1,
				'label' => __('Slides per view','frontend-builder'),
				'max' => 10,
				'std' => 1,
				'unit' => ''
			),
			'auto_play' => array(
				'type' => 'checkbox',
				'std' => 'true',
				'label' => __('Auto play','frontend-builder')
			),
			'auto_delay' => array(
				'type' => 'number',
				'std' => 5,
				'label' => __('Transition delay time','frontend-builder'),
				'unit' => 's',
				'hide_if' => array(
					'auto_play' => 'false'
				)
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			)
		)
	),
	
	'code' => array(
		'type' => 'draggable',
		'text' => 'Code',
		'icon' => $this->url.'images/icons/18.png',
		'function' => 'fbuilder_code',
		'options' => array(
			'content' => array(
				'type' => 'textarea',
				'label' => __('Code','frontend-builder'),
				'std' => 'function Start(){
  // do something
}'
			)
		)
	),
	'testimonials' => array(
		'type' => 'draggable',
		'text' => __('Testimonials','frontend-builder'),
		'icon' => $this->url.'images/icons/7.png',
		'function' => 'fbuilder_testimonials',
		'options' => array(
			'name' => array(
				'type' => __('input','frontend-builder'),
				'label' => __('Name','frontend-builder'),
				'std' => __('John Dough','frontend-builder')
			),
			'profession' => array(
				'type' => 'input',
				'label' => __('Profession','frontend-builder'),
				'std' => __('photographer / fashion interactive','frontend-builder'),
			),
			'quote' => array(
				'type' => 'input',
				'label' => __('Quote','frontend-builder'),
				'std' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
			),
			'url' => array(
				'type' => 'input',
				'label' => __('URL','frontend-builder'),
				'desc' => 'Type if you want to link the testimonial'			
			),
			'image' => array(
				'type' => 'image',
				'label' => __('Image','frontend-builder'),
				'desc' => '80x80'			
			),
			
			'style' => array(
				'type' => 'select',
				'label' => __('Style','frontend-builder'),
				'std' => 'clean',
				'options' => array(
					'clean' => __('Clean','frontend-builder'),
					'squared' => __('Squared','frontend-builder'),
					'rounded' => __('Rounded','frontend-builder')
				)
			
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			'name_color' => array(
				'type' => 'color',
				'label' => __('Name color','frontend-builder'),
				'std' => $opts['title_color']
			),
			'quote_color' => array(
				'type' => 'color',
				'label' => __('Quote text color','frontend-builder'),
				'std' => $opts['text_color']
			),
			'main_color' => array(
				'type' => 'color',
				'label' => __('Main color','frontend-builder'),
				'std' => $opts['main_color']
			),
			'back_color' => array(
				'type' => 'color',
				'label' => __('Background color','frontend-builder'),
				'std' => ''
			)
		
		)
	
	),
	
	'tabs' => array(
		'type' => 'draggable',
		'text' => __('Tabs','frontend-builder'),
		'icon' => $this->url.'images/icons/8.png',
		'function' => 'fbuilder_tabs',
		'options' => array(
			'sortable' => array(
				'type' => 'sortable',
				'label' => __('Tan elements','frontend-builder'),
				'desc' => __('Elements are sortable','frontend-builder'),
				'item_name' => __('tab item','frontend-builder'),
				'std' => array(
					'items' => array(
						0 => array(
							'title' => 'Lorem ipsum',
							'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
							'image' => '',
							'active' => 'true'
						),
						1 => array(
							'title' => 'Lorem ipsum',
							'content' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.',
							'image' => '',
							'active' => 'false'
						),
						2 => array(
							'title' => 'Lorem ipsum',
							'content' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
							'image' => '',
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
						'label' => __('Title','frontend-builder')
					),
					'content' => array(
						'type' => 'textarea',
						'label' => __('Content','frontend-builder')
					),
					'image' => array(
						'type' => 'image',
						'label' => __('Image','frontend-builder'),
						'desc' => __('Add an image to tab content','frontend-builder')
					),
					'active' => array(
						'type' => 'checkbox',
						'label' => __('Active','frontend-builder'),
						'desc' => __('Only one panel can be active at a time, so be sure to uncheck the others for it to work properly','frontend-builder')
					)
				)
			),
			'style' => array(
				'type' => 'select',
				'label' => __('Style','frontend-builder'),
				'std' => 'clean',
				'options' => array(
					'clean' => __('Clean','frontend-builder'),
					'squared' => __('Squared','frontend-builder'),
					'rounded' => __('Rounded','frontend-builder')
				)
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			
			'title_color' => array(
				'type' => 'color',
				'label' => __('Tab title color','frontend-builder'),
				'std' => $opts['title_color']
			),
			'text_color' => array(
				'type' => 'color',
				'label' => __('Text color','frontend-builder'),
				'std' => $opts['text_color']
			),
			'active_tab_title_color' => array(
				'type' => 'color',
				'label' => __('Active tab title color','frontend-builder'),
				'std' => $opts['title_color'],
				'hide_if' => array(
					'style' => array('clean')
				)
			),
			'active_tab_border_color' => array(
				'type' => 'color',
				'label' => __('Active tab border color','frontend-builder'),
				'std' => $opts['main_color']
			),
			'border_color' => array(
				'type' => 'color',
				'label' => __('Border color','frontend-builder'),
				'std' => $opts['light_border_color']
			),
			'tab_back_color' => array(
				'type' => 'color',
				'label' => __('Tab background color','frontend-builder'),
				'std' => $opts['dark_back_color'],
				'hide_if' => array(
					'style' => array('clean')
				)
			),
			'back_color' => array(
				'type' => 'color',
				'label' => __('Background color','frontend-builder'),
				'std' => $opts['light_back_color'],
				'hide_if' => array(
					'style' => array('clean')
				)
			)
		)
	),
	
	'accordion' => array(
		'type' => 'draggable',
		'text' => __('Accordion','frontend-builder'),
		'icon' => $this->url.'images/icons/9.png',
		'function' => 'fbuilder_accordion',
		'options' => array(
			'sortable' => array(
				'type' => 'sortable',
				'label' => __('Accordion elements','frontend-builder'),
				'desc' => __('Elements are sortable','frontend-builder'),
				'item_name' => __('accordion item','frontend-builder'),
				'std' => array(
					'items' => array(
						0 => array(
							'title' => 'Lorem ipsum',
							'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
							'image' => '',
							'active' => 'true'
						),
						1 => array(
							'title' => 'Lorem ipsum',
							'content' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.',
							'image' => '',
							'active' => 'false'
						),
						2 => array(
							'title' => 'Lorem ipsum',
							'content' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
							'image' => '',
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
						'label' => __('Title','frontend-builder')
					),
					'content' => array(
						'type' => 'textarea',
						'label' => __('Content','frontend-builder')
					),
					'image' => array(
						'type' => 'image',
						'label' => __('Image','frontend-builder'),
						'desc' => __('Add an image to accordion content','frontend-builder')
					),
					'active' => array(
						'type' => 'checkbox',
						'label' => __('Active','frontend-builder'),
						'desc' => __('Only one panel can be active at a time, so be sure to uncheck the others for it to work properly','frontend-builder')
					)
				)
			),
			'style' => array(
				'type' => 'select',
				'label' => __('Style','frontend-builder'),
				'std' => 'clean-right',
				'options' => array(
					'clean-right' => __('Clean right','frontend-builder'),
					'squared-right' => __('Squared right','frontend-builder'),
					'rounded-right' => __('Rounded right','frontend-builder'),
					'clean-left' => __('Clean left','frontend-builder'),
					'squared-left' => __('Squared left','frontend-builder'),
					'rounded-left' => __('Rounded left','frontend-builder')
				)
			),
			'fixed_height' => array(
				'type' => 'checkbox',
				'label' => __('Fixed height','frontend-builder'),
				'desc' => __('if desabled height will vary due to content height','frontend-builder'),
				'std' => 'true'
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			'title_color' => array(
				'type' => 'color',
				'label' => __('Title color','frontend-builder'),
				'std' => $opts['title_color']
			),
			'text_color' => array(
				'type' => 'color',
				'label' => __('Text color','frontend-builder'),
				'std' => $opts['text_color']
			),
			'trigger_color' => array(
				'type' => 'color',
				'label' => __('Trigger color','frontend-builder'),
				'std' => $opts['title_color']
			),
			'title_active_color' => array(
				'type' => 'color',
				'label' => __('Title active color','frontend-builder'),
				'std' => $opts['title_color'],
				'hide_if' => array(
					'style' => array('clean-right', 'clean-left', 'squared-left', 'rounded-left')
				)
			),
			'trigger_active_color' => array(
				'type' => 'color',
				'label' => __('Trigger active color','frontend-builder'),
				'std' => $opts['title_color']
			),
			'main_color' => array(
				'type' => 'color',
				'label' => __('Main color','frontend-builder'),
				'std' => $opts['main_color']
			),
			'back_color' => array(
				'type' => 'color',
				'label' => __('Background color','frontend-builder'),
				'std' => ''
			),
			'border_color' => array(
				'type' => 'color',
				'label' => __('Border color','frontend-builder'),
				'std' => $opts['light_border_color']
			)
		)
	),
	
	'pricing' => array(
		'type' => 'draggable',
		'text' => __('Pricing table','frontend-builder'),
		'icon' => $this->url.'images/icons/12.png',
		'function' => 'fbuilder_pricing',
		'options' => array(
			'colnum' => array(
				'type' => 'select',
				'label' => __('Number of columns','frontend-builder'),
				'std' => '3',
				'options' => array(
					'1' => __('One column','frontend-builder'),
					'2' => __('Two columns','frontend-builder'),
					'3' => __('Three columns','frontend-builder'),
					'4' => __('Four columns','frontend-builder'),
					'5' => __('Five columns','frontend-builder')
				)
			),
			
			'services_sidebar' => array(
				'type' => 'checkbox',
				'label' => __('Show services sidebar', 'frontend-builder'),
				'std' => 'true'
			),
			
			
			'sortable' => array(
				'type' => 'sortable',
				'label' => __('Pricing rows','frontend-builder'),
				'desc' => __('Rows are sortable','frontend-builder'),
				'item_name' => __('row','frontend-builder'),
				'std' => array(
					'items' => array(
					),
					'order' => array(
					)
				),
				
				'options'=> array(
					'row_type' => array(
						'type' => 'select',
						'label' => __('Row type','frontend-builder'),
						'std' => 'service',
						'options' => array(
							'heading' => __('Heading','frontend-builder'),
							'price' => __('Price','frontend-builder'),
							'button' => __('Button','frontend-builder'),
							'text-button' => __('Text with button','frontend-builder'),
							'section' => __('Section','frontend-builder'),
							'service' => __('Service','frontend-builder'),
							'border' => __('Border','frontend-builder')
						)
					),
					'bot_border' => array(
						'type' => 'checkbox',
						'label' => __('Bottom border','frontend-builder'),
						'std' => 'true'
					),
					// sidebar
					'service_label' => array(
						'type' => 'input',
						'label' => __('Service label','frontend-builder'),
						'std' => 'Lorem ipstum',
						'hide_if' => array(
							'services_sidebar' => array('false'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'button', 'border')
							)
						)
					),
					'service_icon' => array(
						'type' => 'icon',
						'label' => __('Icon','frontend-builder'),
						'std' => 'icon-star',
						'notNull' => false,
						'hide_if' => array(
							'services_sidebar' => array('false'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'button', 'text-button', 'service', 'border')
							)
						)
					),
					
					// column 1
					'column_1_icon' => array(
						'type' => 'icon',
						'label' => __('Column 1 icon','frontend-builder'),
						'std' => 'icon-ok',
						'notNull' => false,
						'hide_if' => array(
							'sortable' => array(
								'row_type' => array('heading', 'price', 'button','text-button', 'section', 'border')
							)
						)
					),
					'column_1_text' => array(
						'type' => 'input',
						'label' => __('Column 1 text','frontend-builder'),
						'std' => 'Lorem ipstum',
						'hide_if' => array(
							'sortable' => array(
								'row_type' => array('price', 'button', 'border', 'section')
							)
						)
					),
					'column_1_price' => array(
						'type' => 'input',
						'label' => __('Column 1 price','frontend-builder'),
						'std' => '42',
						'hide_if' => array(
							'sortable' => array(
								'row_type' => array('heading', 'button', 'text-button', 'section', 'service', 'border')
							)
						)
					),
					'column_1_interval' => array(
						'type' => 'input',
						'label' => __('Column 1 interval','frontend-builder'),
						'std' => '/per month',
						'hide_if' => array(
							'sortable' => array(
								'row_type' => array('heading', 'button', 'text-button', 'section', 'service', 'border')
							)
						)
					),
					'column_1_button_text' => array(
						'type' => 'input',
						'label' => __('Column 1 button text','frontend-builder'),
						'std' => 'Lorem ipstum',
						'hide_if' => array(
							'sortable' => array(
								'row_type' => array('heading', 'price', 'section', 'service', 'border')
							)
						)
					),
					'column_1_button_link' => array(
						'type' => 'input',
						'label' => __('Column 1 button link','frontend-builder'),
						'std' => '#',
						'hide_if' => array(
							'sortable' => array(
								'row_type' => array('heading', 'price', 'section', 'service', 'border')
							)
						)
					),
					
					// column 2
					'column_2_icon' => array(
						'type' => 'icon',
						'label' => __('Column 2 icon','frontend-builder'),
						'std' => 'icon-remove',
						'notNull' => false,
						'hide_if' => array(
							'colnum' => array('1'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'button','text-button', 'section', 'border')
							)
						)
					),
					'column_2_text' => array(
						'type' => 'input',
						'label' => __('Column 2 text','frontend-builder'),
						'std' => 'Lorem ipstum',
						'hide_if' => array(
							'colnum' => array('1'),
							'sortable' => array(
								'row_type' => array('price', 'button', 'border', 'section')
							)
						)
					),
					'column_2_price' => array(
						'type' => 'input',
						'label' => __('Column 2 price','frontend-builder'),
						'std' => '42',
						'hide_if' => array(
							'colnum' => array('1'),
							'sortable' => array(
								'row_type' => array('heading', 'button', 'text-button', 'section', 'service', 'border')
							)
						)
					),
					'column_2_interval' => array(
						'type' => 'input',
						'label' => __('Column 2 interval','frontend-builder'),
						'std' => '/per month',
						'hide_if' => array(
							'colnum' => array('1'),
							'sortable' => array(
								'row_type' => array('heading', 'button', 'text-button', 'section', 'service', 'border')
							)
						)
					),
					'column_2_button_text' => array(
						'type' => 'input',
						'label' => __('Column 2 button text','frontend-builder'),
						'std' => 'Lorem ipstum',
						'hide_if' => array(
							'colnum' => array('1'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'section', 'service', 'border')
							)
						)
					),
					'column_2_button_link' => array(
						'type' => 'input',
						'label' => __('Column 2 button link','frontend-builder'),
						'std' => '#',
						'hide_if' => array(
							'colnum' => array('1'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'section', 'service', 'border')
							)
						)
					),
					
					// column 3
					'column_3_icon' => array(
						'type' => 'icon',
						'label' => __('Column 3 icon','frontend-builder'),
						'std' => 'no-icon',
						'notNull' => false,
						'hide_if' => array(
							'colnum' => array('1','2'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'button','text-button', 'section', 'border')
							)
						)
					),
					'column_3_text' => array(
						'type' => 'input',
						'label' => __('Column 3 text','frontend-builder'),
						'std' => 'Lorem ipstum',
						'hide_if' => array(
							'colnum' => array('1','2'),
							'sortable' => array(
								'row_type' => array('price', 'button', 'section', 'border')
							)
						)
					),
					'column_3_price' => array(
						'type' => 'input',
						'label' => __('Column 3 price','frontend-builder'),
						'std' => '42',
						'hide_if' => array(
							'colnum' => array('1','2'),
							'sortable' => array(
								'row_type' => array('heading', 'button', 'text-button', 'section', 'service', 'border')
							)
						)
					),
					'column_3_interval' => array(
						'type' => 'input',
						'label' => __('Column 3 interval','frontend-builder'),
						'std' => '/per month',
						'hide_if' => array(
							'colnum' => array('1','2'),
							'sortable' => array(
								'row_type' => array('heading', 'button', 'text-button', 'section', 'service', 'border')
							)
						)
					),
					'column_3_button_text' => array(
						'type' => 'input',
						'label' => __('Column 3 button text','frontend-builder'),
						'std' => 'Lorem ipstum',
						'hide_if' => array(
							'colnum' => array('1','2'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'section', 'service', 'border')
							)
						)
					),
					'column_3_button_link' => array(
						'type' => 'input',
						'label' => __('Column 3 button link','frontend-builder'),
						'std' => '#',
						'hide_if' => array(
							'colnum' => array('1','2'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'section', 'service', 'border')
							)
						)
					),
					
					// column 4
					'column_4_icon' => array(
						'type' => 'icon',
						'label' => __('Column 4 icon','frontend-builder'),
						'std' => 'no-icon',
						'notNull' => false,
						'hide_if' => array(
							'colnum' => array('1','2','3'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'button','text-button', 'section', 'border')
							)
						)
					),
					'column_4_text' => array(
						'type' => 'input',
						'label' => __('Column 4 text','frontend-builder'),
						'std' => 'Lorem ipstum',
						'hide_if' => array(
							'colnum' => array('1','2','3'),
							'sortable' => array(
								'row_type' => array('price', 'button', 'section', 'border')
							)
						)
					),
					'column_4_price' => array(
						'type' => 'input',
						'label' => __('Column 4 price','frontend-builder'),
						'std' => '42',
						'hide_if' => array(
							'colnum' => array('1','2','3'),
							'sortable' => array(
								'row_type' => array('heading', 'button', 'text-button', 'section', 'service', 'border')
							)
						)
					),
					'column_4_interval' => array(
						'type' => 'input',
						'label' => __('Column 4 interval','frontend-builder'),
						'std' => '/per month',
						'hide_if' => array(
							'colnum' => array('1','2','3'),
							'sortable' => array(
								'row_type' => array('heading', 'button', 'text-button', 'section', 'service', 'border')
							)
						)
					),
					'column_4_button_text' => array(
						'type' => 'input',
						'label' => __('Column 4 button text','frontend-builder'),
						'std' => 'Lorem ipstum',
						'hide_if' => array(
							'colnum' => array('1','2','3'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'section', 'service', 'border')
							)
						)
					),
					'column_4_button_link' => array(
						'type' => 'input',
						'label' => __('Column 4 button link','frontend-builder'),
						'std' => '#',
						'hide_if' => array(
							'colnum' => array('1','2','3'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'section', 'service', 'border')
							)
						)
					),
					
					// column 5
					'column_5_icon' => array(
						'type' => 'icon',
						'label' => __('Column 5 icon','frontend-builder'),
						'std' => 'no-icon',
						'notNull' => false,
						'hide_if' => array(
							'colnum' => array('1','2','3','4'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'button','text-button', 'section', 'border')
							)
						)
					),
					'column_5_text' => array(
						'type' => 'input',
						'label' => __('Column 5 text','frontend-builder'),
						'std' => 'Lorem ipstum',
						'hide_if' => array(
							'colnum' => array('1','2','3','4'),
							'sortable' => array(
								'row_type' => array('price', 'button', 'section', 'border')
							)
						)
					),
					'column_5_price' => array(
						'type' => 'input',
						'label' => __('Column 5 price','frontend-builder'),
						'std' => '42',
						'hide_if' => array(
							'colnum' => array('1','2','3','4'),
							'sortable' => array(
								'row_type' => array('heading', 'button', 'text-button', 'section', 'service', 'border')
							)
						)
					),
					'column_5_interval' => array(
						'type' => 'input',
						'label' => __('Column 5 interval','frontend-builder'),
						'std' => '/per month',
						'hide_if' => array(
							'colnum' => array('1','2','3','4'),
							'sortable' => array(
								'row_type' => array('heading', 'button', 'text-button', 'section', 'service', 'border')
							)
						)
					),
					'column_5_button_text' => array(
						'type' => 'input',
						'label' => __('Column 5 button text','frontend-builder'),
						'std' => 'Lorem ipstum',
						'hide_if' => array(
							'colnum' => array('1','2','3','4'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'section', 'service', 'border')
							)
						)
					),
					'column_5_button_link' => array(
						'type' => 'input',
						'label' => __('Column 5 button link','frontend-builder'),
						'std' => '#',
						'hide_if' => array(
							'colnum' => array('1','2','3','4'),
							'sortable' => array(
								'row_type' => array('heading', 'price', 'section', 'service', 'border')
							)
						)
					)
				)
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			'currency' => array(
				'type' => 'input',
				'label' => __('Currency','frontend-builder'),
				'std' => '$'
			),
			'text_color' => array(
				'type' => 'color',
				'label' => __('Text color','frontend-builder'),
				'std' => $opts['text_color']
			),
			'back_color' => array(
				'type' => 'color',
				'label' => __('Background color','frontend-builder'),
				'std' => $opts['light_back_color']
			),
			'column_1_main_color' => array(
				'type' => 'color',
				'label' => __('Column 1 main color','frontend-builder'),
				'std' => '#445a68'
			),
			'column_1_hover_color' => array(
				'type' => 'color',
				'label' => __('Column 1 hover color','frontend-builder'),
				'std' => '#5b798c'
			),
			'column_1_button_text_color' => array(
				'type' => 'color',
				'label' => __('Column 1 button text color','frontend-builder'),
				'std' => '#ffffff'
			),
			'column_2_main_color' => array(
				'type' => 'color',
				'label' => __('Column 2 main color','frontend-builder'),
				'std' => '#ed4c3a',
				'hide_if' => array(
					'colnum' => array('1')
				)
			),
			'column_2_hover_color' => array(
				'type' => 'color',
				'label' => __('Column 2 hover color','frontend-builder'),
				'std' => '#f17163',
				'hide_if' => array(
					'colnum' => array('1')
				)
			),
			'column_2_button_text_color' => array(
				'type' => 'color',
				'label' => __('Column 2 button text color','frontend-builder'),
				'std' => '#ffffff',
				'hide_if' => array(
					'colnum' => array('1')
				)
			),
			'column_3_main_color' => array(
				'type' => 'color',
				'label' => __('Column 3 main color','frontend-builder'),
				'std' => '#2b98d3',
				'hide_if' => array(
					'colnum' => array('1','2')
				)
			),
			'column_3_hover_color' => array(
				'type' => 'color',
				'label' => __('Column 3 hover color','frontend-builder'),
				'std' => '#54acdc',
				'hide_if' => array(
					'colnum' => array('1','2')
				)
			),
			'column_3_button_text_color' => array(
				'type' => 'color',
				'label' => __('Column 3 button text color','frontend-builder'),
				'std' => '#ffffff',
				'hide_if' => array(
					'colnum' => array('1','2')
				)
			),
			'column_4_main_color' => array(
				'type' => 'color',
				'label' => __('Column 4 main color','frontend-builder'),
				'std' => '#16a085',
				'hide_if' => array(
					'colnum' => array('1','2','3')
				)
			),
			'column_4_hover_color' => array(
				'type' => 'color',
				'label' => __('Column 4 hover color','frontend-builder'),
				'std' => '#1abc9c',
				'hide_if' => array(
					'colnum' => array('1','2','3')
				)
			),
			'column_4_button_text_color' => array(
				'type' => 'color',
				'label' => __('Column 4 button text color','frontend-builder'),
				'std' => '#ffffff',
				'hide_if' => array(
					'colnum' => array('1','2','3')
				)
			),
			'column_5_main_color' => array(
				'type' => 'color',
				'label' => __('Column 5 main color','frontend-builder'),
				'std' => '#f39c12',
				'hide_if' => array(
					'colnum' => array('1','2','3','4')
				)
			),
			'column_5_hover_color' => array(
				'type' => 'color',
				'label' => __('Column 5 hover color','frontend-builder'),
				'std' => '#f1c40f',
				'hide_if' => array(
					'colnum' => array('1','2','3','4')
				)
			),
			'column_5_button_text_color' => array(
				'type' => 'color',
				'label' => __('Column 5 button text color','frontend-builder'),
				'std' => '#ffffff',
				'hide_if' => array(
					'colnum' => array('1','2','3','4')
				)
			)
			
		)
	),
	
	'alert' => array(
		'type' => 'draggable',
		'text' => __('Alert box','frontend-builder'),
		'icon' => $this->url.'images/icons/10.png',
		'function' => 'fbuilder_alert',
		'options' => array(
			'type' => array(
				'type' => 'select',
				'label' => __('Type','frontend-builder'),
				'std' => 'info',
				'options' => array(
					'info' => __('Info','frontend-builder'),
					'success' => __('Success','frontend-builder'),
					'notice' => __('Notice','frontend-builder'),
					'warning' => __('Warning','frontend-builder'),
					'custom' => __('Custom','frontend-builder')
				)
			),
			'text' => array(
				'type' => 'textarea',
				'label' => __('Text','frontend-builder'),
				'std' => __('This is an alert','frontend-builder')
			),
			'style' => array(
				'type' => 'select',
				'label' => __('Style','frontend-builder'),
				'std' => 'clean',
				'options' => array(
					'clean' => __('Clean','frontend-builder'),
					'squared' => __('Squared','frontend-builder'),
					'rounded' => __('Rounded','frontend-builder')
				)
			),
			'icon' => array(
				'type' => 'icon',
				'label' => __('Icon','frontend-builder'),
				'std' => 'icon-warning-sign',
				'hide_if' => array(
					'type' => array('info', 'success', 'notice', 'warning')
				)
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			'main_color' => array(
				'type' => 'color',
				'label' => __('Main color','frontend-builder'),
				'std' => $opts['main_color'],
				'hide_if' => array(
					'type' => array('info', 'success', 'notice', 'warning')
				)
			),
			'text_color' => array(
				'type' => 'color',
				'label' => __('Text color','frontend-builder'),
				'std' => $opts['text_color'],
				'hide_if' => array(
					'type' => array('info', 'success', 'notice', 'warning')
				)
			),
			'icon_color' => array(
				'type' => 'color',
				'label' => __('Icon color','frontend-builder'),
				'std' => $opts['main_color'],
				'hide_if' => array(
					'type' => array('info', 'success', 'notice', 'warning')
				)
			),
			'back_color' => array(
				'type' => 'color',
				'label' => __('Background color','frontend-builder'),
				'std' => '',
				'hide_if' => array(
					'type' => array('info', 'success', 'notice', 'warning')
				)
			)
		)
	
	),
	
	
	'features' => array(
		'type' => 'draggable',
		'text' => __('Features','frontend-builder'),
		'icon' => $this->url.'images/icons/11.png',
		'function' => 'fbuilder_features',
		'options' => array(
			'title' => array(
				'type' => 'input',
				'label' => __('title','frontend-builder'),
				'std' => 'Lorem ipsum'
			),
			'icon' => array(
				'type' => 'icon',
				'label' => __('Icon','frontend-builder'),
				'std' => 'icon-bell'
			),
			'content' => array(
				'type' => 'textarea',
				'label' => __('Content','frontend-builder'),
				'std' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.'
			),
			'link' => array(
				'type' => 'input',
				'label' => __('Link','frontend-builder'),
				'std' => '',
				'desc' => __('leave empty if you dont want the featur to be linked','frontend-builder')
			),
			'order' => array(
				'type' => 'select',
				'label' => __('Element order','frontend-builder'),
				'std' => 'icon-after-title',
				'options' => array(
					'icon-left' => __('Icon left','frontend-builder'),
					'icon-right' => __('Icon right','frontend-builder'),
					'icon-after-title' => __('Icon after title','frontend-builder'),
					'icon-before-title' => __('Icon before title','frontend-builder')
				)
			),
			'style' => array(
				'type' => 'select',
				'label' => __('Style','frontend-builder'),
				'std' => 'clean',
				'options' => array(
					'clean' => __('Clean','frontend-builder'),
					'squared' => __('Squared','frontend-builder'),
					'rounded' => __('Rounded','frontend-builder'),
					'icon-squared' => __('Icon squared','frontend-builder'),
					'icon-rounded' => __('Icon rounded','frontend-builder')
				)
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			'icon_size' => array(
				'type' => 'number',
				'std' => 60,
				'unit' => 'px',
				'max' => 150,
				'label' => __('Icon size','frontend-builder')
			),
			'icon_padding' => array(
				'type' => 'number',
				'std' => 10,
				'unit' => 'px',
				'max' => 100,
				'label' => __('Icon padding','frontend-builder')
			),
			'icon_border' => array(
				'type' => 'checkbox',
				'std' => 'false',
				'label' => __('Icon border','frontend-builder')
			),
			'title_color' => array(
				'type' => 'color',
				'label' => __('Title color','frontend-builder'),
				'std' => $opts['title_color']
			),
			'icon_color' => array(
				'type' => 'color',
				'label' => __('Icon color','frontend-builder'),
				'std' => $opts['title_color']
			),
			'text_color' => array(
				'type' => 'color',
				'label' => __('Text color','frontend-builder'),
				'std' => $opts['text_color']
			),
			'back_color' => array(
				'type' => 'color',
				'label' => __('Background color','frontend-builder'),
				'std' => $opts['dark_back_color'],
				'hide_if' => array(
					'style' => array('clean')
				)
			),
			'title_hover_color' => array(
				'type' => 'color',
				'label' => __('Title hover color','frontend-builder'),
				'std' => $opts['main_color']
			),
			'icon_hover_color' => array(
				'type' => 'color',
				'label' => __('Icon hover color','frontend-builder'),
				'std' => $opts['main_color']
			),
			'text_hover_color' => array(
				'type' => 'color',
				'label' => __('Text hover color','frontend-builder'),
				'std' => $opts['main_color']
			),
			'back_hover_color' => array(
				'type' => 'color',
				'label' => __('Background hover color','frontend-builder'),
				'std' => '',
				'hide_if' => array(
					'style' => array('clean')
				)
			)
			
		)
	
	),
	
	'post' => array(
		'type' => 'draggable',
		'text' => __('Featured post','frontend-builder'),
		'icon' => $this->url.'images/icons/12.png',
		'function' => 'fbuilder_post',
		'options' => array(
			'id' => array(
				'type' => 'select',
				'label' => __('Post id','frontend-builder'),
				'std' => $first_post,
				'desc' => __('You must have at leest one wordpress post','frontend-builder'),
				'options' => $fbuilder_wp_posts
			),
			'hover_icon' => array(
				'type' => 'icon',
				'label' => __('Image hover icon','frontend-builder'),
				'std' => 'icon-plus'
			),
			'button_text' => array(
				'type' => 'input',
				'label' => __('Button text','frontend-builder'),
				'std' => 'Read more'
			),
			
			'style' => array(
				'type' => 'select',
				'label' => __('Style','frontend-builder'),
				'std' => 'clean',
				'options' => array(
					'clean' => __('Clean','frontend-builder'),
					'squared' => __('Squared','frontend-builder'),
					'rounded' => __('Rounded','frontend-builder')
				)
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			
			'back_color' => array(
				'type' => 'color',
				'label' => __('Background color','frontend-builder'),
				'std' => $opts['light_back_color'],
				'hide_if' => array(
					'style' => array('clean')
				)
			),
			'border_color' => array(
				'type' => 'color',
				'label' => __('Border color','frontend-builder'),
				'std' => $opts['main_color']
			),
			'button_color' => array(
				'type' => 'color',
				'label' => __('Button color','frontend-builder'),
				'std' => $opts['main_color']
			),
			'button_text_color' => array(
				'type' => 'color',
				'label' => __('Button text color','frontend-builder'),
				'std' => $opts['main_back_text_color']
			),
			'button_hover_color' => array(
				'type' => 'color',
				'label' => __('Button hover color','frontend-builder'),
				'std' => $opts['light_main_color']
			),
			'button_text_hover_color' => array(
				'type' => 'color',
				'label' => __('Button text hover color','frontend-builder'),
				'std' => $opts['main_back_text_color']
			),
			'head_color' => array(
				'type' => 'color',
				'label' => __('Heading color','frontend-builder'),
				'std' => $opts['title_color']
			),
			'meta_color' => array(
				'type' => 'color',
				'label' => __('Meta links color','frontend-builder'),
				'desc' => __('color of the meta links - Date, Author, Comments','frontend-builder'),
				'std' => $opts['text_color']
			),
			'meta_hover_color' => array(
				'type' => 'color',
				'label' => __('Meta hover color','frontend-builder'),
				'std' => $opts['main_color']
			),
			'text_color' => array(
				'type' => 'color',
				'label' => __('Text color','frontend-builder'),
				'std' => $opts['text_color']
			)
		)
	),
	
	'menu' => array(
		'type' => 'draggable',
		'text' => __('Nav menu','frontend-builder'),
		'icon' => $this->url.'images/icons/13.png',
		'function' => 'fbuilder_nav_menu',
		'options' => array(
			'wp_menu' => array(
				'type' => 'select',
				'label' => __('WP Menu','frontend-builder'),
				'desc' => __('Select wordpress nav menu that you want to display','frontend-builder'),
				'options'=> $fbuilder_menus,
				'std' => $fbuilder_menu_std
			),
			'type' => array(
				'type' => 'select',
				'label' => __('Type','frontend-builder'),
				'std' => 'horizontal-clean',
				'options' => array(
					'horizontal-clean' => __('Clean horizontal menu','frontend-builder'),
					'horizontal-squared' => __('Squared horizontal menu','frontend-builder'),
					'horizontal-rounded' => __('Rounded horizontal menu','frontend-builder'),
					'vertical-clean' => __('Clean vertical menu','frontend-builder'),
					'vertical-squared' => __('Squared vertical menu','frontend-builder'),
					'vertical-rounded' => __('Rounded vertical menu','frontend-builder'),
					'dropdown-clean' => __('Clean dropdown menu','frontend-builder'),
					'dropdown-squared' => __('Squared dropdown menu','frontend-builder'),
					'dropdown-rounded' => __('Rounded dropdown menu','frontend-builder')
				)
			),
			'menu_title' => array(
				'type' => 'input',
				'label' => __('Menu title','frontend-builder'),
				'std' => __('Nav menu','frontend-builder'),
				'hide_if' => array(
					'type' => array('horizontal-clean', 'horizontal-squared','horizontal-rounded')
				)
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			'text_color' => array(
				'type' => 'color',
				'label' => __('Text color','frontend-builder'),
				'std' => $opts['title_color']
			),
			'hover_color' => array(
				'type' => 'color',
				'label' => __('Hover color','frontend-builder'),
				'std' => $opts['main_color']
			),
			'hover_text_color' => array(
				'type' => 'color',
				'label' => __('Hover text color','frontend-builder'),
				'std' => $opts['main_back_text_color']
			),
			'back_color' => array(
				'type' => 'color',
				'label' => __('Background color','frontend-builder'),
				'std' => ''
			),
			'sub_back_color' => array(
				'type' => 'color',
				'label' => __('Sub-menu background color','frontend-builder'),
				'std' => $opts['light_back_color']
			),
			'sub_text_color' => array(
				'type' => 'color',
				'label' => __('Sub-menu text color','frontend-builder'),
				'std' => $opts['text_color']
			),
			'separator_color' => array(
				'type' => 'color',
				'label' => __('Sub-menu sepparator color','frontend-builder'),
				'std' => $opts['light_border_color'],
				'hide_if' => array(
					'type' => array('horizontal-squared', 'horizontal-rounded', 'dropdown-squared', 'dropdown-rounded')
				)
			)
		)
	
	),
	
	'icon_menu' => array(
		'type' => 'draggable',
		'text' => __('Icon menu','frontend-builder'),
		'icon' => $this->url.'images/icons/14.png',
		'function' => 'fbuilder_icon_menu',
		'options' => array(
			'sortable' => array(
				'type' => 'sortable',
				'label' => __('Icons','frontend-builder'),
				'item_name' => 'icon',
				'std' => array(
					'items' => array(
						0 => array(
							'icon' => 'icon-cogs',
							'url' => '#',
							'link_type' => 'standard'
						),
						1 => array(
							'icon' => 'icon-key',
							'url' => '#',
							'link_type' => 'standard'
						),
						2 => array(
							'icon' => 'icon-group',
							'url' => '#',
							'link_type' => 'standard'
						),
					),
					'order' => array(
						0 => 0,
						1 => 1,
						2 => 2
					)
				),
				'options' => array(
					'icon' => array(
						'type' => 'icon',
						'label' => __('Icon','frontend-builder'),
						'std' => 'icon-check'
					),
					'url' => array(
						'type' => 'input',
						'label' => __('URL','frontend-builder')
					),
					'link_type' => array(
						'type' => 'select',
						'label' => __('Link type','frontend-builder'),
						'std' => 'standard',
						'desc' => __('open in new tab or lightbox','frontend-builder'),
						'options' => array(
							'standard' => __('Standard','frontend-builder'),
							'new-tab' => __('Open in new tab','frontend-builder'),
							'lightbox-image' => __('Lightbox image','frontend-builder'),
							'lightbox-iframe' => __('Lightbox iframe','frontend-builder')
						)
					),
					'iframe_width' => array(
						'type' => 'number',
						'label' => __('Lightbox iframe width','frontend-builder'),
						'std' => 600,
						'min' => 0,
						'max' => 1200,
						'unit' => 'px',
						'hide_if' => array(
							'sortable' => array(
								'link_type' => array('standard', 'new-tab', 'lightbx-image')
							)
						)
					),
					'iframe_height' => array(
						'type' => 'number',
						'label' => __('Lightbox iframe height','frontend-builder'),
						'std' => 300,
						'min' => 0,
						'max' => 1200,
						'unit' => 'px',
						'hide_if' => array(
							'sortable' => array(
								'link_type' => array('standard', 'new-tab', 'lightbx-image')
							)
						)
					)
				)
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			'align' => array(
				'type' => 'select',
				'std' => 'left',
				'label' => __('Icon alignment','frontend-builder'),
				'options' => array(
					'left' => __('Left','frontend-builder'),
					'right' => __('Right','frontend-builder'),
					'center' => __('Center','frontend-builder')
				)
			),
			'icon_size' => array(
				'type' => 'number',
				'std' => 24,
				'label' => __('Icon size','frontend-builder'),
				'unit' => 'px'
			),
			'round' => array(
				'type' => 'checkbox',
				'std' => 'false',
				'label' => __('Round edges','frontend-builder')
			),
			'icon_color' => array(
				'type' => 'color',
				'std' => $opts['title_color'],
				'label' => __('Icon color','frontend-builder')
			),
			'back_color' => array(
				'type' => 'color',
				'std' => '',
				'label' => __('Background color','frontend-builder')
			),
			'icon_hover_color' => array(
				'type' => 'color',
				'std' => $opts['main_color'],
				'label' => __('Icon hover color','frontend-builder')
			),
			'back_hover_color' => array(
				'type' => 'color',
				'std' => '',
				'label' => __('Background hover color','frontend-builder')
			)
		)
		
	),
	
	'sidebar' => array(
		'type' => 'draggable',
		'text' => __('Sidebar','frontend-builder'),
		'icon' => $this->url.'images/icons/15.png',
		'function' => 'fbuilder_sidebar',
		'options' => array(
			'name' => array(
				'type' => 'select',
				'label' => __('WP Sidebar','frontend-builder'),
				'desc' => __('Select wordpress sidebar that you want to display','frontend-builder'),
				'options'=> '$fbuilder_sidebars',
				'std' => '$fbuilder_sidebar_std'
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => 0,
				'unit' => 'px'
			)
		)
	),
	
	'search' => array(
		'type' => 'draggable',
		'text' => __('Search box','frontend-builder'),
		'icon' => $this->url.'images/icons/16.png',
		'function' => 'fbuilder_search',
		'options' => array(
			'text' => array(
				'type' => 'input',
				'label' => __('Text','frontend-builder'),
				'std' => __('Search','frontend-builder')
			),
			'bot_margin' => array(
				'type' => 'number',
				'label' => __('Bottom margin','frontend-builder'),
				'std' => $opts['bottom_margin'],
				'unit' => 'px'
			),
			'round' => array(
				'type' => 'checkbox',
				'label' => __('Round edges','frontend-builder'),
				'std' => 'false'
			),
			'text_color' => array(
				'type' => 'color',
				'label' => __('Text color','frontend-builder'),
				'std' => $opts['title_color']
			),
			'border_color' => array(
				'type' => 'color',
				'label' => __('Border color','frontend-builder'),
				'std' => $opts['light_border_color']
			),
			'back_color' => array(
				'type' => 'color',
				'label' => __('Background color','frontend-builder'),
				'std' => ''
			),
			'text_focus_color' => array(
				'type' => 'color',
				'label' => __('Text focus color','frontend-builder'),
				'std' => $opts['dark_border_color']
			),
			'border_focus_color' => array(
				'type' => 'color',
				'label' => __('Border focus color','frontend-builder'),
				'std' => $opts['dark_border_color']
			),
			'back_focus_color' => array(
				'type' => 'color',
				'label' => __('Background focus color','frontend-builder'),
				'std' => ''
			)
			
		)
	
	)
);

$animationList = array(
	'none' => __('None', 'frontend-builder'),
	'flipInX' => __('Flip in X', 'frontend-builder'),
	'flipInY' => __('Flip in Y', 'frontend-builder'),
	'fadeIn' => __('Fade in', 'frontend-builder'),
	'fadeInDown' => __('Fade in from top', 'frontend-builder'),
	'fadeInUp' => __('Fade in from bottom', 'frontend-builder'),
	'fadeInLeft' => __('Fade in from left', 'frontend-builder'),
	'fadeInRight' => __('Fade in from right', 'frontend-builder'),
	'fadeInDownBig' => __('Slide in from top', 'frontend-builder'),
	'fadeInUpBig' => __('Slide in from bottom', 'frontend-builder'),
	'fadeInLeftBig' => __('Slide in from left', 'frontend-builder'),
	'fadeInRightBig' => __('Slide in from right', 'frontend-builder'),
	'bounceIn' => __('Bounce in', 'frontend-builder'),
	'bounceInDown' => __('Bounce in from top', 'frontend-builder'),
	'bounceInUp' => __('Bounce in from bottom', 'frontend-builder'),
	'bounceInLeft' => __('Bounce in from left', 'frontend-builder'),
	'bounceInRight' => __('Bounce in from right', 'frontend-builder'),
	'rotateIn' => __('Rotate in', 'frontend-builder'),
	'rotateInDownLeft' => __('Rotate in from top-left', 'frontend-builder'),
	'rotateInDownRight' => __('Rotate in from top-right', 'frontend-builder'),
	'rotateInUpLeft' => __('Rotate in from bottom-left', 'frontend-builder'),
	'rotateInUpRight' => __('Rotate in from bottom-right', 'frontend-builder'),
	'lightSpeedIn' => __('Lightning speed', 'frontend-builder'),
	'rollIn' => __('Roll in', 'frontend-builder')
);

$animationControl = array(
	'animate' => array(
		'type' => 'select',
		'label' => __('Animate','frontend-builder'),
		'std' => 'none',
		'options' => $animationList
	),
	'animation_group' => array(
		'type' => 'input',
		'label' => __('Animation group','frontend-builder'),
		'std' => ''
	),
	'animation_delay' => array(
		'type' => 'number',
		'label' => __('Animation delay','frontend-builder'),
		'std' => 0,
		'unit' => 'ms',
		'min' => 0,
		'step' => 50,
		'max' => 10000
	)
);

if(isset($opts['css_classes']) && $opts['css_classes'] == 'true') {
	$classControl = array(
		'shortcode_id' => array(
			'type' => 'input',
			'label' => __('ID','frontend-builder'),
			'desc' => __('For linking via hashtags','frontend-builder'),
			'std' => ''
		),
		'class' => array(
			'type' => 'input',
			'label' => __('Class','frontend-builder'),
			'desc' => __('For custom css','frontend-builder'),
			'std' => ''
		)
	);
	$tabsId = array(
		'custom_id' => array(
			'type' => 'input',
			'label' => __('Custom ID','frontend-builder'),
			'desc' => __('For use of anchor in url. Make sure that this ID is unique on the page.','frontend-builder'),
			'std' => ''
		)
	);
	foreach($fbuilder_shortcodes as $key => $value ) {
		if(array_key_exists('options', $value)) {
			$fbuilder_shortcodes[$key]['options'] = array_merge($classControl, $animationControl, $fbuilder_shortcodes[$key]['options']);
		}
		if($key == 'tabs' || $key == 'accordion') {
			if(isset($value['options']) || isset($value['options']['sortable']) || isset($value['options']['sortable']['options'])) {
				$fbuilder_shortcodes[$key]['options']['sortable']['options'] = array_merge($tabsId, $fbuilder_shortcodes[$key]['options']['sortable']['options']);
			}
		}
	}
}
else {
	foreach($fbuilder_shortcodes as $key => $value ) {
		if(array_key_exists('options', $value)) {
			$fbuilder_shortcodes[$key]['options'] = array_merge($animationControl, $fbuilder_shortcodes[$key]['options']);
		}
	}
}


$output = $fbuilder_shortcodes;
?>