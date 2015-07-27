<?php
/**
	* The template for displaying blog post content.
	*
	* @package WordPress
	* @subpackage AidanAmavi
	* @version 0.3
	*
	* @author Aidan Amavi <mail@aidanamavi.com>
	* @link http://www.aidanamavi.com Author's Web Site
	* @copyright 2012 - 2015, Aidan Amavi
	* @license http://creativecommons.org/licenses/by-sa/4.0/ Attribution-ShareAlike 4.0 International
	*/
?>
				<div id="page_post_<?php the_ID(); ?>"  data-page-title="<?php the_title(); ?>">
					<div class="title_wrapper">
						<div class="titles">
							<img src="<?php bloginfo('template_url'); ?>/img/title_blog@2x.png" alt="">
						</div>
					</div>
					<div class="highlight_post">
						<div class="hightlight_number_1">
							<div class="highlights_text">
								<article>
									<h1 class="blog_title"><a href="<?php the_permalink() ?>" data-post-id="<?php the_ID(); ?>" data-post-type="post"><?php the_title(); ?></a></h1>
									<h4 class="blog_date_categories_tags"><?php the_time('F j, Y'); ?> • <?php custom_the_category(', ',''); ?><?php the_tags(' • '); ?></h4>
									<div class="blog_content">
										<?php the_content(); ?>
									</div>
<?php 							if(comments_open()): ?>
										<div id="comments">
											<?php comments_template(); ?>
										</div>
									<?php endif; ?>
								</article>
							</div>
						</div>
					</div>
				</div>
