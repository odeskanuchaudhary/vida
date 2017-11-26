/**
 * Custom Scripts for ViDA
 * Loads in footer @dependent on jQuery
 */
	
	

	/**
	 * Loading iFrames @deferred in content
	 * markup: src="" data-src="{/url/path/to/video/}"
	 */
			 
	function initDeferredIframes() {		
			
		var vidDefer = document.getElementsByTagName('iframe');
			
		for (var i=0; i<vidDefer.length; i++) {

			if(vidDefer[i].getAttribute('data-src')) {
				
				vidDefer[i].setAttribute('src',vidDefer[i].getAttribute('data-src'));
				
				console.log( 'Iframe ' + vidDefer[i].getAttribute('data-src') + ' ready');
					
			}

		}
			
	}
	
	
	/**
	 * Custom Scripts A
	 * functions executed when triggered 
	 *
	 * jQuery should have loaded
	 */

	jQuery(function($) {
		
		
		/* Email validaiton function */
		
		function isValidEmail( emailAdd ) {
			
			var emailPattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			
			return emailPattern.test( emailAdd );
			
		}
		
		
		/**
		 * ViDA Custom form validations for ontraport
		 *
		 * @ontraport custom/overwrite
		 */
	
		$('.vida-ontraport-form input[type="submit"], .vida-ontraport-form button[type="submit"]').each(function(){	
		
			$(this).click(function(e) {
			
				
			
				e.preventDefault();	

				var currentButton = $(this);				
				
				var hasError = false;
				
				$('input').removeClass('error-required');
				$('input').removeClass('vida-input-error');
				
				//add wrapper to button				
				$(this).wrap('<div class="submit-input-wrapper" ></div>');
				
				
				var currentForm =  $(this).parents('form').addClass('form-processing');
				
				//settimeout				
				setTimeout( function() {
				
					currentForm.find('input').filter('[required]:visible').each(function(){
					
						if ( $(this).val() == "" ) {
						
							$(this).addClass('vida-input-error');							
							hasError = true;							
							return;
							
						} 
						
						if ( $(this).attr('type') == 'email' ) {							
						
							if( !isValidEmail( $(this).val() ) ){
								
								$(this).addClass('vida-input-error');		
								
								hasError = true;								
								return;								
								
							}
						}
						
					
					});
					
					if ( ! hasError ) {
					
						currentForm.addClass('success');
						
						currentForm.submit();
						
						return true;
					
					}  else {
					
						//removewrapper / loader, return to form

						if ( currentButton.parent().is( "div" ) ) {						
							currentButton.unwrap();
						}
						
						currentForm.removeClass('form-processing');
						return false;
						
						
						
					}
				
				}, 1100 );
				
				
				return true;
				
			});	
		
		});
		

		/* custom prettyphoto trigger for vida vimeo videos */
		
		try {
		
			$("a.videoiframe_trigger").prettyPhoto({

				allow_resize: true,

				default_width: 560,

				default_height: 315,

				deeplinking: false,

				social_tools: false,

				autoplay: true,	

				changepicturecallback: function(){

					myframe = $(".pp_content").find('iframe');
					
					mysrc = myframe.attr('src');
					
					myframe.attr('src', ''); 
					
					myframe.attr('src', mysrc + '&autoplay=1'); 
					
				},

				callback: function(){


					myframe.attr('src', mysrc); 

				}

			});
			
		}
		
		catch(e) {
		
			jQuery.getScript('/wp-content/themes/moesia-vida/js/jquery.prettyPhoto.js');
		
		}
		
		/* end - custom prettyphoto for vida vimeo videos */		
	

	});


	
	/**
	 * Custom Scripts 
	 * executes when the DOM has loaded...
	 */

	jQuery(document).ready(function($) {

		if (typeof(CheckLoadjQuery) != 'undefined') {
      
      CheckLoadjQuery();
      
    }
		

		/* remove the welcome-info @homepage header */
			
		$(".welcome-info").remove();
		

		//Page loader
		
		$("#page").show();
		
	
		//add autocomplete to forms
		
		$("form").attr('autocomplete', 'on');

		

		$(window).load(function() {
		
			 
			try {
			
				initDeferredIframes();		
			
			}
			
			finally {
			
				$("#content").fitVids();
				
			
				/* Force page loader - just in case new scripts creates error */
				
				try {
				
					$("#page").show();
					
				}
				
				catch(e) {
				
					CheckLoadjQuery();
					
				}
				
				finally {
				
					$("#page").show();
					
				}
				
				
				$('body').removeClass('vida-loading').addClass('vida-loaded');
				

				
			
			}
		  
			
		});		
		
		
	});	
	