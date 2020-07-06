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
/**
 * To debug, find all "// console.log" and replace with "// console.log"
 */
 /*global _paq, alert, siteTitle, category, userId, nonce*/
jQuery(document).ready( function() {
	// Configurable settings.
	var homepageDiv = 'page_archive_work';
	// Dynamic settings.
	var ajaxurl = window.location.protocol+'//'+window.location.host+'/wp-admin/admin-ajax.php';
	var visiblePage = jQuery('#content_wrapper :visible').attr('id');
	var pageReferrerUrl = document.referrer || document.location.href;
	var isPageLoading = false;
	var isSlideLoading = false;
	var isThumbnailLoading = false;
	var currentProjectType = 'all';
	var isTrackingOn = (typeof _paq === 'undefined') ? false : true;
	var state = window.history.state;

// TODO: Why does state still return null after replacing?
	function initiateState() {
		// console.log('initiateState()');
		// If missing a window history state
		if (!state) {
			var pageUrl = document.location.href;
			var pageTitle = window.document.title;
			var viewType = jQuery('#'+visiblePage).data('viewType');
			var postType = jQuery('#'+visiblePage).data('postType');
			var postId = jQuery('#'+visiblePage).data('postId');
			var pageState = {'pageUrl': pageUrl, 'viewType': viewType, 'postType': postType, 'postId': postId};
			// console.log('Missing state');
			// console.log(pageState);
			// console.log('replaceState({pageUrl: ' + pageUrl + ', viewType: ' + viewType + ', postType: ' + postType + ', postId: ' + postId + '},' + pageTitle + ',' + pageUrl + ')');
			history.replaceState(pageState, pageTitle, pageUrl);
			// console.log('New state');
			// console.log(state);
		} else {
			// console.log('State detected');
			// console.log(state);
		}
	}
	String.prototype.capitalize = function() {
	  return this.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });
	};
	function updateVisiblePage() {
		visiblePage = jQuery('#content_wrapper :visible').attr('id');
		// console.log('updateVisiblePage('+visiblePage+')');
		// Enables checking for new posts since visiblePage was last viewed.
		areAllPostsLoaded = false;
	}
	function showLoadingAnimation() {
		// console.log('showLoadingAnimation()');
		isPageLoading = true;
		jQuery('#loading_animation').stop().show().animate({'opacity': '1'},500);
	}
	function hideLoadingAnimation() {
		// console.log('hideLoadingAnimation()');
		jQuery('html').animate({ scrollTop: 0 }, 1, function(){
			jQuery('#loading_animation').stop().animate({'opacity': '0'},500, function(){
				jQuery('#loading_animation').hide();
				isPageLoading = false;
				updateVisiblePage();
			});
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
	function loadPage(pageUrl, viewType, postType, postId, isPushHistory) {
		if (isPushHistory === undefined) { isPushHistory = true; }
		// console.log('function loadPage(' + pageUrl + ',' + viewType + ',' + postType + ',' + postId + ',' + isPushHistory + ')');
		if (isPageLoading) { return; }
		var pageDiv = getPageDiv(postType, postId);
		if (pageDiv === visiblePage) { return; }
		// console.log('function ajax({action: getAjaxData, viewType: '+viewType+', postType: '+postType+', postId: '+postId+', token: '+window.nonce+' })');
		showLoadingAnimation();
		if (isEmpty(jQuery('#'+pageDiv))) {
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {action: 'getAjaxData', viewType: viewType, postType: postType, postId: postId, token: window.nonce },
				success: function(pageContent) {
					displayPage(pageDiv, pageUrl, pageContent);
				},
				error: function(xhr){
					// console.log('AJAX error');
					if (xhr.status === 403) {
						displayPage('page_error_403', false, xhr.responseText);
					} else {
						// console.log(xhr.responseText);
						// console.log(xhr.status);
						hideLoadingAnimation();
					}
				}
			});
		} else {
			// console.log('Detected cached content');
			displayPage(pageDiv, pageUrl);
		}
		// If not going back in history, add new history entry
		if (isPushHistory) {
			var pageTitle = jQuery('#'+pageDiv).data('pageTitle');
			updateBrowserHistory({pageUrl: pageUrl, viewType: viewType, postType: postType, postId: postId}, pageTitle, pageUrl);
		}
	} // loadpage()








	// TODO: update visible page to fix category workflow
	function displayPage(pageDiv, pageUrl, pageContent) {
		// console.log('function displayPage(' + pageDiv + ',' + pageUrl + ', pageContent)');
		// console.log('visiblePage: ' + visiblePage);
		jQuery('#'+visiblePage).stop().animate({'opacity':'0'},750, function() {
			jQuery('#'+visiblePage).hide( function() {
				if (pageContent) {
					jQuery('#content_wrapper').css('opacity', '0');
					jQuery('#content_wrapper').append(pageContent).imagesLoaded().then(function(){
						// console.log('------ IMAGES LOADED ------');
						jQuery('#content_wrapper').animate({'opacity':'1'},1000);
						hideLoadingAnimation();
        	});
					addHighlightSlideCursor();
				} else {
					// scenario: restart browser with forward history, no div/content
					// TODO: if there is no content & no pagediv loaded
					// if div exists, then..
					jQuery('#'+pageDiv).show().animate({'opacity':'1'},1000);
					hideLoadingAnimation();
					// if div doesnt exist, load. (needed for back history)
				}
				updateCategory(pageDiv);
				var pageTitle = jQuery('#'+pageDiv).data('pageTitle');
				updateTitle(pageTitle);
				pageTitle = window.document.title;
				trackPage(pageUrl, pageTitle);
				// hideLoadingAnimation();
			});
		});
	}
	function trackPage(pageUrl, pageTitle) {
		// console.log('trackPage(' + pageUrl + ',' + pageTitle + ')');
		if (!isTrackingOn) {
			// console.log('Tracking Disabled');
			return;
		}
		// console.log('Tracking Enabled');
		pageUrl = pageUrl || document.location.href;
		pageTitle = pageTitle || window.document.title;
		_paq.push(['setCustomUrl', pageUrl]);
		_paq.push(['setDocumentTitle', pageTitle]);
		_paq.push(['setReferrerUrl', pageReferrerUrl]);
		_paq.push(['trackPageView']);
	}
	function trackAction(pageName, slideNumber) {
		// trackEvent(category, action, [name], [value])
		// console.log('trackAction(' + pageName + ',' + slideNumber + ')');
		if (!isTrackingOn) {
			// console.log('Tracking Disabled');
			return;
		}
		pageName = jQuery('#'+pageName).data('pageTitle');
		slideNumber = 'Slide '+slideNumber;
		_paq.push(['trackEvent', 'Slides', pageName, slideNumber]);
	}
	function updateCategory(pageDiv) {
		// console.log('updateCategory(' + pageDiv + ')');
		var postType = jQuery('#'+pageDiv).data('postType');
		var categoryId = jQuery('#'+pageDiv).data('categoryId');
		// console.log('postType(' + postType + ')');
		// console.log('categoryId(' + categoryId + ')');

		if (postType === 'category') {
			window.categoryName = postType;
			window.categoryId = categoryId;
			// console.log('New categoryName: '+window.categoryName);
		} else {
			window.categoryName = postType;
			// console.log('New categoryName: '+window.categoryName);
		}


	}
	function updateTitle(pageTitle) {
		// console.log('updateTitle(' + pageTitle + ')');
		var pageSeperator = ' › ';
		var newSiteTitle = siteTitle;
		if (window.categoryName.length > 0) {
			if (window.categoryName === 'post') {
				window.categoryName = 'blog';
			}
			if(pageTitle !== window.categoryName) {
				pageTitle = pageTitle.capitalize();
				newSiteTitle += pageSeperator+window.categoryName.capitalize();
			}
		}
		pageTitle = pageTitle.capitalize();
		newSiteTitle += pageSeperator+pageTitle;
		window.document.title = newSiteTitle;
	}
	function updateBrowserHistory(pageState, pageTitle, pageUrl) {
		// console.log('updateBrowserHistory(' + pageState + ',' + pageTitle + ',' + pageUrl + ')');
		pageStateConsole = JSON.stringify(pageState, null, 4);
		// console.log(pageStateConsole);
		// Update the pageReferrerUrl for tracking functionality
		pageReferrerUrl = document.location.href;
		history.pushState(pageState, pageTitle, pageUrl);
	}
	function getPageDiv(postType, postId) {
		var divId = postType;
		var index = 0;
		var seperator = '';
		if (postId) {
			// Add a seperator between words, i.e, work_402
			divId = divId + '_' + postId;
			if (postType === 'category'){
				divId = 'page_'+divId;
			} else {
				divId = 'page_single_'+divId;
			}
		} else {
			divId = 'page_archive_'+divId;
		}
		return divId;
	}
	// Fn to allow an event to fire after all images are loaded
	$.fn.imagesLoaded = function () {
		// console.log('------ IMAGES LOADING ------');
    // Get all the images (excluding those with no src attribute)
    var $imgs = this.find('img[src!=""]');
    // If there's no images, just return an already resolved promise
    if (!$imgs.length) {return $.Deferred().resolve().promise();}
    // For each image, add a deferred object to the array, which resolves when the image is loaded (or if loading fails)
    var dfds = [];
    $imgs.each(function(){
      var dfd = $.Deferred();
      dfds.push(dfd);
      var img = new Image();
      img.onload = function(){dfd.resolve();}
      img.onerror = function(){dfd.resolve();}
      img.src = this.src;
    });
    // Return a master promise object, which will resolve when all the deferred objects have resolved
    // IE - when all the images are loaded
    return $.when.apply($,dfds);
	}
	// First page load.
	window.onload = function() {
		jQuery('html').animate({'opacity':'1'},1, function(){
			jQuery('#content_wrapper').imagesLoaded().then(function(){
				// After images are loaded
				// console.log('------ IMAGES LOADED ------');
				jQuery('#content_wrapper').animate({'opacity':'1'},750);
				hideLoadingAnimation();
			});
		});
		initiateState();
		// List all images for debugging
		// jQuery("img").each(function() {
    //   imgsrc = this.src;
    // 	// console.log('Source: '+imgsrc);
		// });

	};
	addHighlightSlideCursor();
	// Back and forward navigation event handlers.
	window.addEventListener('popstate', function(event) {
		var state = window.history.state;
		event.preventDefault();
		event.stopPropagation();
		if (!state) {
			// console.log('No history state..');
			// console.log(state);
			// TODO: report issue via ajax
		} else if (state) {
			// console.log('Detected history state..');
			// console.log(state); // page_archive_blog
			// console.log('Event:');
			// console.log(event);
			var pageUrl = state.pageUrl;
			var viewType = state.viewType;
			var postType = state.postType;
			var postId = state.postId;
			var isPushHistory = false;
			loadPage(pageUrl, viewType, postType, postId, isPushHistory);
		}
	});
	// Mouse over effects for the navigation.
	jQuery('nav img.off').hover(
		function() {
			// console.log('hover');
			jQuery(this).stop().animate({'opacity': '0'},250); },
		function() {
			jQuery(this).stop().animate({'opacity': '1'},250);
	});
	// Focus effects for the navigation.
	jQuery('nav a').focusin(
		function() {
			jQuery(this).children('img.off').stop().animate({'opacity': '0'},250);
		}
	);
	jQuery('nav a').focusout(
		function() {
			jQuery(this).children('img.off').stop().animate({'opacity': '1'},250);
		}
	);
	// Link click event handlers for pages, posts, categories, and outlinks.
	jQuery(document).on('click', 'a', function(event){
		function internalLink() {
			event.preventDefault();
			event.stopPropagation();
		}
		var link = jQuery(this);
		var linkType = link.data('linkType');
		var pageUrl = link.attr('href');
		// console.log('Anchor clicked: ' + pageUrl);
		if (linkType === 'headerNavigation') {
			internalLink();
			var postType = link.data('postType');
			var viewType = link.data('viewType');
			loadPage(pageUrl, viewType, postType);
		} else if (linkType === 'workNavigation') {
			internalLink();
			var projectType = link.data('projectType');
			if (!isThumbnailLoading && projectType !== currentProjectType) {
				isThumbnailLoading = true;
				$('#page_archive_work .row').fadeOut(1000, function() {
					$('#page_archive_work .column').hide();
					$('#page_archive_work .column[data-project-type~="'+projectType+'"]').show();
					$('#page_archive_work .row').fadeIn(1000, function() {
						currentProjectType = projectType;
						isThumbnailLoading = false;
						// trackAction
						projectType = projectType.capitalize();
						_paq.push(['trackEvent', 'Types', 'Work', projectType]);
					});
				});
			}
		} else if (linkType === 'postNavigation') {
			internalLink();
			var viewType = link.data('viewType');
			var postType = link.data('postType');
			var postId = link.data('postId');
			var categoryId = link.data('categoryId');
			var theId = postId || categoryId;
			loadPage(pageUrl, viewType, postType, theId);
		}
	});
	// Link click event handlers for slide navigation.
	jQuery(document).on('click', '#content_wrapper div .numbers_wrapper .numbers div', function(){
		var button = jQuery(this);
		var pageId = button.parent().parent().parent().attr('id');
		var newSlide = button.data('slide');
		var oldSlide = jQuery('#'+pageId+' .highlight_slides > div:visible').data('slide');
		if (oldSlide !== newSlide && !isSlideLoading) {
			isSlideLoading = true;
			transitionSlide(pageId, oldSlide, newSlide);
		}
	});
	jQuery(document).on('click', '#content_wrapper div .highlight_slides div img.highlight', function(){
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
			} else if (jQuery('#page_blog').is(':visible')) {
				showLoadingAnimation();
				offsetPosts = jQuery('#page_blog > article').length;
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {action: 'getAjaxData', category: '', offset: offsetPosts, token: window.nonce },
					success: function(response) {
						if (response === '') {
							areAllPostsLoaded = true;
						} else {
							jQuery('#page_blog:last-child').append(response);
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
