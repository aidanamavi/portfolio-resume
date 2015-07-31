<?php
/**
	* The template for displaying the header
	*
	* @package WordPress
	* @subpackage AidanAmavi
	* @version 0.2
	*
	* @author Aidan Amavi <mail@aidanamavi.com>
	* @link http://www.aidanamavi.com Author's Web Site
	* @copyright 2012 - 2015, Aidan Amavi
	* @license https://www.gnu.org/licenses/agpl.html GNU Affero General Public License
	*/
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php custom_page_title();?></title>
		<meta name="description" content="<?php custom_meta_description(); ?>" />
		<meta name="keywords" content="<?php echo get_theme_mod( 'seo_keywords_textbox' ); ?>">
<?php global $is_IE;
		if ($is_IE) : ?>
		<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php bloginfo('template_url'); ?>/img/browser_icon.ico" />
		<?php else: ?>
		<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/img/browser_icon.png" />
<?php endif; ?>
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/base.min.css" type="text/css" media="all" />
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/base.min.js"></script>
<?php if (ereg('iPhone', $_SERVER['HTTP_USER_AGENT']) || ereg('iPod', $_SERVER['HTTP_USER_AGENT']) || ereg('iPad',$_SERVER['HTTP_USER_AGENT']) || ereg('android',$_SERVER['HTTP_USER_AGENT'])): ?>
		<meta name="apple-touch-fullscreen" content="yes">
	  <meta name="apple-mobile-web-app-capable" content="yes">
	  <meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/img/apple_touch_icon.png">
		<?php if (ereg('iPad', $_SERVER['HTTP_USER_AGENT'])): ?>
		<link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ipad.css">
		<?php elseif (ereg('iPhone', $_SERVER['HTTP_USER_AGENT'])) : ?>
		<meta name="viewport" content="width=640">
		<link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/iphone.css">
		<link rel="apple-touch-startup-image" href="<?php bloginfo('template_url'); ?>/img/apple_touch_startup_iphone.png" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)">
		<link rel="apple-touch-startup-image" href="<?php bloginfo('template_url'); ?>/img/apple_touch_startup_iphone_4@2x.png" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)">
		<link rel="apple-touch-startup-image" href="<?php bloginfo('template_url'); ?>/img/apple_touch_startup_iphone_5@2x.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)">
		<?php endif; ?>
	<?php else : ?>
		<meta name="viewport" content="width=960">
<?php endif; ?>
<?php wp_head(); ?>
<?php
		global $cat;
		global $current_user;
		$userId = $current_user->ID;
		$nonce = wp_create_nonce( 'ajax_fetch_nonce' );
		$siteName = get_bloginfo('name');
		$categoryName = single_cat_title('', false); ?>
		<script>
			userId = "<?php echo $userId; ?>";
			nonce = "<?php echo $nonce; ?>";
			categoryId = "<?php echo $cat; ?>";
			categoryName = "<?php echo $categoryName; ?>";
			siteName = "<?php echo $siteName; ?>";
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
								<a href="/work" data-link-type="headerNavigation">
									<img src="<?php bloginfo('template_url'); ?>/img/link_work@2x.png" class="off" alt="">
									<img src="<?php bloginfo('template_url'); ?>/img/link_work_on@2x.png" class="on" alt="">
								</a>
							</div>
							<div>
								<a href="/blog" data-link-type="headerNavigation">
									<img src="<?php bloginfo('template_url'); ?>/img/link_blog@2x.png" class="off" alt="">
									<img src="<?php bloginfo('template_url'); ?>/img/link_blog_on@2x.png" class="on" alt="">
								</a>
							</div>
							<div>
								<a href="/about" data-link-type="headerNavigation">
									<img src="<?php bloginfo('template_url'); ?>/img/link_about@2x.png" class="off" alt="">
									<img src="<?php bloginfo('template_url'); ?>/img/link_about_on@2x.png" class="on" alt="">
								</a>
							</div>
						</nav>
					</div>
				</header>
			</div>
			<div id="content_wrapper" class="toggleFade">
