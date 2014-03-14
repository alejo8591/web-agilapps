<?php
/**
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('swiper-slide'); ?>>
	<div class="sliced_single_item">
		<a href="<?php the_permalink(); ?>" class="sliced_preview_image_wrap">
		<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail('full', array('class' => 'sliced_preview_image'));
			}
		?>
		</a><!-- sliced_preview_image_wrap -->
		<div class="sliced_preview_content">
			<h3 class="margin-bottom10"><?php the_title(); ?></h3>
			<div class="pop_ups">
				<span>
				<?php
					$excerpt = get_the_excerpt();
					echo portal_string_limit_words( $excerpt, 156 );
				?>
				</span>
				<a href="<?php the_permalink(); ?>" class="color_main block margin-top10"><?php _e('View project &rarr;', 'anivia'); ?></a>
			</div>
		</div><!-- sliced_preview_content -->
	</div>
</div><!-- swiper-slide -->