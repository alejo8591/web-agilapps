<?php 
/**
 * SMOF Modified / anivia
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @theme anivia
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

function of_head() { do_action( 'of_head' ); }

/**
 * Add default options upon activation else DB does not exist
 *
 * @since 1.0.0
 */
function of_option_setup()	
{
	global $of_options,$options_machine;

	$options_machine = new Options_Machine($of_options);

	if (!get_option(OPTIONS))
	{
		update_option(OPTIONS, $options_machine->Defaults);
	}

}

/**
 * Change activation message
 *
 * @since 1.0.0
 */
function optionsframework_admin_message() { 
	
	//Tweaked the message on theme activate
	?>
	<script type="text/javascript">
	jQuery(function(){

		var message = "<p><strong><?php _e('Welcome to PortalWP Theme', 'portal'); ?></strong></p><p><?php _e('Please install required plugins for this theme!', 'portal'); ?> <a href='<?php echo admin_url('themes.php?page=install-required-plugins'); ?>'><?php _e('CLICK HERE', 'portal'); ?></a></p>";
		jQuery('.themes-php #message2').html(message);

	});
	</script>
<?php
	
}

/**
 * Get header classes
 *
 * @since 1.0.0
 */
function of_get_header_classes_array() 
{
	global $of_options;
	
	foreach ($of_options as $value) 
	{
		if ($value['type'] == 'heading')
			$hooks[] = str_replace(' ','',strtolower($value['name']));	
	}
	
	return $hooks;
}


/**
 * For use in themes
 *
 * @since forever
 */
$portal_data = get_option(OPTIONS);
?>