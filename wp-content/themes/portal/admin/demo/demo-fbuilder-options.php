<?php
	portal_fbuilder_options();

	function portal_fbuilder_options() {
		global $wpdb, $wp_rewrite;
		if (!get_option("blogname", false)) {
			return;
		}
	ob_start();
?>SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

DROP TABLE IF EXISTS `@@TABLE_PREFIX@@frontend_builder_options`;
CREATE TABLE `@@TABLE_PREFIX@@frontend_builder_options` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=146 ;

INSERT INTO `@@TABLE_PREFIX@@frontend_builder_options` (`id`, `name`, `value`) VALUES
(1, 'light_border_color', '#a0a0a0'),
(2, 'css_classes', 'true'),
(3, 'bottom_margin', '30'),
(4, 'high_rezolution_width', '1200'),
(5, 'high_rezolution_margin', '30'),
(6, 'med_rezolution_width', '768'),
(7, 'med_rezolution_margin', '20'),
(8, 'med_rezolution_hide_sidebar', 'false'),
(9, 'low_rezolution_width', '640'),
(10, 'low_rezolution_margin', '10'),
(11, 'low_rezolution_hide_sidebar', 'true'),
(12, 'mob_rezolution_hide_sidebar', 'true'),
(13, 'h1_font_family', 'default'),
(14, 'h1_font_style', 'default'),
(15, 'h1_font_size', '16 px'),
(16, 'h1_line_height', '16 px'),
(17, 'h2_font_family', 'default'),
(18, 'h2_font_style', 'default'),
(19, 'h2_font_size', '16 px'),
(20, 'h2_line_height', '16 px'),
(21, 'h3_font_family', 'default'),
(22, 'h3_font_style', 'default'),
(23, 'h3_font_size', '16 px'),
(24, 'h3_line_height', '16 px'),
(25, 'h4_font_family', 'default'),
(26, 'h4_font_style', 'default'),
(27, 'h4_font_size', '16 px'),
(28, 'h4_line_height', '16 px'),
(29, 'h5_font_family', 'default'),
(30, 'h5_font_style', 'default'),
(31, 'h5_font_size', '16 px'),
(32, 'h5_line_height', '16 px'),
(33, 'h6_font_family', 'default'),
(34, 'h6_font_style', 'default'),
(35, 'h6_font_size', '16 px'),
(36, 'h6_line_height', '16 px'),
(37, 'button_font_family', 'default'),
(38, 'button_font_style', 'default'),
(39, 'button_font_size', '16 px'),
(40, 'button_line_height', '16 px'),
(41, 'slider_font_family', 'default'),
(42, 'slider_font_style', 'default'),
(43, 'slider_font_size', '16 px'),
(44, 'slider_line_height', '16 px'),
(45, 'testimonial_name_font_family', 'default'),
(46, 'testimonial_name_font_style', 'default'),
(47, 'testimonial_name_font_size', '16 px'),
(48, 'testimonial_name_line_height', '16 px'),
(49, 'testimonial_profession_font_family', 'default'),
(50, 'testimonial_profession_font_style', 'default'),
(51, 'testimonial_profession_font_size', '16 px'),
(52, 'testimonial_profession_line_height', '16 px'),
(53, 'testimonial_quote_font_family', 'default'),
(54, 'testimonial_quote_font_style', 'default'),
(55, 'testimonial_quote_font_size', '16 px'),
(56, 'testimonial_quote_line_height', '16 px'),
(57, 'tabs_title_font_family', 'default'),
(58, 'tabs_title_font_style', 'default'),
(59, 'tabs_title_font_size', '16 px'),
(60, 'tabs_title_line_height', '16 px'),
(61, 'tabs_content_font_family', 'default'),
(62, 'tabs_content_font_style', 'default'),
(63, 'tabs_content_font_size', '16 px'),
(64, 'tabs_content_line_height', '16 px'),
(65, 'accordion_title_font_family', 'default'),
(66, 'accordion_title_font_style', 'default'),
(67, 'accordion_title_font_size', '16 px'),
(68, 'accordion_title_line_height', '16 px'),
(69, 'accordion_content_font_family', 'default'),
(70, 'accordion_content_font_style', 'default'),
(71, 'accordion_content_font_size', '16 px'),
(72, 'accordion_content_line_height', '16 px'),
(73, 'alert_text_font_family', 'default'),
(74, 'alert_text_font_style', 'default'),
(75, 'alert_text_font_size', '16 px'),
(76, 'alert_text_line_height', '16 px'),
(77, 'menu_main_font_family', 'default'),
(78, 'menu_main_font_style', 'default'),
(79, 'menu_main_font_size', '16 px'),
(80, 'menu_main_line_height', '16 px'),
(81, 'menu_submenu_font_family', 'default'),
(82, 'menu_submenu_font_style', 'default'),
(83, 'menu_submenu_font_size', '16 px'),
(84, 'menu_submenu_line_height', '16 px'),
(85, 'features_title_font_family', 'Raleway'),
(86, 'features_title_font_style', '500'),
(87, 'features_title_font_size', '16'),
(88, 'features_title_line_height', '24'),
(89, 'features_content_font_family', 'default'),
(90, 'features_content_font_style', 'default'),
(91, 'features_content_font_size', '16 px'),
(92, 'features_content_line_height', '16 px'),
(93, 'searchbox_font_family', 'default'),
(94, 'searchbox_font_style', 'default'),
(95, 'searchbox_font_size', '16 px'),
(96, 'searchbox_line_height', '16 px'),
(97, 'image_desc_font_family', 'default'),
(98, 'image_desc_font_style', 'default'),
(99, 'image_desc_font_size', '16 px'),
(100, 'image_desc_line_height', '16 px'),
(101, 'pricing_table_title_font_family', 'default'),
(102, 'pricing_table_title_font_style', 'default'),
(103, 'pricing_table_title_font_size', '16 px'),
(104, 'pricing_table_title_line_height', '16 px'),
(105, 'pricing_table_price_font_family', 'default'),
(106, 'pricing_table_price_font_style', 'default'),
(107, 'pricing_table_price_font_size', '16 px'),
(108, 'pricing_table_price_line_height', '16 px'),
(109, 'pricing_table_button_font_family', 'default'),
(110, 'pricing_table_button_font_style', 'default'),
(111, 'pricing_table_button_font_size', '60 px'),
(112, 'pricing_table_button_line_height', '60 px'),
(113, 'pricing_table_text_font_family', 'default'),
(114, 'pricing_table_text_font_style', 'default'),
(115, 'pricing_table_text_font_size', '16 px'),
(116, 'pricing_table_text_line_height', '16 px'),
(117, 'featured_post_title_font_family', 'default'),
(118, 'featured_post_title_font_style', 'default'),
(119, 'featured_post_title_font_size', '16 px'),
(120, 'featured_post_title_line_height', '16 px'),
(121, 'featured_post_meta_font_family', 'default'),
(122, 'featured_post_meta_font_style', 'default'),
(123, 'featured_post_meta_font_size', '16 px'),
(124, 'featured_post_meta_line_height', '16 px'),
(125, 'featured_post_excerpt_font_family', 'default'),
(126, 'featured_post_excerpt_font_style', 'default'),
(127, 'featured_post_excerpt_font_size', '16 px'),
(128, 'featured_post_excerpt_line_height', '16 px'),
(129, 'featured_post_button_font_family', 'default'),
(130, 'featured_post_button_font_style', 'default'),
(131, 'featured_post_button_font_size', '16 px'),
(132, 'featured_post_button_line_height', '16 px'),
(133, 'main_color', '#ef5a32'),
(134, 'light_main_color', '#f27e62'),
(135, 'dark_back_color', '#222222'),
(136, 'light_back_color', '#a0a0a0'),
(137, 'dark_border_color', '#222222'),
(138, 'light_border_color', '#a0a0a0'),
(139, 'title_color', '#222222'),
(140, 'text_color', '#333333'),
(141, 'main_back_text_color', '#ffffff'),
(142, 'column_back_opacity', '100'),
(143, 'templates', '{"8000000":"Architecture Post","8000001":"Illustrations Post","8000002":"Furniture Post","8000003":"Software Post","8000005":"Logos Post","8000006":"Web Design Post","8000008":"Portfolio Software - PortalWP","8000009":"Portfolio Furniture - PortalWP","8000010":"Portfolio Illustration - PortalWP","8000011":"Portfolio Architecture - PortalWP","8000012":"Portfolio Webdesign - PortalWP","8000013":"Portfolio Logo - PortalWP","8000014":"Home - PortalWP","8000015":"Home Creative - PortalWP","8000016":"Services - PortalWP","8000017":"Services Round - PortalWP","8000018":"Services Square - PortalWP","8000019":"About Us - PortalWP","8000020":"Contact - PortalWP","8000021":"Home Default - PortalWP","8000022":"Home Business - PortalWP","8000023":"Home Portfolio #1 - PortalWP","8000024":"Home Product - PortalWP","8000025":"Page About Us - PortalWP","8000026":"Page About Us - Creative - PortalWP","8000027":"Page About Us - Fullscreen - PortalWP","8000028":"Page Services - PortalWP","8000029":"Page Services - Creative - PortalWP","8000030":"Page Services - Fullscreen - PortalWP","8000031":"Page Our Team - Member - PortalWP","8000032":"Page Contact - PortalWP","8000033":"Page Contact - Creative - PortalWP","8000034":"Page Contact - Fullscreen - PortalWP","8000035":"Page FAQ - PortalWP","8000036":"Page Pricing - PortalWP","8000037":"Page Location - PortalWP","8000038":"Page Right Sidebar - PortalWP","8000039":"Page Left Sidebar - PortalWP","8000040":"Page Double Sidebar - PortalWP","8000041":"Page Fullscreen - PortalWP"}'),
(144, 'save_overwrite', 'true'),
(145, 'showall', 'true');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
<?php
	$sql   =  ob_get_clean();

	$sql   = str_replace(array("@@TABLE_PREFIX@@", "@@SITE_URL@@"),array($wpdb->prefix, get_option("siteurl")),$sql);
	$lines = explode("\n", $sql);
	$query = "";

	foreach ($lines as $line) {
		$line = trim($line);
		if (strlen($line)==0) continue;
		if (substr($line,-1)==";") {
			$query.=" ".$line;
			$wpdb->query($query);
			$query = "";
		} else {
			$query.=" ".$line;
		}
	}

	$wp_rewrite->flush_rules();
	wp_cache_flush();
}
