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
	$sidebar = get_post_meta( get_the_ID(), 'portal_post_sidebar', true );
	$add_class = ( ( $sidebar == 'none' || $sidebar == '' ) ? 'col-md-12' : 'col-md-8' );
	$sidebar_class = ( ( $sidebar == 'none' || $sidebar == '' ) ? '' : ' class="padding-right40 border_separated_content_inner border_color_default"' );
?>
<div class="row">
	<div class="<?php echo $add_class; ?>">
		<div<?php echo $sidebar_class; ?>>
			<?php if ( '1' !== get_post_meta( get_the_ID(), 'portal_show_title', true ) ) : ?>
			<h2 class="single_title"><?php the_title(); ?></h2>
			<?php endif; ?>
			<?php if ( '1' !== get_post_meta( get_the_ID(), 'portal_show_meta', true ) ) : ?>
			<div class="headline_group margin-bottom30">
				<span class="separator bg_color_default margin-bottom15"></span>
				<span class="color_default block margin-right15"><?php _e('Date', 'portal'); ?>: <?php echo get_the_date();?> - <?php echo get_the_time(); ?></span>
				<?php the_tags('<span class="color_default block margin-right15">'.__('Tags', 'portal').': ', ', ', '</span>'); ?>
				<span class="color_default block margin-right15"><?php _e('Author', 'portal'); ?>: <?php the_author(); ?></span>
			</div>
			<?php endif; ?>
			<?php if ( comments_open() ) : ?>
			<a href="#comments" class="comments_bubble bg_color_default color_white color_white_hover">
				<?php echo get_comments_number(); ?>
				<span class="arrow border_color_default"></span>
			</a><!-- comments_bubble -->
			<?php endif; ?>
			<div class="clearfix"></div>
<?php
	the_content();
?>
			<div class="clearfix"></div>
			<?php posts_nav_link(); ?>
			<?php wp_link_pages(array(
					'before'			=> '<div class="single-pag margin-bottom40"><span>' . __('View more', 'portal') . ': </span>',
					'after'				=> '</div>',
					'next_or_number'	=> 'next',
					'nextpagelink'		=> __('Next page &gt;', 'portal'),
					'previouspagelink'	=> __('&lt; Previous page', 'portal'),
					'pagelink'			=> '%',
					'echo'				=> 1
				) );
			?>

			<?php
				$posttags = get_the_tags();
				if ($posttags) {
			?>
			<?php if ( '1' !== get_post_meta( get_the_ID(), 'portal_show_title', true ) ) : ?>
			<div class="blog_post_tags">
				<span class="text"><?php _e('Tags', 'portal'); ?>:</span>
				<ul class="list_null fullwidth">
				<?php
					foreach($posttags as $tag) {
						printf( '<li class="float_left"><a href="%2$s" class="tag bg_color_default bg_color_main_hover color_white portal_button">%1$s</a></li>', $tag->name, get_tag_link($tag->term_id) );
					}
				?>
				</ul>
			<div class="clearfix"></div>
			</div><!-- blog_post_tags -->
			<?php endif; ?>
			<div class="clearfix margin-bottom30"></div>
					<?php
				}
			?>

<?php
	comments_template();
	printf( '<div class="clearfix"></div>' );
?>
		</div>
	</div>
	<?php
		if ( $sidebar !== 'none' || $sidebar !== '' ) get_sidebar();
	?>
</div>

<?php
else:
printf('No posts');
endif;
get_footer();
?>