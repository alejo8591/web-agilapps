<?php
/**
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */
?>
<!DOCTYPE HTML>
<?php global $portal_data; ?>
<html <?php language_attributes(); ?>>
<head>
<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<?php if ( $portal_data['responsive'] == 1 ) :	?>
<meta name="viewport" content="width=device-width, user-scalable=1.0,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">
<?php else : ?>
<meta name="viewport" content="width=1024, initial-scale=1.0, maximum-scale=3, user-scalable=1, target-densitydpi=device-dpi">
<?php endif; ?>
<?php
	if( $portal_data['tracking-code'] != '' ) :
		echo $portal_data['tracking-code'];
	endif;
	wp_head();
?>
</head>
<?php
	$bodyclass = '';
	if ( is_single() ) :
		$feat_area = get_post_meta( get_the_ID(), 'portal_post_type', true );
		switch ( $feat_area ) :
		case 'image' :
		$bodyclass = '';
		break;
		case 'paralax' :
		$bodyclass = 'blog_header_overlay_parallax';
		break;
		case 'gallery' :
		$bodyclass = 'aside_image';
		break;
		case 'video' :
		$bodyclass = '';
		break;
		case 'videolax' :
		$bodyclass = 'blog_header_overlay_parallax';
		break;
		endswitch;
		if ( '1' == get_post_meta( get_the_ID(), 'portal_fullscreen', true ) ) { $bodyclass .= ' portal_fullscreen'; }
	endif;
?>
<body <?php body_class($bodyclass); ?> >
	<?php if ( $portal_data['service_mode'] == '1' ) { get_template_part('settings/settings'); } ?>
	<div class="page_preload_placeholder"></div>

	<div id="wrapper">

	<div class="header_wrapper bg_color_white">
		<div class="header_menu_wrapper relative">

			<?php if ( $portal_data['logo'] !== '' ) : ?>
				<a href="<?php echo home_url(); ?>" class="logo_wrapper block"><span><img class="logo block" src="<?php echo $portal_data['logo']; ?>" alt="" /></span></a><!-- logo -->
			<?php endif; ?>

			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'depth' => 4, 'fallback_cb' => 'portal_list_pages', 'container' => false, 'menu_class' => ( $portal_data['header_menu'] == 'portal_menu' ? 'header_menu' : 'header_menu_default' ), 'walker' =>  new Walker_Nav_Menu_Widgets() ) ); ?>

		</div><!-- header_menu_wrapper -->
		<div class="header_subline_wrapper bg_color_default relative">
			<?php if ( is_single() ) : ?>
			<div class="chapters_wrapper color_white float_left">
				<span class="chapters_pop_up block"></span>
				<div class="chapters_headline_wrapper float_left">
					<a href="#" class="chapters_trigger color_white bg_color_main_hover float_right"><i class="fa fa-reorder"></i></a>
					<span class="chapters_headline block float_right"><?php _e('CHAPTERS', 'portal'); ?></span>
					<div class="clearfix"></div>
				</div><!-- chapters_headline_wrapper -->
				<ul class="list_null chapters_sub bg_color_default"></ul>
			</div><!-- chapters_wrapper -->
			<?php
				endif;
				portal_breadcrumbs();
			?>
			<form action="<?php echo home_url( '/' ); ?>" method="get" class="header_search_form">
				<input name="s" type="text" value="" class="header_search_box"/>
				<i class="fa fa-search"></i>
				<input type="submit" value="" class="search_submit" />
				<div class="search_close">X</div>
			</form>
		</div><!-- header_subline_wrapper -->
		<div class="clear"></div>
	</div><!-- header_wrapper -->

	<div id="portal_content" class="content">
		<?php
			if ( is_single() ) :
			
			$meta_width = get_post_meta( get_the_ID(), 'portal_content_width', true );
			if ( '' !== $meta_width ) {
				$max_width = ' style="max-width:'.$meta_width.'px;margin:0 auto;"';
			}
			else {
				$max_width = '';
			}
		?>
		<?php
			switch ( $feat_area ) :
			case 'image' : ?>
				<div class="portal_parallax_image_wrapper margin-bottom30 maxfullwidth relative">
					<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail('full');
						}
					?>
				</div><!-- parallax_image_wrapper -->
		<?php
			break;
			case 'paralax' : ?>
				<div class="portal_parallax_image_wrapper margin-bottom30 maxfullwidth relative bg_color_white header_overlay_parallax large_parallax">
					<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail('full');
						}
					?>
					
					<div class="parallax_header_overlay fullwidth padding-left40 padding-right40">
						<div class="row">
							<div class="col-md-12">
								<div class="padding-right40">
									<h2 class="block color_default margin-bottom15 color_white"><?php the_title(); ?></h2>
									<span class="separator bg_color_white"></span>
								</div>
							</div>
						</div>
					</div>

				</div><!-- parallax_image_wrapper -->
				<div class="parallax_placeholder"></div>
				<div class="parallax_margin"></div>
		<?php
			break;
			case 'gallery' : ?>
				<div class="portal_aside_image_wrapper maxfullwidth relative">
				<ul class="list_null">
					<li>
					<?php
						$feat_area = get_post_meta( get_the_ID(), 'portal_video_override', true );
						if ( $feat_area == '' ) {
							if ( has_post_thumbnail() ) {
								the_post_thumbnail('full');
							}
						}
						else {
						$feat_area_ogg = get_post_meta( get_the_ID(), 'portal_video_override_ogg', true );
						$add_poster = ( has_post_thumbnail() ? wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) : '' );
					?>
						<video id="video" class="fullwidth block" preload="auto" autoplay loop="loop" poster="<?php echo $add_poster; ?>">
							<source src="<?php echo $feat_area; ?>" type="video/mp4" />
							<source src="<?php echo $feat_area_ogg; ?>" type="video/ogg" />
							<?php _e( 'Your browser does not support the video tag.', 'portal' ); ?>
						</video>
					<?php
						}
					?>
					</li>
				</ul>
			</div><!-- parallax_image_wrapper -->
		<?php
			break;
			case 'video' :
			$feat_area = get_post_meta( get_the_ID(), 'portal_video_override', true );
			$feat_area_ogg = get_post_meta( get_the_ID(), 'portal_video_override_ogg', true );
			$add_poster = ( has_post_thumbnail() ? wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) : '' );

		?>
			<div class="portal_parallax_image_wrapper margin-bottom30 maxfullwidth relative">
				<video id="video" class="fullwidth block" preload="auto" autoplay loop="loop" poster="<?php echo $add_poster; ?>" data-image-replacement="<?php echo $add_poster; ?>">
					<source src="<?php echo $feat_area; ?>" type="video/mp4" />
					<source src="<?php echo $feat_area_ogg; ?>" type="video/ogg" />
					<?php _e( 'Your browser does not support the video tag.', 'portal' ); ?>
				</video>
			</div><!-- parallax_image_wrapper -->
		<?php
			
			break;
			case 'videolax' :
			$feat_area = get_post_meta( get_the_ID(), 'portal_video_override', true );
			$feat_area_ogg = get_post_meta( get_the_ID(), 'portal_video_override_ogg', true );
			$add_poster = ( has_post_thumbnail() ? wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) : '' );

		?>
			<div class="portal_parallax_image_wrapper margin-bottom30 maxfullwidth relative bg_color_white header_overlay_parallax">
				<video id="video" class="fullwidth" preload="auto" autoplay loop="loop" poster="<?php echo $add_poster; ?>" data-image-replacement="<?php echo $add_poster; ?>">
					<source src="<?php echo $feat_area; ?>" type="video/mp4" />
					<source src="<?php echo $feat_area_ogg; ?>" type="video/ogg" />
					<?php _e( 'Your browser does not support the video tag.', 'portal' ); ?>
				</video>
				
				<div class="parallax_header_overlay fullwidth padding-left40 padding-right40">
					<div class="row">
						<div class="col-md-12">
							<div class="padding-right40">
								<h2 class="block color_default margin-bottom15 color_white"><?php the_title(); ?></h2>
								<span class="separator bg_color_white"></span>
							</div>
						</div>
					</div>
				</div>

			</div><!-- parallax_image_wrapper -->
			<div class="parallax_placeholder"></div>
			<div class="parallax_margin"></div>
		<?php
			break;
			endswitch;
		?>

		<div class="inner_content padding-top40 blog_post_content"<?php echo $max_width; ?>>
		<?php elseif ( is_archive() || is_blog() || is_search() || is_page_template('blog-template.php') ) : ?>
		<div class="info_wall_init_wrapper">
		<?php elseif ( is_page_template('portfolio-template.php') || is_page_template('team-template.php') || is_page_template('smallteam-template.php') || is_page_template('gallery-template.php') ) : ?>
		<div class="inner_content padding-top40">
		<?php elseif ( is_page() ) : ?>
		<?php
			if ( !(is_page_template()) || is_page_template('fullslider-template.php') )
				$rs_full = get_post_meta( get_the_ID(), 'portal_revolution', true );
			if ( !($rs_full == 'none' || $rs_full == '') ) {
				echo do_shortcode( sprintf( '[rev_slider %1$s]', $rs_full ) );
			}
			$meta_padding = get_post_meta( get_the_ID(), 'portal_page_padding', true );
			if ( $meta_padding == 0 || $meta_padding == '' ) {
				$padding = ' padding-top40';
			}
			else {
				$padding = '';
			}
			$meta_width = get_post_meta( get_the_ID(), 'portal_content_width', true );
			if ( '' !== $meta_width ) {
				$max_width = ' style="max-width:'.$meta_width.'px;margin:0 auto;"';
			}
			else {
				$max_width = '';
			}
		?>
		<div class="inner_content<?php echo $padding; ?>"<?php echo $max_width; ?>>
		<?php endif; ?>