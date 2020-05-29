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

function customize_seo_keywords( $wp_customize ) {
  $wp_customize->add_section(
      'seo_section',
      array(
        'title' => 'SEO Keywords',
        'priority' => 35,
      )
  );
	$wp_customize->add_setting(
    'seo_keywords_textbox',
    array(
      'default' => 'portfolio, resume, blog',
			'transport'   => 'postMessage',
    )
	);
	$wp_customize->add_control(
    'seo_keywords_textbox',
    array(
      'label' => 'Keywords',
      'section' => 'seo_section',
      'type' => 'text',
    )
	);
}
add_action( 'customize_register', 'customize_seo_keywords' );

?>
