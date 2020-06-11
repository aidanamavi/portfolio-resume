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

jQuery(document).ready( function() {
	var custom_uploader;
	var input;
  jQuery(document).on('click', '.upload_button', function(event) {
    event.preventDefault();
		var button = jQuery(this);
		input = button.prev('input').attr('id');
    // If the uploader object has already been created, reopen the dialog.
		if (custom_uploader) {
      custom_uploader.open();
      return;
    }
    // Extend the wp.media object.
    custom_uploader = wp.media.frames.file_frame = wp.media({
      title: 'Choose Image',
      button: {
        text: 'Choose Image'
      },
      multiple: false
    });
    // When a file is selected, grab the URL and set it as the text field's value.
    custom_uploader.on('select', function() {
      attachment = custom_uploader.state().get('selection').first().toJSON();
      jQuery('#'+input).val(attachment.url);
    });
    // Open the uploader dialog.
    custom_uploader.open();
  });
});
