/**
 * Functionality specific to Perfetta.
 **/
(function($) {	
	$(document).ready(function(){
	    // fit videos
	    $(".video-wrapper").fitVids();
	    
		// Aside menu
		var toggler = jQuery('#aside-menu-toggler');

		toggler.click(function() {
			gkOpenAsideMenu();
		});

		jQuery('#close-menu').click(function() {
			jQuery('#close-menu').toggleClass('menu-open');
			jQuery('#page').toggleClass('menu-open');
			jQuery('#aside-menu').toggleClass('menu-open');
		});

		// detect android browser
		var ua = navigator.userAgent.toLowerCase();
		var isAndroid = ua.indexOf("android") > -1 && !window.chrome;
	
		if(isAndroid) {
			jQuery(document.body).addClass('android-stock-browser');
		}
		// Android stock browser fix for the aside menu
		if(jQuery(document.body).hasClass('android-stock-browser') && jQuery('#aside-menu').length) {
			jQuery('#aside-menu-toggler').click(function() {
				window.scrollTo(0, 0);
			});
			// menu dimensions
			var asideMenu = jQuery('#aside-menu');
			var menuHeight = jQuery('#aside-menu').outerHeight();
			//
			window.scroll(function() {
				if(asideMenu.hasClass('menu-open')) {
		    		// get the necessary values and positions
		    		var currentPosition = jQuery(window).scrollTop();
		    		var windowHeight = jQuery(window).height();
	
					// compare the values
		    		if(currentPosition > menuHeight - windowHeight) {
		    			jQuery('#close-menu').trigger('click');
		    		}
				}
			});
		}
	});
	
	function gkOpenAsideMenu() {
		jQuery('#page').toggleClass('menu-open');
		jQuery('#aside-menu').toggleClass('menu-open');
	
		if(!jQuery('#close-menu').hasClass('menu-open')) {
			setTimeout(function() {
				jQuery('#close-menu').toggleClass('menu-open');
			}, 300);
		} else {
			jQuery('#close-menu').removeClass('menu-open');
		}
	}
})(jQuery);