<?php
/**
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */
?>
<div class="portal_search newsletter_sign_up newsletter_widget">
	<form action="<?php echo home_url( '/' ); ?>" method="post">
		<input type="submit" name="submit" class="submit_button bg_color_main bg_color_lighter_main_hover" value="" />
		<div class="input_wrapper">
			<input type="text" name="s" class="input_field" placeholder="<?php _e('Search', 'portal'); ?>" />
		</div>
		<div class="clearfix"></div>
	</form>
</div>