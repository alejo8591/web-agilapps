<?php
	portal_demo_revcss();

	function portal_demo_revcss() {
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

CREATE TABLE IF NOT EXISTS `@@TABLE_PREFIX@@revslider_css` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `handle` text NOT NULL,
  `settings` text,
  `hover` text,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

INSERT INTO `@@TABLE_PREFIX@@revslider_css` (`id`, `handle`, `settings`, `hover`, `params`) VALUES
(101, '.tp-caption.big_black_portal', '{"hover":"false"}', '""', '{"font-size":"36px","line-height":"36px","font-weight":"300","font-family":"Raleway","color":"rgb(0, 0, 0)","text-decoration":"none","background-color":"transparent","padding":"0px 4px","text-shadow":"none","margin":"0px","letter-spacing":"-1.5px","border-width":"0px","border-color":"rgb(0, 0, 0)","border-style":"none"}'),
(102, '.tp-caption.portal_big', '{"hover":"false"}', '{"font-size":"50px","line-height":"60px","font-weight":"300","font-family":"\\"Raleway\\",sans-serif","color":"rgb(255, 255, 255)","text-decoration":"none","background-color":"transparent","text-shadow":"none","margin":"0px","letter-spacing":"-1.5px","padding":"20px 30px","border-width":"0px","border-color":"rgb(0, 0, 0)","border-style":"none"}', '{"font-size":"50px","line-height":"60px","font-weight":"600","font-family":"\\"Raleway\\",sans-serif","color":"#ffffff","text-decoration":"none","background-color":"transparent","text-shadow":"none","margin":"0px","letter-spacing":"-1.5px","padding":"20px 30px 20px 30px","border-width":"0px","border-color":"rgb(0, 0, 0)","border-style":"none"}'),
(103, '.tp-caption.portal_small', '{"hover":"false"}', '{"font-size":"50px","line-height":"60px","font-weight":"300","font-family":"\\"Raleway\\",sans-serif","color":"rgb(255, 255, 255)","text-decoration":"none","background-color":"transparent","text-shadow":"none","margin":"0px","letter-spacing":"-1.5px","padding":"20px 30px","border-width":"0px","border-color":"rgb(0, 0, 0)","border-style":"none"}', '{"font-size":"25px","line-height":"35px","font-weight":"500","font-family":"\\"Raleway\\",sans-serif","color":"#ffffff","text-decoration":"none","background-color":"transparent","text-shadow":"none","margin":"0px","letter-spacing":"7px","padding":"20px 30px 20px 30px","border-width":"0px","border-color":"rgb(0, 0, 0)","border-style":"none"}'),
(104, '.tp-caption.portal_thin', '{"hover":"false"}', '{"font-size":"36px","line-height":"36px","font-weight":"700","font-family":"\\"Raleway\\"","color":"rgb(255, 255, 255)","text-decoration":"none","background-color":"rgb(0, 0, 0)","text-shadow":"none","margin":"0px","letter-spacing":"-1.5px","padding":"0px 4px","border-width":"0px","border-color":"rgb(0, 0, 0)","border-style":"none"}', '{"font-size":"36px","line-height":"36px","font-weight":"200","font-family":"\\"Raleway\\"","color":"#ffffff","text-decoration":"none","background-color":"transparent","text-shadow":"none","margin":"0px","letter-spacing":"0px","padding":"0px 4px 0px 4px","border-width":"0px","border-color":"rgb(255, 255, 255)","border-style":"none"}'),
(105, '.tp-caption.portal_small_thin', '{"hover":"false"}', '{"font-size":"50px","line-height":"60px","font-weight":"300","font-family":"\\"Raleway\\",sans-serif","color":"rgb(255, 255, 255)","text-decoration":"none","background-color":"transparent","text-shadow":"none","margin":"0px","letter-spacing":"-1.5px","padding":"20px 30px","border-width":"0px","border-color":"rgb(0, 0, 0)","border-style":"none"}', '{"font-size":"25px","line-height":"33px","font-weight":"200","font-family":"\\"Raleway\\",sans-serif","color":"#ffffff","text-decoration":"none","background-color":"transparent","text-shadow":"none","margin":"0px","letter-spacing":"2px","padding":"0px 4px 0px 4px","border-width":"0px","border-color":"rgb(0, 0, 0)","border-style":"none"}'),
(106, '.tp-caption.portal_thin_very_small', '{"hover":"false"}', '{"font-size":"36px","line-height":"36px","font-weight":"700","font-family":"\\"Raleway\\"","color":"rgb(255, 255, 255)","text-decoration":"none","background-color":"rgb(0, 0, 0)","text-shadow":"none","margin":"0px","letter-spacing":"-1.5px","padding":"0px 4px","border-width":"0px","border-color":"rgb(0, 0, 0)","border-style":"none"}', '{"font-size":"20px","line-height":"28px","font-weight":"200","font-family":"\\"Raleway\\"","color":"#ffffff","text-decoration":"none","background-color":"transparent","text-shadow":"none","margin":"0px","letter-spacing":"0px","padding":"0px 4px 0px 4px","border-width":"0px","border-color":"rgb(255, 255, 255)","border-style":"none"}');

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
