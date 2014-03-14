<?php
$fbuilder_controls = array(
	'padding_top' => array(
		'type' => 'number',
		'label' => __('Top padding','frontend-builder'),
		'std' => 0,
		'max' => 300,
		'unit' => 'px'
	),
	'padding_bot' => array(
		'type' => 'number',
		'label' => __('Bottom padding','frontend-builder'),
		'std' => 0,
		'max' => 300,
		'unit' => 'px'
	),
	'back_type' => array(
		'type' => 'select',
		'label' => __('Background type','frontend-builder'),
		'std' => 'static',
		'options' => array(
			'static' => __('Static','frontend-builder'),
			'parallax' => __('Parallax','frontend-builder')
			)
	),
	'back_color' => array(
		'type' => 'color',
		'label' => __('Background color','frontend-builder'),
		'std' => $this->option('row_back_color')->value
	),
	'back_image' => array(
		'type' => 'image',
		'label' => __('Background image','frontend-builder'),
		'std' => ''
	),
	'back_repeat' => array(
		'type' => 'checkbox',
		'label' => __('Repeat image','frontend-builder'),
		'std' => 'false'
	),
	'column_padding' => array(
		'type' => 'number',
		'label' => __('Column padding','frontend-builder'),
		'std' => 0,
		'unit' => 'px'
	),
	'column_back' => array(
		'type' => 'color',
		'label' => __('Column background color','frontend-builder'),
		'std' => $this->option('column_back_color')->value
	),
	'column_back_opacity' => array(
		'type' => 'number',
		'label' => __('Column background opacity','frontend-builder'),
		'std' => 100,
		'unit' => '%'
	)
	
);


if($this->option('css_classes')->value == 'true') {
	$classControl = array(
		'id' => array(
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
	$fbuilder_controls = array_merge($classControl, $fbuilder_controls);
	
}
$output = $fbuilder_controls;
?>