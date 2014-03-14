<?php
/*
 * Template Name: Portal Team Small
 * Description: A full screen page template used for team showcase, but a small version
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

global $portal_data;

get_header();
if ( have_posts() ) :
	the_post(); ?>
<div class="ots_small_wrapper">
	<div class="centering_system">
	<div><div>
		<div class="ots_small_slider">
			<div class="ots_small_inner_wrap">
			<?php
				if ( is_array( $portal_data['contact'] ) ) :
					$contacts = $portal_data['contact'];
					foreach ( $contacts as $contact ) :
						$contact_name = $contact['name'];
						$contact_description = $contact['description'];
						$contact_url = $contact['url'];
						$contact_job = $contact['job'];
						$contact_networks = $contact['contact'];
					?>
						<div class="ots_small_item">
							<div class="ots_small_name"><?php echo $contact_name; ?><span><?php echo $contact_job; ?></span></div>
							<div class="ots_small_img"><img src="<?php echo $contact_url; ?>" alt="" /></div>
							<div class="ots_small_text margin-bottom10"><?php echo $contact_description; ?></div>
							<?php
								foreach ( $contact_networks as $contact_network ) :
									$url = $contact_network['socialnetworksurl'];
									$icon = $contact_network['socialnetworks'];
									printf('<a href="%1$s" target="_blank" class="inline-block margin-right20"><img width="32" height="32" src="%3$s/images/socialnetworks/%2$s" /></a>', $url, $icon, get_template_directory_uri() );
								endforeach;
							?>
						</div><!-- ots_small_item -->
			<?php
					endforeach;
				endif;
			?>
			</div>
			</div><!-- ots_small_slider -->
	</div></div>
	</div>
	<div class="our_team_controls_wrap-small">
		<a href="#" class="ots_prev-small"></a>
		<a href="#" class="ots_next-small"></a>
	</div><!-- our_team_controls_wrap -->
</div><!-- ots_small_wrapper -->

<?php

else :
	_e('No posts','portal');
endif;
get_footer();

?>