<?php
/**
* @package WordPress
* @subpackage AidanAmavi
* @version 0.2
*
* @author Aidan Amavi <mail@aidanamavi.com>
* @link https://www.aidanamavi.com Author's Web Site
* @copyright 2012 - 2020, Aidan Amavi
* @license https://www.gnu.org/licenses/agpl.html GNU Affero General Public License
*/


function custom_meta_description() {
	global $post;
	function prepare_content($content){
		$content = ucfirst(trim(strip_tags($content)));
		// Remove shortcodes, but leave content.
		$content = preg_replace('/\[.*?\]/', '', $content);
		// Remove new lines.
		$content = preg_replace('~[\r\n]+~', ' ', $content);
		// Removes everything except these characters.
		$content = preg_replace('/[^a-zA-Z0-9_.\-,\s]/', '', $content);
		// Remove extra spaces.
		$content = preg_replace('/\s+/', ' ', $content);
		// Shortens length. May not be needed. Testing with Google indexing.
		if (strlen($content) > 4000) {
			$content = substr($content, 0, 4000).'...';
		}
		return $content;
	}
	if (is_single()) {
		if ($post->post_type === 'work') {
			$description = prepare_content(get_post_meta( get_the_ID(), 'slide_1_description', true ));
		} elseif ($post->post_type === 'blog') {
			if (have_posts()) {
				while(have_posts()) {
					the_post();
					$description = prepare_content(get_the_content());
				}
			}
		}
	} elseif (is_home() || is_page()) {
		$description =  get_bloginfo( 'description' );
	} elseif (is_category()) {
		$description =  prepare_content(category_description());
	} elseif (is_archive()) {
		$description =  'Archive of all '.$post->post_type.' posts.';
	} elseif (is_tag()) {
		$description =  'Archive of all posts with the tag "'.prepare_content(single_tag_title('', FALSE)).'".';
	}
	if (empty($description)) {
		$description =  get_bloginfo( 'description' );
	}
	echo $description;
}

?>
