<?php
/**
	* The template for displaying individual portfolio content.
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
				<div id="page_work_<?php the_ID(); ?>" data-page-title="<?php the_title_attribute(); ?>">
<?php
					$slideTotal = (int) get_post_meta( get_the_ID(), 'slideTotal', true );
					$numberCount = 1; $slideCount = 1;

					if ($slideTotal > $numberCount) : ?>
					<div class="numbers_wrapper">
						<div class="numbers">
<?php 			while ($numberCount <= $slideTotal) : ?>
							<div data-slide="<?php echo $numberCount; ?>">
								<img src="<?php bloginfo('template_url'); ?>/img/highlight_number_<?php echo $numberCount; ?>@2x.png" class="off" alt="">
								<img src="<?php bloginfo('template_url'); ?>/img/highlight_number_<?php echo $numberCount; ?>_on@2x.png" class="on" alt="">
							</div>
<?php 				++$numberCount;
						endwhile; ?>
						</div>
					</div>
<?php 		endif; ?>
					<div class="title_wrapper">
						<div class="titles">
							<img src="<?php echo esc_url(get_post_meta( get_the_ID(), 'title_image_url', true )); ?>" alt="">
						</div>
					</div>
					<div class="highlight_slides">
<?php 		while ($slideCount <= $slideTotal) :
							$slideId = 'slide_'.$slideCount; ?>
						<div class="slide<?php if ($slideCount > 1) : echo ' hide toggleFade'; endif; ?>" data-slide="<?php echo $slideCount; ?>">
<?php					$slideImageUrl = esc_url(get_post_meta( get_the_ID(), 'slide_'.$slideCount.'_url', true ));
							$slideYouTubeUrl = esc_url(get_post_meta( get_the_ID(), 'slide_'.$slideCount.'_youtube_url', true ));
							if ($slideYouTubeUrl) : ?>
							<iframe width="940" height="492" src="<?php echo $slideYouTubeUrl; ?>" allowfullscreen></iframe>
<?php 				else: ?>
							<img src="<?php echo $slideImageUrl; ?>" class="highlight" alt="">
<?php 				endif; ?>
							<div class="highlights_text">
<?php
							$roles = get_post_meta( get_the_ID(), $slideId.'_roles', true );
							if ($roles) : ?>
								<div class="skills">
									<div class="skills_title">
										<strong>occupations</strong>
									</div>
									<div class="masonry_wrapper">
										<div class="masonry_column">
<?php								foreach ($roles as $role) :
											if (!empty($prevRole) && isSeparateGroup('roles', $prevRole, $role)) : ?>
											<br />
										</div>
										<div class="masonry_column">
<?php									endif;
echo '											'.displayMetaLabel('roles', $role).'<br />'.PHP_EOL;
											$prevRole = $role;
										endforeach; unset($prevRole); ?>
											<br />
										</div>
									</div>
								</div>
<?php 				endif;

							$disciplines = get_post_meta( get_the_ID(), $slideId.'_disciplines', true );
							if ($disciplines) : ?>
								<div class="skills">
									<div class="skills_title">
										<strong>disciplines</strong>
									</div>
									<div class="masonry_wrapper">
										<div class="masonry_column">
<?php							foreach ($disciplines as $discipline) :
											if (!empty($prevDiscipline) && isSeparateGroup('disciplines', $prevDiscipline, $discipline)) : ?>
											<br />
										</div>
										<div class="masonry_column">
<?php									endif;
echo '											'.displayMetaLabel('disciplines', $discipline).'<br />'.PHP_EOL;
											$prevDiscipline = $discipline;
										endforeach; unset($prevDiscipline); ?>
											<br />
										</div>
									</div>
								</div>
<?php 				endif;

							$tools = get_post_meta( get_the_ID(), $slideId.'_tools', true );
							if ($tools) : ?>
								<div class="skills">
									<div class="skills_title">
										<strong>tools</strong>
									</div>
									<div class="masonry_wrapper">
										<div class="masonry_column">
<?php							foreach ($tools as $tool) :
											if (!empty($prevTool) && isSeparateGroup('tools', $prevTool, $tool)) : ?>
											<br />
										</div>
										<div class="masonry_column">
<?php									endif;
echo '											'.displayMetaLabel('tools', $tool).'<br />'.PHP_EOL;
											$prevTool = $tool;
										endforeach; unset($prevTool); ?>
											<br />
										</div>
									</div>
								</div>
<?php 			  endif;

							$products = get_post_meta( get_the_ID(), $slideId.'_products', true );
							if ($products) : ?>
								<div class="skills">
									<div class="skills_title">
										<strong>products</strong>
									</div>
									<div class="masonry_wrapper">
										<div class="masonry_column">
<?php							foreach ($products as $product) :
											if (!empty($prevProduct) && isSeparateGroup('products', $prevProduct, $product)) : ?>
											<br />
										</div>
										<div class="masonry_column">
<?php									endif;
echo '											'.displayMetaLabel('products', $product).'<br />'.PHP_EOL;
											$prevProduct = $product;
										endforeach; unset($prevProduct); ?>
											<br />
										</div>
									</div>
								</div>
<?php 				endif;

							$presentations = get_post_meta( get_the_ID(), $slideId.'_presentations', true );
							if ($presentations) : ?>
								<div class="skills">
									<div class="skills_title">
										<strong>presentations</strong>
									</div>
									<div class="masonry_wrapper">
										<div class="masonry_column">
<?php							foreach ($presentations as $presentation) :
											if (!empty($prevPresentation) && isSeparateGroup('presentations', $prevPresentation, $presentation)) : ?>
											<br />
										</div>
										<div class="masonry_column">
<?php									endif;
echo '											'.displayMetaLabel('presentations', $presentation).'<br />'.PHP_EOL;
											$prevPresentation = $presentation;
										endforeach; unset($prevPresentation); ?>
											<br />
										</div>
									</div>
								</div>
<?php 				endif;

							$description = get_post_meta( get_the_ID(), $slideId.'_description', true );
							if ($description) : ?>
								<div class="skills">
									<div class="skills_title">
										<strong>description</strong>
									</div>
									<div>
<?php
echo '										'.do_shortcode(nl2br($description)).'<br />'.PHP_EOL;
										unset($description); ?>
										<br />
									</div>
								</div>
<?php 				endif; ?>
							</div>
						</div>
<?php 			++$slideCount;
					endwhile; ?>
					</div>
				</div>
