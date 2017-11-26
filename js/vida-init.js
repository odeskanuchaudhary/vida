/**
 * Initialize Scripts for ViDA
 * Loads in header @dependent on jQuery
 */


	 
	/* Check/Load jquery */		
	
	function CheckLoadjQuery() {

		if (typeof(jQuery) === 'undefined') {
		
			console.log('Loading jQuery...');
			
			ViDA_Load_Script('/wp-includes/js/jquery/jquery.js', true, false );
			
			//jQuery.getScript('/wp-includes/js/jquery/jquery.js');
			//ViDA_Load_Script('//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js', true, false );
			
		}
		
	}
	
	/* Setup cache of scripts */
	
	function SetupCacheScript() {
	
		jQuery.ajaxSetup({
		
		  cache: true
		  
		});
		
	}

	
	/* Check if jQuery has loaded, if not defer method until it has */
	
	function DeferAction(method) {
	
		if (window.jQuery) {
			method();
		}			
		else {
			setTimeout(function() { DeferAction(method) }, 50);
		}	
	}
	

	
	/* Lazy load script */
	
	function vida_lazy_images_init() {
		
		console.log('loading lazy script...');
			  
			jQuery('.lazy').lazy({
				
				effect: "fadeIn",
				//threshold: 150,
				//appendScroll: $('.vida-lazy-wrap'),
				//combined: true, combined:!0,
				//delay: 15000,delay:15e3,
				enableThrottle: true,
				throttle: 250,
				visibleOnly: true,
				
				
				
				vidaLoader: function(element) {
					
					setTimeout(function() {
					
					  if( element[0].tagName.toLowerCase() === "iframe" ) {
						  
						element.attr("src", element.attr("data-src"));
						
						// remove attribute
						element.removeAttr("data-src");
					
					  } else {
							// pass error state
							// use response function for Zepto
							response(false);
					  }
					  
					 }, 1000);
					 
				},
				
				asyncLoader: function(element) {
					setTimeout(function() {
						element.load()
					}, 5000);
				},
				
				beforeLoad: function(element) {
					var eSrc = element.data('src');
					console.log(element[0].tagName.toLowerCase() + ' ' + eSrc + '" loading...');
				},
				
				afterLoad: function(element) {
					// called after an element was successfully handled
					element.addClass('handled');
					var eSrc = element.data('src');
					console.log(element[0].tagName.toLowerCase() + ' ' + eSrc + '" loaded...');
				},
				
				removeAttribute: true,
				
			}); 
	
	};
	

	
	
	
	/* Start rendering scripts */

	
	
	try {
	
		SetupCacheScript();
	
	}
	
	catch(e) {
		
		if (typeof(CheckLoadjQuery) != 'undefined') {
			
			CheckLoadjQuery();
			
		}		

		DeferAction(SetupCacheScript);
		
	}
	
	finally {	
	
		(function($) {
		
			console.log('finally now!');
		
			jQuery(".welcome-info").hide();
	
			vida_lazy_images_init();
		
		})(jQuery);
		
	}