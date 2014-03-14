<?php
/**
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */
 

?>
<div id="post-<?php get_the_ID(); ?>" <?php post_class('info_wall_item color_default'); ?>>
	<div class="text_wrap">
		<a href="<?php the_permalink(); ?>" class="color_default header_link"><h3 class="block margin-bottom30"><?php the_title(); ?></h3></a>
		<span class="block"><?php _e('Date', 'portal'); ?>: <a href="<?php the_permalink(); ?>" class="color_main"><?php echo get_the_date();?> - <?php echo get_the_time(); ?></a></span>
		<span class="block margin-bottom10"><?php _e('Author', 'portal'); ?>: <a href="<?php the_permalink(); ?>" class="color_main"><?php the_author(); ?></a></span>
		<span class="text">
		<?php
			$excerpt = get_the_excerpt();
			echo portal_string_limit_words( $excerpt, 156 );
		?>
		</span>
	</div><!-- text_wrap -->
	<?php
		printf('<a href="%1$s" rel="bookmark" class="img_wrap">', get_permalink());
		if ( has_post_thumbnail() ) {
			the_post_thumbnail('large');
		}
		echo '</a>';
	?>
	<div class="clearfix"></div>
</div><!-- info_wall_item -->