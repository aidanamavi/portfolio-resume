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
	$siteTitle = bloginfo('name');
	$pageTitle = get_the_title();
	$viewType;
	$postType = get_post_type();
	$pageSeperator = ' &rsaquo; ';
	$newSiteTitle;

	if(is_single()){
		$viewType = 'single';
	} else if (is_archive()){
		if (is_category()){
			global $cat;
			$viewType = 'category';
			$pageTitle = get_cat_name($cat);
		} else {
			$viewType = 'archive';
		}
	}

	if($viewType === 'category'){
		$newSiteTitle = $siteTitle.$pageSeperator.$postType.$pageSeperator.$viewType.$pageSeperator.$pageTitle;
	} else if ($viewType === 'archive') {
		$newSiteTitle = $siteTitle.$pageSeperator.$postType.$pageSeperator.$viewType;
	} else if ($viewType === 'single'){
		$newSiteTitle = $siteTitle.$pageSeperator.$postType.$pageSeperator.$pageTitle;
	}
	echo ucwords($newSiteTitle);
}

?>
