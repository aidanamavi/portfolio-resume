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
/*global _paq, alert, siteName, category, userId, nonce*/
jQuery(document).ready( function() {
	// Configurable settings.
	var homepageDiv = 'page_archive_work';
	// Dynamic settings.
	var ajaxurl = window.location.protocol+'//'+window.location.host+'/wp-admin/admin-ajax.php';
	var visiblePage = jQuery('.content_wrapper :visible').attr('id');
	var pageReferrerUrl = document.referrer || document.location.href;
	var isPageLoading = false;
	var isSlideLoading = false;
	var isThumbnailLoading = false;
	var currentProjectType = 'all';
	var isTrackingOn = (typeof _paq === 'undefined') ? false : true;
	var state = window.history.state;
String.prototype.capitalize = function() {
  return this.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });
};
function updateVisiblePage() {
		visiblePage = jQuery('.content_wrapper :visible').attr('id');
		// Enables checking for new posts since visiblePage was last viewed.
		areAllPostsLoaded = false;
	}
	function showLoadingAnimation() {
		isPageLoading = true;
		jQuery('.loading_animation').stop().show().animate({'opacity': '.85'},750);
	}
	function hideLoadingAnimation() {
		jQuery('.loading_animation').stop().animate({'opacity': '0'},1000, function(){
			jQuery('.loading_animation').hide();
			isPageLoading = false;
			//updateVisiblePage();
		});
	}
	function addHighlightSlideCursor() {
		jQuery('div.highlight_slides').each( function(){
			var divs = jQuery(this);
			var the_count = divs.children().length;
			if (the_count > 1) {
				divs.children().css('cursor', 'pointer');
			}
		});
	}
	function displayPage(pageDiv, pageUrl, pageContent) {
		jQuery('#'+visiblePage).stop().animate({'opacity':'0'},750, function() {
			jQuery('#'+visiblePage).hide( function() {
				if (pageContent) {
					jQuery('.content_wrapper').css('opacity', '0');
					jQuery('.content_wrapper').append(pageContent);
					jQuery('.content_wrapper').animate({'opacity':'1'},750);
					addHighlightSlideCursor();
				} else {
					jQuery('#'+pageDiv).show().animate({'opacity':'1'},750);
				}
				var pageTitle = jQuery('#'+pageDiv).data('pageTitle');
				updateCategory(pageDiv);
				updateVisiblePage();
				updateTitle(pageTitle);
				if (pageUrl) {
					updateUrl(pageUrl);
				}
				history.replaceState({pageDiv: pageDiv, pageUrl: pageUrl}, pageTitle, pageUrl);
				hideLoadingAnimation();
			});
		});
	}
	function transitionSlide(pageId, oldSlide, newSlide) {
		var newSlideElement = jQuery('div#'+pageId+' .highlight_slides div[data-slide='+newSlide+']');
		var oldSlideElement = jQuery('div#'+pageId+' .highlight_slides div[data-slide='+oldSlide+']');
		// Show next slide, and hide visible slide.
		newSlideElement.stop().css('z-index','10').stop().show().animate({'opacity':'1'},250, function() {
			oldSlideElement.stop().animate({'opacity':'0'},250, function(){
				oldSlideElement.hide();
				newSlideElement.css('z-index','5');
				trackAction(pageId, newSlide);
				isSlideLoading = false;
			});
		});
		var buttonList = jQuery('#'+pageId+' .numbers_wrapper .numbers');
		var newButtonImage = buttonList.children('[data-slide='+newSlide+']').children('img.off');
		var oldButtonImage = buttonList.children('[data-slide='+oldSlide+']').children('img.off');
		// Make the off button visible to turn off highlight.
		oldButtonImage.stop().show().animate({'opacity':'1'},300);
		// Make the off button invisible to turn on highlight. Then hide.
		newButtonImage.stop().animate({'opacity':'0'},300, function(){
			newButtonImage.hide();
		});
	}
	function isEmpty( element ){
		return !$.trim( element.html() );
	}
	function loadPage(pageUrl, page, postType, id) {
		if (isPageLoading) { return; }
		pageDiv = 'page_'+page;
		if (postType) {	pageDiv += '_'+postType; }
		if (id) { pageDiv += '_'+id; }
		if (pageDiv === visiblePage) { return; }
		showLoadingAnimation();
		if (isEmpty(jQuery('#'+pageDiv))) {
			// Fetch new page.
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {action: 'getAjaxData', page: page, postType: postType, id: id, token: window.nonce },
				success: function(pageContent) {
					displayPage(pageDiv, pageUrl, pageContent);
				},
				error: function(xhr){
					if (xhr.status === 403) {
						displayPage('page_error_403', false, xhr.responseText);
					} else {
						hideLoadingAnimation();
					}
				}
			});
		} else {
			// Show cached page.
			displayPage(pageDiv, pageUrl);
		}
	}
	function trackPage(pageUrl, pageTitle) {
		if (!isTrackingOn) { return; }
		pageUrl = pageUrl || document.location.href;
		pageTitle = pageTitle || window.document.title;
		_paq.push(['setCustomUrl', pageUrl]);
		_paq.push(['setDocumentTitle', pageTitle]);
		_paq.push(['setReferrerUrl', pageReferrerUrl]);
		_paq.push(['trackPageView']);
	}
	function trackAction(pageName, slideNumber) {
		// trackEvent(category, action, [name], [value])
		if (!isTrackingOn) { return; }
		pageName = jQuery('#'+pageName).data('pageTitle');
		slideNumber = 'Slide '+slideNumber;
		_paq.push(['trackEvent', 'Slides', pageName, slideNumber]);
	}
	function updateCategory(pageDiv) {
		var categoryInfo = pageDiv.split('_');
		if (categoryInfo[1] === 'category') {
			window.categoryId = categoryInfo[2];
			window.categoryName = categoryInfo[1];
		} else {
			window.categoryName = categoryInfo[2];
		}
	}
	function updateTitle(pageTitle) {
		var pageSeperator = ' › ';
		title = siteName;
		if (window.categoryName.length > 0) {
			if (pageTitle.toLowerCase() !== window.categoryName.toLowerCase()) {
				title += pageSeperator+window.categoryName.capitalize();
			}
		}
		title += pageSeperator+pageTitle;
		window.document.title = title;
	}
	function updateUrl(pageUrl) {
		pageReferrerUrl = document.location.href;
		pageUrl = urlParser(pageUrl, 'path');
		trackPage();
	}
	function urlParser(url, returnBack) {
		// The element allows us to access the location object.
		var element = document.createElement('a');
		element.href = url;
		// Now we can use the location object to parse the pathname.
		url = element.pathname;
		// Split the pathname.
		url = url.split(/[\\/]/);
		// Remove empty array elements.
		url = jQuery.grep(url, function(element) { return(element); });
		if (returnBack === 'divId') {
			var divId = 'page_';
			var index = 0;
			var seperator = '';
			url.forEach(function(entry) {
				if (index > 0) { seperator = '_'; }
				divId += seperator+entry;
				++index;
			});
			// If there is no pathname.
			if (divId === 'page_') {
				// Show this div for homepage.
				divId = homepageDiv;
			}
			return divId;
		} else if (returnBack === 'array') {
			// If there is no folder detected.
			if (typeof url[1] === 'undefined') {
				// Add index as the folder for AJAX to process.
				url.unshift('archive');
			}
			return url;
		} else if (returnBack === 'path') {
			url = element.pathname;
			return url;
		}
	}
	// First page load.
	jQuery('html').animate({'opacity':'1'},500, function() {
		jQuery('.content_wrapper').delay(750).animate({'opacity':'1'},1000);
	});
	window.onload = function() {
		jQuery('nav').animate({'opacity':'1'},1000);
		hideLoadingAnimation();
	};
	addHighlightSlideCursor();
	// Back and forward navigation event handlers.
	jQuery(window).bind('popstate', function(event) {
		var pageUrl; state = window.history.state;
		if (!state) {
			var pageTitle = window.document.title;
			pageUrl = document.location.pathname;
			history.replaceState({pageDiv: visiblePage, pageUrl: pageUrl}, pageTitle, pageUrl);
			state = window.history.state;
		} else if (state) {
			pageUrl = state.pageUrl;
			var pageDiv = state.pageDiv.split('_');
			var page = pageDiv[1];
			var postType = pageDiv[2];
			var id = pageDiv[3];
			loadPage(pageUrl, page, postType, id);
		}
	});
	// Mouse over effects for the navigation.
	jQuery('nav img.off').hover(
		function() {
			jQuery(this).stop().animate({'opacity': '0'},250); },
		function() {
			jQuery(this).stop().animate({'opacity': '1'},250);
	});
	// Link click event handlers for pages, posts, categories, and outlinks.
	jQuery(document).on('click', 'a', function(event){
		function internalLink() {
			event.preventDefault();
			event.stopPropagation();
		}
		// Safari triggers popstate automatically.
		// This is a fallback for other browsers.
		if (!state) {
			jQuery(window).trigger('popstate');
		}
		var pagePath; var link = jQuery(this);
		var linkType = link.data('linkType');
		var pageUrl = urlParser(link.attr('href'), 'path');
		var page = link.data('page');
		var postType = link.data('postType');
		if (linkType === 'headerNavigation') {
			internalLink();
			history.pushState(null, null, pageUrl);
			loadPage(pageUrl, page, postType);
		} else if (linkType === 'workNavigation') {
			internalLink();
			history.pushState(null, null, pageUrl);
			var projectType = link.data('projectType');
			if (!isThumbnailLoading && projectType !== currentProjectType) {
				isThumbnailLoading = true;
				$('#page_archive_work .row').fadeOut(1000, function() {
					$('#page_archive_work .column').hide();
					$('#page_archive_work .column[data-project-type~="'+projectType+'"]').show();
					$('#page_archive_work .row').fadeIn(1000, function() {
						currentProjectType = projectType;
						isThumbnailLoading = false;
					});
				});
			}
		} else if (linkType === 'postNavigation') {
			var postId = link.data('postId');
			var categoryId = link.data('categoryId');
			internalLink();
			history.pushState(null, null, pageUrl);
			var id = postId || categoryId;
			pagePath = '/'+postType+'/'+id;
			loadPage(pageUrl, page, postType, id);
		}
	});
	// Link click event handlers for slide navigation.
	jQuery(document).on('click', '.content_wrapper div .numbers_wrapper .numbers div', function(){
		var button = jQuery(this);
		var pageId = button.parent().parent().parent().attr('id');
		var newSlide = button.data('slide');
		var oldSlide = jQuery('#'+pageId+' .highlight_slides > div:visible').data('slide');
		if (oldSlide !== newSlide && !isSlideLoading) {
			isSlideLoading = true;
			transitionSlide(pageId, oldSlide, newSlide);
		}
	});
	jQuery(document).on('click', '.content_wrapper div .highlight_slides div img.highlight', function(){
		var slide = jQuery(this).parent();
		var pageId = slide.parent().parent().attr('id');
		var oldSlide = slide.data('slide');
		var totalDivs = slide.parent().children().length;
		if (totalDivs > 1 && !isSlideLoading) {
			isSlideLoading = true;
			var nextDiv = slide.next('div');
			var newSlide;
			if (nextDiv.length === 0) {
				nextDiv = slide.prevAll('div').last();
				newSlide = nextDiv.data('slide');
			} else {
				newSlide = nextDiv.data('slide');
			}
			transitionSlide(pageId, oldSlide, newSlide);
		}
	});
	/**
	 * Infinite scrolling.
	 *
	 * areAllPostsLoaded resets with function updateVisiblePage.
	 * uses isPageLoading.
	 */
	var categoryId, offsetPosts, areAllPostsLoaded, windowHeight, scrollPosition;
	categoryId = window.categoryId;
	jQuery(window).scroll(function() {
		windowHeight = jQuery(document).height() - jQuery(window).height();
		scrollPosition = jQuery(window).scrollTop() + 200;
		if (scrollPosition >= windowHeight && !areAllPostsLoaded && !isPageLoading) {
			if (jQuery('#page_category_'+categoryId).is(':visible')) {
				showLoadingAnimation();
				offsetPosts = jQuery('#page_category_'+categoryId+' > article').length;
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {action: 'getAjaxData', category: categoryId, offset: offsetPosts, token: window.nonce },
					success: function(response) {
						if (response === '') {
							areAllPostsLoaded = true;
						} else {
							jQuery('#page_category_'+categoryId+':last-child').append(response);
						}
					},
					error: function(xhr){
						if (xhr.status === 403) {
							displayPage('page_error_403', false, xhr.responseText);
						}
					},
					complete: function() {
						hideLoadingAnimation();
					}
				});
			} else if (jQuery('#page_archive_blog').is(':visible')) {
				showLoadingAnimation();
				offsetPosts = jQuery('#page_archive_blog > article').length;
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {action: 'getAjaxData', category: '', offset: offsetPosts, token: window.nonce },
					success: function(response) {
						if (response === '') {
							areAllPostsLoaded = true;
						} else {
							jQuery('#page_archive_blog:last-child').append(response);
						}
					},
					error: function(xhr){
						if (xhr.status === 403) {
							displayPage('page_error_403', false, xhr.responseText);
						}
					},
					complete: function() {
						hideLoadingAnimation();
					}
				});
			}
		}
	});
});