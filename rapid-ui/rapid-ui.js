/*========================================= 
	FILE INFO:
	
	This file adds client-side funcitonality
	to the shortcodes and is required by 
	several shortcodes but not all of them.
	
	TODO:
	
	Incorporate smooth page scrolling for 
	any actionable shortcodes. For example:
	
	jQuery('html, body').stop().animate({scrollTop: jQuery("h2:contains('Button')").offset().top}, 1500);
	
	This will smoothly scroll the page to 
	the "Button" h2 element...
	
	Smooth page scrolling can be coupled with
	a table of contents for advised usage.
*/

/*=========================================
	INITIALIZE:
	
	Initializes all javascript components 
	when the document is ready.
*/

jQuery(document).ready(function() {
	rpLikertScaleInit();
	rpChoiceInit();
	rpPagedSectionsInit();
	rpAccordionInit();
	rpButtonInit();
	rpCaptionBoxInit();
	rpPagedMenuInit();
	rpLightboxInit();
	rpPopupInit();
});

/*=========================================
	LIGHTBOX:
	
	older popup dialog component
	
	TODO: fully replace this with rpDialog
*/

function rpLightboxInit() {	
	// custom alert resize
	jQuery(window).resize(function () {
		rpLightboxSetSize();
	});
}

// TODO: this seems to have trouble with zoomed (mobile) browsers, witnessed on my iPhone
function rpLightboxSetSize() {
	// get the viewport height and width
    var winH = jQuery(document).height();
	var winH2 = jQuery(window).height();
    var winW = jQuery(window).width();
	// set the dimmer size to the computed viewport size
	jQuery(".rp-lightbox-dimmer").css("width", winW);
	jQuery(".rp-lightbox-dimmer").css("height", winH);
    // center the dialog in the viewport
    jQuery(".rp-lightbox").css('top',  winH2 / 2 - jQuery(".rp-lightbox").height() / 2);
    jQuery(".rp-lightbox").css('left', winW / 2 - jQuery(".rp-lightbox").width() / 2);
}

function rpLightboxClose() {
	jQuery(".rp-lightbox-dimmer").hide();
	jQuery(".rp-lightbox").hide();
}

function rpLightbox(argAlertTitle, argAlertMessage, argAlertIcon, argAlertType, argWidth, argFlags, argData) {
	// assign default values to some function args
	argWidth = typeof argWidth !== 'undefined' ? argWidth : "400px";
	argFlags = typeof argFlags !== 'undefined' ? argFlags : ["control-close"];
	// set the width of the dialog
	jQuery(".rp-lightbox").css("width", argWidth);
	// clear alert box and replace with loading indicator, otherwise previous content is visible
	jQuery(".rp-lightbox-title").html("");
	jQuery(".rp-lightbox-body").html("<div class=''></div><span>Loading...</span>");
	jQuery(".rp-lightbox-control-close").hide();
	// initalize the alert dialog size/position based on current screen status
	rpLightboxSetSize();
	// show the dimmer and the dialog
	jQuery(".rp-lightbox-dimmer").fadeIn(500);
	jQuery(".rp-lightbox").fadeIn(1000);
	// instantiate/normalize the optional arg
	if (!argAlertType) {
		var argAlertType = "";
	}
	argAlertType = argAlertType.toLowerCase();
	// clear the icon by removing all classes or we will end up with multiple icon classes added
	//jQuery(".rp-lightbox-title").removeClass();
	// generate a custom dialog based on the alert type argument
	if (argAlertType == "" || argAlertType == "basic") {
		// set the dialog's title text and message text based on the args
		jQuery(".rp-lightbox-title").html(argAlertTitle);
		jQuery(".rp-lightbox-body").html(argAlertMessage);
		jQuery(".rp-lightbox-title").addClass(argAlertIcon);
		rpLightboxSetSize();
	}
	else {
		jQuery(".rp-lightbox-title").html("Unknown Alert");
		jQuery(".rp-lightbox-body").html("An unhandled custom alert type was generated! This shouldn't happen under normal conditions...");
		jQuery(".rp-lightbox-title").addClass(".rp-lightbox-error");
		rpLightboxSetSize();
	}
	// === handle flags
	// handle control-close flag (clicking the close/x button)
	if ( argFlags.indexOf("control-close") > -1 ) {
		jQuery(".rp-lightbox-control-close").show();
		jQuery(".rp-lightbox-control-close").click(function(event) {
			event.preventDefault();
			rpLightboxClose();
		});
	}
	// handle dimmer-click-close (clicking outside the dialog)
	if ( argFlags.indexOf("dimmer-click-close") > -1 ) {
		jQuery(".rp-lightbox-dimmer").click(function() {
			rpLightboxClose();
		});
	}
	else {
		jQuery(".rp-lightbox-dimmer").off("click");
	}
	// handle esc-close (pressing escape key)
	if ( argFlags.indexOf("esc-close") > -1 ) {
		jQuery(document).keydown(function(event) {
			if (event.which == 27) {
				event.preventDefault();
				jQuery(document).off("keydown");
				rpLightboxClose();
			}
		});
	}
}

/*=========================================
	PAGED MENU:
	
	displays a compact paged menu based on 
	an existing WordPress menu
*/

function rpPagedMenuInit() {
	// first, hide the original WordPress menu
	jQuery(".rp-paged-menu>ul").hide();
	// next, create the two empty pages that we will use to slide the menu pages in/out
	jQuery(".rp-paged-menu").append("<div class='rp-paged-menu-page'></div>");
	// load the top level page by passing no argument
	rpPagedMenuSetPage();
}

function rpPagedMenuSetPage(li) {
	
	// clear the page so we can insert the new menu-items
	jQuery(".rp-paged-menu-page").html("");
	
	// append some default page elements (back button and page title)
	var html = "";
	html += "<li class='menu-item rp-paged-menu-header'><span class='rp-paged-menu-link rp-paged-menu-back-button' data-href='#'><i class='icon-left-open-mini'></i>Back</span><span class='rp-paged-menu-link rp-paged-menu-view-button' data-href='#'>View<i class='icon-right-open-mini'></i></span><span class='rp-paged-menu-current-page'>Current Page</span></li>";
	jQuery(".rp-paged-menu-page").append(html);
	
	var ul;
	if (li == null) {
		ul = jQuery(".rp-paged-menu>ul")[0]; // in case the shortcode is used twice on a page, only grab the first UL from the array or we'll end up traversing the original menu N times
	}
	else {
		ul = li.children("ul");
	}
	
	// get the parent menu-item (LI) text to use as the current page heading
	var parentText = "";
	//parentText = jQuery(ul).parent().children("a").text();
	parentText = jQuery(li).children("a").text();
	if (parentText == "") {parentText = "Menu";}
	jQuery(".rp-paged-menu-current-page").text(parentText);
	
	// get the ancestor menu-item (LI) text to use as the back button caption
	var ancestorText = "";
	ancestorText = jQuery(ul).parent().parent().parent().children("span").text();
	if (ancestorText == "") {ancestorText = "Menu";}
	
	// show/hide header buttons if the parent menu-item (LI) of this sub-menu (UL) contains children
	var parentMenuItemCount = 0;
	parentMenuItemCount = jQuery(li).parent().children("li").length;
	//var parentMenuItemCount = ul.parent().parent().children("li").length;
	if (parentMenuItemCount > 0) {
		jQuery(".rp-paged-menu-back-button").show();
		jQuery(".rp-paged-menu-view-button").show();
	}
	else {
		jQuery(".rp-paged-menu-back-button").hide();
		jQuery(".rp-paged-menu-view-button").hide();
	}
	
	// bind the back button to the current sub-menu's (UL) parent menu-item (LI)
	jQuery(".rp-paged-menu-back-button").click(function(event) {
		event.preventDefault(); // prevents default event (href navigate)
		
		if (parentMenuItemCount > 0) {
			//rpPagedMenuSetPage(ul.parent().parent());
			//rpPagedMenuSetPage(ul.parent().parent().parent());
			rpPagedMenuSetPage(jQuery(li).parent().parent());
		}
		return false; // prevents scroll to top
	});
	
	// link the view page menu-item
	//var theLink = jQuery(ul).parent().children("a").attr("href");
	var theLink = jQuery(li).children("a").attr("href");
	jQuery(".rp-paged-menu-view-button").attr("data-href", theLink);
	jQuery(".rp-paged-menu-view-button").click(function(event) {
		window.location = jQuery(this).data("href");
	});
	
	// iterate through each menu-item (LI) of this sub-menu (UL)
	var c = 0;
	if (jQuery(ul).children("li").length > 0) {
		jQuery(ul).children("li").each(function() {
			var theMenuItem = jQuery(this);
			c++;
			var html = "";
			// re-build the menu-item
			html += "<li class='menu-item rp-paged-menu-item'>";
			html += "<span class='rp-paged-menu-link menu-link-" + c + "' data-href='#'>";
			html += jQuery(theMenuItem)[0].firstChild.textContent;
			html += "<i class='rp-paged-menu-item-icon icon-right-open-big'></i>";
			html += "</span>";
			html += "</li>";
			// attach the menu item to the page
			jQuery(".rp-paged-menu-page").append(html);
			// bind the menu item link
			jQuery(".menu-link-" + c).click(function(event) {
				event.preventDefault();
				rpPagedMenuSetPage(jQuery(theMenuItem));
				if (jQuery(theMenuItem).children("ul").length > 0) {
					// TODO: maybe we should pass theMenuItem in rpPagedMenuSetPage, then get the ul inside that function
					//rpPagedMenuSetPage(jQuery(theMenuItem).children("ul"));
					//rpPagedMenuSetPage(jQuery(theMenuItem));
				}
				else {
					//alert("TODO: This menu-item has no child UL so don't rpPagedMenuSetPage as usual...");
				}
				return false;
			});
		});
	}
	else {
			var html = "";
			// re-build the menu-item
			html += "<span class='rp-paged-menu-notice'>";
			html += "<i class='rp-paged-menu-notice-icon icon-info-circled'></i>";
			html += "There are no sub-pages. You may go Back or View the current page.";
			html += "</span>";
			// attach the menu item to the page
			jQuery(".rp-paged-menu-page").append(html);
	}

}

/*=========================================
	BUTTON:
*/

function rpButtonInit() {
	jQuery(".rp-button").click(function(event){
		/*$(".panel").slideToggle("slow");*/
		var href = jQuery(this).children("span").data("href");
		if (href == "" || href == "#") {
			event.preventDefault();
			return false;
		}
		else if (href.startsWith("javascript:")) {
			var href = href.replace("javascript:", "");
			var hparts = href.split(";");
			var func = hparts[0];
			window[func](hparts[1], hparts[2], hparts[3], hparts[4], hparts[5], hparts[6], hparts[7]);
		}
		else {
			window.location = href;
		}
	});
	/*
	jQuery(this).mousedown(function(event) {
		jQuery(this).mouseleave(function(event) {
			jQuery(this).trigger('mouseup');
		});
	});
	*/
	/*
	jQuery(".rp-button").hover(function(event){
		target = jQuery(this).children("span");
		prev = target.text();
		target.text( jQuery(this).data("caption_b") );
	}, function(event) {
		target.text(prev);
	});
	*/
}

/*=========================================
	CAPTION BOX:
*/

if (typeof String.prototype.startsWith != 'function') {
  // see below for better implementation!
  String.prototype.startsWith = function (str){
    return this.indexOf(str) == 0;
  };
}

function rpCaptionBoxInit() {
	jQuery(".rp-caption-box-link").click(function(event){
		/*$(".panel").slideToggle("slow");*/
		var href = jQuery(this).attr("href")
		if (href == "" || href == "#") {
			event.preventDefault();
		}
		else if (href.startsWith("#")) {
			var target = href.substring(1);
			jQuery('html, body').stop().animate({scrollTop: jQuery(target).offset().top}, 1500, 'easeInOutQuart');
			//jQuery('body').css("-webkit-filter", "blur(0);");
		}
	});
}

/*=========================================
	ACCORDION:
*/

function rpAccordionInit() {
	jQuery(".rp-accordion-top").click(function(){
		/*$(".panel").slideToggle("slow");*/
		if (jQuery(this).hasClass('rp-accordion-top-expanded') == false) {
			jQuery(this).addClass('rp-accordion-top-expanded');
		}
		else {
			jQuery(this).removeClass('rp-accordion-top-expanded');
		}
		jQuery(this).next().slideToggle("fast");
		var icon_element = jQuery(this).find('.rp-accordion-icon');
		if (jQuery(icon_element).hasClass('icon-plus-squared')) {
			jQuery(icon_element).removeClass('icon-plus-squared');
			jQuery(icon_element).addClass('icon-minus-squared');
		}
		else {
			jQuery(icon_element).removeClass('icon-minus-squared');
			jQuery(icon_element).addClass('icon-plus-squared');
		}
	});
}

/*=========================================
	LIKERT SCALE:
*/

function rpLikertScaleInit() {
	// likert anchor click toggler
	jQuery(".rp-likert-anchor").click(function() {
		rpLikertScaleClick(this, jQuery(this).parents('.rp-likert'));
	});
}

function rpLikertScaleClick(el, parent) {
	// de-select all anchors
	jQuery(parent).find('.rp-likert-anchor').removeClass("rp-likert-anchor-on");
	// select the clicked anchor
	jQuery(el).addClass("rp-likert-anchor-on");
	// set the hidden form field value
	var anchor_index = jQuery(el).children('.rp-likert-anchor-label').text();
	jQuery(parent).find('select').val(anchor_index);
}

/*=========================================
	CHOICE:
	
	a control that provides multiple choices
*/

function rpChoiceInit() {
	// choice button click toggler
	jQuery(".rp-choice-button").click(function() {
		var el = this;
		var parent = jQuery(this).parents('.rp-choice');
		var index = jQuery(parent).find(".rp-choice-button").index(this);
		rpChoiceClick(el, parent, index);
	});
}

function rpChoiceClick(el, parent, index) {
	// de-select all anchors
	//jQuery(parent).find('.rp-choice-button-label').removeClass("active");
	jQuery(parent).find(".rp-choice-button").removeClass("active");
	// select the clicked button
	//jQuery(el).addClass("active");
	jQuery(el).addClass("active");
	// set the hidden form field value
	jQuery(parent).find('select').val(index);
	// get the button's assigned action from the data-rp-action attribute
	var action = jQuery(el).parents(".rp-choice").data("rp-action");
	var action_parts = action.split(" ");
	var action_type = action_parts[0];
	var action_target = action_parts[1];
	// hide all tab pages, show tab page matching current button index
	jQuery("#" + action_target).children(".rp-tab").hide();
	jQuery("#" + action_target).children(".rp-tab:eq(" + (index) + ")").show();
}

/*=========================================
	PAGINATOR:
	
	TODO: make a paginateSubSections() javascript function that takes all sub-sections from below and converts
	them into a sub-section like on the front-end. The front-end could also incorporate this idea since its more
	universal and could become a standardized method for quickly building layouts.
*/

// rpPagedSectionsInit() fully sets up the paginator control by detecting a properly marked up set of HTML.
function rpPagedSectionsInit() {
	// create a paginator button for each section inside the paginator wrap
	jQuery(".rp-paginator .section").each(function(index) {
		var section_title = jQuery(this).find('h3').text();
		if (index == 0) {
			jQuery(".rp-paginator-controls").append('<a id="" class="active-button" href="" >' + section_title + '</a>');
		}
		else {
			jQuery(".rp-paginator-controls").append('<a id="" class="" href="" >' + section_title + '</a>');
		}
	});
	// bind each paginator button's click event
	jQuery(".rp-paginator-controls a").each(function(index) {
		jQuery(this).click(function(event) {
			event.preventDefault();
			rpPagedSectionsSetPage(index);
		});
	});
	// finally, set the paginator to the first page
	rpPagedSectionsSetPage(0);
}

function rpPagedSectionsSetPage(section_index) {
	jQuery(".rp-paginator .section").each(function(index) {
		if (index == section_index) {
			jQuery(this).show();
			jQuery(".rp-paginator-controls a:eq(" + index + ")").addClass("active-button");
		}
		else {
			jQuery(this).hide();
			jQuery(".rp-paginator-controls a:eq(" + index + ")").removeClass("active-button");
		}
	});
}

/*=========================================
	SLIDER:
	
	new slider component
	
	on page load, we start at the first slide in the DOM
	if direction Next is about to animate, get the slide that comes AFTER the current slide in the DOM
	and position this slide to the right of the current slide (just off-screen) so it can slide in
	then animate the current slide and next slide (by DOM order not left position)
	
	TODO: this hasn't been fully implemented/tested...
*/

var slideCount;
var currentSlide;
var autoPlay;

/* TEMP UNDONE:
jQuery(document).ready(function() {
	// preload the image resources
	//SliderInitialize(['img/t.jpg', 'img/s.jpg', 'img/u.jpg', 'img/v.jpg']);
	sliderInit();
});

jQuery(window).resize(function() {
	// prepare the slider by setting its height
	sliderPrepare();
	sliderPlay();
});
*/

// sliderInit() initializes the slider by preloading image resources before allowing the animations
// TODO: pull image array from the featured image for all posts in the "Slider" category
// TODO: since img preload is unpredictable when each will finish, they might fire out
// of order and we will end up with an unexpected image as the first slide in the set...
function sliderInit() {

	var images = new Array();
	jQuery(".slide-anchor").each(function() {
		images.push(jQuery(this).find(".slide-img").attr("src"));
	});

	var imageCount = images.length;
	jQuery(images).each(function(index) {
		//var imgurl = wpjs.template_directory + "/" + images[index];
		var imgurl = images[index];
		jQuery("<img>")
		.attr('src', imgurl)
		.load(function() {
			// create the slide markup
			//var html = "";
			//html = "<a class='slide-anchor' href='#'><img class='slide-img' src='" + imgurl + "'></img></a>";
			// append this slide to the slide wrap
			//jQuery(".slide-wrap").append(html);
			if (index == imageCount - 1) {
				// get the slide count
				slideCount = jQuery(".slide-anchor").length;
				// set the first slide in the DOM to the current slide
				currentSlide = jQuery(".slide-anchor").first();
				// prepare the slider (size, buttons, etc)
				sliderPrepare();
				// start the auto timer
				sliderPlay();
			}
		});
	});
}

function sliderPrepare() {

	// hide all but the first slide
	jQuery(".slide-anchor").css("display", "none");
	jQuery(currentSlide).css("display", "block");

	// set the height of the entire slide wrap dynamically based on the internal image height after it gets auto-fit during initialization
	var detectedHeight = jQuery(currentSlide).height();
	if (detectedHeight == 0) {
		detectedHeight = 573;
	}
	jQuery(".slide-wrap").css("height", detectedHeight);
	
	// center the left/right buttons vertically
	var halfButton = jQuery(".slide-button-left").width() / 2;
	jQuery(".slide-button-left").css("top", detectedHeight / 2 - halfButton);
	jQuery(".slide-button-right").css("top", detectedHeight / 2 - halfButton);

	// (re)bind the buttons' click events
	jQuery(".slide-button-left").unbind();
	jQuery(".slide-button-left").bind("click", GoPrevious);
	jQuery(".slide-button-right").unbind();
	jQuery(".slide-button-right").bind("click", GoNext);
}

function sliderPause() {
	clearInterval(autoPlay);
}

function sliderPlay() {
	sliderPause();
	autoPlay = setInterval(function(){GoNext();}, 5000);
}

function sliderGoNext() {

	// prevent all other animations from occurring
	sliderPause();
	jQuery(".slide-button-left").unbind();
	jQuery(".slide-button-right").unbind();

	// get the current window width
	var w = jQuery(window).width();
	
	// get the next slide by traversing DOM and checking if the next element is indeed a slide!
	var nextSlide = jQuery(currentSlide).next();
	if (!nextSlide.hasClass("slide-anchor")) {
		nextSlide = jQuery(".slide-anchor").first();
	}
	
	// set the next slide's left value so it appears just to the right (off-screen) of the current slide
	nextSlide.css("display", "block");
	nextSlide.css("left", w);
	
	// animate the current and next slide
	var slidesDoneAnimating = 0;
	jQuery(".slide-anchor").each(function() {
		jQuery(this).stop().animate({left: jQuery(this).position().left - w}, 1000, 'easeOutQuad', function() {
			slidesDoneAnimating++;
			if (slidesDoneAnimating == slideCount) {
			
				// rebind the next/previous buttons
				jQuery(".slide-button-left").bind("click", GoPrevious);
				jQuery(".slide-button-right").bind("click", GoNext);
				
				// set the current slide to the slide that was just brought into view
				currentSlide = nextSlide;
				
				// hide all but the current slide
				jQuery(".slide-anchor").css("display", "none");
				jQuery(currentSlide).css("display", "block");
				
				// allow the auto play to start back up
				sliderPlay();
			}
		});
	});
}

function sliderGoPrevious() {

	// prevent all other animations from occurring
	sliderPause();
	jQuery(".slide-button-left").unbind();
	jQuery(".slide-button-right").unbind();

	// get the current window width
	var w = jQuery(window).width();
	
	// get the next slide by traversing DOM and checking for nulls
	var previousSlide = jQuery(currentSlide).prev();
	if (!previousSlide.hasClass("slide-anchor")) {
		previousSlide = jQuery(".slide-anchor").last();
	}
	
	// set the next slide's left value so it appears just to the right (off-screen) of the current slide
	previousSlide.css("display", "block");
	previousSlide.css("left", -w);
	
	// animate the current and next slide
	var slidesDoneAnimating = 0;
	jQuery(".slide-anchor").each(function() {
		jQuery(this).stop().animate({left: jQuery(this).position().left + w}, 1000, 'easeOutQuad', function() {
			slidesDoneAnimating++;
			if (slidesDoneAnimating == slideCount) {
			
				// rebind the next/previous buttons
				jQuery(".slide-button-left").bind("click", GoPrevious);
				jQuery(".slide-button-right").bind("click", GoNext);
				
				// set the current slide to the slide that was just brought into view
				currentSlide = previousSlide;
				
				// hide all but the current slide
				jQuery(".slide-anchor").css("display", "none");
				jQuery(currentSlide).css("display", "block");
				
				// allow the auto play to start back up
				sliderPlay();
			}
		});
	});
	
}

// initializes the popup dialog by injecting it into the page
// or simply add the div into a page template manually
function rpPopupInit() {
	if (!jQuery("#rp-popup")) {
		
	}
	jQuery("body").append("<div id='rp-popup'></div>");
}

// shows a popup dialog with the specified settings
function rpPopup(settings) {
	// build the html that will go into the dialog
	var html = "";
	if (settings["title"]) {
		// set the descripton content
		html += "<h2 id='rp-dialog-title'>" + settings["title"] + "</h2>";
	}
	if (settings["description"]) {
		// set the descripton content
		html += "<div id='rp-dialog-description'>" + settings["description"] + "</div>";
	}
	if (settings["response"]) {
		//ccDialogCallback = settings.callback;
		// add the choice buttons to the dialog html
		html += "<div id='rp-dialog-responses'>";
		jQuery.each(settings["response"], function(index, response) {
			html += "<span class='rp-dialog-button response' data-response='" + index + "'>" + index + "</span>";
		});
		html += "</div>";
	}
	if (settings["escclose"]) {
		// keyboard esc closes the dialog
	}
	if (settings["btnclose"]) {
		// a close button is added to the dialog, which closes the dialog
	}
	if (settings["outclose"]) {
		// clicking outside the dialog closes the dialog
	}
	if (settings["bgcolor"]) {
		// clicking outside the dialog closes the dialog
		jQuery("#rp-dialog-overlay").css("background-color", settings["bgcolor"]);
	}
	if (settings["response"]) {
		// TODO: create the OK buttons
		// iterate the responses and their functions
	}
	// finally append the html to the dialog, resize/recenter it, then show it
	jQuery("#rp-popup").html(html);
	// TODO: attach dialog button click events after injecting html
	jQuery(".rp-dialog-button.response").click(function(index) {
		var response_index = jQuery(this).data("response");
		settings["response"][response_index]();
	});
	rpDialogResize();
	jQuery("#rp-popup").fadeIn();
	jQuery("#rp-popup-overlay").fadeIn();
}

// resizes the popup dialog, forcing it to stay centered
// gets called when showing the popup dialog and when resizing the browser window
function rpDialogResize() {
	// get the viewport height and width
    var winH = jQuery(document).height();
	var winH2 = jQuery(window).height();
    var winW = jQuery(window).width();
	// set the dimmer size to the computed viewport size
	// TODO: this shouldn't be needed if we're using display:fixed...
	/* UNDONE: reimplement the dimmer as optional!
	jQuery("#rp-dialog-dimmer").css("width", winW);
	jQuery("#rp-dialog-dimmer").css("height", winH);
	*/
    // center the dialog in the viewport
    jQuery("#rp-dialog").css('top',  winH2 / 2 - jQuery("#rp-dialog").height() / 2);
    jQuery("#rp-dialog").css('left', winW / 2 - jQuery("#rp-dialog").width() / 2);
}

// closes the popup dialog
function rpDialogClose(reason, callback) {
	jQuery("#rp-dialog").fadeOut();
	jQuery("#rp-dialog-overlay").fadeOut();
	jQuery("html").removeClass("dialog-mode");
	// check if a dialog callback was set during initial call to ccDialog() and fire it
	if (rpDialogCallback) {
		rpDialogCallback();
	}
}

// initializes the tooltip for every element having a data-tip attribute
function attachTips() {
	jQuery("body").find("[data-tip]").each(function() {
		jQuery(this).hover(
			function() {
				jQuery('#rp-tip').text(jQuery(this).data("tip"));
				jQuery('#rp-tip').stop(true,true).fadeIn('fast');
			},
			function() {
				jQuery('#rp-tip').stop(true,true).fadeOut('fast');
			}
		);
	});
}