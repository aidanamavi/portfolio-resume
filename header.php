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
	* @copyright 2012 - 2020, Aidan Amavi
	* @license https://www.gnu.org/licenses/agpl.html GNU Affero General Public License
	*/
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php custom_page_title();?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if (is_single()) :
		global $post;
		setup_postdata($post); ?>
		<meta name="description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />
<?php wp_reset_postdata();
		elseif (is_home() || is_page()) : ?>
		<meta name="description" content="<?php bloginfo( 'description' ); ?>" />
<?php
		elseif (is_category()) : ?>
		<meta name="description" content="<?php echo trim(strip_tags(category_description())); ?>" />
<?php
		elseif (is_archive()) : ?>
		<meta name="description" content="<?php echo 'Archive of all '.$post->post_type.' posts.'; ?>" />
<?php endif; ?>
		<meta name="keywords" content="<?php echo get_theme_mod( 'seo_keywords_textbox' ); ?>">
<?php global $is_IE;
		if ($is_IE) : ?>
		<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php bloginfo('template_url'); ?>/img/browser_icon.ico" />
		<?php else: ?>
		<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/img/browser_icon.png" />
<?php endif; ?>
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/base.min.css?<?php echo rand(); ?>" type="text/css" media="all" />
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.min.js?<?php echo rand(); ?>"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/base.min.js?<?php echo rand(); ?>"></script>
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
								<a href="/work" data-link-type="headerNavigation" data-post-type="work">
									<img src="<?php bloginfo('template_url'); ?>/img/link_work@2x.png" class="off" alt="">
									<img src="<?php bloginfo('template_url'); ?>/img/link_work_on@2x.png" class="on" alt="">
								</a>
							</div>
							<div>
								<a href="/blog" data-link-type="headerNavigation" data-post-type="blog">
									<img src="<?php bloginfo('template_url'); ?>/img/link_blog@2x.png" class="off" alt="">
									<img src="<?php bloginfo('template_url'); ?>/img/link_blog_on@2x.png" class="on" alt="">
								</a>
							</div>
							<div>
								<a href="/about" data-link-type="headerNavigation" data-post-type="about">
									<img src="<?php bloginfo('template_url'); ?>/img/link_about@2x.png" class="off" alt="">
									<img src="<?php bloginfo('template_url'); ?>/img/link_about_on@2x.png" class="on" alt="">
								</a>
							</div>
						</nav>
					</div>
				</header>
			</div>
			<div id="content_wrapper" class="toggleFade">
