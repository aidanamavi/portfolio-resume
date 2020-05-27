<?php
/**
	* The template for displaying the footer
	*
	* @package WordPress
	* @subpackage AidanAmavi
	* @version 0.2
	*
	* @author Aidan Amavi <mail@aidanamavi.com>
	* @link http://www.aidanamavi.com Author's Web Site
	* @copyright 2012 - 2020, Aidan Amavi
	* @license https://www.gnu.org/licenses/agpl.html GNU Affero General Public License
	*/
?>
			</div>
			<footer>
<?php		$trackerUrl = get_theme_mod('matomo_tracker_url_textbox');
				$trackerId = get_theme_mod('matomo_site_id_textbox');
				if ($trackerUrl && $trackerId) : ?>
				<!-- Matomo -->
				<script type="text/javascript">
				var _paq = _paq || [];
				_paq.push(['trackPageView']);
				_paq.push(['enableLinkTracking']);
					(function() {
				    var u="<?php echo $trackerUrl; ?>";
				    _paq.push(['setTrackerUrl', u+'matomo.php']);
				    _paq.push(['setSiteId', <?php echo $trackerId; ?>]);
				    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
				    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
				  })();
				</script>
				<noscript>
					<p>
						<img src="<?php echo $trackerUrl; ?>matomo.php?idsite=<?php echo $trackerId; ?>" style="border:0;" alt="" />
					</p>
				</noscript>
				<!-- End Matomo Code -->
<?php 	endif; ?>
			</footer>
		</div>
	</body>
</html>
