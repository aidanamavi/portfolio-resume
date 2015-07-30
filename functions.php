<?php
/**
	* @package WordPress
	* @subpackage AidanAmavi
	* @version 0.2
	*
	* @author Aidan Amavi <mail@aidanamavi.com>
	* @link http://www.aidanamavi.com Author's Web Site
	* @copyright 2012 - 2015, Aidan Amavi
	* @license https://www.gnu.org/licenses/agpl.html GNU Affero General Public License
	*/

// Saftey first.
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'functions.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly.');

/************************************************************
/* CUSTOM SCRIPTING
/************************************************************/
add_filter('show_admin_bar', '__return_false');
add_filter('the_generator', '__return_false');

// Add browser classes to body tag.
add_filter('body_class','browser_body_class');
function browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}

// Remove the_generator meta tag.
add_filter( 'the_generator', create_function('$a', "return null;") );

// Add custom logo.
function custom_logo() { ?>
	<style type="text/css">
		h1 a { background-image: url(
			<?php get_bloginfo('template_directory'); ?>/img/logo-login.gif
		) !important) }
    </style>
<?php }
add_action('login_head', 'custom_logo');

// Enables the ability to get the category ID from a link for AJAX requests.
function custom_the_category($separator = '', $parents='', $post_id = false) {
	$categories = get_the_category($post_id); $i = 0;
	if (!empty($categories)) {
		foreach($categories as $cat) {
			if ( $i > 0 ) {
				$thelist .= $separator;
			}
			$thelist .= '<a href="' . esc_url(get_category_link($cat->term_id)) . '" data-category-id="' . $cat->term_id . '" data-post-type="category" data-link-type="postNavigation" title="View all posts in '. esc_attr($cat->name) . '">' . $cat->cat_name . '</a>';
			$i++;
		}
		echo $thelist;
	}
}

function custom_page_title() {
	$title = bloginfo('name');
	if (is_single()) {
		$postType = get_post_type( $post );
		if ($postType === 'post') {
			$postType = 'blog';
		}
		$title .= ' &rsaquo; '.ucwords($postType);
	}
	$title .= wp_title('&rsaquo;', false, 'left');
	echo $title;
}

add_action( 'after_setup_theme', 'add_thumbnail_support' );
function add_thumbnail_support() {
  add_theme_support('post-thumbnails', array('slide-items','post','gallery-items','audio-items','video-items','page','event-items','work'));
}

// Add the work post type to the theme.
require_once(get_template_directory().'/php/post-type-work.php');
// Add the blog post type to the theme.
require_once(get_template_directory().'/php/post-type-blog.php');

// Show the blog post type in our category and tag pages.
add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if (is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
		if ($post_type) {
		  $post_type = $post_type;
		} else {
		  $post_type = array('blog');
		}
	  $query->set('post_type',$post_type);
		return $query;
	}
}

function remove_menus() {
global $menu;
	$restricted = array(
		//__('Dashboard'),
		__('Posts')
		/*
		__('Media'),
		__('Links'),
		__('Pages'),
		__('Appearance'),
		__('Tools'),
		__('Users'),
		__('Settings'),
		__('Comments'),
		__('Plugins')*/
	);
	end($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'remove_menus');

/**
 * Adds the individual sections, settings, and controls to the theme customizer.
 */
function customize_seo_keywords( $wp_customize ) {
  $wp_customize->add_section(
      'seo_section',
      array(
        'title' => 'SEO Keywords',
        'priority' => 35,
      )
  );
	$wp_customize->add_setting(
    'seo_keywords_textbox',
    array(
      'default' => 'portfolio, resume, blog',
			'transport'   => 'postMessage',
    )
	);
	$wp_customize->add_control(
    'seo_keywords_textbox',
    array(
      'label' => 'Keywords',
      'section' => 'seo_section',
      'type' => 'text',
    )
	);
}
add_action( 'customize_register', 'customize_seo_keywords' );
function customize_piwik_tracking( $wp_customize ) {
  $wp_customize->add_section(
      'piwik_section',
      array(
        'title' => 'Piwik Settings',
        'priority' => 35,
      )
  );
	$wp_customize->add_setting(
    'piwik_site_id_textbox',
    array(
      'default' => '',
			'transport'   => 'postMessage',
    )
	);
	$wp_customize->add_control(
    'piwik_site_id_textbox',
    array(
      'label' => 'Site ID',
      'section' => 'piwik_section',
      'type' => 'text',
    )
	);
	$wp_customize->add_setting(
    'piwik_tracker_url_textbox',
    array(
      'default' => '',
			'transport'   => 'postMessage',
    )
	);
	$wp_customize->add_control(
    'piwik_tracker_url_textbox',
    array(
      'label' => 'Tracker URL',
      'section' => 'piwik_section',
      'type' => 'text',
    )
	);
}
add_action( 'customize_register', 'customize_piwik_tracking' );

/**
 * Must use global $post to use setup_postdata().
 * Must echo the response, and use exit(0) to complete the callback.
 * This is necessary for wp_ajax to complete the return.
 */
add_action( 'wp_ajax_getAjaxData', 'getAjaxData' );
add_action( 'wp_ajax_nopriv_getAjaxData', 'getAjaxData' );
// Uses AJAX data object {action: fetch-data $_POST[ 'key' ]: value}
function getAjaxData( $category='', $offset='10' ) {
	$folder = $_POST[ 'folder' ];
	$page = $_POST[ 'page' ];
	$offset = $_POST[ 'offset' ];
	$category = $_POST[ 'category' ];

	function validateIntegerInput($input) {
		$input = abs(intval($input));
		filter_var($input, FILTER_SANITIZE_NUMBER_INT);
		if (!is_int($input) && !filter_var($input, FILTER_VALIDATE_INT)) {
			echo 'Invalid page input.';
			exit(0);
		}
	}
	// Validate cross-site request forgery security token.
	if (!check_ajax_referer( 'ajax_fetch_nonce', 'token', false )) {
		header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
		get_template_part( 'templates/index', '403' );
		exit(0);
	}

	if ($folder === 'index') {
		if ($page === 'about' || $page === 'work' || $page === 'blog') {
			get_template_part( 'templates/index', $page );
		} else {
			echo 'Invalid page input.';
		}
		exit(0);

	// page, postId & postType;				categoryId & offset
	} elseif ($folder === 'work') {
		validateIntegerInput($page);
		global $post;
		$post = get_post($page);
		setup_postdata($post);
		get_template_part( 'templates/index', 'work_post' );
		wp_reset_postdata();
		exit(0);

	} elseif ($folder === 'post') {
		validateIntegerInput($page);
		global $post;
		$post = get_post($page);
		setup_postdata($post);
		get_template_part( 'templates/index', 'blog_post' );
		wp_reset_postdata();
		exit(0);

	} elseif ($folder === 'category') {
		validateIntegerInput($page);
		global $post;
		$category = $page;
		$args = array(
			'posts_per_page'   => 10,
			'offset'           => '',
			'category'         => $category,
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'blog',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'post_status'      => 'publish',
			'suppress_filters' => true
		);
		$fetchedPosts = get_posts( $args );
		?>
		<div id="page_category_<?php echo $category; ?>"  data-page-title="<?php echo strip_tags(esc_attr(get_the_category_by_id($category))); ?>">
			<div class="title_wrapper">
				<div class="titles">
					<img src="<?php bloginfo('template_url'); ?>/img/title_blog@2x.png" alt="">
				</div>
			</div>
			<?php
			foreach($fetchedPosts as $post) {
				setup_postdata($post); ?>
				<article class="blog_list">
					<h1 class="blog_title"><a href="<?php the_permalink(); ?>" data-post-id="<?php the_ID(); ?>" data-post-type="post" data-link-type="postNavigation"><?php the_title(); ?></a></h1>
					<h4 class="blog_date_categories_tags"><?php the_time('F j, Y'); ?> • <?php custom_the_category(', ',''); ?><?php the_tags(' • '); ?></h4>
				</article><?php
				wp_reset_postdata();
			} ?>
		</div>
		<?php
		exit(0);
	// Add if check here, so our final else can output a 404 error.
} elseif (isset($offset) && isset($category)) {
		// Infinite scroll.
		global $post;
		validateIntegerInput($offset);
		validateIntegerInput($category);
		$args = array(
			'posts_per_page'   => 10,
			'offset'           => $offset,
			'category'         => $category,
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'blog',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'post_status'      => 'publish',
			'suppress_filters' => true
		);
		$fetchedPosts = get_posts( $args );
		foreach($fetchedPosts as $post) {
			setup_postdata( $post );
			?>
			<article class="blog_list">
				<h1 class="blog_title"><a href="<?php the_permalink(); ?>" data-post-id="<?php the_ID(); ?>" data-link-type="postNavigation"><?php the_title(); ?></a></h1>
				<h4 class="blog_date_categories_tags"><?php the_time('F j, Y'); ?> • <?php custom_the_category(', ',''); ?><?php the_tags(' • '); ?></h4>
			</article>
			<?php
			wp_reset_postdata();
		}
		exit(0);
	} else {
		get_template_part( 'templates/index', '404' );
		exit(0);
	}
}
