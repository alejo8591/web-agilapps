<?php
/*
 * Template Name: Portal Team
 * Description: A full screen page template used for team showcase
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

global $portal_data;

get_header();
if ( have_posts() ) :
	the_post(); ?>

<div class="our_team_slider_wrapper">
	<div class="our_team_slide_container">
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
				<div class="our_team_slide ots_current">
					<img src="<?php echo $contact_url; ?>" alt="" class="member_img_big" />
					<div class="ots_slide_content">
						<h3><?php echo $contact_name; ?></h3>
						<div class="ots_rank margin-bottom10"><?php echo $contact_job; ?></div>
						<div class="margin-bottom15"><?php echo $contact_description; ?></div>
						<?php
							foreach ( $contact_networks as $contact_network ) :
								$url = $contact_network['socialnetworksurl'];
								$icon = $contact_network['socialnetworks'];
								printf('<a href="%1$s" target="_blank" class="inline-block margin-right20"><img width="32" height="32" src="%3$s/images/socialnetworks/%2$s" /></a>', $url, $icon, get_template_directory_uri() );
							endforeach;
						?>
					</div><!-- our_team_slide -->
				</div><!-- our_team_slide -->

	<?php
			endforeach;
		endif;
	?>
	</div>
	<div class="our_team_controls_wrap">
		<a href="#" class="ots_prev disabled"></a>
		<a href="#" class="ots_next"></a>
	</div><!-- our_team_controls_wrap -->
</div>

<?php

else :
	_e('No posts','portal');
endif;
get_footer();

?>