<?php
/**
 * The custom hello bar for ViDA.
 *
 * Adds LeadQuizzes hello bar
 * @package Moesia
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Enqueues Bootstrap Alert Javascript
 */
function lq_hello_bar_script() {
	
	if ( ! ( is_home() || is_singular('post') || is_post_type_archive( 'post' )  )  )
		return;
	
		wp_enqueue_script( 'vida-lq-bar', get_stylesheet_directory_uri() . '/js/bootstrap.alert.js', array('jquery'), true );

}
add_action( 'wp_enqueue_scripts', 'lq_hello_bar_script', 12 ); 
		

/**
 * Adds Hello Bar styles
 */
function lq_hello_bar_styles() {
	
	if ( ! ( is_home() || is_singular('post') || is_post_type_archive( 'post' )  )  )
		return;
?>
<style>
/* making LQ bar sticky */
.admin-bar .is-sticky #lq-bar {
	    margin-top: 32px;
}

.is-sticky .top-bar {	
	    margin-top: 43px;
}
	.is-sticky .top-bar.no-lq {
		margin-top: 0px;
	}

.admin-bar .is-sticky .top-bar {	
	    margin-top: 75px;
}
	.admin-bar .is-sticky .top-bar.no-lq  {
		margin-top: 32px;
	}


@media screen and (max-width: 600px) {
	.sticky-wrapper {
		height: initial !important;
	}
	.admin-bar .is-sticky #lq-bar,
	.is-sticky #lq-bar {
	    margin-top: 0px;
	}
	.admin-bar .is-sticky .top-bar,
	.is-sticky .top-bar {
		margin-top: 59px;
	}
		.top-bar.no-lq  {
			margin-top: 0px;
		}
}

/* Women's Floating Button over-write (on Blog & Single posts only) */
.vida-floating-button  > a, .women-site-button > a, 
.women-site-button > a:hover, .women-site-button > a:active, .women-site-button > a:focus, .women-site-button > a:visited {
	 background: rgba(64, 124, 157, .9);
}	
</style>
<?php	
	
}
add_action( 'wp_head', 'lq_hello_bar_styles', 20 );



	
if ( ! function_exists( 'vida_lead_quiz_hello_bar' ) ) {
	
	function vida_lead_quiz_hello_bar() {
		
		if ( ! ( is_home() || is_singular('post') || is_post_type_archive( 'post' )  )  )
			return;
			
?>
<div id="lq-bar" style=" background:#B19645; " class="alert alert-info alert-dismissible text-center fade in" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<strong>What's The Absolute Best Dating Site For You?</strong>
<a id="lq-bar-trigger" class="lq-trigger" href="#">Start Quiz</a>
</div>
<script type="text/javascript">
//Make the hello bar sticky
jQuery(function($) {
	$(window).bind("load", function() {
		$("#lq-bar").sticky();
	});
	$(document).ready(function(){
		$("#lq-bar").on('close.bs.alert', function () {
			$("#lq-bar-sticky-wrapper").remove();
			$(".top-bar").addClass("no-lq");
		});
	});
});
</script>
<script type="text/javascript">var vlq=document.getElementById('lq-bar-trigger'); vlq.addEventListener('click',function(e){e.preventDefault();var lq_pop=document.getElementById('lq-trigger-C3xGcV');lq_pop.click();}); </script>
<?php		
	}

}
add_action('tha_header_before', 'vida_lead_quiz_hello_bar', 12);
//add_action('tha_header_after', 'vida_lead_quiz_hello_bar', 5);

?>