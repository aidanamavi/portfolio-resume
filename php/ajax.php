<?php
/**
* @package WordPress
* @subpackage AidanAmavi
* @version 0.3
*
* @author Aidan Amavi <mail@aidanamavi.com>
* @link https://www.aidanamavi.com Author's Web Site
* @copyright 2012 - 2020, Aidan Amavi
* @license https://www.gnu.org/licenses/agpl.html GNU Affero General Public License
*/

/**
 * Must use global $post to use setup_postdata().
 * Must echo the response, and use wp_die function to complete the callback.
 * This is necessary for wp_ajax to complete the return.
 *
 * https://codex.wordpress.org/AJAX_in_Plugins
 */
add_action( 'wp_ajax_getAjaxData', 'getAjaxData' );
add_action( 'wp_ajax_nopriv_getAjaxData', 'getAjaxData' );
// Uses AJAX data object {action: fetch-data $_POST[ 'key' ]: value}
function getAjaxData( $category='', $offset='10' ) {
 	$postType = $_POST[ 'postType' ];
	$postID = $_POST[ 'postId' ];

	$id = $_POST[ 'id' ];

	// Used for infinite scroll
	$offset = $_POST[ 'offsetPosts' ];
	$category = $_POST[ 'category' ];

	function validateIntegerInput($input) {
		$input = abs(intval($input));
		filter_var($input, FILTER_SANITIZE_NUMBER_INT);
		if (!is_int($input) && !filter_var($input, FILTER_VALIDATE_INT)) {
			echo 'Invalid page input.';
			exit(0);
			wp_die();
		}
	}

	// Validate cross-site request forgery security token.
	if (!check_ajax_referer( 'ajax_fetch_nonce', 'token', false )) {
		header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
		get_template_part( 'templates/index', '403' );
		exit(0);
		wp_die();
	}

	// If the $postID is blank, show the archive
	if(!empty($postType)){
		// Setup the template name
		if ($postType === 'index') {
			// code...
		} elseif ($postType === 'category') {
			//validateIntegerInput($postID);
			global $post;
			$args = array(
				'posts_per_page'   => 10,
				'offset'           => '',
				'category'         => $postID,
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
			<div id="page_category_<?php echo $postID; ?>"  data-page-title="<?php echo strip_tags(esc_attr(get_the_category_by_id($postID))); ?>">
				<div class="title_wrapper">
					<div class="title">
						<img src="<?php bloginfo('template_url'); ?>/img/title_blog@2x.png" alt="">
					</div>
				</div>
				<?php
				foreach($fetchedPosts as $post) {
					setup_postdata($post); ?>
					<article class="blog_list">
						<h1 class="blog_title"><a href="<?php the_permalink(); ?>" data-link-type="postNavigation" data-post-type="blog" data-post-id="<?php the_ID(); ?>"><?php the_title(); ?></a></h1>
						<h4 class="blog_date_categories_tags"><?php the_time('F j, Y'); ?> • <?php custom_the_category(', ',''); ?><?php the_tags(' • '); ?></h4>
					</article><?php
					wp_reset_postdata();
				} ?>
			</div>
			<?php
		} elseif ($postType === 'work') {

			$templateName = 'work_post';

			// If postID is set, show single post
			if(!empty($postID)){

				// if there is a $postID, show the post
				validateIntegerInput($postID);
				global $post;
				$post = get_post($postID);
				setup_postdata($post);
				get_template_part( 'templates/index', $templateName );
				wp_reset_postdata();

			// If postID is unset, show index
			} else {
				get_template_part( 'templates/index', $postType );
			}

		} elseif ($postType === 'blog') {

			$templateName = 'blog_post';

			// If postID is set, show single post
			if(!empty($postID)){

				// if there is a $postID, show the post
				validateIntegerInput($postID);
				global $post;
				$post = get_post($postID);
				setup_postdata($post);
				get_template_part( 'templates/index', $templateName );
				wp_reset_postdata();

			// If postID is unset, show index
			} else {
				get_template_part( 'templates/index', $postType );
			}

		} elseif ($postType === 'about') {

			$templateName = 'blog_post';

			// If postID is set, show single post
			if(!empty($postID)){

				// if there is a $postID, show the post
				validateIntegerInput($postID);
				global $post;
				$post = get_post($postID);
				setup_postdata($post);
				get_template_part( 'templates/index', $templateName );
				wp_reset_postdata();

			// If postID is unset, show index
			} else {
				get_template_part( 'templates/index', $postType );
			}

		}


	}

	// OLD
	/*
	if ($page === 'archive') {
		if ($postType === 'about' || $postType === 'work' || $postType === 'blog') {
			get_template_part( 'templates/index', $postType );
		} else {
			echo 'Invalid page input.';
		}
		exit(0);
	}

	// page, postId & postType;				categoryId & offset
	elseif ($postType === 'work') {
		if ($postType === 'work') {
			$name = 'work_post';
		} elseif ($postType === 'blog') {
			$name = 'blog_post';
		}
		validateIntegerInput($id);
		global $post;
		$post = get_post($id);
		setup_postdata($post);
		get_template_part( 'templates/index', $name );
		wp_reset_postdata();
		exit(0);
	}*/

	elseif (!empty($category)) {
		validateIntegerInput($category);
		global $post;
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
				<div class="title">
					<img src="<?php bloginfo('template_url'); ?>/img/title_blog@2x.png" alt="">
				</div>
			</div>
			<?php
			foreach($fetchedPosts as $post) {
				setup_postdata($post); ?>
				<article class="blog_list">
					<h1 class="blog_title"><a href="<?php the_permalink(); ?>" data-link-type="postNavigation" data-page="single" data-post-type="blog" data-post-id="<?php the_ID(); ?>"><?php the_title(); ?></a></h1>
					<h4 class="blog_date_categories_tags"><?php the_time('F j, Y'); ?> • <?php custom_the_category(', ',''); ?><?php the_tags(' • '); ?></h4>
				</article><?php
				wp_reset_postdata();
			} ?>
		</div>
		<?php
	// Add if check here, so our final else can output a 404 error.
	}

	elseif (isset($offset) && isset($category)) {
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
				<h1 class="blog_title"><a href="<?php the_permalink(); ?>" data-link-type="postNavigation" data-page="single" data-post-type="blog" data-post-id="<?php the_ID(); ?>"><?php the_title(); ?></a></h1>
				<h4 class="blog_date_categories_tags"><?php the_time('F j, Y'); ?> • <?php custom_the_category(', ',''); ?><?php the_tags(' • '); ?></h4>
			</article>
			<?php
			wp_reset_postdata();
		}
	}


	else {
		get_template_part( 'templates/index', '404' );
	}
	wp_die();

}

?>
