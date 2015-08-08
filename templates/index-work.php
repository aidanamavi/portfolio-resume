<?php
/**
	* The template for displaying all portfolio content.
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
				<div id="page_archive_work" data-page-title="Work">
					<div class="title_wrapper">
						<div class="titles">
							&nbsp;&nbsp;
							<a href="#" class="new_glow" data-project-type="all" data-link-type="workNavigation">All</a>&nbsp;&rsaquo;
							<a href="#" class="new_glow" data-project-type="web" data-link-type="workNavigation">Web</a>&nbsp;&rsaquo;
							<a href="#" class="new_glow" data-project-type="video" data-link-type="workNavigation">Video</a>&nbsp;&rsaquo;
							<a href="#" class="new_glow" data-project-type="photo" data-link-type="workNavigation">Photo</a>&nbsp;&rsaquo;
							<a href="#" class="new_glow" data-project-type="graphic" data-link-type="workNavigation">Graphic</a>&nbsp;&rsaquo;
							<a href="#" class="new_glow" data-project-type="sound" data-link-type="workNavigation">Sound</a>
						</div>
					</div>
					<div class="row">
<?php
					$args = array(
						'posts_per_page'   => 35,
						'offset'           => 0,
						'category'         => '',
						'orderby'          => 'post_date',
						'order'            => 'ASC',
						'include'          => '',
						'exclude'          => '',
						'meta_key'         => '',
						'meta_value'       => '',
						'post_type'        => 'work',
						'post_mime_type'   => '',
						'post_parent'      => '',
						'post_status'      => 'publish',
						'suppress_filters' => true );
					$myposts = get_posts( $args );
					foreach($myposts as $post) : setup_postdata($post);
						$keywords = get_post_meta( get_the_ID(), 'shortcut_keywords', true );
						if ($keywords) :
							foreach ($keywords as $keyword) :
								if (!empty($keywordList)) : $keywordList.= ' '; endif;
								$keywordList .= $keyword;
							endforeach;
						endif;
					?>
						<div class="column" data-project-type="<?php echo $keywordList; ?>">
							<a href="<?php the_permalink(); ?>" data-link-type="postNavigation" data-page="single" data-post-type="work" data-post-id="<?php the_ID(); ?>">
								<?php the_post_thumbnail(); echo PHP_EOL; ?>
							</a>
						</div>
<?php
					unset($keywordList);
					endforeach; wp_reset_postdata(); ?>
					</div>
				</div>
