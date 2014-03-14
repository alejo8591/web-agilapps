<?php
class FrontendBuilder {
	
	var $main, $path, $name, $url, $menu_controls, $row_controls, $shortcodes, $rows, $icons, $showall, $yoast, $hideifs;
	
	function __construct($file) {
		$this->main = $file;
		$this->init();
		return $this;
	}
	
	function init() {
  		load_plugin_textdomain( 'frontend-builder', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		$this->activate();
		
		$this->path = dirname( __FILE__ );
		$this->name = basename( $this->path );
		$this->url = plugins_url( "/{$this->name}/" );
		$this->admin_controls = $this->get_admin_controls();
		$this->menu_controls = $this->get_menu_controls();
		$this->row_controls = $this->get_row_controls();
		$this->shortcodes = $this->get_shortcodes();
		$this->rows = $this->get_rows();
		$this->icons = $this->get_icons();
		$this->showall = false;
		$this->yoast = false;
		$this->hideifs = array('parents' => array(), 'children' => array());
		define('FBUILDER_URL', $this->url);
		
		
		require_once($this->path .'/functions/shortcodes.php');
		$opt = $this->option('showall');
		if(!empty($opt) && $opt->value == 'true') {
			$this->showall = true;
			add_action('wp_ajax_nopriv_fbuilder_edit', array(&$this, 'ajax_edit'));
			add_action('wp_ajax_nopriv_fbuilder_shortcode', array(&$this, 'ajax_shortcode'));  
			add_action('wp_ajax_nopriv_fbuilder_pages', array(&$this, 'ajax_pages'));  
			add_action('wp_ajax_nopriv_fbuilder_page_content', array(&$this, 'ajax_page_content'));  
		}
		if( is_admin() ) {
			
			register_activation_hook( $this->main , array(&$this, 'wp_activate') );
			
			add_action('admin_menu', array(&$this, 'admin_menu')); 
			
			add_action( 'init', array(&$this, 'global_admin_includes') );
			add_action('admin_head', array(&$this, 'admin_head')); 


			add_action('wp_ajax_fbuilder_check', array(&$this, 'ajax_check'));  
			add_action('wp_ajax_fbuilder_switch', array(&$this, 'ajax_switch'));  
			add_action('wp_ajax_fbuilder_shortcode', array(&$this, 'ajax_shortcode'));  
			add_action('wp_ajax_fbuilder_save', array(&$this, 'ajax_save'));  
			add_action('wp_ajax_fbuilder_pages', array(&$this, 'ajax_pages'));  
			add_action('wp_ajax_fbuilder_page_content', array(&$this, 'ajax_page_content'));  
			add_action('wp_ajax_fbuilder_template_save', array(&$this, 'ajax_template_save'));  
			add_action('wp_ajax_fbuilder_admin_save', array(&$this, 'ajax_admin_save'));  
			add_action('wp_ajax_fbuilder_edit', array(&$this, 'ajax_edit'));

			// Ajax calls
			add_theme_support( 'post-thumbnails' );
			
		}
		else {
			add_action('wp', array(&$this, 'refresh_variables'));
			add_action('wp_head', array(&$this, 'wp_head') );
			add_action('init', array(&$this, 'frontend_includes'));
			
			add_filter('the_content',array(&$this, 'replace_content'), 999);
			add_filter('get_the_excerpt', array(&$this, 'excerpt_filter'),0);
		}
		add_action( 'fbuilder_head', array(&$this, 'edit_page_includes'));
		add_action( 'admin_bar_menu', array(&$this, 'admin_bar'),81 );
}
	function activate() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'frontend_builder_pages';
	
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$fbuilder_pages_sql = "CREATE TABLE " . $table_name ." (
						  id mediumint(9) NOT NULL AUTO_INCREMENT,
						  switch text NOT NULL,
						  layout text NOT NULL,
						  items MEDIUMTEXT NOT NULL COLLATE utf8_general_ci,
						  PRIMARY KEY (id)
						);";	
	
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($fbuilder_pages_sql);			
		}
		
	
		$table_name = $wpdb->prefix . 'frontend_builder_options';
	
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$fbuilder_options_sql = "CREATE TABLE " . $table_name ." (
			              id mediumint(9) NOT NULL AUTO_INCREMENT,
						  name text NOT NULL,
						  value text NOT NULL,
						  PRIMARY KEY (id)
						);";
	
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($fbuilder_options_sql);			
		}
	
	}
	function wp_activate() {
		do_action('fbuilder_activate');
	}
	
	function remove_shortcodes($shortcodes = false) {
		if (is_array($shortcodes)) {
			foreach($shortcodes as $sh) {
				if(array_key_exists($sh, $this->shortcodes)) {
					unset($this->shortcodes[$sh]);
				}
			}
		}
		else if(is_string($shortcodes)) {
			unset($this->shortcodes[$shortcodes]);
		}
		else
		 $this->shortcodes = array();
	}
	function add_new_shortcodes($sh) {
		if(is_array($sh)) {
			$this->shortcodes = array_merge($this->shortcodes, $sh);
		}
	}
	function refresh_variables() {
		$nav_menus = json_encode(get_registered_nav_menus());
		$this->shortcodes = str_replace('"wp_nav_menu_list"', $nav_menus, $this->shortcodes);
	}
	function admin_head(){
		if(array_key_exists('post', $_GET)) {
			$builder = $this->database($_GET['post'], true);
			echo '<script type="text/javascript">var fbuilderSwitch="'.$builder->switch.'";</script>';
		}
		
	}
	function admin_bar() {
		
		if ( is_admin() ) {
			$current_screen = get_current_screen();
			$post = get_post();
	
			if ( 'post' == $current_screen->base
				&& 'add' != $current_screen->action
				&& ( $post_type_object = get_post_type_object( $post->post_type ) )
				&& current_user_can( 'read_post', $post->ID )
				&& ( $post_type_object->public )
				&& ( $post_type_object->show_in_admin_bar ) )
			{
				$this->admin_bar_links($post->ID);
			} elseif ( 'edit-tags' == $current_screen->base
				&& isset( $tag ) && is_object( $tag )
				&& ( $tax = get_taxonomy( $tag->taxonomy ) )
				&& $tax->public )
			{
				$this->admin_bar_links($post->ID);
			}
		}
	
		else {
				
			if ( !is_super_admin() || !is_admin_bar_showing() )
				return;
			$current_object = get_queried_object();
			if (!empty($current_object) && !empty( $current_object->post_type ) && ( $post_type_object = get_post_type_object( $current_object->post_type ) ) && current_user_can( $post_type_object->cap->edit_post, $current_object->ID )) {
				$this->admin_bar_links($current_object->ID);
				return;
			}
			if(!get_post_type()) {
				echo '';
				return;
			}
			global $post;
			$this->admin_bar_links($post->ID);
		
		}
	}
	function admin_bar_links($id) {
		global $wp_admin_bar;
		$sw = $this->ajax_check($id);
		if(isset($sw) && $sw == 'on') {
			$wp_admin_bar->add_menu(
				array( 'id' => 'fbuilder_edit',
	            	'href' => admin_url().'admin-ajax.php?action=fbuilder_edit&p='.$id,
					'title' => '<span class="fbuilder_edit_icon"></span>',
					'meta' => array( 'title' => __('Edit In Frontend', 'frontend-builder'),)
	        	)
	    	);
		}
		else {
			$wp_admin_bar->add_menu(
				array( 'id' => 'fbuilder_edit',
	            	'href' => admin_url().'admin-ajax.php?action=fbuilder_edit&p='.$id.'&sw=on',
					'title' => '<span class="fbuilder_edit_icon"></span>',
					'meta' => array('title' => __('Activate Frontend Builder', 'frontend-builder'))
	        	)
	    	);
		}
	}
	
	function global_admin_includes(){
		wp_enqueue_style('fbuilder_admin_global', $this->url . 'css/admin_global.css');
		wp_enqueue_script('fbuilder_admin_global', $this->url . 'js/admin_global.js', array('jquery'), 1.0, true);
	    wp_enqueue_script( 'wp-color-picker');
	    wp_enqueue_style( 'wp-color-picker');
	}
	
	function admin_menu() {
		$menu = add_menu_page( 'Frontend Builder', 'Frontend Builder', 'manage_options', 'frontendbuilder', array(&$this, 'admin_page'));
		
		add_action('load-'.$menu, array(&$this, 'admin_menu_includes')); 
	}
	
	function admin_menu_includes() {
		/* general includes */
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-color');
		wp_enqueue_script('jquery-ui');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-ui-accordion');
		
		/* image includes */
		wp_enqueue_style('thickbox');
		wp_enqueue_script('thickbox');
		
		/* custom scrollbar includes */
		wp_enqueue_script('fbuilder_mousewheel_js', $this->url . 'js/jquery.mousewheel.min.js');
		wp_enqueue_script('fbuilder_mCustomScrollbar_js', $this->url . 'js/jquery.mCustomScrollbar.min.js');
		wp_enqueue_style('fbuilder_mCustomScrollbar_css', $this->url . 'css/jquery.mCustomScrollbar.css');
		
		/* colorpicker includes */
	    wp_enqueue_script( 'fbuilder_iris', $this->url . 'js/iris.min.js',array(), 1.0, true);
		
		/* interface */		
		wp_enqueue_style('fbuilder_admin_page_css', $this->url . 'css/admin_page.css');
		wp_enqueue_script('fbuilder_admin_page_js', $this->url . 'js/admin_page.js');
	}
	
	function frontend_includes() {
		/* general includes */
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-color');
		wp_enqueue_script('jquery-ui');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-draggable');
		
		/* interface includes */
		wp_enqueue_style('fbuilder_font-awesome_css', $this->url . 'css/font-awesome.css');
		wp_enqueue_style('fbuilder_fornt_css', $this->url . 'css/front.css');
		
		/* required includes */
		wp_enqueue_style('fbuilder_prettyphoto_css', $this->url . 'css/jquery.prettyphoto.css');
		wp_enqueue_script('fbuilder_prettyphoto_js', $this->url . 'js/jquery.prettyphoto.js', array('jquery'),'3.1.5',true);
		wp_enqueue_style('fbuilder_swiper_css', $this->url . 'css/idangerous.swiper.css');
		wp_enqueue_script('fbuilder_swiper_js', $this->url . 'js/idangerous.swiper-2.0.min.js', array('jquery'),'2.0', true);
		
		/* shrotcode includes */
		wp_enqueue_style('fbuilder_animate_css', $this->url . 'css/animate.css');
		wp_enqueue_style('fbuilder_shortcode_css', $this->url . 'css/shortcodes.css');
		wp_enqueue_script('fbuilder_shortcode_js', $this->url . 'js/shortcodes.js', array('jquery', 'fbuilder_swiper_js', 'fbuilder_prettyphoto_js'),'1.0', true);
		
		
	}
	
	function edit_page_includes() {
		wp_enqueue_script(array('jquery', 'editor', 'thickbox', 'media-upload'));
		wp_enqueue_script('jquery-color');
		wp_enqueue_script('jquery-ui');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-draggable');
		
		/* admin css */
		wp_enqueue_style( 'colors' );
		wp_enqueue_style( 'ie' );
		wp_enqueue_script('utils');
		
		/* image includes */
		wp_enqueue_style('thickbox');
		wp_enqueue_script('thickbox');
		
		/* custom scrollbar includes */
		wp_enqueue_script('fbuilder_mousewheel_js', $this->url . 'js/jquery.mousewheel.min.js');
		wp_enqueue_script('fbuilder_mCustomScrollbar_js', $this->url . 'js/jquery.mCustomScrollbar.min.js');
		wp_enqueue_style('fbuilder_mCustomScrollbar_css', $this->url . 'css/jquery.mCustomScrollbar.css');
		
		/* colorpicker includes */
	    wp_enqueue_script( 'fbuilder_iris', $this->url . 'js/iris.min.js',array(), 1.0, true);
		
		/* interface includes */
		wp_enqueue_style('fbuilder_font-awesome_css', $this->url . 'css/font-awesome.css');
		wp_enqueue_style('fbuilder_fornt_css', $this->url . 'css/front.css');
		wp_enqueue_script('fbuilder_front_js', $this->url . 'js/front.js', array('jquery'),'1.0', true);
		
}
		
	function admin_page() {
		require_once($this->path . '/pages/admin_page.php');
	}
	
	function get_admin_controls() {
		$output = array();
		require_once($this->path .'/functions/admin_control_list.php');
		
		$optionsDB = $this->option();
		foreach($output as $skey => $section) {
			$controls = $section['options'];
			if(is_array($controls)) {
				foreach($controls as $ckey => $control) {
					if($control['type'] == 'collapsible') {
						foreach($control['options'] as $okey => $option) {
							if(array_key_exists('name',$option)) {
								$exists = false;
								foreach($optionsDB as $ind => $opt) {
									if(is_object($opt) && $opt->name == $option['name']) {
										$exists =  true;
										$output[$skey]['options'][$ckey]['options'][$okey]['std'] = $optionsDB[$ind];
										unset($optionsDB[$ind]);
										break;
									}
								}
								if(!$exists && array_key_exists('std', $option)) {
									$this->option($option['name'], $option['std']);
								}
							}
						}
					}
					else {
						if(array_key_exists('name',$control)) {
							$exists = false;
							foreach($optionsDB as $ind => $opt) {
								if(is_object($opt) && $opt->name == $control['name']) {
									$exists =  true;
									if(array_key_exists($skey, $output) && array_key_exists('otpions', $output[$skey]) && array_key_exists($ckey, $output[$skey]['options']))
										$output[$skey]['options'][$ckey]['std'] = $optionsDB[$ind];
									unset($optionsDB[$ind]);
									break;
								}
							}
							if(!$exists && array_key_exists('std', $control)) {
								$this->option($control['name'], $control['std']);
							}
						}
					}
					
				}
			}
		}
		return $output;
	}
	function get_admin_hideifs($options) {
		$hideifs = array();
		foreach($options as $control) {
			
			if($control['type'] == 'collapsible') {
				foreach($control['options'] as $option) {
					if(array_key_exists('hide_if', $option)) {
						$hideifs[$option['name']] = $option['hide_if'];
					}
				}
			}
			else {
				if(array_key_exists('hide_if', $control)) {
					$hideifs[$control['name']] = $control['hide_if'];
				}
			}
		}
		return $hideifs;
	}
	function get_admin_control($arr) {
		global $builder_icons;
		$fbuilder_icons = $this->icons;
		require_once($this->path .'/functions/admin_controls.php');
		$ctrl = new fbuilderControl($arr);
		return $ctrl->html;
	}
	function get_menu_controls() {
		$output = '{}';
		require_once($this->path .'/functions/menu_controls.php');
		return $output;
	}
	function extract_row_controls($row) {
		$output = array('row' => array(), 'column' => array());
		$id = '';
		$class = '';
		$style = '';
		$colstyle = '';
		$rowback = '';
		$rowbackrep = '';
		$rowbackpos = '';
		$rowbackcolor = '';
		if(isset($row['options']))
		foreach($row['options'] as $key => $option) {
			switch($key) {				
				case 'id':
					$id = $option; 
					break;				
				case 'class':
					$class .= $option.' '; 
					break;			
				case 'padding_top':
					$style .= 'padding-top:'.((int)$option).'px;'; 
					break;
				
				case 'padding_bot':
					$style .= 'padding-bottom:'.((int)$option).'px;';
					break;
				
				case 'back_type' :
					if($option == 'parallax') 
						$rowbackpos = 'fixed';
					break;
				case 'back_color' :
					if($option != '')
						$rowbackcolor = 'background-color:'.$option.';';
					break;
				
				case 'back_image' :
					if($option != '')
						$rowback = 'background-image:url('.$option.');';
					break;
					
				case 'back_repeat' :
					if($option == 'true') 
						$rowbackrep = 'background-repeat:repeat;';
					break;
				
				case 'column_padding' :
					$colstyle .= 'padding:'.((int)$option).'px;';
					break;
				
				case 'column_back' :
					if(!isset($row['options']['column_back_opacity'])) {
						if($option != '')
							$colstyle .= 'background:'.$option.';';
					}
					else {
					    $color = str_replace('#', '', $row['options']['column_back']);
					    if (strlen($color) != 6){ 
							$colstyle .= 'background:transparent;';
						}
						else {
						    $rgb = array();
						    for ($x=0;$x<3;$x++){
						        $rgb[$x] = hexdec(substr($color,(2*$x),2));
						    }
							$colstyle .= 'background:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].','.(((int)$row['options']['column_back_opacity'])/100).');';
						}

					}
					break;
			}
		}
		
		if($rowback != '' ) {
			$output['row']['back'] = '<div class="fbuilder_row_background'.($rowbackpos == 'fixed' ? ' fbuilder_row_background_fixed' : '').($rowbackpos == 'parallax' ? ' fbuilder_row_background_parallax' : '').'" style="'.$rowback.$rowbackcolor.$rowbackrep.'" ></div>';
		}
		else if($rowbackcolor) {
			$output['row']['back'] = '<div class="fbuilder_row_background" style="'.$rowbackcolor.'"></div>';
		}
		else {
			$output['row']['back'] = '';
		}
		$output['row']['class'] = $class;
		$output['row']['style'] = $style;
		$output['row']['id'] = $id;
		$output['column']['style'] = $colstyle;
		return $output;
	}
	function get_row_controls() {
		$output = '{}';
		require_once($this->path .'/functions/row_control_list.php');
		return $output;
	}
	
	function get_shortcodes() {
		$output = array();
		require_once($this->path .'/functions/shortcode_list.php');
		return $output;
	}
	
	function get_icons() {
		$output = array();
		require_once($this->path .'/functions/icon_list.php');
		return $output;
	}
	
	function get_rows() {
		$output = array();
		require_once($this->path .'/functions/row_list.php');
		return $output;
	}
	
	function get_shortcode($get) {
		if(array_key_exists('f',$get)) {
			$shortcode = '['.$get['f'];
			$content = '';
			if(array_key_exists('options',$get)) {
				$optArray = $get['options'];
				foreach($optArray as $name => $val) {
					// check for sortable elements
					if (!is_array($val)) {
						if($name == 'content') $content = str_replace('&quot;','"',$val);	
						else $shortcode .= ' '.$name.'="'.$val.'"';
					}
					else if(!empty($val)) {
						$sortableOpts = Array();
						$firstOpt = true;
						foreach($val['order'] as $pos => $id) {
							foreach($val['items'][$id] as $opt => $oval) {
								if($opt == 'content') {
									if($firstOpt) {
										$firstOpt = false;
										$content .= str_replace('&quot;','"',$oval);
									}
									else {
										$content .= '|'.str_replace('&quot;','"',$oval);
									}
									
								}
								else $sortableOpts[$opt] = (array_key_exists($opt,$sortableOpts) ? $sortableOpts[$opt].'|'.$oval : $oval);
							}
						}
						foreach($sortableOpts as $opt => $oval) {
							if($opt == 'content') $content = str_replace('&quot;','"',$oval);	
							else $shortcode .= ' '.$opt.'="'.$oval.'"';
						}
					}
				}
			}
			$shortcode .= ']'.$content.'[/'.$get['f'].']';
			return do_shortcode($shortcode);
		}
	}
	
	function get_google_fonts($json = false) {
		$current_date = getdate(date("U"));
		
		$current_date = $current_date['weekday'] . $current_date['month'] . $current_date['mday'] . $current_date['year'];
		
		if(!get_option('fbuilder_admin_webfonts')) {
			$file_get = wp_remote_fopen("http://www.shindiristudio.com/responder/fonts.txt");
			if (strlen($file_get)>100) {
				add_option('fbuilder_admin_webfonts', $file_get);
				add_option('fbuilder_admin_webfonts_date', $current_date);
			}
		}
		
		if(get_option('fbuilder_admin_webfonts_date') != $current_date || get_option('fbuilder_admin_webfonts_date') == '') {
			$file_get = wp_remote_fopen("http://www.shindiristudio.com/responder/fonts.txt");
			if (strlen($file_get)>100) {
				update_option('fbuilder_admin_webfonts', wp_remote_fopen("http://www.shindiristudio.com/responder/fonts.txt"));
				update_option('fbuilder_admin_webfonts_date', $current_date);
			}
		}
		
		
		$fontsjson = get_option('fbuilder_admin_webfonts');
		$decode = json_decode($fontsjson, true);
		if(!is_array($decode) || $fontsjson == '' || !isset($fontsjson)) {
			$fontFailList = '';
			require_once($this->path . '/functions/font_list.php');
			$fontsjson = $fontFailList;
			$decode = json_decode($fontsjson, true);
		}
			
		$webfonts = array();
		$webfonts['default'] = 'Default';
		foreach ($decode['items'] as $key => $value) {
			$item_family= $decode['items'][$key]['family'];
			$item_family_trunc =  str_replace(' ','+',$item_family);
			$webfonts[$item_family_trunc] = $item_family;
		}
		if ($json) return $fontsjson;
		return $webfonts;
	}
	
	function get_font_variants($optionName = false, $variants = false) {
		if($optionName == false) {
			$fontsjson = get_option('fbuilder_admin_webfonts');
			$decode = json_decode($fontsjson, true);
			if(!is_array($decode) || $fontsjson == '' || !isset($fontsjson)) {
				$fontFailList = '';
				require_once($this->path . '/functions/font_list.php');
				$fontsjson = $fontFailList;
				$decode = json_decode($fontsjson, true);
			}
			$vars = array();
			foreach ($decode['items'] as $key => $value) {
				$vars[$value['family']] =  $value['variants'];
			}
			return $vars;
		}
		else {
			$font = str_replace('+',' ', $this->option($optionName)->value);
			if($font == 'default' || $font == '') return array('default' => 'Default');
			else if($variants != false && is_array($variants)) {
				if(array_key_exists($font, $variants)) {
					return $variants[$font];
				}
				else {
					return array('regular');
				}
			}
			else {
				$fontsjson = get_option('fbuilder_admin_webfonts');
				$decode = json_decode($fontsjson, true);
				if(!is_array($decode) || $fontsjson == '' || !isset($fontsjson)) {
					$fontFailList = '';
					require_once($this->path . '/functions/font_list.php');
					$fontsjson = $fontFailList;
					$decode = json_decode($fontsjson, true);
				}
				foreach ($decode['items'] as $key => $value) {
					if ($value['family'] == $font) {
						$vars = array();
						foreach($value['variants'] as $fvar) {
							$vars[$fvar] = $fvar;
						}
						return $vars;
						
					}
				}
			}
		}
	}
	
	function get_font_head() {
		$output = '';
		require_once($this->path .'/functions/font_head.php');
		return $output;
	}
	
	function get_head_css() {
		$output = '';
		require_once($this->path .'/functions/head_css.php');
		return $output;
	}
	function strip_html_tags( $text )
	{
	    $text = preg_replace(
	        array(
	          // Remove invisible content
	            '@<head[^>]*?>.*?</head>@siu',
	            '@<style[^>]*?>.*?</style>@siu',
	            '@<script[^>]*?.*?</script>@siu',
	            '@<object[^>]*?.*?</object>@siu',
	            '@<embed[^>]*?.*?</embed>@siu',
	            '@<applet[^>]*?.*?</applet>@siu',
	            '@<noframes[^>]*?.*?</noframes>@siu',
	            '@<noscript[^>]*?.*?</noscript>@siu',
	            '@<noembed[^>]*?.*?</noembed>@siu',
	          // Add line breaks before and after blocks
	            '@</?((address)|(blockquote)|(center)|(del))@iu',
	            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
	            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
	            '@</?((table)|(th)|(td)|(caption))@iu',
	            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
	            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
	            '@</?((frameset)|(frame)|(iframe))@iu',
	        ),
	        array(
	            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
	            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
	            "\n\$0", "\n\$0",
	        ),
	        $text );
	    return strip_tags( $text );
	}
	
	
	function excerpt_filter($output) {
        global $post;
        if(empty($output) && !empty($post->post_content)) {
            $text = $this->strip_html_tags(strip_shortcodes($post->post_content));
            $excerpt_length = apply_filters('excerpt_length', 55);
            $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
            $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
            return $text;
        }
        return $output;
	}
	function replace_content($content, $pid = 0) {
		if($content == '//builder-false') {
			$id = $pid;
			$locked = false;
		}
		else {
			global $post; 
			$id = $post->ID;
			$locked = post_password_required();
		}
		$builder = $this->database($id, true);
		$output = '';
		if($content == '//builder-false' || ($builder->switch == 'on' && !$locked)) {
			require($this->path . '/pages/front_html.php');
			return $output;
		}
		else {
			return $content;
		}
	}
	// DEPRECATED
	function get_html($builder){
		$html = '';
		$output = '
		<div id="fbuilder_wrapper"'.($builder->items == '{}' ? ' class="empty"' : '').'>';

		$sidebar = false;
		if($builder->items != '{}') {
			$items = json_decode(stripslashes($builder->items), true);
			if(array_key_exists('sidebar', $items) 
				&& array_key_exists('active', $items['sidebar'])
				&& array_key_exists('items', $items['sidebar']) 
				&& array_key_exists('type', $items['sidebar']) 
				&& $items['sidebar']['active'] == true) {
				$sidebar = $items['sidebar']['type'];
				$html = '<div class="fbuilder_sidebar fbuilder_'.$items['sidebar']['type'].' fbuilder_row" data-rowid="sidebar"><div class="fbuilder_column">';
				if(is_array($items['sidebar']['items'])) {
					
					foreach($items['sidebar']['items'] as $sh) {
						if(!is_null($items['items'][$sh])) {
							$html .= '<div class="fbuilder_module" data-shortcode="'.$items['items'][$sh]['slug'].'" data-modid="'.$sh.'">';
							$html .= $this->get_shortcode($items['items'][$sh]);
							$html .= '</div>';
						}
					}
					
				}
				$html .= '</div><div style="clear:both;"></div></div>';
			}
			
		}
		$output .= $html.'
			<div id="fbuilder_content_wrapper"'.($sidebar != false ? ' class="fbuilder_content_'.$sidebar.'"' : '').'>
				<div id="fbuilder_content">
		';

		if($builder->items != '{}') {
			$rows = $this->rows;
			
			for($rowId = 0; $rowId<$items['rowCount']; $rowId++) {
				if(array_key_exists($rowId, $items['rowOrder']))
					$row = $items['rowOrder'][$rowId];
				else 
					$row = null;
				if(!is_null($row)) {
					$current = $items['rows'][$row];
					$html = $rows[$current['type']]['html'];
					$html = str_replace('%1$s',$row,$html);
					$html = str_replace('%2$s','',$html);
					
					foreach($current['columns'] as $colId => $shortcodes) {
						$columnInterface = '';
							foreach($shortcodes as $sh) {
							if(!is_null($items['items'][$sh])) {
								$columnInterface .= '<div class="fbuilder_module" data-shortcode="'.$items['items'][$sh]['slug'].'" data-modid="'.$sh.'">';
								$columnInterface .= $this->get_shortcode($items['items'][$sh]);
								$columnInterface .= '</div>';
							}
						}
						$html = str_replace('%'.($colId+3).'$s',$columnInterface,$html);
					}
					
					$output .= $html;
				}
			}
		}


		$output .= '
				</div>
				<div style="clear:both"></div>
			</div>
			<div style="clear:both"></div>
		</div>
		';

		return $output;
	}
	
	function refresh_shortcode_list() {
		$fbuilder_sidebars = array();
		$fbuilder_sidebar_std = '';
		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
			if($fbuilder_sidebar_std == '') $fbuilder_sidebar_std = $sidebar['id'];
			$fbuilder_sidebars[$sidebar['id']] = ucwords( $sidebar['name'] );
		}
		if(array_key_exists('sidebar', $this->shortcodes))
		$this->shortcodes['sidebar']['options']['name']['options'] = $fbuilder_sidebars;
		$this->shortcodes['sidebar']['options']['name']['std'] = $fbuilder_sidebar_std;
		
		foreach($this->shortcodes as $name => $array) {
			if(!isset($this->hideifs['children'][$name])) $this->hideifs['children'][$name] = array();
			if(!isset($this->hideifs['parents'][$name])) $this->hideifs['parents'][$name] = array();
			foreach($array['options'] as $opt => $optarray) {
				if($optarray['type'] == 'sortable') {
					foreach($optarray['options'] as $soname => $soarray) {
						if(isset($soarray['hide_if'])) {
							if(!isset($this->hideifs['children'][$name])) $this->hideifs['children'][$name] = array();
							if(!isset($this->hideifs['children'][$name][$opt])) $this->hideifs['children'][$name][$opt] = array();
							$this->hideifs['children'][$name][$opt][$soname] = $soarray['hide_if'];
							
							foreach($soarray['hide_if'] as $hide => $hidear) {
								if(!isset($this->hideifs['parents'][$name][$hide])) $this->hideifs['parents'][$name][$hide] = array();
								if(array_keys($hidear) !== range(0, count($hidear) - 1)) {
									foreach($hidear as $sohide => $sohidear) {
										if(!isset($this->hideifs['parents'][$name][$hide][$sohide])) $this->hideifs['parents'][$name][$hide][$sohide] = array();
										if(!isset($this->hideifs['parents'][$name][$hide][$sohide][$opt])) $this->hideifs['parents'][$name][$hide][$sohide][$opt] = array();
										$this->hideifs['parents'][$name][$hide][$sohide][$opt][$soname] = $sohidear;
									}
								}
								else {
									if(!isset($this->hideifs['parents'][$name][$hide][$opt])) $this->hideifs['parents'][$name][$hide][$opt] = array();
									$this->hideifs['parents'][$name][$hide][$opt][$soname] = $hidear;
								}
							}
							/*
							$this->hideifs['children'][$opt] = $optarray['hide_if'];
							$optarray['hide_if']*/
						}
					}
				}
				else {
					if(isset($optarray['hide_if'])) {
						$this->hideifs['children'][$name][$opt] = $optarray['hide_if'];
						foreach($optarray['hide_if'] as $hide => $hidear) {
							if(!isset($this->hideifs['parents'][$name][$hide])) $this->hideifs['parents'][$name][$hide] = array();
							$this->hideifs['parents'][$name][$hide][$opt] = $hidear;
							
							/* for sortable
							if(array_keys($hidear) !== range(0, count($hidear) - 1)) {
								
							}
							else {
								
							}*/
						}
						/*
						$this->hideifs['children'][$opt] = $optarray['hide_if'];
						$optarray['hide_if']*/
					}
				}
			}
		}
	}
	
	function wp_head() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$this->yoast = is_plugin_active('wordpress-seo/wp-seo.php');
		$output = $this->get_font_head();
		$output .= $this->get_head_css();
		
		echo $output;
		
	}
	
	function ajax_shortcode() {
	
		if(array_key_exists('options',$_POST)) {
			$_POST['options'] = json_decode(stripslashes($_POST['options']),true);
		}
		echo $this->get_shortcode($_POST);
		die();
	}
	
	function ajax_save() {
		if(array_key_exists('json',$_POST)) {
			
			global $wpdb;
			$table_name = $wpdb->prefix . 'frontend_builder_pages';
			$id = (int)$_POST['id'];
		
			$wpdb->update(
				$table_name,
				array(
					'items' => $_POST['json']
				),
				array( 'id' => $id),
				array(
					'%s'	
				),
				array('%d')
			);
			if($this->option('save_overwrite')->value == 'true') {
				$my_post = array();
				$my_post['ID'] = $id;
				$my_post['post_content'] = $this->replace_content('//builder-false',$id);
				
				wp_update_post( $my_post );
			}
		
			echo 'success';
		}
		die();
	}
	
	function ajax_pages() {
		$pages = $this->database(false, true, false, false, false, true);
		$templates = $this->option('templates');
		if($templates->value == '') {
			$this->option('templates', '{}');
		}
		
		
		
		$pages = (array) $pages;
		$obj = array();
		if(count($pages) > 0) {
			foreach($pages as $id => $page) {
				$page->title = get_the_title($page->id);
				if($page->title == '')
					$page->title = '(no-title : id='.$page->id.')';
				//$page->items = stripslashes($page->items);
				if(!is_null(get_post((int)$page->id)))
					$obj[$page->id] = $page;
			}
		}
		echo '{"pages" : '. json_encode($obj). ', "templates" : ' . $templates->value .'}';
		die();
	}
	
	function ajax_page_content(){
		if(isset($_GET['id'])) {
			$page = $this->database($_GET['id'], true);
			$html = $this->replace_content('//builder-false',$_GET['id']);
			echo $page->items . '|+break+response+|' . $html;
		}
		die();
	}
	function ajax_template_save(){
		if(isset($_POST['name']) && isset($_POST['items'])) {
			$tmplArr = array($_POST['name'] => $_POST['items']);
			$this->save_templates(array($_POST['name'] => $_POST['items']));
		}
		die();
	}
	
	function ajax_edit() {
		//header('X-Frame-Options: GOFORIT');
		require($this->path . '/pages/edit_page.php');
		die();
	}
	
	
	function ajax_admin_save(){
		if(array_key_exists('json', $_POST)) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'frontend_builder_options';
			$rows = $wpdb->get_results('SELECT * FROM '.$table_name);
			foreach($_POST['json'] as $option => $value) {
				$exists = false;
				foreach($rows as $row) {
					if($row->name == $option) {
						if($row->value != $value)
							$this->option($option, $value, array($row));
						$exists = true;
						break;
					}
				}
				if(!$exists) {
						$this->option($option, $value, '!exists');
				}
			}
		}
		echo 'success';
		die();
	}
	
	function ajax_check($id = false) {
		if($id) {
			$builder = $this->database($id, true);
			return $builder->switch;
			
		}
		else if(array_key_exists('p',$_GET)) {
			$builder = $this->database($_GET['p'], true);
			echo $builder->switch;
		}
		die();
	}
	function ajax_switch($ret = false) {
		if(array_key_exists('p',$_GET) && array_key_exists('sw', $_GET)) {
			global $wpdb;
			$content = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE id = '" . $_GET['p'] . "'", 'ARRAY_A');
			if(array_key_exists('post_status', $content) && $content['post_status'] != 'auto-draft') {
				$this->database($_GET['p'], false, $_GET['sw']);
				if($ret) return;
				echo 'success';
			}
			else {
				echo 'You need to set the title and save post as draft first.';
			}
		}
		else {
			echo 'You need to set the title and save post as draft first.';
		}
		die();
	}
	
	function save_templates($arr = false) {
		$templates = $this->option('templates');
		if($templates->value == '') {
			$this->option('templates', '{}');
			$tmplObj = array();
		}
		else {
			$tmplObj = json_decode($templates->value,true);
		}
		if(is_array($arr)) foreach($arr as $name => $items) {
			$tmplID = array_search($name,$tmplObj);
			if($tmplID) {
				$tmplID = (int)$tmplID;
				$this->database($tmplID,false,false,false, $items);
			}
			else {
				$tmplID = 8000000;
				while(isset($tmplObj[''+$tmplID])) 
					$tmplID++;
				$this->database($tmplID,false,'template','full width', $items);
				$tmplObj[''+$tmplID] = $name;
				$this->option('templates', json_encode($tmplObj));
			}
		}
	}
	
	function set_options ($arr = false) {
		if(is_array($arr)) {
			$rows = $this->option();
			foreach($arr as $key => $val) {
				foreach($rows as $rkey => $row) {
					if($row->name == $key) {
						$this->option($key, $val, array($row));
						unset($rows[$rkey]);
					}
				}
			}	
		}
	}
	
	function option($name = false, $value = false, $rows = false){
		global $wpdb;
		$table_name = $wpdb->prefix . 'frontend_builder_options';
		if(!$rows) $rows = $wpdb->get_results('SELECT * FROM '.$table_name. ($name ? ' WHERE name=\''.$name.'\'' : ''));
		if($rows != '!exists' && count($rows) != 0 ) {
			if($value) {
				$wpdb->update(
					$table_name,
					array(
						'value' => $value,
						'name' => $name),
					array('id' => $rows[0]->id),
					array(
						'%s',
						'%s'),
					array('%d')
				);
			}
			else if(!$name){
				return $rows;
			}
			else {
				return $rows[0];
			}
		}
		else {
			if($value) {
				$wpdb->insert(
					$table_name,
					array(
						'name' => $name,
						'value' => $value),
					array(
						'%s',
						'%s')					
					
				);
			}
			else {
				$output = new stdClass();
				$output->value = '';
				return $output;
			}
		}
	}
	function database($id = false, $get = false, $switch = false, $layout = false, $items = false, $no_content = false) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'frontend_builder_pages';
		$rows = $wpdb->get_results('SELECT '.($no_content ? 'id' : '*').' FROM '.$table_name. ($id !== false ? ' WHERE id='.$id : ''));
		if(count($rows) != 0) {
			if($get) {
				if($id !== false)
					return $rows[0];
				else
					return $rows;
			}
			else {
				$wpdb->update(
					$table_name,
					array(
						'switch' => ($switch ? $switch : $rows[0]->switch),
						'layout' => ($layout ? $layout : $rows[0]->layout),
						'items'=> ($items ? $items : $rows[0]->items)),
					array( 'id' => $id ),
					array( 
						'%s',
						'%s',
						'%s'),
					array('%d')
				);
			}
		}
		else {
			if($get) {
				$output = new stdClass();
				$output->items = '{}';
				$output->switch = 'off';
				$output->layout = 'full width';
				return $output;
			}
			else {
				$wpdb->insert(
					$table_name,
					array(
						'id' => $id,
						'switch' => ($switch ? $switch : 'on'),
						'layout' => ($layout ? $layout : 'full width'),
						'items'=>($items ? $items : '{}')),	
					array(
						'%d',
						'%s',
						'%s',
						'%s')					
					
				);
			}
		}
	}
}
?>