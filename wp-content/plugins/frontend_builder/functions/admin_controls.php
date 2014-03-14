<?php

Class fbuilderControl {
	var $html;
	function __construct($object){
		global $fbuilder;
		$wrapper = 
			'<div class="fbuilder_control'.(array_key_exists('hide_if', $object) ? ' fbuilder_hidable' : '').(array_key_exists('class',$object) ? ' '.$object['class'] : '').'"><div class="fbuilder_control_left">'.
			(array_key_exists('label', $object) && array_key_exists('name', $object) ? '<label for="'.$object['name'].'">'.$object['label'].' </label>' : '').
			(array_key_exists('desc', $object) ? '<span class="fbuilder_desc">('.$object['desc'].')</span>' : '').
			'</div><div class="fbuilder_control_right"><div class="fbuilder_control_right_inner">';
		$wrapperFull =
			'<div class="fbuilder_control'.(array_key_exists('hide_if', $object) ? ' fbuilder_hidable' : '').(array_key_exists('class',$object) ? ' '.$object['class'] : '').'"><div class="fbuilder_control_full">'.
			(array_key_exists('label', $object) && array_key_exists('name', $object) ? '<label for="'.$object['name'].'">'.$object['label'].' </label>' : '').
			(array_key_exists('desc', $object) ? '<span class="fbuilder_desc">('.$object['desc'].')</span>' : '').
			'</div><div class="fbuilder_control_full"><div class="fbuilder_control_full_inner">';
			
		$wrapperClose = '</div></div><div style="clear:both"></div></div><div style="clear:both"></div>';
		$html = '';	
		switch($object['type']) {
			case 'margin' :
				$html = '<div style="height:'.$object['height'].'"></div>';
				break;
			case 'heading' :
				$hTypes = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');
				if(array_key_exists('size', $object) && in_array($object['size'], $hTypes))
					$hType = $object['size'];
				else 
					$hType = 'h3';
				$html .= '<'.$hType.' class="fbuilder_admin_menu_heading">'.$object['label'].'</'.$hType.'>';
				break;
			case 'input' : 
				$html .= $wrapper;
				$html .= '<input class="fbuilder_input'.(array_key_exists('hide_if', $object) ? ' fbuilder_hidable_control' : '').'" name="'.$object['name'].'" id="fbuilder_'.$object['type'].'_'.$object['name'].'" '.(array_key_exists('std',$object) && $object['std'] != '' ? 'value="'.$object['std'].'"' : '').'/>';
				$html .= $wrapperClose;
				break;
		
			case 'textarea' :
				$html .= $wrapperFull;
				$html .= '<textarea class="fbuilder_textarea'.(array_key_exists('hide_if',$object) ? ' fbuilder_hidable_control' : '').'" name="'.$object['name'].'" id="fbuilder_'.$object['type'].'_'.$object['name'].'">'.(array_key_exists('std',$object) && $object['std'] != '' ? $object['std'] : '').'</textarea>';
				$html .= $wrapperClose;
				break;
			
			case 'checkbox' :
				$html .= 
					$wrapper.
					'<div class="fbuilder_checkbox'.(array_key_exists('std',$object) && $object['std'] != '' && $object['std'] == 'true' ? ' active' : '').'"></div>'.
					'<input class="fbuilder_checkbox_input'.(array_key_exists('hide_if',$object) ? ' fbuilder_hidable_control' : '').'" name="'.$object['name'].'" id="fbuilder_'.$object['type'].'_'.$object['name'].'" style="display:none;"'.
					(array_key_exists('std',$object) && $object['std'] == 'true' ? ' value="'.$object['std'].'"' : ' value="false"').' />'.
					'<div class="fbuilder_checkbox_label">'.
					'</div><div style="clear:both;"></div>'.
					$wrapperClose;
				break;
			
			case 'select' :
				$options = $object['options'];
				$html .= $wrapper;
				$html .= '<select class="'.(array_key_exists('hide_if',$object) ? ' fbuilder_hidable_control' : '').'" name="'.$object['name'].'" id="fbuilder_'.$object['type'].'_'.$object['name'].'" style="display:none;">';
				$visibleSelect = '<div class="fbuilder_select fbuilder_gradient'.(array_key_exists('search',$object) && $object['search'] == 'true' ? ' fbuilder_select_with_search' : '').'" data-name="'.$object['name'].'">';

				$count = 0;
				foreach($options as $x => $valx) {
					$html .= '<option value="'.$x.'"'.((array_key_exists('std',$object) && $object['std'] != '' && $object['std'] == $x) ? ' selected="selected"' : '').'>'.$valx.'</option>';
					if ($count == 0) {
						$visibleSelect .=
							'<span>'.(array_key_exists('std',$object) && $object['std'] != '' ? $options[$object['std']] : $valx).'</span>'.
							'<div class="drop_button"></div>'.
							(array_key_exists('search',$object) && $object['search'] == 'true' ? '<input class="fbuilder_select_search" placeholder="Search..." value="" style="display:none" />' : '').
							'<ul style="display:none">'.
							'
						<li><a href="#" data-value="'.$x.'"'.((array_key_exists('std',$object) && $object['std'] != '' && $object['std'] == $x) ? ' class="selected"' : '').'>'.$valx.'</a></li>';
					}
					else {
						$visibleSelect .= '
						<li><a href="#" data-value="'.$x.'"'.($object['std'] == $x ? ' class="selected"' : '').'>'.$valx.'</a></li>';
					}
					$count++;
				}
				
				$html .= '</select>';
				$visibleSelect .=
					'</ul>'.
					'<div class="clear"></div>'.
					'</div>';
				$html .= $visibleSelect;
				$html .= $wrapperClose;
				
				break;
			
			case 'icon' :
				global $fbuilder_icons;
				$dataMin = ((array_key_exists('notNull',$object) && $object['notNull'] == false) ? 0 : 1);
				$current = ((array_key_exists('std',$object) && $object['std'] != '' ) ? $object['std'] : $fbuilder_icons[$dataMin]);
				$html .= $wrapper;
				$html .= '<input class="'.(array_key_exists('hide_if',$object) ? ' fbuilder_hidable_control' : '').'" type="hidden" name="'.$object['name'].'" id="fbuilder_'.$object['type'].'_'.$object['name'].'" data-current="'.array_search($current,$fbuilder_icons).'" data-min="'.$dataMin.'" value="'.$current.'" /><div class="fbuilder_icon_holder"><i class="'.$current.' fawesome"></i></div><a href="#" class="fbuilder_gradient fbuilder_icon_left"><span></span></a><a href="#" class="fbuilder_gradient fbuilder_icon_right"><span></span></a><a href="#" class="fbuilder_gradient fbuilder_icon_pick">Show all</a>';
				$html .= '<div style="clear:both;"></div><span class="fbuilder_icon_drop_arrow"></span><div class="fbuilder_icon_dropdown">';
				if(array_key_exists('notNull', $object) && $object['notNull'] == false) {
					$html .= '<a href="0" title="No icon"><i class="no-icon fawesome"></i></a>';
				}
				foreach($fbuilder_icons as $x => $valx) {
					$html .= '<a href="'.$x.'"><i class="'.$fbuilder_icons[$x].' fawesome"></i></a>';
				}
				$html .= '<div style="clear:both;"></div></div><div style="clear:both;"></div>';
				$html .= $wrapperClose;
				break;
			case 'image' : 
				$html .= $wrapper;
				$html .= '<div class="fbuilder_image_holder" id="fbuilder_'.$object['type'].'_'.$object['name'].'_holder">'.(array_key_exists('std',$object) && $object['std'] != '' ? '<img src="'.$object['std'].'" alt="" />' : '').'</div>';
				$html .= '<div class="fbuilder_image_input"><input class="fbuilder_input'.(array_key_exists('hide_if',$object) ? ' fbuilder_hidable_control' : '').'" name="'.$object['name'].'" id="fbuilder_'.$object['type'].'_'.$object['name'].'" value="'.(array_key_exists('std',$object) && $object['std'] != '' ? $object['std'].'" />' : '" /><span>Enter image url...</span>').'</div>';
				$html .= '<a html="'.$object['name'].'" class="fbuilder_image_button fbuilder_gradient_primary" data-input="fbuilder_'.$object['type'].'_'.$object['name'].'">Upload</a>';
				$html .= '<div style="clear:both;"></div>';
				$html .= $wrapperClose;
				break;
			
			
			case 'draggable' :
				$html .= '<div class="fbuilder_draggable fbuilder_gradient" data-shortcode="'.$object['name'].'">'.$object['text'].'<span class="draggable_icon"></span></div>';
				break;
			
			case 'button' :
				$cl = (array_key_exists('class',$object) ? $object['class'] : '');
				$href = (array_key_exists('href',$object) ? $object['href'] : '#');
				$id = (array_key_exists('id',$object) && $object['id'] != '' ? ' id="'.$object['id'].'"' : '');
				$style = (array_key_exists('style', $object) && $object['style'] == 'primary' ? 'fbuilder_gradient_primary' : 'fbuilder_gradient');
				$align = (array_key_exists('align', $object) && $object['align'] == 'right' ? ' style="float:right;"' : '');
				
				$html .= '<a'.$id.' href="'.$href.'" class="'.$style.' fbuilder_button '.$cl.'"'.$align.'>'.$object['label'].'</a>'.(!array_key_exists('loader', $object) || $object['loader'] == 'true' ? '<img src="'.$fbuilder->url.'images/save-loader.gif" class="fbuilder_save_loader" alt="" />' : '').(!array_key_exists('clear', $object) || $object['clear'] != 'false' ? '<div style="clear:both;"></div>' : '');
				break;
			
			case 'number' :
				$min = (array_key_exists('min',$object) && $object['min'] != '' ? $object['min'] : 0);
				$max = (array_key_exists('max',$object) && $object['max'] != '' ? $object['max'] : 100);
				$std = (array_key_exists('std',$object) && $object['std'] != '' ? (int)$object['std'] : 0);
				$unit = (array_key_exists('unit',$object) ? $object['unit'] : '');
				$maxStr = ''.$max;
				
				$html .= $wrapper;
				$html .= '<div class="fbuilder_number_bar" data-min="'.$min.'" data-max="'.$max.'" data-std="'.$std.'" data-unit="'.$unit.'"></div><input class="fbuilder_number_amount'.(array_key_exists('hide_if',$object) ? ' fbuilder_hidable_control' : '').'" name="'.$object['name'].'" id="fbuilder_'.$object['type'].'_'.$object['name'].'" value="'.$std.' '.$unit.'"/><div style="clear:both;"></div>';
				$html .= $wrapperClose;
				break;
			
			case 'color' : 
				$html .= $wrapper;
				$html .= '<div class="fbuilder_color_wrapper">';
				$html .= '<input class="fbuilder_color fbuilder_input'.(array_key_exists('hide_if',$object) ? ' fbuilder_hidable_control' : '').'" name="'.$object['name'].'" id="fbuilder_'.$object['type'].'_'.$object['name'].'" '.(array_key_exists('std',$object) && $object['std'] != '' ? 'value="'.$object['std'].'"' : '').'/>';
				$html .= '<div class="fbuilder_color_display"></div><div class="fbuilder_colorpicker"></div>';
				$html .= '</div>';
				$html .= $wrapperClose;
				break;
			
			case 'collapsible' :
				$html .= '<div class="fbuilder_collapsible"><div class="fbuilder_gradient fbuilder_collapsible_header">'.$object['label'].'<span class="fbuilder_collapse_trigger">+</span></div><div class="fbuilder_collapsible_content">';
				if(array_key_exists('options', $object)) {
					foreach($object['options'] as $obj) {
						$newControl = new fbuilderControl($obj);
						$html .= $newControl->html;
					}
				}
				$html .='</div></div>';
				break;
			
			case 'sortable' :
				$item_name = (array_key_exists('item_name',$object) && $object['item_name'] != '' ? $object['item_name'] : 'item');
				$html .= $wrapper;
				$html .= '<div class="fbuilder_sortable_holder" data-name="'.$object['name'].'" data-iname="'.$item_name.'" id="fbuilder_'.$object['type'].'_'.$object['name'].'">';
				$html .= '<div class="fbuilder_sortable">';
				
				
				if(array_key_exists('std',$object) && $object['std'] != '') {
					if(array_key_exists('order',$object['std']) && !empty($object['std']['order'])) {
						foreach ($object['std']['order'] as $x => $valx) {
							$sortid = $valx;
							$html .= '<div class="fbuilder_sortable_item fbuilder_collapsible" data-sortid="'.$sortid.'" data-sortname="'.$object['name'].'"><div class="fbuilder_gradient fbuilder_sortable_handle fbuilder_collapsible_header">'.$item_name.' '.$sortid.' - <span class="fbuilder_sortable_delete">delete</span><span class="fbuilder_collapse_trigger">+</span></div><div class="fbuilder_collapsible_content">';
							
							$controlObj = $object['options'];
							foreach($controlObj as $y => $valy) {
								if(array_key_exists($y,$object['std']['items'][$sortid])) {
									$controlObj[$y]['std'] = $object['std']['items'][$sortid][$y];
								}
								$controlObj[$y]['name'] = 'fsort-'.$sortid.'-'.$y;
								$newControl = new fbuilderControl($controlObj[$y]);
								$html .= $newControl->html;
							}
							$html .='</div></div>';
						}
					}
				}
				
				
				
				$html .= '</div>';
				$html .= '<a href="#" class="fbuilder_sortable_add fbuilder_gradient_primary fbuilder_button">+ Add new '.$item_name.'</a>';
				$html .= '<div style="clear:both;"></div>';
				$html .= '</div>';
				$html .= $wrapperClose;
				break;
		
		}
		$this->html = $html;
	
	}
}

?>