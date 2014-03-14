<?php



/* ------------------ */
/* fbuilder_separator */
/* ------------------ */

function fbuilder_separator ($atts, $content=null) {
	extract (shortcode_atts( array(
		'width' => 2,
		'style' => 'solid',
		'color' => '#27a8e1',
		'bot_margin' => 24,
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts));
	
	$styleArray = array('solid', 'dashed', 'dotted', 'double');
	if(!in_array($style,$styleArray)) $style = 'solid';
	$width = (int)$width.'px';
	$bot_margin = (int)$bot_margin.'px';
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	
	$html = '<div class="frb_separator '.$class.$animate.' style="border-top:'.$width.' '.$style.' '.$color.'; padding-bottom:'.$bot_margin.';"></div>';
	return $html;
}
add_shortcode( 'fbuilder_separator', 'fbuilder_separator' );



/* --------------- */
/* fbuilder_slider */
/* --------------- */


function fbuilder_slider ( $atts, $content=null ) {
		extract (shortcode_atts( array(
		'ctype' => 'image',
		'image' => '',
		'image_link' => '',
		'image_link_type' => '',
		'iframe_width' => '600',
		'iframe_height' => '300',
		'html' => '',
		'text_align' => '',
		'back_color' => '',
		'text_color' => '',
		'bot_margin' => 24,
		'mode' => 'horizontal',
		'pagination' => 'true',
		'slides_per_view' =>  1,
		'auto_play' => 'true',
		'auto_delay' => 5,
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts ));
	$content = nl2br($content);
	$modeArray = array('horizontal', 'vertical');
	if(!in_array($mode,$modeArray)) $mode = 'horizontal';
	$ctype = explode('|', $ctype);
	$content = explode('|', $content);
	$image = explode('|', $image);
	$image_link = explode('|', $image_link);
	$image_link_type = explode('|', $image_link_type);
	$text_align = explode('|', $text_align);
	$back_color = explode('|', $back_color);
	$text_color = explode('|', $text_color);	
	$auto_delay = (int) $auto_delay;
	$slides_per_view = (int)$slides_per_view;
	$iframe_width = (int)$iframe_width;
	$iframe_height = (int)$iframe_height;
	
	
	$html ='
	<style>
.frb-swiper-container{width:100%;height:100%;} 
.frb-swiper-pagination {'.($pagination != 'true' ? 'display:none; ': '').'position: static; left: 0;text-align: center;width: 100%; padding-top:10px}
.frb-swiper-container .swiper-pagination-switch {display: inline-block;width: 10px;height: 10px;border-radius: 10px;background: #999;box-shadow: 0px 1px 2px #555 inset;margin: 0 3px;cursor: pointer;padding:0;float:none;}
.frb-swiper-container .swiper-active-switch {background: #fff;} 
.frb-swiper-container .content-slide{padding:10px;} 
.frb-swiper-container .swiper-image {display:block}
  </style>
	
	
	    <div class="frb-swiper-container" data-autoPlay="'.($auto_play == 'true' ? $auto_delay*1000 : '' ).'" data-slidesPerView="'.$slides_per_view.'" data-mode="'.$mode.'">
	      <div class="swiper-wrapper">';

	if(is_array($ctype))
		foreach($ctype as $ind => $type) {
			if($ctype[$ind] == 'image') {
				switch($image_link_type[$ind]) {
					case 'new-tab' : $lightbox = '" target="_blank'; break;
					case 'lightbox-image' : $lightbox = ' frb_lightbox_link" rel="prettyphoto'; break;
					case 'lightbox-iframe' : $lightbox = ' frb_lightbox_link"  rel="prettyphoto'; $image_link[$ind] .= '?iframe=true&width='.$iframe_width.'&height='.$iframe_height; /* &width=500&height=500 */ break;
					default : $lightbox = '';
				}
	        	$html .='
			<div class="swiper-slide">'.(isset($image_link[$ind]) ? '<a class="'.$lightbox.'" href="'.$image_link[$ind].'"><img class="swiper-image" src="'.$image[$ind].'" alt=""></a>'  : '<img class="swiper-image" src="'.$image[$ind].'" alt="">').'</div>';
			}
			else {
				$html .='
	        <div class="swiper-slide" style="background:'.$back_color[$ind].'; color:'.$text_color[$ind].'; text-align:'.(isset($text_align[$ind]) ? $text_align[$ind] : 'left').';">
	          <div class="content-slide">
	            '.$content[$ind].'
	          </div>
	        </div>';
				
			}
		}
			
			
	$html .= '
	      </div>
	    </div>
	    <div class="frb-swiper-pagination"></div>
	';
	
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.$html.'</div>';
	
	return $html;
}
add_shortcode( 'fbuilder_slider', 'fbuilder_slider' );



/* ------------- */
/* fbuilder_code */
/* ------------- */

function fbuilder_code ($atts, $content=null) {
	extract (shortcode_atts( array(
		'bot_margin' => 24,
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts));
	$content = nl2br($content);
	
	$bot_margin = (int)$bot_margin.'px';
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	
	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="frb_code '.$class.$animate.' style="padding-bottom:'.$bot_margin.';"><pre><code>'.$content.'</code></pre></div>';
	return $html;
}
add_shortcode( 'fbuilder_code', 'fbuilder_code' );


/* --------------- */
/* fbuilder_button */
/* --------------- */

function fbuilder_button ( $atts, $content=null ) {
	extract (shortcode_atts( array(
		'text' => 'Read more',
		'url' => '',
		'icon' => 'no-icon',
		'type' => 'standard',
		'iframe_width' => '600',
		'iframe_height' => '300',
		'h_padding' => 10,
		'v_padding' => 10,
		'bot_margin' => 24,
		'font_size' => 16,
		'icon_size' => 16,
		'text_align' => 'left',
		'icon_align' => 'right',
		'fullwidth' => 'false',
		'round' => 'false',
		'fill' => 'true',
		'text_color' => '#376a6e',
		'back_color' => '',
		'hover_text_color' => '#27a8e1',
		'hover_back_color' => '',
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts ));
	
	$alignArray = array('center', 'left', 'right');
	if(!in_array($text_align,$alignArray)) $text_align = 'left';
	$typeArray = array( 'standard', 'new-tab', 'lightbox-image', 'lightbox-iframe');
	if(!in_array($type,$typeArray)) $type = 'standard';
	$icon_alignArray = array( 'left','right', 'center');
	if(!in_array($icon_align,$icon_alignArray)) $icon_align = 'right';
	$font_size = (int)$font_size .'px';
	$icon_size = (int)$icon_size .'px';
	$h_padding = (int)$h_padding .'px';
	$v_padding = (int)$v_padding .'px';
	$iframe_width = (int)$iframe_width;
	$iframe_height = (int)$iframe_height;
	$content = nl2br($content);
	$style = 'style="'.
		'font-size:'.$font_size.'; '.
		'line-height:'.$font_size.'; '. 
		'padding:'.$v_padding.' '.$h_padding.'; '. 
		'color:'.($text_color == '' ? 'transparent' : $text_color).'; '.
		'background:'.($back_color == '' ? 'transparent' : $back_color).'; '.
		'border-color:'.($back_color == '' ? 'transparent' : $back_color).'" '.
		
		'data-textcolor="'.$text_color.'" '.
		'data-backcolor="'.$back_color.'" '.
		'data-hovertextcolor="'.$hover_text_color.'" '.
		'data-hoverbackcolor="'.$hover_back_color.'"';
	
	switch($type) {
		case 'new-tab' : $lightbox = '" target="_blank"'; break;
		case 'lightbox-image' : $lightbox = ' frb_lightbox_link" rel="prettyphoto'; break;
		case 'lightbox-iframe' : $lightbox = ' frb_lightbox_link"  rel="prettyphoto'; $url .= '?iframe=true&width='.$iframe_width.'&height='.$iframe_height; /* &width=500&height=500 */ break;
		default : $lightbox = '';
	}
	
	$align = ' frb_'.$text_align;
	$round = ($round == 'true' ? ' frb_round' : '');
	$no_fill = ($fill != 'true' ? ' frb_nofill' : '');
	$fullwidth = ($fullwidth == 'true' ? ' frb_fullwidth' : '');
	switch($icon_align) {
		case 'right' : $icon_style = 'padding-left:8px; float:right; font-size:'.$icon_size.';'; break; 
		case 'left' : $icon_style = 'padding-right:8px; float:left; font-size:'.$icon_size.';'; break; 
		case 'inline' : $icon_style = 'padding-right:8px; font-size:'.$icon_size.'; float:none;'; break;
	}
	$icon = ($icon != '' && $icon != 'no-icon' ? '<span class="frb_button_icon" style="'.$icon_style.'"><i class="'.$icon.' fawesome"></i></span>' : '');
	
	$html = '<a class="frb_button'.$round.' '.$align.$fullwidth.$no_fill.$lightbox.'" href="'.$url.'" '.$style.'>'.$icon.$text.'</a>';
	
	if($align == ' frb_center') $html = '<div class="frb_textcenter">'.$html.'</div>';
	
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.$html.'<div style="clear:both;"></div></div>';
	
	return $html;
}
add_shortcode( 'fbuilder_button', 'fbuilder_button' );

function fbuilder_testimonials ( $atts, $content=null ) {
		extract (shortcode_atts( array(
		'name' => 'John Dough',
		'profession' => 'photographer / fashion interactive',
		'quote' => 'lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
		'url' => '',
		'image' => '',
		'style' => 'clean',
		'bot_margin' => 24,
		'name_color' => '#376a6e',
		'quote_color' => '#376a6e',
		'main_color' => '#27a8e1',
		'back_color' => '',
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts ));
	$content = nl2br($content);
	$name_block = '<span class="frb_testimonials_name"><b'.($name_color != '' ? ' style="color:'.$name_color.'"' : '').'>'.$name.'</b>'.'<span'.($name_color != '' ? ' style="color:'.$name_color.'"' : '').'>'.$profession.'</span></span>';
	if($image != ''){
		$quote_block = '<div class="frb_testimonials_quote" '.($quote_color != '' ? 'style="color:'.$quote_color.'"' : '').'>'.$quote.'</div>';
		$image = ($url != '' ? '<a href="'.$url.'"><img class="frb_testimonials_img" src="'.$image.'" alt=""/></a>' : '<img class="frb_testimonials_img" src="'.$image.'" alt=""/>');
		$main_block = '<div class="frb_testimonials_main_block" style="'.($main_color != '' ? 'background:'.$main_color.'; border-color:'.$main_color.';' : '').'">'.$image.'</div>';
		$html = $name_block.'<div class="frb_testimonials frb_testimonials_'.$style.'" style="'.($back_color != '' ? 'background:'.$back_color.';' : '').($main_color != '' ? ' border-color:'.$main_color.';' : '').'">'.$main_block.$quote_block.'</div>';
	}
	else {
		$quote_block = '<div class="frb_testimonials_quote'.($style == 'clean' ? ' frb_testimonials_quote_border' : '').'" style="'.($quote_color != '' ? 'color:'.$quote_color.';' : '').($main_color != '' ? ' border-color:'.$main_color.';' : '').'">'.$quote.'</div>';
		$name_block = ($url != '' ? '<a href="'.$url.'">'.$name_block.'</a>' : $name_block);
		$main_block = '<div class="frb_testimonials_main_block" style="'.($main_color != '' ? 'background:'.$main_color.'; border-color:'.$main_color.';' : '').'">'.$name_block.'</div>';
		$html = '<div class="frb_testimonials frb_testimonials_'.$style.'"  style="'.($back_color != '' ? 'background:'.$back_color.';' : '').($main_color != '' ? ' border-color:'.$main_color.';' : '').'">'.$main_block.$quote_block.'</div>';
	}
	
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.$html.'</div>';
	return $html;
}
add_shortcode( 'fbuilder_testimonials', 'fbuilder_testimonials' );

function fbuilder_alert ( $atts, $content=null ) {
	extract (shortcode_atts( array(
		'type' => 'info',
		'text' => 'This is an alert',
		'icon' => 'icon-warning-sign',
		'style' => 'clean',
		'bot_margin' => 24,
		'main_color' => '#27a8e1',
		'text_color' => '#376a6e',
		'icon_color' => '#27a8e1',
		'back_color' => '',
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts ));
	$content = nl2br($content);
	$typeArray = array('info', 'success', 'notice', 'warning', 'custom');
	if(!in_array($type,$typeArray)) $type = 'info';
	$styleArray = array('info', 'success', 'notice', 'warning', 'custom');
	if(!in_array($type,$typeArray)) $type = 'info';
	if($type != 'custom') {
		$html = '<div class="frb_alert frb_alert_'.$type.' frb_alert_'.$style.'"><div class="frb_alert_icon"></div><div class="frb_alert_text">'.$text.'</div></div>';
	}
	else {
		$html = '<div class="frb_alert frb_alert_'.$type.' frb_alert_'.$style.'" style="border-color:'.$main_color.'; background-color:'.$back_color.';"><div class="frb_alert_icon" style="background-color:'.$main_color.';"><i class="'.$icon.' fawesome" style="color:'.$icon_color.';"></i></div><div class="frb_alert_text" style="color:'.$text_color.';">'.$text.'</div></div>';
	}
	
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.$html.'</div>';
	
	return $html;
}

add_shortcode( 'fbuilder_alert', 'fbuilder_alert' );

function fbuilder_accordion ( $atts, $content=null ) {
		extract (shortcode_atts( array(
		'active' => '',
		'title' => '',
		'image' => '',
		'style' => 'clean-right',
		'fixed_height' => 'true',
		'bot_margin' => 24,
		'title_color' => '#376a6e',
		'text_color' => '#376a6e',
		'trigger_color' => '#376a6e',
		'title_active_color' => '#376a6e',
		'trigger_active_color' => '#376a6e',
		'main_color' => '#27a8e1',
		'border_color' => '#376a6e',
		'back_color' => '',
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts ));
	$content = nl2br($content);
	$styleArray = array('clean-right', 'squared-right', 'rounded-right', 'clean-left', 'squared-left', 'rounded-left');
	if(!in_array($style,$styleArray)) $style = 'clean-right';
	$title = explode('|', $title);
	$content = explode('|', $content);
	$active = explode('|', $active);
	$image = explode('|', $image);
	
	if($border_color == '') $border_color = 'transparent';
	if($back_color == '') $back_color = 'transparent';
	$randomId = rand();
	
	$html = '
	<style>
		#frb_accordion_'.$randomId.' {border-bottom-color:'.$border_color.';}
		#frb_accordion_'.$randomId.' h3 {color:'.$title_color.'; background:'.$back_color.'; border-top-color:'.$border_color.'; border-left-color:'.$border_color.';}
		#frb_accordion_'.$randomId.' h3 .frb_accordion_trigger{color:'.$trigger_color.'; background:'.$back_color.';}
		#frb_accordion_'.$randomId.' h3.ui-state-active {color:'.$title_active_color.';}
		#frb_accordion_'.$randomId.' h3.ui-state-active .frb_accordion_trigger{color:'.$trigger_active_color.';}
		#frb_accordion_'.$randomId.' div {color:'.$text_color.'; background:'.$back_color.';}
		#frb_accordion_'.$randomId.' h3.ui-accordion-header-active{'.($style == 'squared-right' || $style == 'rounded-right' ? 'background:'.$main_color.';' : 'color:'.$main_color.';').' border-left-color:'.$main_color.';}
		#frb_accordion_'.$randomId.' h3.ui-accordion-header-active .frb_accordion_trigger{'.($style == 'squared-left' || $style == 'rounded-left' ? 'background:'.$main_color.';':'').'}
		#frb_accordion_'.$randomId.' div.ui-accordion-content-active{'.($style == 'squared-right' || $style == 'rounded-right' ? 'background:'.$main_color.';' : '').' border-left-color:'.$main_color.';}
	</style>';
	
	$html .= '<div id="frb_accordion_'.$randomId.'" class="frb_accordion frb_accordion_'.$style.'" data-fixedheight="'.$fixed_height.'">';
	
	if(is_array($title) && is_array($content)){
		for($i=0; $i<count($title); $i++) {
			$html .= '<h3'.($active[$i] == 'true' ? ' class="ui-state-active"' : '').' >'.$title[$i].'<span class="frb_accordion_trigger"></span></h3>';
			$image[$i] = ($image[$i] != '' ? '<img style="float:left; margin-right:10px;" src="'.$image[$i].'" alt="" />' : '');
			$html .= '<div style="">'.$image[$i].$content[$i].'<div style="clear:both;"></div></div>';
		}
	}
			
	$html .='</div>';
	
	
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.(do_shortcode($html)).'</div>';
	
	return $html;
}
add_shortcode( 'fbuilder_accordion', 'fbuilder_accordion' );


function fbuilder_tabs ( $atts, $content=null ) {
		extract (shortcode_atts( array(
		'active' => '',
		'title' => '',
		'image' => '',
		'style' => 'clean',
		'bot_margin' => 24,
		'title_color' => '#376a6e',
		'text_color' => '#376a6e',
		'active_tab_title_color' => '#376a6e',
		'active_tab_border_color' => '#27a8e1',
		'border_color' => '#ebecee',
		'tab_back_color' => '#376a6e',
		'back_color' => '#f4f4f4',
		'class' => '',
		'custom_id' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts ));
	$content = nl2br($content);
	$styleArray = array('clean', 'squared', 'rounded');
	if(!in_array($style,$styleArray)) $style = 'clean';
	$title = explode('|', $title);
	$content = explode('|', $content);
	$active = explode('|', $active);
	$image = explode('|', $image);
	$custom_id = explode('|', $custom_id);
	
	if($border_color == '') $border_color = 'transparent';
	if($back_color == '') $back_color = 'transparent';
	$randomId = rand();
	
	$html = '
	<style>
		#frb_tabs_'.$randomId.' .frb_tabs-content {
			color:'.$text_color.';
			border:2px solid '.$border_color.';
			'.($style != 'clean' ? 'background:'.$back_color.';' :'').'
		}
		#frb_tabs_'.$randomId.' ul:first-child a {
			color:'.$title_color.';
			'.($style != 'clean' ? '
			background:'.$tab_back_color.';':'').'
		}
		#frb_tabs_'.$randomId.' ul:first-child a.active{
			'.($style != 'clean' ? '
			background:'.$back_color.';
			color:'.$active_tab_title_color.';
			border-top:2px solid '.$active_tab_border_color.';
			padding-bottom:10px !important;
			margin-top:-2px !important' : '
			padding-bottom:10px !important;
			border-bottom:2px solid '.$active_tab_border_color.';').'
		}
		#frb_tabs_'.$randomId.' ul:first-child a:hover{
			'.($style != 'clean' ? '
			background-color:'.$back_color.';
			color:'.$active_tab_title_color.';
			border-top:2px solid '.$active_tab_border_color.';
			padding-bottom:10px !important;
			margin-top:-2px !important;
			transition: border-top-color 300ms, background-color 300ms;
			-webkit-transition: border-top-color 300ms, background-color 300ms;' : '
			padding-bottom:10px !important;
			border-bottom:2px solid '.$active_tab_border_color.';
			transition: border-bottom-color 300ms;
			-webkit-transition: border-bottom-color 300ms;').'
		}
		'.($style == 'rounded' ? '
			#frb_tabs_'.$randomId.' ul:first-child li:first-child a {
				border-radius:5px 0 0 0;
			}
			#frb_tabs_'.$randomId.' ul:first-child li:last-child a {
				border-radius:0 5px 0 0;
			}
		': '').'
	</style>';
	
	$html .= '<div id="frb_tabs_'.$randomId.'" class="frb_tabs frb_tabs_'.$style.'"><ul>';
	
	if(is_array($title) && is_array($content)){
		for($i=0; $i<count($title); $i++) {
			$html .='<li><a href="'.(isset($custom_id[$i]) && $custom_id[$i] != '' ? '#'.$custom_id[$i] : '#frb_tabs_'.$randomId.'_'.$i).'"'.($active[$i] == 'true' ? ' class="active"' : '').'>'.$title[$i].'</a></li>';
			
		}
	}
			
	$html .='</ul><div style="clear:both;"></div>';
	
	if(is_array($title) && is_array($content)){
		for($i=0; $i<count($title); $i++) {
			$image[$i] = ($image[$i] != '' ? '<img style="float:left; margin-right:10px;" src="'.$image[$i].'" alt="" />' : '');
			$html .= '<div id="'.(isset($custom_id[$i]) && $custom_id[$i] != '' ? $custom_id[$i] : 'frb_tabs_'.$randomId.'_'.$i).'" class="frb_tabs-content">'.$image[$i].$content[$i].'<div style="clear:both;"></div></div>';
		}
	}
	
	$html .='</div>';
	
	
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.(do_shortcode($html)).'</div>';
	
	return $html;
}
add_shortcode( 'fbuilder_tabs', 'fbuilder_tabs' );


function fbuilder_features ( $atts, $content=null ) {
		extract (shortcode_atts( array(
		'title' => 'Lorem ipsum',
		'icon' => 'icon-bell',
		'link' => '',
		'order' => 'icon-after-title',
		'style' => 'clean',
		'bot_margin' => 24,
		'icon_size' => 70,
		'title_color' => '#376a6e',
		'icon_color' => '#376a6e',
		'icon_padding' => 10,
		'icon_border' => 'false',
		'text_color' => '#376a6e',
		'back_color' => '#999999',
		'title_hover_color' => '#27a8e1',
		'icon_hover_color' => '#376a6e',
		'text_hover_color' => '#376a6e',
		'back_hover_color' => '#27a8e1',
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts ));
	if($shortcode_id == '') $shortcode_id = 'frb_features_'.rand();
	$content = nl2br($content);
	$styleArray = array('clean', 'squared', 'rounded', 'icon-squared', 'icon-rounded');
	if(!in_array($style,$styleArray)) $style = 'clean-right';
	$orderArray = array('icon-left', 'icon-right', 'icon-after-title', 'icon-before-title');
	if(!in_array($order,$orderArray)) $order = 'icon-after-title';
	$margin = (int)$icon_size + (int)$icon_padding*2 + 20;
	$icon_size = (int)$icon_size .'px';
	$icon_padding = (int)$icon_padding .'px';
	
	$sty = '
	<style>
		#'.$shortcode_id.' .frb_features{
			'.($style == 'squared' || $style == 'rounded' ? 'background:'.$back_color.';"' : '').'
		}
		#'.$shortcode_id.' .frb_features:hover {
			'.($style == 'squared' || $style == 'rounded' ? 'background:'.$back_hover_color.';"' : '').'
		}
	
		#'.$shortcode_id.' .frb_features_title {
			color:'.$title_color.';
			'.($order != 'icon-before-title' ? 'margin-top:0; padding-top:10px;':'').'
			'.($order == 'icon-left' ? ' margin-left:'.($margin+2).'px;' : '').'
			'.($order == 'icon-right' ? ' margin-right:'.($margin+2).'px;' : '').'
			transition: color 300ms;
			-webkit-transition: color 300ms;
		}
		
		#'.$shortcode_id.' .frb_features:hover .frb_features_title {
			color: '.$title_hover_color.';
		}
		
		#'.$shortcode_id.' .frb_features_icon {
			font-size:'.$icon_size.'; 
			line-height:'.$icon_size.'; 
			color:'.$icon_color.';
			padding:'.$icon_padding.';
			'.($order == 'icon-left' ? 'margin-left:0; margin-right:20px;' : '').'
			'.($order == 'icon-right' ? 'margin-left:20px; margin-right:0;' : '').'
			'.($style == 'icon-squared' || $style == 'icon-rounded' ? 'background:'.$back_color.';' : '').'
			'.($style == 'icon-rounded' ? 'border-radius:50%;' : '').'
			'.($icon_border == 'true' ? 'border:1px solid '.$icon_color.';' : '').'
			transition: color 300ms;
			-webkit-transition: color 300ms, border-color 300ms;
		}
		
		#'.$shortcode_id.' .frb_features:hover .frb_features_icon {
			color: '.$icon_hover_color.';
			border-color: '.$icon_hover_color.';
			'.($style == 'icon-squared' || $style == 'icon-rounded' ? 'background:'.$back_hover_color.';"' : '').'
		}
		
		#'.$shortcode_id.' .frb_features_content {
			color:'.$text_color.';
			'.($order == 'icon-left' ? 'margin-left:'.($margin+2).'px;' : '').'
			'.($order == 'icon-right' ? 'margin-right:'.($margin+2).'px;' : '').'
			transition: color 300ms;
			-webkit-transition: color 300ms;
		}
		
		#'.$shortcode_id.' .frb_features:hover .frb_features_content {
			color:'.$text_hover_color.';
		}
	</style>
	';
	
	
	$title = '<h3 class="frb_features_title">'.$title.'</h3>';
	$icon = '<i class="frb_features_icon frb_features_'.$order.' '.$icon.' fawesome" ></i>';
	$content = '<span class="frb_features_content">'.$content.'</span>';
	
	$html = '<div class="frb_features frb_features_'.$style.' frb_features_'.$order.'">';
	if($link != '') $html .= '<a href="'.$link.'">';
	if($order != 'icon-after-title') $html .= $icon.$title.$content;
	else  $html .= $title.$icon.$content;
	$html .= '<div style="clear:both;"></div>'.($link != '' ? '</a>' : '').'</div>';
	
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$html = $sty.'<div id="'.$shortcode_id.'" class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.$html.'</div>';
	
	return $html;
}
add_shortcode( 'fbuilder_features', 'fbuilder_features' );

function fbuilder_icon_menu ( $atts, $content=null ) {
		extract (shortcode_atts( array(
		'icon' => '',
		'url' => '',
		'align' => 'left',
		'link_type' => 'standard',
		'iframe_width' => '600',
		'iframe_height' => '300',
		'bot_margin' => 24,
		'icon_size' => 24,
		'round' => 'false',
		'icon_color' => '#376a6e',
		'back_color' => '',
		'icon_hover_color' => '#27a8e1',
		'back_hover_color' => '',
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts ));
	$alignArray = array('left', 'right', 'center');
	if(!in_array($align, $alignArray)) $align = 'left';
	if($back_hover_color == '') $back_hovar_color = 'transparent';
	if($back_color == '') $back_color = 'transparent';
	$icon_size = (int)$icon_size;
	$iframe_width = (int)$iframe_width;
	$iframe_height = (int)$iframe_height;
	
	$html = '<div class="frb_iconmenu'.($round == 'true' ? ' frb_iconmenu_round' : '').' frb_iconmenu_'.$align.'" style="background:'.$back_color.';">';
	
	$icon = explode('|', $icon);
	$link_type = explode('|', $link_type);
	$url = explode('|', $url);
	if(is_array($icon)){
		for($i=0; $i<count($icon); $i++) {
			$ii = '<i class="fawesome '.$icon[$i].'" style="color:'.$icon_color.'; width:'.($icon_size+10).'px; font-size:'.$icon_size.'px; line-height:'.$icon_size.'px;" data-color="'.$icon_color.'" data-hovercolor="'.$icon_hover_color.'"></i>';
			switch($link_type[$i]) {
				case 'new-tab' : $lightbox = '" target="_blank'; break;
				case 'lightbox-image' : $lightbox = ' frb_lightbox_link" rel="prettyphoto'; break;
				case 'lightbox-iframe' : $lightbox = ' frb_lightbox_link"  rel="prettyphoto'; $url[$i] .= '?iframe=true&width='.$iframe_width.'&height='.$iframe_height; /* &width=500&height=500 */ break;
				default : $lightbox = '';
			}
			$html .= '<a href="'.$url[$i].'" style="background:'.$back_color.'; color:'.$icon_color.';" data-backcolor="'.$back_color.'" data-backhover="'.$back_hover_color.'" class="frb_iconmenu_link'.$lightbox.'">'.$ii.'</a>';
		}
	}
	$html .= '<div style="clear:both;"></div></div>';
	
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.$html.'</div>';
	
	return $html;
}
add_shortcode( 'fbuilder_icon_menu', 'fbuilder_icon_menu' );

function fbuilder_search ( $atts, $content=null ) {
		extract (shortcode_atts( array(
		'text' => 'Search',
		'bot_margin' => 24,
		'round' => 'flase',
		'text_color' => '#376a6e',
		'border_color' => '#ebecee',
		'back_color' => '',
		'text_focus_color' => '#376a6e',
		'border_focus_color' => '#376a6e',
		'back_focus_color' => '',
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts ));
	
	if($back_color == '') $back_color = 'transparent';
	if($border_color == '') $border_color = 'transparent';
	if($text_color == '') $text_color = 'transparent';
	if($text_focus_color == '') $text_focus_color = 'transparent';
	if($border_focus_color == '') $border_focus_color = 'transparent';
	if($back_focus_color == '') $back_focus_color = 'transparent';
	
	$html = '
<form method="get" style="background:'.$back_color.'; border-color:'.$border_color.';"  data-backcolor="'.$back_color.'" data-bordercolor="'.$border_color.'"  data-backfocus="'.$back_focus_color.'" data-borderfocus="'.$border_focus_color.'" class="frb_searchform'.($round == 'true' ? ' frb_searchform_round' : '').'" action="'.home_url( '/' ).'">
	<div class="frb_searchleft">
		<div class="frb_searchleft_inner">
			<input type="text" style="color:'.$text_color.';"  data-color="'.$text_color.'" data-focuscolor="'.$text_focus_color.'" data-value="'.$text.'" class="frb_searchinput" value="'.$text.'" name="s" />
		</div>
	</div>
	<div class="frb_searchright">
		<i style="color:'.$text_color.';" class="frb_searchsubmit fawesome icon-search"></i>
	</div>
	<div class="clear"></div>
</form>';

	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.$html.'</div>';
	
	return $html;
}
add_shortcode( 'fbuilder_search', 'fbuilder_search' );


function fbuilder_h( $atts, $content=null ) {
	extract (shortcode_atts( array(
		'type' => 'h1',
		'bot_margin' => 24,
		'align' => 'left',
		'text_color' => '#232323',
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts));
	
	$alignArray = array('left', 'right', 'center');
	if(!in_array($align, $alignArray)) $align = 'left';
	
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	return ($content != '' && $content != null ? '<'.$type.' '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important; margin-top:0 !important; text-align:'.$align.'; color:'.$text_color.'">'.$content.'</'.$type.'>' : '');
}
add_shortcode( 'fbuilder_h', 'fbuilder_h' );

function fbuilder_text( $atts, $content=null ) {
	extract (shortcode_atts( array(
		'autop' => 'true',
		'bot_margin' => 24,
		'align' => 'left',
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts));
	if($autop == 'true') $content = nl2br($content);
	$alignArray = array('left', 'right', 'center');
	if(!in_array($align, $alignArray)) $align = 'left';
	
	$html = '<div class="frb_text">'.do_shortcode($content).'</div>';
	
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important; text-align:'.$align.'">'.$html.'</div>';
	
	return $html;
}
add_shortcode( 'fbuilder_text', 'fbuilder_text' );


function fbuilder_image ( $atts, $content=null ) {
		extract (shortcode_atts( array(
		'desc' => '',
		'text_align' => 'left',
		'link' => '',
		'link_type' => 'lightbox-image',
		'iframe_width' => '600',
		'iframe_height' => '300',
		'hover_icon' => 'icon-search',
		'hover_icon_size' => 30,
		'bot_margin' => 24,
		'round' => 'false',
		'border' => 'false',
		'border_color' => '#376a6e',
		'desc_color' => '#376a6e',
		'back_color' => '#ebecee',
		'border_hover_color' => '#376a6e',
		'desc_hover_color' => '#376a6e',
		'back_hover_color' => '#ebecee',
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
		
	), $atts ));
	$desc = nl2br($desc);
	$alignArray = array('left', 'right', 'center');
	if(!in_array($text_align, $alignArray)) $text_align = 'left';
	if($border_color == '') $border_color = 'transparent';
	if($back_color == '') $back_color = 'transparent';
	if($desc_color == '') $desc_color = 'transparent';
	if($border_hover_color == '') $border_hover_color = 'transparent';
	if($desc_hover_color == '') $desc_hover_color = 'transparent';
	if($back_hover_color == '') $back_hover_color = 'transparent';
	$hover_icon_size = (int)$hover_icon_size;
	$iframe_width = (int)$iframe_width;
	$iframe_height = (int)$iframe_height;
	
	$html = '<span class="frb_image_inner"><img'.($round != 'false' && $desc == '' ? ' class="frb_image_round"' : '').' src="'.$content.'" alt="" '.($text_align == 'center' ? 'style="margin:0 auto;"' : ($text_align == 'right' ? 'style="float:right;"':'')).' /><div style="clear:both;"></div><span class="frb_image_hover"></span><i class="fawesome '.$hover_icon.'" style="line-height:'.$hover_icon_size.'px; font-size:'.$hover_icon_size.'px; height:'.$hover_icon_size.'px; width:'.$hover_icon_size.'px; margin:'.(-$hover_icon_size/2).'px "></i></span>';
	
	if($desc != '') $html .= '<span class="frb_image_desc'.($round != 'false' ? ' frb_image_round' : '').'" style="color:'.$desc_color.'; text-align:'.$text_align.'; background:'.$back_color.'" data-color="'.$desc_color.'" data-hovercolor="'.$desc_hover_color.'" data-backcolor="'.$back_color.'" data-backhover="'.$back_hover_color.'">'.$desc.'</span>';
	
	if($link != '') {	
		switch($link_type) {
			case 'new-tab' : $lightbox = ' target="_blank"'; break;
			case 'lightbox-image' : $lightbox = ' frb_lightbox_link" rel="prettyphoto'; break;
			case 'lightbox-iframe' : $lightbox = ' frb_lightbox_link"  rel="prettyphoto'; $link .= '?iframe=true&width='.$iframe_width.'&height='.$iframe_height; /* &width=500&height=500 */ break;
			default : $lightbox = '';
		}
		$html = '<a class="'.$lightbox.'" href='.$link.'>'.$html.'</a>';
	}
	
	$html = '<div class="frb_image'.($border != 'false' ? ' frb_image_border' : '').($round != 'false' ? ' frb_image_round' : '').'" style="border-color:'.$border_color.'; " data-bordercolor="'.$border_color.'" data-borderhover="'.$border_hover_color.'">'.$html.'</div>';
	
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.$html.'</div>';
	
	return $html;
}
add_shortcode( 'fbuilder_image', 'fbuilder_image' );


function fbuilder_video($atts) {
    extract(shortcode_atts(array(
        'url' => '',
		'auto_width' => 'true',
		'bot_margin' => 24,
		'width' => '620',
		'height' => '310',
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
    ), $atts));

	$width = (int)$width;
	$height = (int)$height;
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';

	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.' frb_video_wrapper'.($auto_width == 'true' ? ' frb_auto_width' : '').$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.fbuilder_get_video_iframe($url, $width, $height).'</div>';
	
    return $html;
}
add_shortcode('fbuilder_video', 'fbuilder_video');

function fbuilder_get_video_iframe($url, $width, $height){
	preg_match('/^(https?:\/\/)(www\.)?([^\/]+)(\.com)/i', $url, $matches);
	
	if ($matches[3] == 'youtube'){
		preg_match('/^(https?:\/\/)?(www\.)?youtube\.com\/(watch\?v=)?(v\/)?([^&]+)/i', $url, $matches);
		$match = $matches[5];
		
		$html = '<iframe src="http://www.youtube.com/embed/'.$match.'?rel=0&amp;hd=1" frameborder="0"';
		if ($width){
			$html .= ' width="'.$width.'"';
		} else {
			$html .= ' width="620"';
		}
		if ($height){
			$html .= ' height="'.$height.'"';
		} else {
			$html .= ' height="400"';
		}
		$html .= '></iframe>';
		
		return $html;
	} elseif ($matches[3] == 'vimeo'){
		preg_match('/^(https?:\/\/)?(www\.)?vimeo\.com\/([^\/]+)/i', $url, $matches);
		$match = $matches[3];
		
		$html .= '<iframe src="http://player.vimeo.com/video/'.$match.'?title=0&amp;byline=0&amp;portrait=0" frameborder="0"';
		if ($width){
			$html .= ' width="'.$width.'"';
		} else {
			$html .= ' width="620"';
		}
		if ($height){
			$html .= ' height="'.$height.'"';
		} else {
			$html .= ' height="400"';
		}
		$html .= '></iframe>';
		
		return $html;
	} elseif ($matches[3] == 'dailymotion'){
		preg_match('/^(https?:\/\/)?(www\.)?dailymotion\.com\/(video\/)?([^_]+)/i', $url, $matches);
		$match = $matches[4];
		
		$html .= '<iframe src="http://www.dailymotion.com/embed/video/'.$match.'?hideInfos=1" frameborder="0"';
		if ($width){
			$html .= ' width="'.$width.'"';
		} else {
			$html .= ' width="620"';
		}
		if ($height){
			$html .= ' height="'.$height.'"';
		} else {
			$html .= ' height="400"';
		}
		$html .= '></iframe>';
		
		return $html;
	} elseif ($matches[3] == 'screenr'){
		preg_match('/^(https?:\/\/)?(www\.)?screenr\.com\/([^\/]+)/i', $url, $matches);
		$match = $matches[3];
		
		$html .= '<iframe src="http://www.screenr.com/embed/'.$match.'" frameborder="0"';
		if ($width){
			$html .= ' width="'.$width.'"';
		} else {
			$html .= ' width="620"';
		}
		if ($height){
			$html .= ' height="'.$height.'"';
		} else {
			$html .= ' height="400"';
		}
		$html .= '></iframe>';
		
		return $html;
	} else {
		return '<br /><h2 style="text-align:center;">Unknown type of the video. Check your video link.</h2><br />';
	}
}


function fbuilder_sidebar( $atts ) {
	extract (shortcode_atts( array( 
		'name' => '1',
		'bot_margin' => 0,
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts ));
	
	$html =  '<div id="' . str_replace( " ", "_", $name ) . '" class="frb_sidebar">';
	ob_start();
	if ( ! function_exists('dynamic_sidebar') || ! dynamic_sidebar($name) ) {}
	$html .= ob_get_contents();
	ob_end_clean();
	$html .= '</div>';
		
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.$html.'</div>';
	
	return $html;
}
add_shortcode( 'fbuilder_sidebar', 'fbuilder_sidebar' );


function fbuilder_nav_menu( $atts, $content=null ) {
	extract (shortcode_atts( array(
		'wp_menu' => '',
		'type' => 'horizontal-clean',
		'menu_title' => 'Nav menu',
		'bot_margin' => 24,
		'text_color' => '#232323',
		'hover_color' => '#27a8e1',
		'hover_text_color' => '#ffffff',
		'back_color' => '',
		'sub_back_color' => '#f4f4f4',
		'sub_text_color' => '#232323',
		'separator_color' => '#ebecee',
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts));
	
	$randomId = rand();
	$navArgs = array(
		'menu'            => $wp_menu,
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'frb_menu frb_menu_'.$type,
		'menu_id'         => '',
		'echo'            => false,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="%1$s" class="%2$s" data-textcolor="'.$text_color.'" data-hovercolor="'.$hover_color.'" data-hovertextcolor="'.$hover_text_color.'"  data-subtextcolor="'.$sub_text_color.'">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
	);

	$html = '
	<style>
		#frb_menu'.$randomId.' {
			background:'.$back_color.';
		}
		#frb_menu'.$randomId.' ul.frb_menu a {
			color:'.$text_color.';
		}
		#frb_menu'.$randomId.' ul.frb_menu ul.sub-menu a {
			color:'.$sub_text_color.';
		}
		#frb_menu'.$randomId.' .frb_menu_header {
			color:'.$text_color.';
			border-bottom:1px solid '.$hover_color.';
		}
		#frb_menu'.$randomId.' ul.frb_menu ul.sub-menu li {
			background:'.$sub_back_color.';
		}
		
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_horizontal-clean ul.sub-menu:before {
			border-bottom-color:'.$hover_color.';
		}
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_horizontal-clean ul.sub-menu:after {
			border-bottom-color:'.$sub_back_color.';
		}
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_horizontal-clean ul.sub-menu a {
			border-top:1px solid '.$separator_color.';
		}
		
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_horizontal-clean ul.sub-menu li:first-child a {
			border-top:1px solid '.$hover_color.';
		}
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_horizontal-squared ul.sub-menu:before,
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_horizontal-squared ul.sub-menu:after,
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_horizontal-rounded ul.sub-menu:before,
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_horizontal-rounded ul.sub-menu:after {
			border-bottom-color:'.$sub_back_color.';
		}
		
		#frb_menu'.$randomId.'.frb_menu_container_vertical-clean .frb_menu_header,
		#frb_menu'.$randomId.'.frb_menu_container_vertical-squared .frb_menu_header,
		#frb_menu'.$randomId.'.frb_menu_container_vertical-rounded .frb_menu_header{
			color:'.$text_color.';
		}
		#frb_menu'.$randomId.'.frb_menu_container_vertical-clean ul.frb_menu,
		#frb_menu'.$randomId.'.frb_menu_container_vertical-squared ul.frb_menu,
		#frb_menu'.$randomId.'.frb_menu_container_vertical-rounded ul.frb_menu {
			background:'.$sub_back_color.';
		}
		#frb_menu'.$randomId.'.frb_menu_container_vertical-clean ul.frb_menu a,
		#frb_menu'.$randomId.'.frb_menu_container_vertical-squared ul.frb_menu a,
		#frb_menu'.$randomId.'.frb_menu_container_vertical-rounded ul.frb_menu a,
		#frb_menu'.$randomId.'.frb_menu_container_vertical-clean ul.frb_menu ul.sub-menu a,
		#frb_menu'.$randomId.'.frb_menu_container_vertical-squared ul.frb_menu ul.sub-menu a,
		#frb_menu'.$randomId.'.frb_menu_container_vertical-rounded ul.frb_menu ul.sub-menu a  {
			color:'.$sub_text_color.';
		}
		
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_vertical-clean a,
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_vertical-squared a,
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_vertical-rounded a,
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_vertical-clean > li > ul.sub-menu,
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_vertical-squared > li > ul.sub-menu,
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_vertical-rounded > li > ul.sub-menu {
			border-top:1px solid '.$separator_color.';
		}
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_vertical-clean li:first-child a,
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_vertical-squared li:first-child a,
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_vertical-rounded li:first-child a,
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_vertical-clean ul.sub-menu a,
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_vertical-squared ul.sub-menu a,
		#frb_menu'.$randomId.' ul.frb_menu.frb_menu_vertical-rounded ul.sub-menu a {
			border-top:0;
		}
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-clean .frb_menu_header,
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-squared .frb_menu_header,
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-rounded .frb_menu_header {
			color:'.$text_color.';
			border:0;
		}
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-clean .frb_menu_header:before,
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-squared .frb_menu_header:before,
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-rounded .frb_menu_header:before {
			background:'.$text_color.';
		}
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-clean .frb_menu_header:after,
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-squared .frb_menu_header:after,
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-rounded .frb_menu_header:after {
			border-top-color:'.$text_color.';
		}
		
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-clean ul.frb_menu:before {
			border-bottom-color:'.$hover_color.';
		}
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-clean ul.frb_menu:after {
			border-bottom-color:'.$sub_back_color.';
		}
		
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-squared ul.frb_menu:before,
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-squared ul.frb_menu:after,
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-rounded ul.frb_menu:before,
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-rounded ul.frb_menu:after {
			border-bottom-color:'.$sub_back_color.';
			
		}
		
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-clean ul.frb_menu li,
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-squared ul.frb_menu li,
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-rounded ul.frb_menu li {
			background:'.$sub_back_color.';
		}
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-clean ul.frb_menu li a {
			color:'.$sub_text_color.';
			border-top:1px solid '.$separator_color.';
		}
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-squared ul.frb_menu li a,
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-rounded ul.frb_menu li a {
			color:'.$sub_text_color.';
		}
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-squared ul.frb_menu li a,
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-rounded ul.frb_menu li a {
			color:'.$sub_text_color.';
		}
		#frb_menu'.$randomId.'.frb_menu_container_dropdown-clean ul.frb_menu li:first-child a {
			border-top:1px solid '.$hover_color.';
		}
		
		
	</style>
	';
	$html .= '<div class="frb_menu_container frb_menu_container_'.$type.'" id="frb_menu'.$randomId.'">';
	if($type != 'horizontal-clean' && $type != 'horizontal-squared' && $type != 'horizontal-rounded' && $menu_title != '') {
		$html .= '<div class="frb_menu_header">'.$menu_title.'</div>';
	}
	
	$html .= wp_nav_menu( $navArgs ).'</div>';
	
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$html = '<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.$html.'</div>';
	
	return $html;
}
add_shortcode( 'fbuilder_nav_menu', 'fbuilder_nav_menu' );

function fbuilder_post( $atts, $content=null) {
	extract (shortcode_atts( array(
		'id' => '1',
		'hover_icon' => 'icon-search',
		'button_text' => 'Read more',
		'style' => 'clean',
		'bot_margin' => 24,
		'back_color' => '',
		'border_color' => '#27a8e1',
		'button_color' => '#27a8e1',
		'button_text_color' => '#ffffff',
		'button_hover_color' => '#57bce8',
		'button_text_hover_color' => '#ffffff',
		'head_color' => '#232323',
		'meta_color' => '#232323',
		'meta_hover_color' => '#27a8e1',
		'text_color' => '#232323',
		'class' => '',
		'shortcode_id' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts));
	
	$color_array = array(
		'back_color',
		'border_color',
		'button_color',
		'button_text_color',
		'button_hover_color',
		'button_text_hover_color',
		'head_color',
		'meta_color',
		'meta_hover_color',
		'text_color'
	);
	foreach($color_array as $color) {
		if($$color == '') $$color = 'transparent';
	}
	global $fbuilder;
	$randomId = rand();
	$id = (int)$id;
	$post = get_post($id);
	$url = get_permalink($id);
	$thumb = get_the_post_thumbnail($id,'full');
	$author_id = $post->post_author;
	$comments = $post->comment_count;
	
	$content = $fbuilder->strip_html_tags($post->post_content);
	$excerpt_length = apply_filters('excerpt_length', 55);
	$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
	$content = wp_trim_words( $content, $excerpt_length, $excerpt_more );
	
	if($comments == 1) $comments .= ' comment';
	else $comments .= ' comments';
	
	$html = '<span class="frb_image_inner">'.$thumb.'<span class="frb_image_hover"></span><i class="fawesome '.$hover_icon.'"></i></span>';
	
	$html = '<a class="lightbox-image" href="'.$url.'">'.$html.'</a>';
	
	$html .= '<h3 class="frb_post_title">'.$post->post_title.'</h3>';
	
	$html .= '<div class="frb_post_meta"><span class="frb_date">'.get_the_time('m. d. Y.', $id).'</span> | '.'<a class="frb_author" href="mailto:'.get_the_author_meta( 'user_email' , $author_id ).'">'.get_the_author_meta( 'user_nicename' , $author_id ).'</a> | '.'<a href="'.$url.'">'.$comments.'</a></div>';
	
	$html .= '<div class="frb_post_content">'.$content.'</div>';
		
	$button_style = 'style="'.
		'color:'.$button_text_color.'; '.
		'background:'.$button_color.'; '.
		'border-color:'.$button_color.'" '.
		
		'data-textcolor="'.$button_text_color.'" '.
		'data-backcolor="'.$button_color.'" '.
		'data-hovertextcolor="'.$button_text_hover_color.'" '.
		'data-hoverbackcolor="'.$button_hover_color.'"';

	$round = ($style == 'rounded' ? ' frb_round' : '');

	$html .= '<a class="frb_button'.$round.'" href="'.$url.'" '.$button_style.'>'.$button_text.'</a>';
	
	
	$html = '<div id="frb_post'.$randomId.'" class="frb_post frb_post_'.$style.' frb_image'.($border_color != 'transparent' ? ' frb_image_border' : '').'">'.$html.'</div>';
	
	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	$post_style = '
	<style>
		#frb_post'.$randomId.' {
			color: '.$text_color.';
			border-color:'.$border_color.'; 
			'.($style != 'clean' ? 'background:'.$back_color : '').'
		}
		
		#frb_post'.$randomId.' h3 {
			color:'.$head_color.';
		}
		
		#frb_post'.$randomId.' .frb_post_meta,
		#frb_post'.$randomId.' .frb_post_meta a{
			color: '.$meta_color.';
		}
		#frb_post'.$randomId.' .frb_post_meta a:hover {
			color: '.$meta_hover_color.'
		}
	</style>';
	
	$html = $post_style.'<div '.($shortcode_id != '' ? 'id="'.$shortcode_id.'"' : '').' class="'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;">'.$html.'</div>';
	
	
	return $html;
}
add_shortcode( 'fbuilder_post', 'fbuilder_post' );








function fbuilder_pricing ( $atts, $content=null ) {
		extract (shortcode_atts( array(
		'bot_margin' => '24',
		'currency' => '',
		'bot_border' => '',
		'class' => '',
		'shortcode_id' => '',
		'colnum' => '1',
		'services_sidebar' => 'true',
		'row_type' => '',
		'service_label' => '',
		'service_icon' => '',
		'column_1_icon' => '',
		'column_1_text' => '',
		'column_1_price' => '',
		'column_1_interval' => '',
		'column_1_button_text' => '',
		'column_1_button_link' => '',
		'column_2_icon' => '',
		'column_2_text' => '',
		'column_2_price' => '',
		'column_2_interval' => '',
		'column_2_button_text' => '',
		'column_2_button_link' => '',
		'column_3_icon' => '',
		'column_3_text' => '',
		'column_3_price' => '',
		'column_3_interval' => '',
		'column_3_button_text' => '',
		'column_3_button_link' => '',
		'column_4_icon' => '',
		'column_4_text' => '',
		'column_4_price' => '',
		'column_4_interval' => '',
		'column_4_button_text' => '',
		'column_4_button_link' => '',
		'column_5_icon' => '',
		'column_5_text' => '',
		'column_5_price' => '',
		'column_5_interval' => '',
		'column_5_button_text' => '',
		'column_5_button_link' => '',
		'text_color' => '',
		'back_color' => '',
		'column_1_main_color' => '',
		'column_1_hover_color' => '',
		'column_1_button_text_color' => '',
		'column_2_main_color' => '',
		'column_2_hover_color' => '',
		'column_2_button_text_color' => '',
		'column_3_main_color' => '',
		'column_3_hover_color' => '',
		'column_3_button_text_color' => '',
		'column_4_main_color' => '',
		'column_4_hover_color' => '',
		'column_4_button_text_color' => '',
		'column_5_main_color' => '',
		'column_5_hover_color' => '',
		'column_5_button_text_color' => '',
		'animate' => 'none',
		'animation_delay' => 0,
		'animation_group' => ''
	), $atts ));
	
	$colnum = (int)$colnum;
	if($services_sidebar == 'true') $colnum++;
	$bot_border = explode('|', $bot_border);
	$row_type = explode('|', $row_type);
	$service_label = explode('|', $service_label);
	$service_icon = explode('|', $service_icon);
	$column_1_icon = explode('|', $column_1_icon);
	$column_1_text = explode('|', $column_1_text);
	$column_1_price = explode('|', $column_1_price);
	$column_1_interval = explode('|', $column_1_interval);
	$column_1_button_text = explode('|', $column_1_button_text);
	$column_1_button_link = explode('|', $column_1_button_link);
	$column_2_icon = explode('|', $column_2_icon);
	$column_2_text = explode('|', $column_2_text);
	$column_2_price = explode('|', $column_2_price);
	$column_2_interval = explode('|', $column_2_interval);
	$column_2_button_text = explode('|', $column_2_button_text);
	$column_2_button_link = explode('|', $column_2_button_link);
	$column_3_icon = explode('|', $column_3_icon);
	$column_3_text = explode('|', $column_3_text);
	$column_3_price = explode('|', $column_3_price);
	$column_3_interval = explode('|', $column_3_interval);
	$column_3_button_text = explode('|', $column_3_button_text);
	$column_3_button_link = explode('|', $column_3_button_link);
	$column_4_icon = explode('|', $column_4_icon);
	$column_4_text = explode('|', $column_4_text);
	$column_4_price = explode('|', $column_4_price);
	$column_4_interval = explode('|', $column_4_interval);
	$column_4_button_text = explode('|', $column_4_button_text);
	$column_4_button_link = explode('|', $column_4_button_link);
	$column_5_icon = explode('|', $column_5_icon);
	$column_5_text = explode('|', $column_5_text);
	$column_5_price = explode('|', $column_5_price);
	$column_5_interval = explode('|', $column_5_interval);
	$column_5_button_text = explode('|', $column_5_button_text);
	$column_5_button_link = explode('|', $column_5_button_link);
	
	$randomId = rand();
	
	$colIdMod = ($services_sidebar == 'true' ? 1 : 0);
	
	$html = '
	<style>
		'.($text_color != '' ? 'table#frb_pricing_'.$randomId.'.frb_pricing_table {color: '.$text_color.';}' : '').'
		#frb_pricing_'.$randomId.'.frb_pricing_table td {border-right-color:#ffffff;} /* 	boja za prostor izmedju celija				*/
		'.($back_color != '' ? '#frb_pricing_'.$randomId.' .frb_pricing_pale_background {background-color: '.$back_color.';}' : '').'
		#frb_pricing_'.$randomId.'.frb_pricing_table .frb_pricing_row_separator td {background: #dedee0;}
		';
	for($i=1; $i<=($colnum-$colIdMod); $i++) {
		$main_color = 'column_'.$i.'_main_color';
		$hover_color = 'column_'.$i.'_hover_color';
		$button_text_color = 'column_'.$i.'_button_text_color';
		
		$html .= '
		#frb_pricing_'.$randomId.' .frb_pricing_main_color'.($i+$colIdMod).' {background: '.$$main_color.'; color: '.$$button_text_color.'; transition:background-color 300ms;}
		#frb_pricing_'.$randomId.' .frb_pricing_main_color'.($i+$colIdMod).'-hover:hover {background: '.$$hover_color.'; color: '.$$button_text_color.'; transition:background-color 300ms;}
		';
	}
	$html .= '
	</style>';
	
	$html .= '
	<table cellspacing="0" class="frb_pricing_table frb_pricing_table_'.$colnum.'col" id="frb_pricing_'.$randomId.'">';
	
	
	if(is_array($row_type)){
		for($i=0; $i<count($row_type); $i++) {
			
		
		$html.= '
		<tr class="'.($row_type[$i] == 'text-button' ? 'frb_pricing_row_text_button' : '').($row_type[$i] == 'heading' || $row_type[$i] == 'border' ? 'frb_pricing_row_no_padding' : '').($row_type[$i] == 'section' ? 'frb_pricing_row_section' : '').($row_type[$i] == 'heading' ? ' frb_pricing_row_heading' : '').'">';
		
		for($j=0; $j<$colnum; $j++) {
			$ind = ($services_sidebar == 'true' ? $j : $j+1);
			$var_names = array(
				'icon' => 'column_'.$ind.'_icon',
				'text' => 'column_'.$ind.'_text',
				'price' => 'column_'.$ind.'_price',
				'interval' => 'column_'.$ind.'_interval',
				'button_text' => 'column_'.$ind.'_button_text',
				'button_link' => 'column_'.$ind.'_button_link'
			);
			
			if($j == 0 && $services_sidebar == 'true') {
				$slabel_flag = ($row_type[$i] != 'heading' && $row_type[$i] != 'price' && $row_type[$i] != 'button' && $row_type[$i] != 'border');
				
				$html .= '
			<td class="frb_pricing_column1 frb_pricing_column_label'.($slabel_flag && $service_label[$i] != '' ? ' frb_pricing_pale_background' : '').'">
				<div'.($row_type[$i] == 'text-button' ? ' class="frb_pricing_large_font"' : '').'>'.($slabel_flag && $service_label[$i] != '' ? ($row_type[$i] == 'section' ? '<i class="'.$service_icon[$i].' fawesome frb_pricing_fawesome"></i> ' : '').$service_label[$i] : '').'</div>
			</td>';
			}
			else {
				$html .= '	
			<td class="frb_pricing_column'.($j+1).' frb_pricing_pale_background">';
				switch($row_type[$i]){
					case 'heading' : 
					$textj = $$var_names['text'];
					$html .= '
				<div class="frb_pricing_table_category_tag frb_pricing_main_color'.($j+1).'">'.$textj[$i].'</div>';
					break;
					
					case 'price' :
					$pricej = $$var_names['price'];
					$intervalj = $$var_names['interval'];
					$html .= '
				<div class="frb_pricing_table_price" style="clear:both;"><div>'.$currency.'</div><span><div>'.$pricej[$i].'</div><span>'.$intervalj[$i].'</span></span></div>
					';
					break;
					
					case 'button' :
					$button_textj = $$var_names['button_text'];
					$button_linkj = $$var_names['button_link'];
					$html .= '
				<a href="'.$button_linkj[$i].'" class="frb_pricing_table_button frb_pricing_main_color'.($j+1).' frb_pricing_main_color'.($j+1).'-hover">'.$button_textj[$i].'</a>';
					break;
					
					case 'text-button' :
					$textj = $$var_names['text'];
					$button_textj = $$var_names['button_text'];
					$button_linkj = $$var_names['button_link'];
					$html .= '
				<div>'.$textj[$i].'</div>
				<a href="'.$button_linkj[$i].'" class="frb_pricing_table_button frb_pricing_main_color'.($j+1).' frb_pricing_main_color'.($j+1).'-hover">'.$button_textj[$i].'</a>';
					break;
					
					case 'border' :
					$textj = $$var_names['text'];
					$iconj = $$var_names['icon'];
					$html .= '
				<div class="frb_pricing_main_color'.($j+1).' frb_pricing_colored_line"></div>';
					break;
					
					case 'service' :
					$textj = $$var_names['text'];
					$iconj = $$var_names['icon'];
					$html .= '
				<div><strong class="frb_pricing_label_responsive">'.$service_label[$i].'</strong>'.($iconj[$i] != '' && $iconj[$i] != 'no-icon' ? '<i class="'.$iconj[$i].' fawesome frb_pricing_fawesome"></i>' : $textj[$i]).'</div>';
					break;
					
					case 'section' :
					$html .= '
				<div class="frb_pricing_section_responsive"><i class="'.$service_icon[$i].' fawesome frb_pricing_fawesome"></i> '.$service_label[$i].'</div>';
					break;
				}
				$html .= '	
			</td>';
			}
		}
		
		
		$html .= '
		</tr>';
		
		if(isset($bot_border[$i]) && $bot_border[$i] == 'true') {
			$html .= '
				<tr class="frb_pricing_row_separator">';
				for($j=0; $j<$colnum; $j++) {
					$html .= '
					<td class="frb_pricing_column'.$j.' '.($j == 0 && $services_sidebar == 'true' ? 'frb_pricing_column_label' : '').'"></td>';
				}
			$html .= '
				</tr>';
		}
		
		}
	}
	
	$html .= '	
		
	</table>';

	$bot_margin = (int)$bot_margin;
	if($animate != 'none') {
		$animate = ' frb_animated frb_'.$animate.'"';
		
		if($animation_delay != 0) {
			$animation_delay = (int)$animation_delay;
			$animate .= ' data-adelay="'.$animation_delay.'"';
		}
		if($animation_group != '') {
			$animate .= ' data-agroup="'.$animation_group.'"';
		}
	}
	else
		$animate = '"';
	if($services_sidebar == 'true') $colnum--;
	$html = '<div data-colnum="'.$colnum.'" class="frb_pricing_container frb_pricing_container_'.$colnum.'col'.$class.$animate.' style="padding-bottom:'.$bot_margin.'px !important;"><div class="frb_pricing_controls"><a href="#" class="frb_pricing_left"><i class="icon-chevron-left fawesome" ></i></a><a href="#" class="frb_pricing_right"><i class="icon-chevron-right fawesome" ></i></a></div>'.(do_shortcode($html)).'</div>';
	return $html;
}
add_shortcode( 'fbuilder_pricing', 'fbuilder_pricing' );

?>