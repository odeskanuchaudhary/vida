<?php
/**
 * The FloatingButtonScript.
 *
 * Class : FloatingButtonScript
 *
 * @theme vida-women
 */

	// Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
	
	//Exit if our Main class isn't ready
	if ( ! class_exists( 'ViDA' ) ) {
		return;
	}

	//require our abstract class helper
	require_once('abstract.ViDAHelper.class.php');

	

		class FloatingButtonScript extends ViDA_Helper 
		{
			
			public function render() {
		

				$customScrollTrigger = ViDA::get_metabox('vida_button_scroll_position') ?: "null" ;
				
				return <<<HTML
				
				<script id="vida-wbutton-scroll-trigger" type="text/javascript">jQuery(document).ready(function(o){var d=o(".site-footer").offset().top/3,e=o(".site-footer").offset().top/2,i={$customScrollTrigger}
i&&(d=i),d>e&&(e=d),o(window).scroll(function(){o(window).scrollTop()>d?o("body").addClass("vida-one-third"):o("body").removeClass("vida-one-third"),o(window).scrollTop()>e?o("body").addClass("vida-one-third vida-one-half"):o("body").removeClass("vida-one-half")})})
</script>
			
HTML;
				
				
				return '';
				
				
			} //render
			
		} //class

	?>
