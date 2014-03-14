<?php
/**
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

global $portal_data;

get_header();
if ( have_posts() ) :
	the_post();
	the_content();
	if ( $portal_data['enable_comments'] == 1 ) : comments_template(); endif;
else :
	_e('No posts','anivia');
endif;
get_footer();

?>