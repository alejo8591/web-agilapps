<?php
/*
 * Template Name: Portal Portfolio
 * Description: A full screen page template used for portfolio showcase
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

?>
<div class="sliced_preview_container">
	<div class="focused_swipe_slider bg_color_default">
		<div class="portal-swiper-container bg_color_default">
			<div class="swiper-scrollbar"></div>
			<div class="swiper-wrapper">

<?php
	while( $portal_posts->have_posts() ): $portal_posts->the_post();
		get_template_part( 'content', 'portfolio' );
	endwhile;
?>

			</div><!-- swiper-wrapper --> 
		</div><!-- swiper-container -->	
	</div><!-- focused_swipe_slider -->	
</div><!-- sliced_preview_container -->
<?php

endif;

if ( portal_pagination($portal_posts->max_num_pages, $paged, 2) ) { echo '</div>' . portal_pagination($portal_posts->max_num_pages, $paged, 2); }

get_footer();

?>