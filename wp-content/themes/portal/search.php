<?php
/**
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

get_header();

if ( have_posts() ) :

	while ( have_posts() ) : the_post();
		get_template_part( 'content', 'archive' );
	endwhile;

endif;

get_footer();

?>