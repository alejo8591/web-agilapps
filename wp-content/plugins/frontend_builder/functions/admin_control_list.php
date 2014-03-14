<?php
$fbuilder_google_font_names = $this->get_google_fonts();
$fbuilder_google_font_variants = $this->get_font_variants();

$fbuilder_admin_options = array(
	'general' => array(
		'label' => __('General options','frontend-builder'),
		'options' => array(
			array(
				'type' => 'heading',
				'label' => __('Utility options','frontend-builder')
			),
			array(
				'name' => 'save_overwrite',
				'type' => 'checkbox',
				'label' => __('Save over post content','frontend-builder'),
				'desc' => __('overwrite old post content when saving - recomended','frontend-builder'),
				'std' => 'true'
			),
			array(
				'name' => 'css_classes',
				'type' => 'checkbox',
				'label' => __('Show CSS controls','frontend-builder'),
				'desc' => __('Display shortcode controls for setting classes','frontend-builder'),
				'std' => 'flase'
			),
			array(
				'name' => 'css_custom',
				'type' => 'textarea',
				'label' => __('Custom CSS code','frontend-builder'),
				'std' => ''
			),
			array(
				'type' => 'heading',
				'label' => __('Dimensions','frontend-builder')
			),
			array(
				'type' => 'number',
				'name' => 'bottom_margin',
				'label' => __('Default module margin','frontend-builder'),
				'std' => 24,
				'unit' => 'px' 
			),
			array(
				'type' => 'collapsible',
				'label' => __('High rezolution','frontend-builder'),
				'options' => array(
					array(
						'name' => 'high_rezolution_width',
						'label' => __('Content width','frontend-builder'),
						'type' => 'number',
						'min' => 900,
						'max' => 2000,
						'std' => 1200,
						'step' => 2,
						'unit' => 'px'
					),			
					array(
						'name' => 'high_rezolution_margin',
						'label' => __('Column margin','frontend-builder'),
						'type' => 'number',
						'std' => 48,
						'unit' => 'px'
					),
				)
			),
			array(
				'type' => 'collapsible',
				'label' => __('Medium rezolution','frontend-builder'),
				'options' => array(
					array(
						'name' => 'med_rezolution_width',
						'label' => __('Content width','frontend-builder'),
						'type' => 'number',
						'min' => 600,
						'max' => 1200,
						'std' => 960,
						'step' => 2,
						'unit' => 'px'
					),			
					array(
						'name' => 'med_rezolution_margin',
						'label' => __('Column margin','frontend-builder'),
						'type' => 'number',
						'std' => 36,
						'unit' => 'px'
					),
					array(
						'name' => 'med_rezolution_hide_sidebar',
						'type' => 'checkbox',
						'label' => __('Hide sidebar','frontend-builder'),
						'std' => 'false'
					),
				)
			),
			array(
				'type' => 'collapsible',
				'label' => __('Low rezolution','frontend-builder'),
				'options' => array(
					array(
						'name' => 'low_rezolution_width',
						'label' => __('Content width','frontend-builder'),
						'type' => 'number',
						'min' => 400,
						'max' => 900,
						'std' => 768,
						'step' => 2,
						'unit' => 'px'
					),			
					array(
						'name' => 'low_rezolution_margin',
						'label' => __('Column margin','frontend-builder'),
						'type' => 'number',
						'std' => 24,
						'unit' => 'px'
					),
					array(
						'name' => 'low_rezolution_hide_sidebar',
						'type' => 'checkbox',
						'label' => __('Hide sidebar','frontend-builder'),
						'std' => 'false'
					),
				)
			),
			array(
				'type' => 'collapsible',
				'label' => __('Mobile devices','frontend-builder'),
				'options' => array(
					array(
						'name' => 'mob_rezolution_hide_sidebar',
						'type' => 'checkbox',
						'label' => __('Hide sidebar','frontend-builder'),
						'std' => 'true'
					),
				)
			),
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			)
			
		)
	),
	'font' => array(
		'label' => __('Typography options','frontend-builder'),
		'desc' => __('Font and typography settings for each shortcode. The "Default" option will use the theme fonts.','frontend-builder'),
		'options' => array(
			array(
				'type' => 'heading',
				'label' => __('Heading','frontend-builder')
			),
			array(
				'type' => 'collapsible',
				'label' => __('H1 typography','frontend-builder'),
				'options' => array(
					array(
						'name' => 'h1_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'h1_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('h1_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'h1_font_family' => array('default')
						)
					),
					array(
						'name' => 'h1_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'h1_font_family' => array('default')
						)
					),
					array(
						'name' => 'h1_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'h1_font_family' => array('default')
						)
					)
				)
			), // h1 font
			array(
				'type' => 'collapsible',
				'label' => __('H2 typography','frontend-builder'),
				'options' => array(
					array(
						'name' => 'h2_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'h2_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('h2_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'h2_font_family' => array('default')
						)
					),
					array(
						'name' => 'h2_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'h2_font_family' => array('default')
						)
					),
					array(
						'name' => 'h2_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'h2_font_family' => array('default')
						)
					)
				)
			), // h2 font
			array(
				'type' => 'collapsible',
				'label' => __('H3 typography','frontend-builder'),
				'options' => array(
					array(
						'name' => 'h3_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'h3_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('h3_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'h3_font_family' => array('default')
						)
					),
					array(
						'name' => 'h3_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'h3_font_family' => array('default')
						)
					),
					array(
						'name' => 'h3_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'h3_font_family' => array('default')
						)
					)
				)
			), // h3 font
			array(
				'type' => 'collapsible',
				'label' => __('H4 typography','frontend-builder'),
				'options' => array(
					array(
						'name' => 'h4_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'h4_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('h4_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'h4_font_family' => array('default')
						)
					),
					array(
						'name' => 'h4_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'h4_font_family' => array('default')
						)
					),
					array(
						'name' => 'h4_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'h4_font_family' => array('default')
						)
					)
				)
			), // h4 font
			array(
				'type' => 'collapsible',
				'label' => __('H5 typography','frontend-builder'),
				'options' => array(
					array(
						'name' => 'h5_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'h5_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('h5_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'h5_font_family' => array('default')
						)
					),
					array(
						'name' => 'h5_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'h5_font_family' => array('default')
						)
					),
					array(
						'name' => 'h5_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'h5_font_family' => array('default')
						)
					)
				)
			), // h5 font
			array(
				'type' => 'collapsible',
				'label' => __('H6 typography','frontend-builder'),
				'options' => array(
					array(
						'name' => 'h6_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'h6_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('h6_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'h6_font_family' => array('default')
						)
					),
					array(
						'name' => 'h6_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'h6_font_family' => array('default')
						)
					),
					array(
						'name' => 'h6_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'h6_font_family' => array('default')
						)
					)
				)
			), // h6 font
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			),
			array(
				'type' => 'heading',
				'label' => __('Buttons','frontend-builder')
			),
			array(
				'type' => 'collapsible',
				'label' => __('Text font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'button_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'button_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('button_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'button_font_family' => array('default')
						)
					),
					array(
						'name' => 'button_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'button_font_family' => array('default')
						)
					),
					array(
						'name' => 'button_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'button_font_family' => array('default')
						)
					)
				)
			), // button font
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			),
			
			array(
				'type' => 'heading',
				'label' => __('Slider','frontend-builder')
			),
			array(
				'type' => 'collapsible',
				'label' => __('Text font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'slider_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'slider_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('testimonial_name_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'slider_font_family' => array('default')
						)
					),
					array(
						'name' => 'slider_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'slider_font_family' => array('default')
						)
					),
					array(
						'name' => 'slider_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'slider_font_family' => array('default')
						)
					)
				)
			), // slider font
			
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			),
			
			array(
				'type' => 'heading',
				'label' => __('Testimonials','frontend-builder')
			),
			array(
				'type' => 'collapsible',
				'label' => __('Name font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'testimonial_name_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'testimonial_name_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('testimonial_name_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'testimonial_name_font_family' => array('default')
						)
					),
					array(
						'name' => 'testimonial_name_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'testimonial_name_font_family' => array('default')
						)
					),
					array(
						'name' => 'testimonial_name_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'testimonial_name_font_family' => array('default')
						)
					)
				)
			), // testimonial_name font
			array(
				'type' => 'collapsible',
				'label' => __('Profession font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'testimonial_profession_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'testimonial_profession_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('testimonial_profession_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'testimonial_profession_font_family' => array('default')
						)
					),
					array(
						'name' => 'testimonial_profession_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'testimonial_profession_font_family' => array('default')
						)
					),
					array(
						'name' => 'testimonial_profession_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'testimonial_profession_font_family' => array('default')
						)
					)
				)
			), // testimonial_profession font
			array(
				'type' => 'collapsible',
				'label' => __('Quote font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'testimonial_quote_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'testimonial_quote_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('testimonial_quote_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'testimonial_quote_font_family' => array('default')
						)
					),
					array(
						'name' => 'testimonial_quote_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'testimonial_quote_font_family' => array('default')
						)
					),
					array(
						'name' => 'testimonial_quote_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'testimonial_quote_font_family' => array('default')
						)
					)
				)
			), // testimonial_quote font
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			),
			array(
				'type' => 'heading',
				'label' => __('Tabs','frontend-builder')
			),
			array(
				'type' => 'collapsible',
				'label' => __('Title font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'tabs_title_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'tabs_title_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('tabs_title_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'tabs_title_font_family' => array('default')
						)
					),
					array(
						'name' => 'tabs_title_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'tabs_title_font_family' => array('default')
						)
					),
					array(
						'name' => 'tabs_title_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'tabs_title_font_family' => array('default')
						)
					)
				)
			), // tabs_title font
			array(
				'type' => 'collapsible',
				'label' => __('Content font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'tabs_content_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'tabs_content_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('tabs_content_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'tabs_content_font_family' => array('default')
						)
					),
					array(
						'name' => 'tabs_content_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'tabs_content_font_family' => array('default')
						)
					),
					array(
						'name' => 'tabs_content_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'tabs_content_font_family' => array('default')
						)
					)
				)
			), // tabs_content font
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			),
			array(
				'type' => 'heading',
				'label' => __('Accordion','frontend-builder')
			),
			array(
				'type' => 'collapsible',
				'label' => __('Title font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'accordion_title_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'accordion_title_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('accordion_title_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'accordion_title_font_family' => array('default')
						)
					),
					array(
						'name' => 'accordion_title_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'accordion_title_font_family' => array('default')
						)
					),
					array(
						'name' => 'accordion_title_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'accordion_title_font_family' => array('default')
						)
					)
				)
			), // accordion_title font
			array(
				'type' => 'collapsible',
				'label' => __('Content font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'accordion_content_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'accordion_content_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('accordion_content_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'accordion_content_font_family' => array('default')
						)
					),
					array(
						'name' => 'accordion_content_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'accordion_content_font_family' => array('default')
						)
					),
					array(
						'name' => 'accordion_content_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'accordion_content_font_family' => array('default')
						)
					)
				)
			), // accordion_content font
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			),
			array(
				'type' => 'heading',
				'label' => __('Alert box','frontend-builder')
			),
			array(
				'type' => 'collapsible',
				'label' => __('Text font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'alert_text_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'alert_text_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('alert_text_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'alert_text_font_family' => array('default')
						)
					),
					array(
						'name' => 'alert_text_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'alert_text_font_family' => array('default')
						)
					),
					array(
						'name' => 'alert_text_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'alert_text_font_family' => array('default')
						)
					)
				)
			), // alert_text font
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			),
			array(
				'type' => 'heading',
				'label' => __('Nav menu','frontend-builder')
			),
			array(
				'type' => 'collapsible',
				'label' => __('Main font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'menu_main_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'menu_main_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('menu_main_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'menu_main_font_family' => array('default')
						)
					),
					array(
						'name' => 'menu_main_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'menu_main_font_family' => array('default')
						)
					),
					array(
						'name' => 'menu_main_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'menu_main_font_family' => array('default')
						)
					)
				)
			), // menu_main font
			array(
				'type' => 'collapsible',
				'label' => __('Submenu font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'menu_submenu_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'menu_submenu_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('menu_submenu_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'menu_submenu_font_family' => array('default')
						)
					),
					array(
						'name' => 'menu_submenu_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'menu_submenu_font_family' => array('default')
						)
					),
					array(
						'name' => 'menu_submenu_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'menu_submenu_font_family' => array('default')
						)
					)
				)
			), // menu_submenu font
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			),
			array(
				'type' => 'heading',
				'label' => __('Features','frontend-builder')
			),
			array(
				'type' => 'collapsible',
				'label' => __('Title font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'features_title_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'features_title_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('features_title_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'features_title_font_family' => array('default')
						)
					),
					array(
						'name' => 'features_title_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'features_title_font_family' => array('default')
						)
					),
					array(
						'name' => 'features_title_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'features_title_font_family' => array('default')
						)
					)
				)
			), // features_title font
			array(
				'type' => 'collapsible',
				'label' => __('Content font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'features_content_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'features_content_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('features_content_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'features_content_font_family' => array('default')
						)
					),
					array(
						'name' => 'features_content_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'features_content_font_family' => array('default')
						)
					),
					array(
						'name' => 'features_content_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'features_content_font_family' => array('default')
						)
					)
				)
			), // features_content font
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			),
			array(
				'type' => 'heading',
				'label' => __('Searchbox','frontend-builder')
			),
			array(
				'type' => 'collapsible',
				'label' => __('Text font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'searchbox_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'searchbox_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('searchbox_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'searchbox_font_family' => array('default')
						)
					),
					array(
						'name' => 'searchbox_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'searchbox_font_family' => array('default')
						)
					),
					array(
						'name' => 'searchbox_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'searchbox_font_family' => array('default')
						)
					)
				)
			), // searchbox font
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			),
			array(
				'type' => 'heading',
				'label' => __('Image','frontend-builder')
			),
			array(
				'type' => 'collapsible',
				'label' => __('Description font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'image_desc_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'image_desc_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('image_desc_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'image_desc_font_family' => array('default')
						)
					),
					array(
						'name' => 'image_desc_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'image_desc_font_family' => array('default')
						)
					),
					array(
						'name' => 'image_desc_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'image_desc_font_family' => array('default')
						)
					)
				)
			), // image_desc font
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			),
			array(
				'type' => 'heading',
				'label' => __('Pricing table','frontend-builder')
			),
			array(
				'type' => 'collapsible',
				'label' => __('Title font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'pricing_table_title_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'pricing_table_title_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('pricing_table_title_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'pricing_table_title_font_family' => array('default')
						)
					),
					array(
						'name' => 'pricing_table_title_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'pricing_table_title_font_family' => array('default')
						)
					),
					array(
						'name' => 'pricing_table_title_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'pricing_table_title_font_family' => array('default')
						)
					)
				)
			), // pricing_table_title font
			array(
				'type' => 'collapsible',
				'label' => __('Price font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'pricing_table_price_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'pricing_table_price_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('pricing_table_price_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'pricing_table_price_font_family' => array('default')
						)
					),
					array(
						'name' => 'pricing_table_price_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'pricing_table_price_font_family' => array('default')
						)
					),
					array(
						'name' => 'pricing_table_price_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'pricing_table_price_font_family' => array('default')
						)
					)
				)
			), // pricing_table_price font
			array(
				'type' => 'collapsible',
				'label' => __('Button font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'pricing_table_button_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'pricing_table_button_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('pricing_table_button_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'pricing_table_button_font_family' => array('default')
						)
					),
					array(
						'name' => 'pricing_table_button_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 60,
						'unit' => 'px',
						'hide_if' => array(
							'pricing_table_button_font_family' => array('default')
						)
					),
					array(
						'name' => 'pricing_table_button_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 60,
						'unit' => 'px',
						'hide_if' => array(
							'pricing_table_button_font_family' => array('default')
						)
					)
				)
			), // pricing_table_button font
			array(
				'type' => 'collapsible',
				'label' => __('Text font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'pricing_table_text_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'pricing_table_text_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('pricing_table_text_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'pricing_table_text_font_family' => array('default')
						)
					),
					array(
						'name' => 'pricing_table_text_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'pricing_table_text_font_family' => array('default')
						)
					),
					array(
						'name' => 'pricing_table_text_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'pricing_table_text_font_family' => array('default')
						)
					)
				)
			), // pricing_table_button font
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			),
			array(
				'type' => 'heading',
				'label' => __('Featured post','frontend-builder')
			),
			array(
				'type' => 'collapsible',
				'label' => __('Title font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'featured_post_title_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'featured_post_title_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('featured_post_title_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'featured_post_title_font_family' => array('default')
						)
					),
					array(
						'name' => 'featured_post_title_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'featured_post_title_font_family' => array('default')
						)
					),
					array(
						'name' => 'featured_post_title_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'featured_post_title_font_family' => array('default')
						)
					)
				)
			), // featured_post_title font
			array(
				'type' => 'collapsible',
				'label' => __('Content font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'featured_post_meta_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'featured_post_meta_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('featured_post_meta_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'featured_post_meta_font_family' => array('default')
						)
					),
					array(
						'name' => 'featured_post_meta_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'featured_post_meta_font_family' => array('default')
						)
					),
					array(
						'name' => 'featured_post_meta_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'featured_post_meta_font_family' => array('default')
						)
					)
				)
			), // featured_post_meta font
			array(
				'type' => 'collapsible',
				'label' => __('Meta links font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'featured_post_excerpt_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'featured_post_excerpt_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('featured_post_excerpt_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'featured_post_excerpt_font_family' => array('default')
						)
					),
					array(
						'name' => 'featured_post_excerpt_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'featured_post_excerpt_font_family' => array('default')
						)
					),
					array(
						'name' => 'featured_post_excerpt_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'featured_post_excerpt_font_family' => array('default')
						)
					)
				)
			), // featured_post_excerpt font
			array(
				'type' => 'collapsible',
				'label' => __('Button font','frontend-builder'),
				'options' => array(
					array(
						'name' => 'featured_post_button_font_family',
						'class' => 'fbuilder_font_select',
						'type' => 'select', 'search' => 'true',
						'std' => 'default',
						'label' => __('Font family','frontend-builder'),
						'options' => $fbuilder_google_font_names
					),
					array(
						'name' => 'featured_post_button_font_style',
						'type' => 'select',
						'std' => 'default',
						'label' => __('Font style','frontend-builder'),
						'options' => $this->get_font_variants('featured_post_button_font_family',$fbuilder_google_font_variants),
						'hide_if' => array(
							'featured_post_button_font_family' => array('default')
						)
					),
					array(
						'name' => 'featured_post_button_font_size',
						'type' => 'number',
						'label' => __('Font size','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'featured_post_button_font_family' => array('default')
						)
					),
					array(
						'name' => 'featured_post_button_line_height',
						'type' => 'number',
						'label' => __('Line height','frontend-builder'),
						'std' => 16,
						'unit' => 'px',
						'hide_if' => array(
							'featured_post_button_font_family' => array('default')
						)
					)
				)
			), // featured_post_button font
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			)
		)
	),
	'color' => array(
		'label' => __('Color options','frontend-builder'),
		'desc' => __('Default colors used when the shortcode is dropped on the page. Specific colors can be set for each shortcode while it is being modified.','frontend-builder'),
		'options' => array(
			array(
				'type' => 'margin',
				'height' => '40px'
			),
			array(
				'type' => 'color',
				'name' => 'main_color',
				'label' => __('Main color','frontend-builder'),
				'std' => '#27a8e1'
			),
			array(
				'type' => 'color',
				'name' => 'light_main_color',
				'label' => __('Lighter main color','frontend-builder'),
				'desc' => __('Color used when main color is hovered etc.','frontend-builder'),
				'std' => '#57bce8'
			),
			array(
				'type' => 'color',
				'name' => 'dark_back_color',
				'label' => __('Dark background color','frontend-builder'),
				'std' => '#376a6e'
			),
			array(
				'type' => 'color',
				'name' => 'light_back_color',
				'label' => __('Light background color','frontend-builder'),
				'std' => '#f4f4f4'
			),
			array(
				'type' => 'color',
				'name' => 'dark_border_color',
				'label' => __('Dark border color','frontend-builder'),
				'std' => '#376a6e'
			),
			array(
				'type' => 'color',
				'name' => 'light_border_color',
				'label' => __('Light border color','frontend-builder'),
				'std' => '#ebecee'
			),
			array(
				'type' => 'color',
				'name' => 'title_color',
				'label' => __('Title color','frontend-builder'),
				'std' => '#232323'
			),
			array(
				'type' => 'color',
				'name' => 'text_color',
				'label' => __('Text color','frontend-builder'),
				'std' => '#808080'
			),
			array(
				'type' => 'color',
				'name' => 'main_back_text_color',
				'label' => __('Text color over main color','frontend-builder'),
				'desc' => __('Used in places where main color is the background color','frontend-builder'),
				'std' => '#ffffff'
			),
			array(
				'type' => 'color',
				'name' => 'row_back_color',
				'label' => __('Row background color','frontend-builder'),
				'std' => ''
			),
			array(
				'type' => 'color',
				'name' => 'column_back_color',
				'label' => __('Column background color','frontend-builder'),
				'std' => ''
			),
			array(
				'type' => 'number',
				'name' => 'column_back_opacity',
				'label' => __('Column background opacity','frontend-builder'),
				'std' => 100,
				'unit' => '%'
			),
			array(
				'type' => 'button',
				'style' => 'primary',
				'class' => 'fbuilder_save',
				'label' => __('Save options','frontend-builder')
			)
		)
	)
);

$output = $fbuilder_admin_options;
?>