<?php   
/*
Plugin Name: Frontend Builder
Plugin URI: http://www.shindiristudio.com/fbuilder/wp-admin/admin-ajax.php?action=fbuilder_edit&p=2
Description: Design your web page with a simple drag and drop system. Customize the elements with intuitive sidebar options. A modern, must-have solution for your website!
Author: br0
Version: 1.53
Author URI: http://www.shindiristudio.com/
*/
global $fbuilder;
if (!class_exists("FrontendBuilder")) {
	require_once dirname( __FILE__ ) . '/frontend_builder_class.php';	
	$fbuilder = new FrontendBuilder(__FILE__);
}

?>