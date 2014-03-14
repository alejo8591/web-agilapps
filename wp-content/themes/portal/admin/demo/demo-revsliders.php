<?php
	portal_demo_revsliders();

	function portal_demo_revsliders() {
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

CREATE TABLE IF NOT EXISTS `@@TABLE_PREFIX@@revslider_sliders` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `alias` tinytext,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `@@TABLE_PREFIX@@revslider_sliders` (`id`, `title`, `alias`, `params`) VALUES
(1001, 'Portal Home', 'portal_home', '{"title":"Portal Home","alias":"portal_home","shortcode":"[rev_slider portal_home]","source_type":"gallery","post_types":"post","post_category":"category_203","post_sortby":"ID","posts_sort_direction":"DESC","max_slider_posts":"30","excerpt_limit":"55","slider_template_id":"","posts_list":"","slider_type":"fullscreen","fullscreen_offset_container":"","full_screen_align_force":"off","auto_height":"off","force_full_width":"off","responsitive_w1":"940","responsitive_sw1":"770","responsitive_w2":"780","responsitive_sw2":"500","responsitive_w3":"510","responsitive_sw3":"310","responsitive_w4":"0","responsitive_sw4":"0","responsitive_w5":"0","responsitive_sw5":"0","responsitive_w6":"0","responsitive_sw6":"0","width":"1200","height":"350","delay":"9000","shuffle":"off","lazy_load":"off","use_wpml":"off","stop_slider":"off","stop_after_loops":0,"stop_at_slide":2,"load_googlefont":"false","google_font":["<link href=\\\\''http:\\/\\/fonts.googleapis.com\\/css?family=PT+Sans+Narrow:400,700\\\\'' rel=\\\\''stylesheet\\\\'' type=\\\\''text\\/css\\\\''>"],"position":"center","margin_top":0,"margin_bottom":0,"margin_left":0,"margin_right":0,"shadow_type":"0","show_timerbar":"hide","padding":0,"background_color":"#ffffff","show_background_image":"false","background_image":"","bg_fit":"cover","bg_repeat":"no-repeat","bg_position":"center top","touchenabled":"on","stop_on_hover":"on","navigaion_type":"bullet","navigation_arrows":"solo","navigation_style":"round","navigaion_always_on":"false","hide_thumbs":200,"navigaion_align_hor":"center","navigaion_align_vert":"bottom","navigaion_offset_hor":"0","navigaion_offset_vert":20,"leftarrow_align_hor":"left","leftarrow_align_vert":"center","leftarrow_offset_hor":20,"leftarrow_offset_vert":0,"rightarrow_align_hor":"right","rightarrow_align_vert":"center","rightarrow_offset_hor":20,"rightarrow_offset_vert":0,"thumb_width":100,"thumb_height":50,"thumb_amount":5,"hide_slider_under":0,"hide_defined_layers_under":0,"hide_all_layers_under":0,"hide_thumbs_under_resolution":0,"start_with_slide":"1","first_transition_type":"fade","first_transition_duration":300,"first_transition_slot_amount":7,"jquery_noconflict":"on","js_to_body":"false","output_type":"none","template":"false","0":["<link href=\\\\''http:\\/\\/fonts.googleapis.com\\/css?family=PT+Sans+Narrow:400,700\\\\'' rel=\\\\''stylesheet\\\\'' type=\\\\''text\\/css\\\\''>"]}'),
(1002, 'portal business', 'business', '{"title":"portal business","alias":"business","shortcode":"[rev_slider business]","source_type":"gallery","post_types":"post","post_category":"category_203","post_sortby":"ID","posts_sort_direction":"DESC","max_slider_posts":"30","excerpt_limit":"55","slider_template_id":"","posts_list":"","slider_type":"fullwidth","fullscreen_offset_container":"","full_screen_align_force":"off","auto_height":"off","force_full_width":"on","responsitive_w1":"940","responsitive_sw1":"770","responsitive_w2":"780","responsitive_sw2":"500","responsitive_w3":"510","responsitive_sw3":"310","responsitive_w4":"0","responsitive_sw4":"0","responsitive_w5":"0","responsitive_sw5":"0","responsitive_w6":"0","responsitive_sw6":"0","width":"1200","height":"500","delay":"9000","shuffle":"off","lazy_load":"off","use_wpml":"off","stop_slider":"off","stop_after_loops":0,"stop_at_slide":2,"load_googlefont":"false","google_font":["<link href=\\\\''http:\\/\\/fonts.googleapis.com\\/css?family=PT+Sans+Narrow:400,700\\\\'' rel=\\\\''stylesheet\\\\'' type=\\\\''text\\/css\\\\''>"],"position":"center","margin_top":0,"margin_bottom":0,"margin_left":0,"margin_right":0,"shadow_type":"0","show_timerbar":"hide","padding":0,"background_color":"#ffffff","show_background_image":"false","background_image":"","bg_fit":"cover","bg_repeat":"no-repeat","bg_position":"center top","touchenabled":"on","stop_on_hover":"on","navigaion_type":"bullet","navigation_arrows":"solo","navigation_style":"round","navigaion_always_on":"false","hide_thumbs":200,"navigaion_align_hor":"center","navigaion_align_vert":"bottom","navigaion_offset_hor":"0","navigaion_offset_vert":20,"leftarrow_align_hor":"left","leftarrow_align_vert":"center","leftarrow_offset_hor":20,"leftarrow_offset_vert":0,"rightarrow_align_hor":"right","rightarrow_align_vert":"center","rightarrow_offset_hor":20,"rightarrow_offset_vert":0,"thumb_width":100,"thumb_height":50,"thumb_amount":5,"hide_slider_under":0,"hide_defined_layers_under":0,"hide_all_layers_under":0,"hide_thumbs_under_resolution":0,"start_with_slide":"1","first_transition_type":"fade","first_transition_duration":300,"first_transition_slot_amount":7,"jquery_noconflict":"on","js_to_body":"false","output_type":"none","template":"false","0":["<link href=\\\\''http:\\/\\/fonts.googleapis.com\\/css?family=PT+Sans+Narrow:400,700\\\\'' rel=\\\\''stylesheet\\\\'' type=\\\\''text\\/css\\\\''>"]}');

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
