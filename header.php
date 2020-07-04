<?php
/**
	* The template for displaying the header
	*
	* @package WordPress
	* @subpackage AidanAmavi
	* @version 0.3
	*
	* @author Aidan Amavi <mail@aidanamavi.com>
	* @link https://www.aidanamavi.com Author's Web Site
	* @copyright 2012 - 2020, Aidan Amavi
	* @license https://www.gnu.org/licenses/agpl.html GNU Affero General Public License
	*/
?>
<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="en" lang="en" class="toggleFade">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php custom_page_title();?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if(!in_array('seo-by-rank-math/rank-math.php', apply_filters('active_plugins', get_option('active_plugins')))): ?>
		<?php custom_meta_description(); ?>
<?php endif; ?>
		<meta name="keywords" content="<?php echo get_theme_mod( 'seo_keywords_textbox' ); ?>">
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/base.min.css?<?php echo rand(); ?>" type="text/css" media="all" />
		<script src="<?php bloginfo('template_url'); ?>/js/jquery.min.js?<?php echo rand(); ?>"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/base.js?<?php echo rand(); ?>"></script>
<?php if (preg_match('/iPhone/', $_SERVER['HTTP_USER_AGENT']) || preg_match('/iPod/', $_SERVER['HTTP_USER_AGENT']) || preg_match('/iPad/',$_SERVER['HTTP_USER_AGENT']) || preg_match('/android/',$_SERVER['HTTP_USER_AGENT'])): ?>
		<meta name="apple-touch-fullscreen" content="yes">
	  <meta name="apple-mobile-web-app-capable" content="yes">
	  <meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/img/apple_touch_icon.png">
		<?php if (preg_match('/iPad/', $_SERVER['HTTP_USER_AGENT'])): ?>
		<link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ipad.css?<?php echo rand(); ?>">
		<?php elseif (preg_match('/iPhone/', $_SERVER['HTTP_USER_AGENT'])) : ?>
		<link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/iphone.css?<?php echo rand(); ?>">
		<link rel="apple-touch-startup-image" href="<?php bloginfo('template_url'); ?>/img/apple_touch_startup_iphone.png" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)">
		<link rel="apple-touch-startup-image" href="<?php bloginfo('template_url'); ?>/img/apple_touch_startup_iphone_4@2x.png" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)">
		<link rel="apple-touch-startup-image" href="<?php bloginfo('template_url'); ?>/img/apple_touch_startup_iphone_5@2x.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)">
		<?php endif; ?>
	<?php else : ?>
<?php 	endif; ?>
		<?php wp_head(); ?>
<?php
		global $cat;
		global $current_user;
		$userId = $current_user->ID;
		$nonce = wp_create_nonce( 'ajax_fetch_nonce' );
		$siteTitle = get_bloginfo('name');
		$categoryName = single_cat_title('', false); ?>
		<script>
			userId = "<?php echo $userId; ?>";
			nonce = "<?php echo $nonce; ?>";
			categoryId = "<?php echo $cat; ?>";
			categoryName = "<?php echo $categoryName; ?>";
			siteTitle = "<?php echo $siteTitle; ?>";
		</script>
	</head>
	<body>
		<div id="loading_animation">
		  <span class="helper"></span>
		  <img src="<?php bloginfo('template_url'); ?>/img/loading.gif" alt="" />
		</div>
		<div id="wrapper">
			<div id="header_wrapper">
				<header>
					<div id="navigation_wrapper">
						<nav>
							<div>
								<a href="/work" data-link-type="headerNavigation" data-view-type="archive" data-post-type="work" class="underline">
									work
								</a>
							</div>
							<div>
								<a href="/blog" data-link-type="headerNavigation" data-view-type="archive" data-post-type="blog" class="underline">
									blog
								</a>
							</div>
							<div>
								<a href="/about" data-link-type="headerNavigation" data-view-type="archive" data-post-type="about" class="underline">
									about
								</a>
							</div>
						</nav>
					</div>
				</header>
			</div>
			<div id="content_wrapper" class="toggleFade">
