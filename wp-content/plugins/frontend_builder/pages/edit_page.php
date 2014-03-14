<!DOCTYPE HTML>
<html>
<head>
<title>Frontend builder edit page</title>


<?php
$id = (isset($_GET['p']) ? (int)$_GET['p'] : 0);
if(isset($_GET['p']) && isset($_GET['sw']) && $_GET['sw'] == 'on') {
	$this->ajax_switch(true);
}
$this->refresh_shortcode_list();
$builder = $this->database($id, true);
echo
'<script type="text/javascript">
//<![CDATA[
	var ajaxurl = "'. admin_url('admin-ajax.php').'";
	var post_id = '.$id.';
	var fbuilder_sw = "'.$builder->switch.'";
	var fbuilder_items = '.str_replace(array('<','>'), array('\\<','\\>'),stripcslashes($builder->items)).';
	var fbuilder_user = '.(current_user_can('edit_post', $id) ? 'true' : 'false').';
	var fbuilder_main_menu = '.json_encode($this->menu_controls).';
	var fbuilder_row_controls = '.json_encode($this->row_controls).';
	var fbuilder_shortcodes = '.json_encode($this->shortcodes).';
	var fbuilder_hideifs = '.json_encode($this->hideifs).';
	var fbuilder_rows = '.json_encode($this->rows).';
	var fbuilder_icons = '.$this->icons.';
	var fbuilder_url = "'.$this->url.'";
	var fbuilder_showall = "'.$this->showall.'";
	var pagenow = 0;
	var postion = {
		top: 0,
		left:0
	};
//]]>
</script>';

global $title, $hook_suffix, $current_screen, $wp_locale, $pagenow, $wp_version,
	$current_site, $update_title, $total_update_count, $parent_file;

	
do_action('admin_enqueue_styles');
do_action('admin_print_styles');
do_action('admin_enqueue_scripts');
do_action('admin_print_scripts');
do_action('admin_head');
do_action('fbuilder_head');
 ?>
</head>
<body style="margin: 0;">
<div id="fbuilder_editor_popup_shadow"></div>
<div id="fbuilder_editor_popup">
<div class="fbuilder_module_controls fbuilder_gradient"><span class="fbuilder_module_name"><?php _e('Text editor', 'frontend-builder'); ?></span> <a href="#" class="fbuilder_close" title="close"></a></div>
<div id="fbuilder_editor_popup_inner"><div id="postdivrich">
<?php
wp_editor( 'content', 'fbuilder_editor', array('textarea_rows' => 10) );
?>

</div>
</div>
<div class="fbuilder_editor_popup_buttons">
<a href="#" class="fbuilder_gradient fbuilder_button fbuilder_popup_close left">Close</a><a href="#" class="fbuilder_gradient_primary fbuilder_button fbuilder_popup_edit_submit right">Submit</a>
<div style="clear: both;"></div>
</div>
<div style="clear: both;"></div></div>
<div id="fbuilder_body" <?php if($this->showall && !current_user_can('edit_post', $id)) echo 'style="border-left-width:0;"'; ?>>
	<div id="fbuilder_body_inner">
		<div id="fbuilder_frame_cover"></div>
		<iframe id="fbuilder_body_frame" src="<?php echo get_permalink($id); ?>"></iframe>
	</div>
</div>
<?php do_action( 'in_admin_footer' ); ?>
<?php
do_action('admin_footer', '');
do_action('admin_print_footer_scripts');
do_action("admin_footer-" . $GLOBALS['hook_suffix']);

// get_site_option() won't exist when auto upgrading from <= 2.7
if ( function_exists('get_site_option') ) {
	if ( false === get_site_option('can_compress_scripts') )
		compression_test();
}

?>
</body>
</html>
