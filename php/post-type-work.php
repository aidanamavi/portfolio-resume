<?php
/**
  * @package WordPress
  * @subpackage AidanAmavi
  * @version 0.1
  *
  * @author Aidan Amavi <mail@aidanamavi.com>
  * @link http://www.aidanamavi.com Author's Web Site
  * @copyright 2012 - 2015, Aidan Amavi
  * @license https://www.gnu.org/licenses/agpl.html GNU Affero General Public License
  */

add_action('init', 'add_post_type_work');
function add_post_type_work() {
	$labels = array(
		'name' => _x('Work', 'post type general name'),
		'singular_name' => _x('Work', 'post type singular name'),
		'all_items' => __('All Work'),
		'add_new' => _x('Add Work', 'Work'),
		'add_new_item' => __('Add New Work'),
		'edit_item' => __('Edit Work'),
		'new_item' => __('New Work'),
		'view_item' => __('View Work'),
		'search_items' => __('Search Work'),
		'not_found' =>  __('No Work found'),
		'not_found_in_trash' => __('No Work found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Work'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => true,
		'menu_position' => 5,
		'map_meta_cap' => true,
		'supports' => array('author','title','thumbnail','page-attributes')
	);
	register_post_type('work',$args);
}

add_filter( 'enter_title_here', 'add_post_type_work_title' );
function add_post_type_work_title( $input ) {
global $post_type;
if ($post_type == 'work') {
	return __( 'Enter work title here', 'changeMe' );
}
return $input;
}

$roleGroups = array(
	array(
		'creativeProducer'			=> __('Creative Producer', 'changeMe'),
		'creativeDirector'			=> __('Creative Director', 'changeMe'),
		'assistantDirector'			=> __('Assistant Director', 'changeMe'),
	),
	array(
		'webDeveloper'					=> __('Web Developer', 'changeMe'),
		'systemsAdministrator'	=> __('Systems Administrator', 'changeMe'),
		'graphicDesigner'				=> __('Graphic Designer', 'changeMe'),
	),
	array(
		'lightingDesigner'			=> __('Lighting Designer', 'changeMe'),
		'gaffer'								=> __('Gaffer', 'changeMe'),
		'keyGrip'								=> __('Key Grip', 'changeMe'),
		'dollyGrip'							=> __('Dolly Grip', 'changeMe'),
		'bestBoyGrip'						=> __('Best Boy Grip', 'changeMe'),
		'bestBoyElectrician'		=> __('Best Boy Electrician', 'changeMe'),
	),
	array(
		'cinematographer'				=> __('Cinematographer', 'changeMe'),
		'photographer'					=> __('Photographer', 'changeMe'),
		'assistantPhotographer'	=> __('Assistant Photographer', 'changeMe'),
		'retoucher'							=> __('Retoucher', 'changeMe'),
		'editor'								=> __('Editor', 'changeMe'),
		'colorist'							=> __('Colorist', 'changeMe'),
		'boradcastProgrammer'		=> __('Broadcast Programmer', 'changeMe'),
	)
);
$disciplineGroups = array(
	array(
		'broadcastMedia'		=> __('Broadcast Media', 'changeMe'),
		'digitalMedia'			=> __('Digital Media', 'changeMe'),
		'socialMedia'				=> __('Social Media', 'changeMe'),
	),
	array(
		'marketing'					=> __('Marketing', 'changeMe'),
		'marketResearch'		=> __('Market Research', 'changeMe'),
		'advertising'				=> __('Advertising', 'changeMe'),
	),
	array(
		'experienceDesign'	=> __('Experience Design', 'changeMe'),
		'networkDesign'			=> __('Network Design', 'changeMe'),
		'graphicDesign'			=> __('Graphic Design', 'changeMe'),
		'interactiveDesign'	=> __('Interactive Design', 'changeMe'),
		'webDesign'					=> __('Web Design', 'changeMe'),
		'soundDesign'				=> __('Sound Design', 'changeMe'),
		'lightingDesign'		=> __('Lighting Design', 'changeMe'),
	),
	array(
		'systemsAdministration'		=> __('Systems Administration', 'changeMe'),
		'informationArchitecture'	=> __('Information Architecture', 'changeMe'),
		'webDevelopment'					=> __('Web Development', 'changeMe'),
	),
	array(
		'photography'				=> __('Photography', 'changeMe'),
		'videography'				=> __('Videography', 'changeMe'),
		'audiography'				=> __('Audiography', 'changeMe'),
	),
	array(
		'amFmBroadcasting'	=> __('AM/FM Broadcasting', 'changeMe'),
	),
	array(
		'acting'						=> __('Acting', 'changeMe'),
		'copywriting'				=> __('Copywriting', 'changeMe'),
		'composition'				=> __('Composition', 'changeMe'),
	),
	array(
		'talentAcquisition'	=> __('Talent Acquisition', 'changeMe'),
	)
);
$toolGroups = array(
	array(
		'roland'						=> __('Roland', 'changeMe'),
		'zoom'							=> __('Zoom', 'changeMe'),
		'sennheiser'				=> __('Sennheiser', 'changeMe'),
		'rode'							=> __('Rode', 'changeMe'),
		'm-audio'						=> __('M-Audio', 'changeMe'),
	),
	array(
		'canon'							=> __('Canon', 'changeMe'),
		'nikon'							=> __('Nikon', 'changeMe'),
		'sony'							=> __('Sony', 'changeMe'),
		'red'								=> __('RED', 'changeMe'),
	),
	array(
		'matthewsDolly'			=> __('Matthews Dolly', 'changeMe'),
		'spiderDolly'				=> __('Spider Dolly', 'changeMe'),
		'losmandyPortaJib'	=> __('Losmandy Porta-Jib', 'changeMe'),
		'easyrigCinema3'		=> __('Easyrig Cinema 3', 'changeMe'),
	),
	array(
		'autopoles'					=> __('Autopoles', 'changeMe'),
		'backdrops'					=> __('Backdrops', 'changeMe'),
		'comboStands'				=> __('Combo Stands', 'changeMe'),
		'cStands'						=> __('C-Stands', 'changeMe'),
		'cardelliniClamps'	=> __('Cardellini Clamps', 'changeMe'),
		'sandBags'					=> __('Sand Bags', 'changeMe'),
	),
	array(
		'arri'							=> __('Arri', 'changeMe'),
		'bron'							=> __('Bron', 'changeMe'),
		'chimera'						=> __('Chimera', 'changeMe'),
		'kinoFlo'						=> __('Kino Flo', 'changeMe'),
		'litepanels'				=> __('Litepanels', 'changeMe'),
		'moleRichardson'		=> __('Mole Richardson', 'changeMe'),
		'profoto'						=> __('Profoto', 'changeMe'),
	),
	array(
		'beautyDish'				=> __('Beauty Dish', 'changeMe'),
		'flagKit'						=> __('Flag Kit', 'changeMe'),
		'duvetyneMuslin'		=> __('Duvetyne/Muslin', 'changeMe'),
		'gelFilters'				=> __('Gel Filters', 'changeMe'),
		'reflectors'				=> __('Reflectors', 'changeMe'),
		'foils'							=> __('Foil', 'changeMe'),
		'tapes'							=> __('Tapes', 'changeMe'),
		'stingers'					=> __('Stingers', 'changeMe'),
	),
	array(
		'iWork'							=> __('iWork', 'changeMe'),
		'office'						=> __('Office', 'changeMe'),
		'openOffice'				=> __('Open Office', 'changeMe'),
	),
	array(
		'illustrator'				=> __('Illustrator', 'changeMe'),
		'lightroom'					=> __('Lightroom', 'changeMe'),
		'photoshop'					=> __('Photoshop', 'changeMe'),
		'premiere'					=> __('Premiere', 'changeMe'),
		'afterEffects'			=> __('After Effects', 'changeMe'),
		'bridge'						=> __('Bridge', 'changeMe'),
	),
	array(
		'unrealEngine'			=> __('Unreal Engine', 'changeMe'),
		'chaosScope'				=> __('Chaos Scope', 'changeMe'),
	),
	array(
		'finalCutPro'				=> __('Final Cut Pro', 'changeMe'),
	),
	array(
		'live'							=> __('Live', 'changeMe'),
	),
	array(
		'centOs'						=> __('CentOS', 'changeMe'),
		'rhel'							=> __('RHEL', 'changeMe'),
		'macOs'							=> __('Mac OS', 'changeMe'),
		'windows'						=> __('Windows', 'changeMe'),
	),
	array(
		'apache'						=> __('Apache', 'changeMe'),
	),
	array(
		'icecast'						=> __('Icecast', 'changeMe'),
		'shoutcast'					=> __('Shoutcast', 'changeMe'),
	),
	array(
		'wordpress'					=> __('Wordpress', 'changeMe'),
		'piwik'							=> __('Piwik', 'changeMe'),
	),
	array(
		'php'								=> __('PHP', 'changeMe'),
		'mySql'							=> __('MySQL', 'changeMe'),
		'javascript'				=> __('Javascript', 'changeMe'),
		'html'							=> __('HTML', 'changeMe'),
		'css'								=> __('CSS', 'changeMe'),
		'git'								=> __('GIT', 'changeMe'),
	)
);
$productGroups = array(
	array(
		'brandName'				=> __('Brand Name', 'changeMe'),
		'brandLogo'				=> __('Brand Logo', 'changeMe'),
		'fineArt'					=> __('Fine Art', 'changeMe'),
		'graphic'					=> __('Graphic', 'changeMe'),
		'literature'			=> __('Literature', 'changeMe'),
		'photography'			=> __('Photography', 'changeMe'),
	),
	array(
		'act'							=> __('Act', 'changeMe'),
		'show'						=> __('Show', 'changeMe'),
		'commercial'			=> __('Commercial', 'changeMe'),
		'trailer'					=> __('Trailer', 'changeMe'),
		'film'						=> __('Film', 'changeMe'),
		'musicVideo'			=> __('Music Video', 'changeMe'),
		'animation'				=> __('Animation', 'changeMe'),
	),
	array(
		'music'						=> __('Music', 'changeMe'),
		'fieldRecording'	=> __('Field Recording', 'changeMe'),
	),
	array(
		'webSite'					=> __('Web Site', 'changeMe'),
		'webPage'					=> __('Web Page', 'changeMe'),
		'webApp'					=> __('Web App', 'changeMe'),
	),
);
$presentationGroups = array(
	array(
		'goods'						=> __('Goods', 'changeMe'),
		'print'						=> __('Print', 'changeMe'),
		'recording'				=> __('Recording', 'changeMe'),
		'theater'					=> __('Theater', 'changeMe'),
		'cinema'					=> __('Cinema', 'changeMe'),
		'tv'							=> __('TV', 'changeMe'),
		'radio'						=> __('Radio', 'changeMe'),
		'internet'				=> __('Internet', 'changeMe'),
	)
);

/**
 *
 * Check if each custom meta key is in a seperately displayed group.
 *
 */
function isSeparateGroup($metaGroup, $previousEntry, $nextEntry) {
	global $roleGroups;
	global $disciplineGroups;
	global $toolGroups;
	global $productGroups;
	global $presentationGroups;
	$allGroups = array();
	if ($metaGroup === 'roles') {
		$allGroups = $roleGroups;
	} elseif ($metaGroup === 'disciplines') {
		$allGroups = $disciplineGroups;
	} elseif ($metaGroup === 'tools') {
		$allGroups = $toolGroups;
	} elseif ($metaGroup === 'products') {
		$allGroups = $productGroups;
	} elseif ($metaGroup === 'presentations') {
		$allGroups = $productGroups;
	} else {
		error_log('Incorrect metaGroup: '.$metaGroup);
	}
	// Seperate the sub-groups
	foreach($allGroups as $group) {
		static $groupIndex = 0;
		foreach($group as $key => $value) {
			if ($key === $previousEntry) {
				$previousEntryGroup = $groupIndex;
			}
			if ($key === $nextEntry) {
				$nextEntryGroup = $groupIndex;
			}
		}
		++$groupIndex;
	}
	$groupIndex = 0;
	if ($previousEntryGroup === $nextEntryGroup) {
		return false;
	} else {
		return true;
	}
}

function displayMetaLabel($metaGroup, $metaKey) {
	global $roleGroups;
	global $disciplineGroups;
	global $toolGroups;
	global $productGroups;
	global $presentationGroups;
	if ($metaGroup === 'roles') {
		$allGroups = $roleGroups;
	} elseif ($metaGroup === 'disciplines') {
		$allGroups = $disciplineGroups;
	} elseif ($metaGroup === 'tools') {
		$allGroups = $toolGroups;
	} elseif ($metaGroup === 'products') {
		$allGroups = $productGroups;
	} elseif ($metaGroup === 'presentations') {
		$allGroups = $presentationGroups;
	} else {
		error_log('Undefined metaGroup.');
	}
	foreach($allGroups as $group) {
		foreach($group as $key => $label) {
			if ($metaKey === $key) {
				return $label;
			}
		}
	}
}


/* Define the custom box */
add_action( 'add_meta_boxes_work', 'work_image_url_meta_boxes' );
/* Do something with the data entered */
//add_action( 'save_post', 'work_info_save_postdata' );
/* Adds a box to the main column on the Work post type edit screens */
function work_image_url_meta_boxes() {
	add_meta_box(
    'work_info_title_image_url',
    __('Work Image URLs', 'changeMe'),
    'work_image_url_meta_boxes_html',
    'work',
    'normal',
    'high'
  );
}
/* Adds the upload functions for the images. */
add_action('admin_enqueue_scripts', 'image_upload_scripts');
function image_upload_scripts() {
	global $post_type;
	if (($_GET['post_type'] == 'work') || ($post_type == 'work')) {
		error_log('loading upload javascript');
    wp_enqueue_media();
    wp_register_script('upload-slide-image', get_bloginfo('template_url').'/js/upload-slide-image.js', array('jquery'));
    wp_enqueue_script('upload-slide-image');
  }
}
/* Prints the box content */
function work_image_url_meta_boxes_html($post, $arguments) {
	printf(
		'<p><strong>%1$s</strong></p>',
		__('Title Image URL', 'changeMe')
	);
	$saved = get_post_meta( $post->ID, 'title_image_url', true );
	$label = __('Enter a URL or upload an image', 'changeMe');
	if ($saved) {
		$imageUrl = $saved;
	} else {
		$imageUrl = '';
	}
  printf(
    '<input type="text" name="title_image_url" value="%1$s" id="title_image_url" style="width: 100&#37;; margin-bottom: 10px;" />'.
		'<input type="button" value="Upload Image" class="button button-small upload_button" id="title_image_button" />'.
    '<label for="title_image_url"> %2$s </label>',
    esc_attr($imageUrl),
		esc_html($label)
  );
	echo '</p><hr>';

	printf(
		'<p><strong>%1$s</strong></p>',
		__('Work Page Image URL', 'changeMe')
	);
	$saved = get_post_meta( $post->ID, 'work_page_image_url', true );
	$label = __('Enter a URL or upload an image', 'changeMe');
	if ($saved) {
		$imageUrl = $saved;
	} else {
		$imageUrl = '';
	}
  printf(
    '<input type="text" name="work_page_image_url" value="%1$s" id="work_page_image_url" style="width: 100&#37;; margin-bottom: 10px;" />'.
		'<input type="button" value="Upload Image" class="button button-small upload_button" id="work_page_image_button" />'.
    '<label for="title_image_url"> %2$s </label>',
    esc_attr($imageUrl),
		esc_html($label)
  );
	echo '</p>';
}

$numberOfSlides = 4;
/* Define the custom box */
add_action( 'add_meta_boxes_work', 'slide_info_add_custom_box' );
/* Do something with the data entered */
add_action( 'save_post', 'slide_info_save_postdata' );
/* Adds a box to the main column on the Work post type edit screens */
function slide_info_add_custom_box() {
	global $numberOfSlides;
	$slideNumber = 0;
	while ($numberOfSlides > 0){
		++$slideNumber;
		--$numberOfSlides;
		add_meta_box(
	    'slide_info_sectionid'.$slideNumber,
	    __('Slide Info', 'changeMe').' '.$slideNumber,
	    'slide_info_html_custom_box',
	    'work',
	    'normal',
	    'high',
			array('slideNumber'=>$slideNumber)
	  );
	}
}
/* Prints the box content */
function slide_info_html_custom_box($post, $arguments) {
  // Use nonce for verification.
  wp_nonce_field( 'work_info_field_nonce', 'work_info_noncename' );

	$slideNumber = $arguments['args']['slideNumber'];
	$slideId = 'slide_'.$slideNumber;

	printf(
		'<p><strong>%1$s</strong></p>',
		__('Project Slide', 'changeMe')
	);
	$saved = get_post_meta( $post->ID, $slideId.'_url', true );
	$label = __('Enter a URL or upload an image', 'changeMe');
	if ($saved) {
		$imageUrl = $saved;
	} else {
		$imageUrl = '';
	}
  printf(
    '<input type="text" name="'.$slideId.'_url" value="%1$s" id="'.$slideId.'_url" style="width: 100&#37;; margin-bottom: 10px;" />'.
		'<input type="button" value="Upload Image" class="button button-small upload_button" id="'.$slideId.'_button" />'.
    '<label for="'.$slideId.'_url"> %2$s </label>'.
		'<br /><br />',
    esc_attr($imageUrl),
		esc_html($label)
  );

	$saved = get_post_meta( $post->ID, $slideId.'_youtube_url', true );
	$label = __('Slide YouTube URL', 'changeMe');
	if ($saved) {
		$imageUrl = $saved;
	} else {
		$imageUrl = '';
	}
  printf(
    '<input type="text" name="'.$slideId.'_youtube_url" value="%1$s" id="'.$slideId.'_youtube_url" style="width: 100&#37;; margin-bottom: 10px;" />'.
    '<label for="'.$slideId.'_youtube_url"> %2$s ' .
    '</label><br />',
    esc_attr($imageUrl),
		esc_html($label)
  );
	echo '</p><hr>';

	printf(
		'<p><strong>%1$s</strong></p>',
		__('Project Roles', 'changeMe')
	);
  $saved = get_post_meta( $post->ID, $slideId.'_roles', true );
  global $roleGroups;
	echo '<p>';
	foreach($roleGroups as $group) {
	  foreach($group as $key => $label) {
			if (!empty($prevRole) && isSeparateGroup('roles', $prevRole, $key)) {
				echo '<br />';
			}
			if (!empty($saved)) {
				if (in_array($key, $saved)) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}
			}
	    printf(
	      '<input type="checkbox" name="'.$slideId.'_roles[]" value="%1$s" id="'.$slideId.'_roles[%1$s]" %3$s />'.
	      '<label for="'.$slideId.'_roles[%1$s]"> %2$s ' .
	      '</label><br />',
	      esc_attr($key),
	      esc_html($label),
				$checked
	    );
			$prevRole = $key;
			unset($checked);
	  }
	}
	unset($prevRole);
	echo '</p><hr>';

	printf(
		'<p><strong>%1$s</strong></p>',
		__('Project Disciplines', 'changeMe')
	);
  $saved = get_post_meta( $post->ID, $slideId.'_disciplines', true );
  global $disciplineGroups;
	echo '<p>';
	foreach($disciplineGroups as $group) {
	  foreach($group as $key => $label) {
			if (!empty($prevDiscipline) && isSeparateGroup('disciplines', $prevDiscipline, $key)) {
				echo '<br />';
			}
			if (!empty($saved)) {
				if (in_array($key, $saved)) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}
			}
	    printf(
	      '<input type="checkbox" name="'.$slideId.'_disciplines[]" value="%1$s" id="'.$slideId.'_disciplines[%1$s]" %3$s />'.
	      '<label for="'.$slideId.'_disciplines[%1$s]"> %2$s ' .
	      '</label><br />',
	      esc_attr($key),
	      esc_html($label),
				$checked
	    );
			$prevDiscipline = $key;
			unset($checked);
	  }
	}
	unset($prevDiscipline);
	echo '</p><hr>';

	printf(
		'<p><strong>%1$s</strong></p>',
		__('Project Tools', 'changeMe')
	);
  $saved = get_post_meta( $post->ID, $slideId.'_tools', true );
  global $toolGroups;
	echo '<p>';
	foreach ($toolGroups as $groups) {
	  foreach($groups as $key => $label) {
			if (!empty($prevTool) && isSeparateGroup('tools', $prevTool, $key)) {
				echo '<br />';
			}
			if (!empty($saved)) {
				if (in_array($key, $saved)) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}
			}
	    printf(
	      '<input type="checkbox" name="'.$slideId.'_tools[]" value="%1$s" id="'.$slideId.'_tools[%1$s]" %3$s />'.
	      '<label for="'.$slideId.'_tools[%1$s]"> %2$s ' .
	      '</label><br />',
	      esc_attr($key),
	      esc_html($label),
				$checked
	    );
			$prevTool = $key;
			unset($checked);
	  }
	}
	unset($prevTool);
	echo '</p><hr>';

	printf(
		'<p><strong>%1$s</strong></p>',
		__('Project Products', 'changeMe')
	);
  $saved = get_post_meta( $post->ID, $slideId.'_products', true );
  global $productGroups;
	echo '<p>';
	foreach ($productGroups as $group) {
	  foreach($group as $key => $label) {
			if (!empty($prevProduct) && isSeparateGroup('products', $prevProduct, $key)) {
				echo '<br />';
			}
			if (!empty($saved)) {
				if (in_array($key, $saved)) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}
			}
	    printf(
	      '<input type="checkbox" name="'.$slideId.'_products[]" value="%1$s" id="'.$slideId.'_products[%1$s]" %3$s />'.
	      '<label for="'.$slideId.'_products[%1$s]"> %2$s ' .
	      '</label><br />',
	      esc_attr($key),
	      esc_html($label),
				$checked
	    );
			$prevProduct = $key;
			unset($checked);
	  }
	}
	unset($prevProduct);
	echo '</p><hr>';

	printf(
		'<p><strong>%1$s</strong></p>',
		__('Project Presentation', 'changeMe')
	);
  $saved = get_post_meta( $post->ID, $slideId.'_presentations', true );
  global $presentationGroups;
	echo '<p>';
	foreach ($presentationGroups as $groups) {
	  foreach($groups as $key => $label) {
			if (!empty($prevPresentation) && isSeparateGroup('presentations', $prevPresentation, $key)) {
				echo '<br />';
			}
			if (!empty($saved)) {
				if (in_array($key, $saved)) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}
			}
	    printf(
	      '<input type="checkbox" name="'.$slideId.'_presentations[]" value="%1$s" id="'.$slideId.'_presentations[%1$s]" %3$s />'.
	      '<label for="'.$slideId.'_presentations[%1$s]"> %2$s ' .
	      '</label><br />',
	      esc_attr($key),
	      esc_html($label),
				$checked
	    );
			$prevPresentation = $key;
			unset($checked);
	  }
	}
	unset($prevTool);
	echo '</p>';
}
/**
	* When the post is saved, saves our custom data.
	* @param $post_id
	*/
function slide_info_save_postdata( $post_id )
{
  // If auto-save action, do nothing.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
	}
  // Validate cross-site request forgery security token.
  if (!wp_verify_nonce($_POST['work_info_noncename'], 'work_info_field_nonce')) {
    return;
	}

	// @todo reduce code, by creating a sanatize function for URLs.
	if ( isset($_POST['title_image_url']) && $_POST['title_image_url'] !== '' ){
		$titleImageUrl = esc_url_raw($_POST['title_image_url']);
		$sanatizedUrl = filter_var($titleImageUrl, FILTER_SANITIZE_URL);
		if (filter_var($sanatizedUrl, FILTER_VALIDATE_URL)) {
			update_post_meta( $post_id, 'title_image_url', $sanatizedUrl );
		} else {
			error_log('Invalid URL type detected for title image url.');
		}
	} else {
		delete_post_meta($post_id, 'title_image_url'  );
	}
	if ( isset($_POST['work_page_image_url']) && $_POST['work_page_image_url'] !== '' ){
		$workPageImageUrl = esc_url_raw($_POST['work_page_image_url']);
		$sanatizedUrl = filter_var($workPageImageUrl, FILTER_SANITIZE_URL);
		if (filter_var($sanatizedUrl, FILTER_VALIDATE_URL)) {
			update_post_meta( $post_id, 'work_page_image_url', $sanatizedUrl );
		} else {
			error_log('Invalid URL type detected for work page image url.');
		}
	} else {
		delete_post_meta($post_id, 'work_page_image_url'  );
	}

	global $numberOfSlides;
	$slideNumber = 0;
	while ($numberOfSlides > 0){
		++$slideNumber;
		--$numberOfSlides;
		$slideId = 'slide_'.$slideNumber;
		$slideDetected = false;

		if ( isset($_POST[$slideId.'_url']) && $_POST[$slideId.'_url'] !== '' ){
			$slideImageUrl = esc_url_raw($_POST[$slideId.'_url']);
			$sanatizedUrl = filter_var($slideImageUrl, FILTER_SANITIZE_URL);
			if (filter_var($sanatizedUrl, FILTER_VALIDATE_URL)) {
				update_post_meta( $post_id, $slideId.'_url', $sanatizedUrl );
				$slideDetected = true;
			} else {
				error_log('Invalid URL type detected for image slide.');
			}
			$slideDetected = true;
	  } else {
	  	delete_post_meta($post_id, $slideId.'_url'  );
	  }
		if ( isset($_POST[$slideId.'_youtube_url']) && $_POST[$slideId.'_youtube_url'] !== '' ){
			$slideYouTubeUrl = esc_url_raw($_POST[$slideId.'_youtube_url']);
			$sanatizedUrl = filter_var($slideYouTubeUrl, FILTER_SANITIZE_URL);
			if (filter_var($sanatizedUrl, FILTER_VALIDATE_URL)) {
	    	update_post_meta( $post_id, $slideId.'_youtube_url', $sanatizedUrl );
				$slideDetected = true;
			} else {
				error_log('Invalid URL type detected for YouTube slide.');
			}
	  } else {
	  	delete_post_meta($post_id, $slideId.'_youtube_url'  );
	  }
		if ($slideDetected) {
			++$slideTotal;
		}
	  if ( isset($_POST[$slideId.'_products']) && $_POST[$slideId.'_products'] !== '' ){
	    update_post_meta( $post_id, $slideId.'_products', $_POST[$slideId.'_products'] );
	  } else {
	  	delete_post_meta($post_id, $slideId.'_products'  );
	  }
		if ( isset($_POST[$slideId.'_roles']) && $_POST[$slideId.'_roles'] !== '' ){
	    update_post_meta( $post_id, $slideId.'_roles', $_POST[$slideId.'_roles'] );
	  } else {
	  	delete_post_meta($post_id, $slideId.'_roles'  );
	  }
		if ( isset($_POST[$slideId.'_disciplines']) && $_POST[$slideId.'_disciplines'] !== '' ){
	    update_post_meta( $post_id, $slideId.'_disciplines', $_POST[$slideId.'_disciplines'] );
	  } else {
	  	delete_post_meta($post_id, $slideId.'_disciplines'  );
	  }
		if ( isset($_POST[$slideId.'_tools']) && $_POST[$slideId.'_tools'] !== '' ){
	    update_post_meta( $post_id, $slideId.'_tools', $_POST[$slideId.'_tools'] );
	  } else {
	  	delete_post_meta($post_id, $slideId.'_tools'  );
	  }
		if ( isset($_POST[$slideId.'_presentations']) && $_POST[$slideId.'_presentations'] !== '' ){
	    update_post_meta( $post_id, $slideId.'_presentations', $_POST[$slideId.'_presentations'] );
	  } else {
	  	delete_post_meta($post_id, $slideId.'_presentations'  );
	  }
	}
	update_post_meta( $post_id, 'slideTotal', $slideTotal );
}
 ?>
