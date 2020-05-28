<?php
/**
	* The template for displaying blog post content.
	*
	* @package WordPress
	* @subpackage AidanAmavi
	* @version 0.2
	*
	* @author Aidan Amavi <mail@aidanamavi.com>
	* @link https://www.aidanamavi.com Author's Web Site
	* @copyright 2012 - 2020, Aidan Amavi
	* @license https://www.gnu.org/licenses/agpl.html GNU Affero General Public License
	*/
?>
				<div id="page_single_blog_<?php the_ID(); ?>"  data-page-title="<?php the_title_attribute(); ?>">
					<div class="title_wrapper">
						<div class="titles">
							<img src="<?php bloginfo('template_url'); ?>/img/title_blog@2x.png" alt="">
						</div>
					</div>
					<div class="highlight_post">
						<div class="hightlight_number_1">
							<div class="highlights_text">
								<article>
									<h1 class="blog_title"><a href="<?php the_permalink() ?>" data-link-type="postNavigation" data-page="single" data-post-type="blog" data-post-id="<?php the_ID(); ?>"><?php the_title(); ?></a></h1>
									<h4 class="blog_date_categories_tags"><?php the_time('F j, Y'); ?> • <?php custom_the_category(', ',''); ?><?php the_tags(' • '); ?></h4>
									<div class="blog_content">
										<?php global $post; setup_postdata($post); the_content(); wp_reset_postdata(); ?>
									</div>
<?php 							if(comments_open()): ?>
										<div class="comments">
											<?php comments_template(); ?>
										</div>
									<?php endif; ?>
								</article>
							</div>
						</div>
					</div>
				</div>
