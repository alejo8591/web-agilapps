<?php


$optsDB = $this->option();
$optsDBaso = Array();
$admin_options = $this->admin_controls;
$admin_fonts = array();
$font_options = array();


foreach($optsDB as $oo) {
	$optsDBaso[$oo->name] = $oo->value;
}
if(array_key_exists('font', $admin_options) && array_key_exists('options', $admin_options['font'])) {
	foreach($admin_options['font']['options'] as $font_option) {
		if(array_key_exists('type',$font_option) && $font_option['type'] == 'collapsible')
			foreach($font_option['options'] as $col_option) {
				if(array_key_exists('name',$col_option)) {
					if(array_key_exists($col_option['name'],$optsDBaso)) {
						$font_options[$col_option['name']] = $optsDBaso[$col_option['name']];
					}
					else {
						$font_options[$col_option['name']] = $col_option['std'];
					}
					if(substr($col_option['name'],-6) == 'family') {
						if(array_key_exists($col_option['name'],$optsDBaso)) {
							$admin_fonts[substr($col_option['name'],0,-12)] = $optsDBaso[$col_option['name']];
						}
						else {
							$admin_fonts[substr($col_option['name'],0,-12)] = $col_option['std'];
						}
					}
				}
			}
		else if(array_key_exists('name',$font_option)) {
			$font_options[$font_option['name']] = $font_option['std'];
			if(substr($font_option['name'],-6) == 'family')
				$admin_fonts[substr($font_option['name'],0,-12)] = $font_option['std'];
		}
	}
}
$used_fonts = array();
foreach($admin_fonts as $kk => $vv) {
	$opt = '';
	$fnt = $vv;
	if(empty($fnt) || $fnt == '') $fnt = 'default';
	if($fnt != 'default') {
		$opt .= 'font-family: '.str_replace('+',' ',$fnt).', serif; ';
		$stl = $font_options[$kk.'_font_style'];
		$ipos = strpos($stl,'italic');
		if ($stl == 'regular') {
			$opt .= 'font-weight:400; font-style: normal; ';
		} 
		else if($ipos !== false) {
			if ($ipos > 0) {
				$opt .= 'font-weight:'.substr($stl,0,$ipos).'; ';
			}
			else {
				$opt .= 'font-weight: 400; ';
			}
			$opt .= 'font-style:italic; ';
		}
		else {
			$opt .= 'font-weight:'.$stl.'; font-style: normal; ';
		}
		if(array_key_exists($fnt, $used_fonts)) {
			if (!in_array($stl, $used_fonts[$fnt])) {
				array_push($used_fonts[$fnt],$stl);
			}
		}
		else {
			$used_fonts[$fnt] = array($stl);
		}
		$opt .= 'font-size:'.((int)$font_options[$kk.'_font_size']).'px; line-height:'.((int)$font_options[$kk.'_line_height']).'px;';
		$admin_fonts[$kk] = $opt;
	}
}

$used_fonts_string = '';
$firstFont = true;
foreach($used_fonts as $kk => $vv) {
	if($firstFont) $firstFont = false;
	else $used_fonts_string.='|';
	$used_fonts_string.= $kk;
	$firstStyle = true;
	foreach ($vv as $style) {
		if($firstStyle) {
			$firstStyle = false;
			$used_fonts_string.=':';
		}
		else {
			$used_fonts_string.=',';
		}
		$used_fonts_string.= $style;
	}
}

if($used_fonts_string != '')
	$output .= '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.$used_fonts_string.'">';
	$output .= '
<style>';
if(array_key_exists('h1', $admin_fonts) && $admin_fonts['h1'] != 'default')
	$output .= '
	#fbuilder_wrapper h1 {
		'.$admin_fonts['h1'].'
	}';
if(array_key_exists('h2', $admin_fonts) && $admin_fonts['h2'] != 'default')
	$output .= '
	#fbuilder_wrapper h2 {
		'.$admin_fonts['h2'].'
	}';
if(array_key_exists('h3', $admin_fonts) && $admin_fonts['h3'] != 'default')
	$output .= '
	#fbuilder_wrapper h3 {
		'.$admin_fonts['h3'].'
	}';
if(array_key_exists('h4', $admin_fonts) && $admin_fonts['h4'] != 'default')
	$output .= '
	#fbuilder_wrapper h4 {
		'.$admin_fonts['h4'].'
	}';
if(array_key_exists('h5', $admin_fonts) && $admin_fonts['h5'] != 'default')
	$output .= '
	#fbuilder_wrapper h5 {
		'.$admin_fonts['h5'].'
	}';
if(array_key_exists('h6', $admin_fonts) && $admin_fonts['h6'] != 'default')
	$output .= '
	#fbuilder_wrapper h6 {
		'.$admin_fonts['h6'].'
	}';
if(array_key_exists('slider', $admin_fonts) && $admin_fonts['slider'] != 'default')
	$output .= '
	#fbuilder_wrapper .content-slide {
		'.$admin_fonts['slider'].'
	}';
if(array_key_exists('button', $admin_fonts) && $admin_fonts['button'] != 'default')
	$output .= '
	#fbuilder_wrapper a.frb_button {
		'.$admin_fonts['button'].'
	}';
if(array_key_exists('testimonial_name', $admin_fonts) && $admin_fonts['testimonial_name'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_testimonials_name b{
		'.$admin_fonts['testimonial_name'].'
	}';
if(array_key_exists('testimonial_profession', $admin_fonts) && $admin_fonts['testimonial_profession'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_testimonials_name span{
		'.$admin_fonts['testimonial_profession'].'
	}';
if(array_key_exists('testimonial_quote', $admin_fonts) && $admin_fonts['testimonial_quote'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_testimonials_quote{
		'.$admin_fonts['testimonial_quote'].'
	}';
if(array_key_exists('accordion_title', $admin_fonts) && $admin_fonts['accordion_title'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_accordion h3 {
		'.$admin_fonts['accordion_title'].'
	}';
if(array_key_exists('accordion_content', $admin_fonts) && $admin_fonts['accordion_content'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_accordion .ui-accordion-content {
		'.$admin_fonts['accordion_content'].'
	}';
if(array_key_exists('tabs_title', $admin_fonts) && $admin_fonts['tabs_title'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_tabs ul:first-child li a {
		'.$admin_fonts['tabs_title'].'
	}';
if(array_key_exists('tabs_content', $admin_fonts) && $admin_fonts['tabs_content'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_tabs-content {
		'.$admin_fonts['tabs_content'].'
	}';
if(array_key_exists('alert_text', $admin_fonts) && $admin_fonts['alert_text'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_alert_text {
		'.$admin_fonts['alert_text'].'
	}';
if(array_key_exists('features_title', $admin_fonts) && $admin_fonts['features_title'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_features h3.frb_features_title,
	#fbuilder_wrapper a .frb_features h3.frb_features_title {
		'.$admin_fonts['features_title'].'
	}';
if(array_key_exists('features_content', $admin_fonts) && $admin_fonts['features_content'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_features .frb_features_content,
	#fbuilder_wrapper a .frb_features .frb_features_content {
		'.$admin_fonts['features_content'].'
	}';
if(array_key_exists('menu_main', $admin_fonts) && $admin_fonts['menu_main'] != 'default')
	$output .= '
	#fbuilder_wrapper ul.frb_menu_header,
	#fbuilder_wrapper ul.frb_menu.frb_menu_horizontal-clean li a,
	#fbuilder_wrapper ul.frb_menu.frb_menu_horizontal-squared li a,
	#fbuilder_wrapper ul.frb_menu.frb_menu_horizontal-rounded li a{
		'.$admin_fonts['menu_main'].'
	}';
if(array_key_exists('menu_submenu', $admin_fonts) && $admin_fonts['menu_submenu'] != 'default')
	$output .= '
	#fbuilder_wrapper ul.frb_menu.frb_menu_horizontal-clean li li a,
	#fbuilder_wrapper ul.frb_menu.frb_menu_horizontal-squared li li a,
	#fbuilder_wrapper ul.frb_menu.frb_menu_horizontal-rounded li li a,
	#fbuilder_wrapper ul.frb_menu li a,{
		'.$admin_fonts['menu_submenu'].'
	}';
if(array_key_exists('searchbox', $admin_fonts) && $admin_fonts['searchbox'] != 'default')
	$output .= '
	#fbuilder_wrapper input.frb_searchinput {
		'.$admin_fonts['searchbox'].'
	}';
if(array_key_exists('image_desc', $admin_fonts) && $admin_fonts['image_desc'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_image_desc {
		'.$admin_fonts['image_desc'].'
	}';
if(array_key_exists('featured_post_title', $admin_fonts) && $admin_fonts['featured_post_title'] != 'default')
	$output .= '
	#fbuilder_wrapper h3.frb_post_title {
		'.$admin_fonts['featured_post_title'].'
	}';
if(array_key_exists('featured_post_meta', $admin_fonts) && $admin_fonts['featured_post_meta'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_post_meta,
	#fbuilder_wrapper .frb_post_meta a {
		'.$admin_fonts['featured_post_meta'].'
	}';
if(array_key_exists('featured_post_content', $admin_fonts) && $admin_fonts['featured_post_content'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_post_content {
		'.$admin_fonts['featured_post_content'].'
	}';
if(array_key_exists('featured_post_button', $admin_fonts) && $admin_fonts['featured_post_button'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_post a.frb_button {
		'.$admin_fonts['featured_post_button'].'
	}';
if(array_key_exists('pricing_table_price', $admin_fonts) && $admin_fonts['pricing_table_price'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_pricing_table .frb_pricing_table_price span div {
		'.$admin_fonts['pricing_table_price'].'
	}';
if(array_key_exists('pricing_table_title', $admin_fonts) && $admin_fonts['pricing_table_title'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_pricing_table .frb_pricing_table_price span div {
		'.$admin_fonts['pricing_table_title'].'
	}';
if(array_key_exists('pricing_table_text', $admin_fonts) && $admin_fonts['pricing_table_text'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_pricing_table .frb_pricing_row_heading {
		'.$admin_fonts['pricing_table_text'].'
	}';
if(array_key_exists('pricing_table_button', $admin_fonts) && $admin_fonts['pricing_table_button'] != 'default')
	$output .= '
	#fbuilder_wrapper .frb_pricing_table .frb_pricing_table_button {
		'.$admin_fonts['pricing_table_button'].'
	}';
	
	
	
	$output .= '	
</style>';




?>