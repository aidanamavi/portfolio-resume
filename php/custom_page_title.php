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

// Add custom page title.
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

?>
