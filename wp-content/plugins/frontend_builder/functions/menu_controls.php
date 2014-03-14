<?php
$fbuilder_controls = array(
	'fbuilder_layout' => array(
		'class' => 'fbuilder_layout',
		'type' => 'select',
		'label' => __('Page layout','frontend-builder'),
		'std' => 'full-width',
		'options' => array(
			'full-width' => __('Full width','frontend-builder'),
			'one-third-left-sidebar' => __('One third left sidebar','frontend-builder'),
			'one-third-right-sidebar' => __('One third right sidebar','frontend-builder'),
			'one-fourth-left-sidebar' => __('One fourth left sidebar','frontend-builder'),
			'one-fourth-right-sidebar' => __('One fourth right sidebar','frontend-builder')
			)
	),
	'fbuilder_shortcode_druggables' => array(
		'type' => 'shortcode-holder',
		'label' => __('Template elements','frontend-builder'),
		'desc' => __('Drag and drop an element to the web page','frontend-builder'),
	),
	'fbuilder_save_page' => array(
		'type' => 'button',
		'style' => 'primary',
		'class' => 'fbuilder_save left',
		'label' => __('Save changes','frontend-builder'),
		'clear' => 'false',
		'loader' => 'true'
	
	),
	'fbuilder_save_template' => array(
		'type' => 'button',
		'class' => 'fbuilder_save_template left',
		'label' => __('Save template','frontend-builder'),
		'clear' => 'false',
	),
	'fbuilder_load_page' => array(
		'type' => 'button',
		'class' => 'fbuilder_load right',
		'label' => __('Load','frontend-builder')
	)
);

$output = $fbuilder_controls;

?>