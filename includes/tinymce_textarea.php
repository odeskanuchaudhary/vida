<?php

// JQ JS to add the class 'mceEditor' to the excerpt textarea
function tme_convert_excerpt_js()
{
	// Only continue if this is an editing screen
	if ( ! tme_rich_editing() ) return;
?>
<script type="text/javascript">
	/* <![CDATA[ */
	
	jQuery(document).on('panelsopen', function(e) {
		var dialog = jQuery(e.target);
			
		// Check that this is for our widget class
		if( !dialog.has('.mceEditor') ) return;
			//alert(dialog);
		// Here we can setup our widget form.
		//tme_convertExcerpt();
		

		
	});
	
	/* ]]> */
</script>
<?php
}

// Enqueue script files, for inclusion by the standard WP magic
function tme_admin_enqueue_js()
{
	// Only continue if this is an editing screen
	if ( ! tme_rich_editing() ) return;
	wp_enqueue_script('jquery'); // Probably there anyway, but best to be sure
}

// Quick CSS make our new excerpt editor even more lovelier
function tme_admin_css()
{
	// Only continue if this is an editing screen
	if ( ! tme_rich_editing() ) return;
	// Fix the CSS, so the resize icon appears hard against the far right of the TinyMCE status bar.
?>
<style type='text/css'>
	#postexcerpt .mceStatusbarResize { margin-right: 0; }
	#postexcerpt #vida_textareaeditorcontainer { border-style: solid; padding: 0; }	
</style>
<?php
}

// Are we on an editing screen?
function tme_rich_editing()
{
	global $editing;
	return ( $editing && user_can_richedit() );
}

// Hook it up to Wordpress

// We need to enqueue some scripts. This is not an ideal action 
// hook, but it does the business
add_action('admin_xml_ns', 'tme_admin_enqueue_js');
// Paragraphise the excerpt on save
add_filter('excerpt_save_pre', 'wpautop');
// Some CSS
add_action('admin_head', 'tme_admin_css');
// Some inline JS in the head, to avoid loading another file
add_action('admin_head', 'tme_convert_excerpt_js');

?>
