<?php
$optsDB = $this->option();
$optsDBaso = Array();
$opts = $this->admin_controls;
if(isset($_GET['section']) && $_GET['section'])
	$section = $_GET['section'];
else 
	$section = 'general';

$controls = $opts[$section]['options'];

$hideifs = $this->get_admin_hideifs($controls);
echo '
<script type="text/javascript">
	var hideIfs = '.json_encode($hideifs).';
	var fontsObj = '.$this->get_google_fonts(true).';
</script>';

echo '<div id="fbuilder_admin_menu" class="wrap fbuilder_controls_wrapper">';

echo '<ul class="fbuilder_admin_menu_tabs">';
foreach ($opts as $key => $val) {
	echo '<li><a href="'.esc_url( home_url( '/' ) ).'wp-admin/admin.php?page=frontendbuilder&section='.$key.'" '.(($section == $key) ? 'class="active fbuilder_gradient_primary"' : 'class="fbuilder_gradient"').'><span>'.$val['label'].'</span></a></li>';
}

echo '</ul><div style="clear:both;"></div>';
echo '<h2 class="fbuilder_admin_menu_main_title" style="text-align:left; margin:10px 0;">'.$opts[$section]['label'].'</h2>';
if (array_key_exists('desc', $opts[$section])) echo '<span class="fbuilder_admin_menu_main_description">'.$opts[$section]['desc'].'</span>';
if(is_array($controls)) {
	
	foreach($optsDB as $id => $oo) {
		$optsDBaso[$oo->name] = $oo->value;
	}
	foreach($controls as $control) {
		if($control['type'] == 'collapsible') {
			if(array_key_exists('options', $control))
				foreach($control['options'] as $ok => $ov) {
					if(array_key_exists('name', $control['options'][$ok]) && array_key_exists($control['options'][$ok]['name'], $optsDBaso)) {
						$control['options'][$ok]['std'] = $optsDBaso[$control['options'][$ok]['name']];
					}
				}
			if(array_key_exists('name', $control) && array_key_exists($control['name'], $optsDBaso)) {
				$control['std'] = $optsDBaso[$control['name']];
			}
		}
		else {
			if(array_key_exists('name', $control) && array_key_exists($control['name'], $optsDBaso)) {
				$control['std'] = $optsDBaso[$control['name']];
			}
		}
		echo $this->get_admin_control($control);
	}
}

echo '</div>';

?>