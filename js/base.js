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
/*global _paq, alert, siteName, category, userId, nonce*/

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

	String.prototype.capitalize = function() {
	  return this.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });
	};
	function updateVisiblePage() {
		visiblePage = jQuery('#content_wrapper :visible').attr('id');
		// Enables checking for new posts since visiblePage was last viewed.
		areAllPostsLoaded = false;
	}
	function showLoadingAnimation() {
		isPageLoading = true;
		jQuery('#loading_animation').stop().show().animate({'opacity': '.85'},750);
	}
	function hideLoadingAnimation() {
		jQuery('#loading_animation').stop().animate({'opacity': '0'},1000, function(){
			jQuery('#loading_animation').hide();
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
	function loadPage(pageUrl, postType, postId) {
		//console.log("function loadPage(pageUrl, postType, postId)");
		//console.log("pageUrl: " + pageUrl);
		//console.log("postType: " + postType);
		//console.log("postId: " + postId);
		//console.log("pagePath: " + pagePath);

		// pageUrl: https://aidanamavi.com/work/aidan-amavi/ base.min.js:106:11
		// pagePath: /work/402 base.min.js:107:11
		// folder: work base.min.js:116:11
		// page: 402

		if (isPageLoading) { return; }

		//console.log("function AJAXorCache(pageDiv, postType, postId)");
		// pagePath = pagePath || pageUrl;
		var pageDiv = getPageDiv(postType, postId, 'divId');
		//console.log("pageDiv: " + pageDiv);

		if (pageDiv === visiblePage) { return; }

		// var ajaxArray = pathParser(pagePath, 'array');
		// var postType = ajaxArray[0]; 	// work	// index
		// var postID = ajaxArray[1];		// 402	// work
		//console.log("postType: " + postType);
		//console.log("postId: " + postId);

		showLoadingAnimation();
		if (isEmpty(jQuery('#'+pageDiv))) {
			// Fetch new page.
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {action: 'getAjaxData', postType: postType, postId: postId, token: window.nonce },
				success: function(pageContent) {
					//console.log("AJAX success");
					displayPage(pageDiv, pageUrl, pageContent);
				},
				error: function(xhr){
					//console.log("AJAX error");
					if (xhr.status === 403) {
						displayPage('page_error_403', false, xhr.responseText);
					} else {
						hideLoadingAnimation();
					}
				}
			});
		} else {
			// Show cached page.
			//console.log("CACHED success");
			displayPage(pageDiv, pageUrl);
			//console.log("function history.pushState(pageDiv, pageTitle, pageUrl)");
			//console.log("pageDiv: " + pageDiv);
			var pageTitle = jQuery('#'+pageDiv).data('pageTitle');
			//console.log("pageTitle: " + pageTitle);
			//console.log("pageUrl: " + pageUrl);
			history.pushState(pageDiv, pageTitle, pageUrl);
		}


	}
	function displayPage(pageDiv, pageUrl, pageContent, pageHistory) {
		//console.log("function displayPage(pageDiv, pageUrl, pageContent, pageHistory)");
		//console.log("pageDiv: " + pageDiv);
		//console.log("pageUrl: " + pageUrl);
		//console.log("pageContent: ... " );
		if (pageHistory === undefined) {
			//console.log("pageHistory: undefined / true");
			pageHistory = true;
		} else {
			//console.log("pageHistory: " + pageHistory);
		}
		//console.log("pageHistory: " + pageHistory);
		jQuery('#'+visiblePage).stop().animate({'opacity':'0'},750, function() {
			jQuery('#'+visiblePage).hide( function() {
				if (pageContent) {
					jQuery('#content_wrapper').css('opacity', '0');
					jQuery('#content_wrapper').append(pageContent);
					jQuery('#content_wrapper').animate({'opacity':'1'},750);
					addHighlightSlideCursor();
				} else {
					jQuery('#'+pageDiv).show().animate({'opacity':'1'},750);
				}
				var pageTitle = jQuery('#'+pageDiv).data('pageTitle');
				updateCategory(pageDiv);
				updateTitle(pageTitle);
				if (pageUrl) {
					pageReferrerUrl = document.location.href;
					trackPage();
				}
				if(pageHistory) {
					//console.log("function history.pushState(pageDiv, pageTitle, pageUrl)");
					//console.log("pageDiv: " + pageDiv);
					var pageTitle = jQuery('#'+pageDiv).data('pageTitle');
					//console.log("pageTitle: " + pageTitle);
					//console.log("pageUrl: " + pageUrl);
					history.pushState(pageDiv, pageTitle, pageUrl);
				}
				updateVisiblePage();
				hideLoadingAnimation();
			});
		});
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
			window.categoryName = categoryInfo[1];
		}
	}
	function updateTitle(pageTitle) {
		var pageSeperator = ' › ';
		title = siteName;
		if (window.categoryName.length > 0) {
			if (window.categoryName === 'post') {
				window.categoryName = 'blog';
			}
			if(pageTitle.toLowerCase() !== window.categoryName.toLowerCase()){
				title += pageSeperator+window.categoryName.capitalize();
			}
		}
		title += pageSeperator+pageTitle;
		window.document.title = title;
	}
	function updateUrl(pageUrl) {
		pageReferrerUrl = document.location.href;
		pageUrl = pathParser(pageUrl, 'path');
		history.pushState(null, null, pageUrl);
		trackPage();
	}
	function getPageDiv(postType, postId, returnBack) {

		if (returnBack === 'divId') {
			var divId = postType;
			var index = 0;
			var seperator = '';

			// If there is an Id
			if (postId) {
				// Add a seperator between words, i.e, work_402
				divId = divId + "_" + postId;
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
	}
	function pathParser(url, returnBack) {
		// Accepts:
		// /work/402
		//  bvcxz

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
			var divId = '';
			var index = 0;
			var seperator = '';

			// Add a seperator between words, i.e, work_402
			url.forEach(function(entry) {
				if (index === 0) { firstIndex = entry; }
				if (index > 0) { seperator = '_'; }
				divId += seperator+entry;
				++index;
			});

			// If there are two indexs, the 2nd is the post ID
			if ( index > 1 ) {
				if (firstIndex === 'category'){
					divId = 'page_'+divId;
				} else {
					divId = 'page_single_'+divId;
				}
			} else {
				divId = 'page_archive_'+divId;
			}
			return divId;
		} else if (returnBack === 'array') {
			// If there is no folder detected.
			if (typeof url[1] === 'undefined') {
				// Add index as the folder for AJAX to process.
				//url.unshift('index'); // might not need this now that we define indexes by name/type
			}
			return url;
		} else if (returnBack === 'path') {
			url = element.pathname;
			return url;
		}
	}

	// First page load.
	jQuery('html').animate({'opacity':'1'},500, function() {
		jQuery('#content_wrapper').delay(750).animate({'opacity':'1'},1000);
	});
	window.onload = function() {
		jQuery('#navigation_wrapper').animate({'opacity':'1'},1000);
		pageDiv = visiblePage;
		var pageTitle = jQuery('#'+pageDiv).data('pageTitle');
		pageUrl = document.location.pathname;
		//console.log("Added first history for: " + pageDiv);
		//console.log("function history.replaceState(pageDiv, pageTitle, pageUrl)");
		//console.log("pageDiv: " + pageDiv);
		//console.log("pageTitle: " + pageTitle);
		//console.log("pageUrl: " + pageUrl);
		history.replaceState(pageDiv, pageTitle, pageUrl);
		hideLoadingAnimation();
	};
	addHighlightSlideCursor();

	// Back and forward navigation event handlers.
	window.addEventListener('popstate', function(event) {
		//console.log("listener popstate")
		var pageUrl = document.location.pathname;
		var pageDiv = event.state;
		var pageContent = null;
		var pageHistory = false;
		//console.log("pageUrl: " + pageUrl);
		//console.log("pageDiv: " + pageDiv);
		if(pageDiv != null) {
			displayPage(pageDiv, pageUrl, pageContent, pageHistory);
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
		var pagePath; var link = jQuery(this);
		var linkType = link.data('linkType');
		var pageUrl = link.attr('href');

		//console.log("link detected: " + pageUrl);

		if (linkType === 'headerNavigation') {
			internalLink();
			var postType = link.data('postType');
			loadPage(pageUrl, postType);

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
					});
				});
			}
		} else if (linkType === 'postNavigation') {
			var postId = link.data('postId');
			var categoryId = link.data('categoryId');
			var postType = link.data('postType');
			internalLink();
			var theId = postId || categoryId;
			loadPage(pageUrl, postType, theId);
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
