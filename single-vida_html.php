<?php

/*

Template Name: HTML Embed

*/



$html_file = ltrim( get_post_meta( $post->ID, 'vida_html_url', true ), '/' );

if ( $html_file != '' ) {
	
	include $html_file ;
	
} else {
	
	wp_redirect( home_url('/') );

	exit;
	
}

?>
