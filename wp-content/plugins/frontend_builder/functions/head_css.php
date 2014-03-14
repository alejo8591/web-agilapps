<?php

$admin_optionsDB = $this->option();
$admin_options = $this->admin_controls;
$general_options = array();
if(array_key_exists('general', $admin_options) && array_key_exists('options', $admin_options['general']))
foreach ($admin_options['general']['options'] as $general_ctrl) {
	if(array_key_exists('type',$general_ctrl) && $general_ctrl['type'] != 'collapsible') {
		if(array_key_exists('name', $general_ctrl) && array_key_exists('std',$general_ctrl)) {
			
			$general_options[$general_ctrl['name']] = $general_ctrl['std'];
			foreach($admin_optionsDB as $optt) {
				if($optt->name == $general_ctrl['name']) {
					if(isset($optt->value)) {
						$general_options[$general_ctrl['name']] = $optt->value;
					}
					break;
				}
			}
		}
	}
	else {
		foreach ($general_ctrl['options'] as $collapsible_ctrl) {
			if(array_key_exists('name',$collapsible_ctrl)) {
				if(array_key_exists('name', $collapsible_ctrl) && array_key_exists('std',$collapsible_ctrl)) {
					
					$general_options[$collapsible_ctrl['name']] = $collapsible_ctrl['std'];
					foreach($admin_optionsDB as $optt) {
						if($optt->name == $collapsible_ctrl['name']) {
							if(isset($optt->value)) {
								$general_options[$collapsible_ctrl['name']] = $optt->value;
							}
							break;
						}
					}
				}
			}
		}
	}
}

$general_options['high_rezolution_margin'] = (int) $general_options['high_rezolution_margin'];
$general_options['high_rezolution_width'] = (int) $general_options['high_rezolution_width'];
$general_options['med_rezolution_margin'] = (int) $general_options['med_rezolution_margin'];
$general_options['med_rezolution_width'] = (int) $general_options['med_rezolution_width'];
$general_options['low_rezolution_margin'] = (int) $general_options['low_rezolution_margin'];
$general_options['low_rezolution_width'] = (int) $general_options['low_rezolution_width'];



$output ='
<style>
#fbuilder_content_wrapper .fbuilder_row > div:last-child, .anivia_row > div:last-child,  #fbuilder_wrapper.fbuilder_wrapper_one-fourth-right-sidebar, #fbuilder_wrapper.fbuilder_wrapper_one-fourth-left-sidebar, #fbuilder_wrapper.fbuilder_wrapper_one-third-right-sidebar, #fbuilder_wrapper.fbuilder_wrapper_one-third-left-sidebar {
	margin: 0px -'.($general_options['high_rezolution_margin']/2).'px;
}

.fbuilder_column.fbuilder_column-1-1, .fbuilder_column.fbuilder_column-1-2, .fbuilder_column.fbuilder_column-1-3, .fbuilder_column.fbuilder_column-2-3, .fbuilder_sidebar.fbuilder_one-fourth-right-sidebar, .fbuilder_sidebar.fbuilder_one-fourth-left-sidebar, .fbuilder_sidebar.fbuilder_one-third-right-sidebar, .fbuilder_sidebar.fbuilder_one-third-left-sidebar, .fbuilder_column.fbuilder_column-1-4, .fbuilder_column.fbuilder_column-3-4, .fbuilder_column.fbuilder_column-1-5, .fbuilder_column.fbuilder_column-2-5, .fbuilder_column.fbuilder_column-3-5, .fbuilder_column.fbuilder_column-4-5, .fbuilder_wrapper_one-fourth-left-sidebar #fbuilder_content_wrapper, .fbuilder_wrapper_one-third-left-sidebar #fbuilder_content_wrapper, .fbuilder_wrapper_one-fourth-right-sidebar #fbuilder_content_wrapper, .fbuilder_wrapper_one-third-right-sidebar #fbuilder_content_wrapper{
	border-right:'.($general_options['high_rezolution_margin']/2).'px solid transparent;
	border-left:'.($general_options['high_rezolution_margin']/2).'px solid transparent;
}

@media screen and (max-width: '.$general_options['high_rezolution_width'].'px) {

	#fbuilder_content_wrapper .fbuilder_row > div:last-child, .anivia_row > div:last-child,  #fbuilder_wrapper.fbuilder_wrapper_one-fourth-right-sidebar, #fbuilder_wrapper.fbuilder_wrapper_one-fourth-left-sidebar, #fbuilder_wrapper.fbuilder_wrapper_one-third-right-sidebar, #fbuilder_wrapper.fbuilder_wrapper_one-third-left-sidebar {
		margin: 0px -'.($general_options['med_rezolution_margin']/2).'px;
	}
	.fbuilder_column.fbuilder_column-1-1, .fbuilder_column.fbuilder_column-1-2, .fbuilder_column.fbuilder_column-1-3, .fbuilder_column.fbuilder_column-2-3, .fbuilder_sidebar.fbuilder_one-fourth-right-sidebar, .fbuilder_sidebar.fbuilder_one-fourth-left-sidebar, .fbuilder_sidebar.fbuilder_one-third-right-sidebar, .fbuilder_sidebar.fbuilder_one-third-left-sidebar, .fbuilder_column.fbuilder_column-1-4, .fbuilder_column.fbuilder_column-3-4, .fbuilder_column.fbuilder_column-1-5, .fbuilder_column.fbuilder_column-2-5, .fbuilder_column.fbuilder_column-3-5, .fbuilder_column.fbuilder_column-4-5, .fbuilder_wrapper_one-fourth-left-sidebar #fbuilder_content_wrapper, .fbuilder_wrapper_one-third-left-sidebar #fbuilder_content_wrapper, .fbuilder_wrapper_one-fourth-right-sidebar #fbuilder_content_wrapper, .fbuilder_wrapper_one-third-right-sidebar #fbuilder_content_wrapper{
		border-right:'.($general_options['med_rezolution_margin']/2).'px solid transparent;
		border-left:'.($general_options['med_rezolution_margin']/2).'px solid transparent;
	}
}
@media screen and (max-width: '.$general_options['med_rezolution_width'].'px) {
	#fbuilder_content_wrapper .fbuilder_row > div:last-child, .anivia_row > div:last-child,  #fbuilder_wrapper.fbuilder_wrapper_one-fourth-right-sidebar, #fbuilder_wrapper.fbuilder_wrapper_one-fourth-left-sidebar, #fbuilder_wrapper.fbuilder_wrapper_one-third-right-sidebar, #fbuilder_wrapper.fbuilder_wrapper_one-third-left-sidebar {
		margin: 0px -'.($general_options['low_rezolution_margin']/2).'px;
	}

	.fbuilder_column.fbuilder_column-1-1, .fbuilder_column.fbuilder_column-1-2, .fbuilder_column.fbuilder_column-1-3, .fbuilder_column.fbuilder_column-2-3, .fbuilder_sidebar.fbuilder_one-fourth-right-sidebar, .fbuilder_sidebar.fbuilder_one-fourth-left-sidebar, .fbuilder_sidebar.fbuilder_one-third-right-sidebar, .fbuilder_sidebar.fbuilder_one-third-left-sidebar, .fbuilder_column.fbuilder_column-1-4, .fbuilder_column.fbuilder_column-3-4, .fbuilder_column.fbuilder_column-1-5, .fbuilder_column.fbuilder_column-2-5, .fbuilder_column.fbuilder_column-3-5, .fbuilder_column.fbuilder_column-4-5, .fbuilder_wrapper_one-fourth-left-sidebar #fbuilder_content_wrapper, .fbuilder_wrapper_one-third-left-sidebar #fbuilder_content_wrapper, .fbuilder_wrapper_one-fourth-right-sidebar #fbuilder_content_wrapper, .fbuilder_wrapper_one-third-right-sidebar #fbuilder_content_wrapper{
		border-right:'.($general_options['low_rezolution_margin']/2).'px solid transparent;
		border-left:'.($general_options['low_rezolution_margin']/2).'px solid transparent;
	}
}
@media screen and (max-width: '.$general_options['low_rezolution_width'].'px) {
	.fbuilder_column.fbuilder_column-1-1, .fbuilder_column.fbuilder_column-1-2, .fbuilder_column.fbuilder_column-1-3, .fbuilder_column.fbuilder_column-2-3, .fbuilder_sidebar.fbuilder_one-fourth-right-sidebar, .fbuilder_sidebar.fbuilder_one-fourth-left-sidebar, .fbuilder_sidebar.fbuilder_one-third-right-sidebar, .fbuilder_sidebar.fbuilder_one-third-left-sidebar, .fbuilder_column.fbuilder_column-1-4, .fbuilder_column.fbuilder_column-3-4, .fbuilder_column.fbuilder_column-1-5, .fbuilder_column.fbuilder_column-2-5, .fbuilder_column.fbuilder_column-3-5, .fbuilder_column.fbuilder_column-4-5, .fbuilder_wrapper_one-fourth-left-sidebar #fbuilder_content_wrapper, .fbuilder_wrapper_one-third-left-sidebar #fbuilder_content_wrapper, .fbuilder_wrapper_one-fourth-right-sidebar #fbuilder_content_wrapper, .fbuilder_wrapper_one-third-right-sidebar #fbuilder_content_wrapper{
		width:100%;
		border-width:0;
	}
	.frb_pricing_column_label {
		display:none;
	}
	.frb_pricing_container_1col table {
		width:100% !important;
	}
	.frb_pricing_container_2col table{
		width:200% !important;
	}
	.frb_pricing_container_3col table{
		width:300% !important;
	}
	.frb_pricing_container_4col table{
		width:400% !important;
	}
	.frb_pricing_container_5col table{
		width:500% !important;
	}
	.frb_pricing_table td {
		border-right:0 !important;
	}
	#fbuilder_content_wrapper .fbuilder_row > div:last-child, .anivia_row > div:last-child,  .fbuilder_wrapper_one-third-left-sidebar .fbuilder_row, .fbuilder_wrapper_one-third-right-sidebar .fbuilder_row, .fbuilder_wrapper_one-fourth-left-sidebar .fbuilder_row, .fbuilder_wrapper_one-fourth-right-sidebar .fbuilder_row, .fbuilder_row_controls  {
		margin: 0px;
	}
	.frb_pricing_controls,
	.frb_pricing_section_responsive,
	.frb_pricing_label_responsive {
		display:block;
	}


}



</style>
';

if(array_key_exists('css_custom', $general_options) && $general_options['css_custom'] != '') {
	$output .='
<style>
'.$general_options['css_custom'].'
</style>
';
}

?>