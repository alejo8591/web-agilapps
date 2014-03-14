<?php
/*
 * Template Name: Portal Blog
 * Description: A full screen page template used for team showcase
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

global $portal_data;

get_header();

if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } else { $paged = 1; }

$query_string = array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'cat' => get_post_meta( get_the_ID(), 'portal_selected_category', true ),
	'paged' => $paged
	);

$portal_posts = new WP_Query( $query_string );

if ( $portal_posts->have_posts() ) :
	while( $portal_posts->have_posts() ): $portal_posts->the_post();
		get_template_part( 'content', 'archive' );
	endwhile;

endif;


if ( portal_pagination($portal_posts->max_num_pages, $paged, 2) ) { echo '</div>' . portal_pagination($portal_posts->max_num_pages, $paged, 2); }

get_footer();

?>