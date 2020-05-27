<?php
/**
	* The template for displaying all blog post content.
	*
	* @package WordPress
	* @subpackage AidanAmavi
	* @version 0.2
	*
	* @author Aidan Amavi <mail@aidanamavi.com>
	* @link http://www.aidanamavi.com Author's Web Site
	* @copyright 2012 - 2020, Aidan Amavi
	* @license http://creativecommons.org/licenses/by-sa/4.0/ Attribution-ShareAlike 4.0 International
	*/
?>
				<div id="page_archive_blog" data-page-title="Blog">
					<div class="title_wrapper">
						<div class="titles">
							<img src="<?php bloginfo('template_url'); ?>/img/title_blog@2x.png" alt="">
						</div>
					</div>
<?php
					$args = array(
						'posts_per_page'   => 15,
						'offset'           => 0,
						'category'         => '',
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
						'suppress_filters' => true );
					$myposts = get_posts( $args );
					foreach($myposts as $post) : setup_postdata($post);
					?>
					<article class="blog_list">
						<h1 class="blog_title"><a href="<?php the_permalink(); ?>" data-link-type="postNavigation" data-page="single" data-post-type="blog" data-post-id="<?php the_ID(); ?>"><?php the_title(); ?></a></h1>
						<h4 class="blog_date_categories_tags"><?php echo get_the_date(); ?> • <?php custom_the_category(', '); ?><?php the_tags(' • '); ?></h4>
					</article>
<?php
					endforeach; wp_reset_postdata(); ?>
				</div>
