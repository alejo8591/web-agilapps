<?php
/**
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

global $portal_data;

if ( !is_page_template('blog-template.php') || !is_page_template('portfolio-template.php') ) :
	echo '</div>' . portal_pagination();
endif;

?>
	<div class="clearfix"></div>
	</div>
	
	<div class="clearfix"></div>
			
	<div class="footer_outer_wrapper">
			<div class="footer_wrapper bg_color_default">
					<?php if ( $portal_data['footer_widgets'] !== '1' ) : ?>
					<div class="row">
						<?php
							$footer_sidebar = $portal_data['footer_sidebar'];
							$lines = '<div class="col-md-12 footer_lines"><div class="row">';
							switch ( $footer_sidebar ) :
								case '1' :
								$column_class = 'col-md-12';
								break;
								case '2' :
								$column_class = 'col-md-6';
								break;
								case '3' :
								$column_class = 'col-md-4';
								break;
								case '4' :
								$column_class = 'col-md-3';
								break;
							endswitch;
							for ($i = 1; $i <= $footer_sidebar; $i++) {
								printf( '<div class="%1$s"><div class="footer_item">', $column_class );
								dynamic_sidebar('footer-' . $i);
								printf( '</div></div>');
								
								$lines .= sprintf('<div class="%1$s"><div class="line margin-top20 margin-bottom10"></div></div>', $column_class );
							}
							$lines .= '</div></div>';
						?>
					</div><!-- row -->
					<div class="row">
						<?php echo $lines; ?>
						<div class="clearix"></div>
					</div>
					<?php endif; ?>
				

			</div><!-- footer_wrapper -->
			<div class="clearfix"></div>
			<div class="subfooter bg_color_main">
				<div class="float_left"><?php echo $portal_data['copyright']; ?></div>
				<div class="float_right socials">
				<?php
					if ( $portal_data['footer-facebook'] !== '' ) printf('<a href="%1$s"><i class="fa fa-facebook"></i></a>', $portal_data['footer-facebook']);
					if ( $portal_data['footer-twitter'] !== '' ) printf('<a href="%1$s"><i class="fa fa-twitter"></i></a>', $portal_data['footer-twitter']);
					if ( $portal_data['footer-linkedin'] !== '' ) printf('<a href="%1$s"><i class="fa fa-linkedin"></i></a>', $portal_data['footer-linkedin']);
					if ( $portal_data['footer-google'] !== '' ) printf('<a href="%1$s"><i class="fa fa-google-plus"></i></a>', $portal_data['footer-google']);
					if ( $portal_data['footer-pin'] !== '' ) printf('<a href="%1$s"><i class="fa fa-pinterest-square"></i></a>', $portal_data['footer-pin']);
					if ( $portal_data['footer-youtube'] !== '' ) printf('<a href="%1$s"><i class="fa fa-youtube"></i></a>', $portal_data['footer-youtube']);
				?>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div><!-- subfooter -->
		</div><!-- footer_outer_wrapper -->
	</div>
<?php wp_footer(); ?>
</body>
</html>