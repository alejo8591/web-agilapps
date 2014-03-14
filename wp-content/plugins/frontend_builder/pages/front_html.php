<?php
		$html = '';
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
		$output .= 
		'<div id="fbuilder_wrapper"'.($builder->items == '{}' ? ' class="empty"' : '').($sidebar != false ? ' class="fbuilder_wrapper_'.$sidebar.'"' : '').'>'.$html.'
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
					
					
					
					$rowCtrl = $this->extract_row_controls($items['rows'][$row]);
					$html = str_replace('%2$s',$rowCtrl['row']['back'],$html);
					$rowCSS = (isset($rowCtrl['row']['id']) && $rowCtrl['row']['id'] != '' ? 'id="'.$rowCtrl['row']['id'].'" ' : '').(isset($rowCtrl['row']['style']) ? 'style="'.$rowCtrl['row']['style'].'" ' : '').(isset($rowCtrl['row']['class']) ? 'class="'.$rowCtrl['row']['class'].'' : 'class="');
					$colCSS = (isset($rowCtrl['column']['style']) ? 'style="'.$rowCtrl['column']['style'].'" ' : '').(isset($rowCtrl['column']['class']) ? 'class="'.$rowCtrl['column']['class'].'' : 'class="');
					$html = preg_replace('/class=\"/', $rowCSS, $html, 1);
					
					foreach($current['columns'] as $colId => $shortcodes) {
						$columnInterface = '<div '.$colCSS.'fbuilder_droppable" >';
							foreach($shortcodes as $sh) {
							if(!is_null($items['items'][$sh])) {
								$columnInterface .= '<div class="fbuilder_module" data-shortcode="'.$items['items'][$sh]['slug'].'" data-modid="'.$sh.'">';
								$columnInterface .= $this->get_shortcode($items['items'][$sh]);
								$columnInterface .= '</div>';
							}
						}
						$columnInterface .= '</div>';
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
?>