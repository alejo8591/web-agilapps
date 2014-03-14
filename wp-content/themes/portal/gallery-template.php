<?php
/*
 * Template Name: Portal Gallery
 * Description: A full screen page template used for your galleries. Just attach images to the page.
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

global $portal_data;

get_header();

if ( have_posts() ) : the_post();

	$feat_area = get_post_meta( get_the_ID(), 'portal_post_type', true );

?>

<div class="portal_gallery_wrapper">
<div class="pog_inner_wrapper">
	<div class="portal_gallery_background">
	<?php
		switch($feat_area) :
		case 'image' :
		if ( has_post_thumbnail() ) {
			the_post_thumbnail('full', array('class' => 'pog_parallax_obj'));
		}
		break;
		case 'video' :
		$feat_area = get_post_meta( get_the_ID(), 'portal_video_override', true );
		$feat_area_ogg = get_post_meta( get_the_ID(), 'portal_video_override_ogg', true );
		if ( has_post_thumbnail() ) {
			the_post_thumbnail('full');
		}
	?>
		<video id="video" class="pog_parallax_obj" preload="auto" autoplay loop="loop">
			<source src="<?php echo $feat_area; ?>" type="video/mp4" />
			<source src="<?php echo $feat_area_ogg; ?>" type="video/ogg" />
			<?php _e('Your browser does not support the video tag.', 'portal'); ?>
		</video>
	<?php
		break;
		case '' || 'none' :
		break;
		endswitch;

	?>
	</div>
	<div class="pog_overlay_content">
		<?php the_content(); ?>
	</div>
	<div class="portal_gallery_tube">
		<div class="portal_gallery_init">
		<?php
			$args = array(
				'post_type' => 'attachment',
				'numberposts' => -1,
				'post_status' => 'any',
				'post_parent' => $post->ID,
				'exclude' => get_post_thumbnail_id()
				);

			$attachments = get_posts( $args );

			if ( $attachments ) {
				foreach ( $attachments as $attachment ) {
					$current_image = wp_get_attachment_image_src( $attachment->ID, 'large' );
					$current_title = apply_filters( 'the_title', $attachment->post_title );
					printf('<div class="pog_image_wrapper"><img src="%1$s" alt="%2$s" /><h4 class="pog_text_overlay color_white"><span>%2$s</span></h4><div class="integrated_gallery"><a href="%1$s" data-lightbox="porta_gallery">%2$s</a></div></div>', $current_image[0], $current_title);
					//echo apply_filters( 'the_title', $attachment->post_title );
					//the_attachment_link( $attachment->ID, true );
				}
			}
		?>
		</div><!-- portal_gallery_init -->
		<div class="clearfix"></div>
		</div><!-- portal_gallery_tube -->
</div>
	</div><!-- portal_gallery_wrapper -->

<?php

endif;

get_footer();

?>