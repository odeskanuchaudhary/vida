/**
 * Initialize Lazy Loading Scripts for ViDA
 * Loads in header @dependent on jQuery, Jquery Lazy plugin, vida-scripts-init
 */

jQuery(function($) {

	$('.lazy').show().lazy({
		effect: "fadeIn",
		threshold: 150,
		//appendScroll: $('.vida-lazy-wrap'),
		combined: true,
		delay: 15000,
		enableThrottle: true,
		throttle: 250,
		beforeLoad: function(element) {
			var imageSrc = element.data('src');
			console.log('image "' + imageSrc + '" is about to be loaded');
		},
		afterLoad: function(element) {
			// called after an element was successfully handled
			element.addClass('handled');
			var imageSrc = element.data('src');
			console.log('image "' + imageSrc + '" was loaded successfully');
		},
	});


});